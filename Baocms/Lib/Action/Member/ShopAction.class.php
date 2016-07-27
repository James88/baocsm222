<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class ShopAction extends CommonAction {

    public function myshop() {
        $shop = D('Shop');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('tui_uid' => $this->uid, 'closed' => 0);
        $count = $shop->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 25); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $shop->where($map)->order(array('shop_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板
    }

    public function tongji() {
        $shopIds = D('Shop')->getShopIdsByTuiId($this->uid);
        if (empty($shopIds)) {
            $this->error('您还没有推广的商户', U('member/myshop'));
        }
        $bg_date = $this->_param('bg_date', 'htmlspecialchars');
        $end_date = $this->_param('end_date', 'htmlspecialchars');
        if (empty($bg_date) || empty($end_date)) {
            $bg_date = date('Y-m-d', NOW_TIME - 86400 * 30);
            $end_date = TODAY;
        }
        $this->assign('bg_date', $bg_date);
        $this->assign('end_date', $end_date);

        $this->assign('total', D('Shopmoney')->sumByIds($bg_date, $end_date, $shopIds));
        $shops = D('Shop')->itemsByIds($shopIds);
        $datas = D('Shopmoney')->sumByIdsTop10($bg_date, $end_date, $shopIds);
        $showdatas = array();
        foreach ($datas as $k => $val) {
            if (!empty($val['shop_id'])) {
                $showdatas['shop'][] = '"' . $shops[$val['shop_id']]['shop_name'] . '"';
                $showdatas['money'][] = round($val['money'] / 100, 2);
            }
        }
        $this->assign('shops', join(',', $showdatas['shop']));
        $this->assign('moneys', join(',', $showdatas['money']));
        $this->display();
    }

    
    public function shoplist() {
        $Shop = D('Shop');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('closed' => 0);
        if ($keyword = $this->_param('keyword', 'htmlspecialchars')) {
            $map['shop_name|tel'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword', $keyword);
        }

        $count = $Shop->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 10); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $Shop->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->select();

        $this->assign('areas', D('Area')->fetchAll());
        $this->assign('cates', D('Shopcate')->fetchAll());
        $this->assign('business', D('Business')->fetchAll());
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板
    }

    public function favorites() {
        $Shopfavorites = D('Shopfavorites');
        import('ORG.Util.Page');
        $map = array('user_id' => $this->uid);
        $count = $Shopfavorites->where($map)->count();
        $Page = new Page($count, 25);
        $show = $Page->show();
        $list = $Shopfavorites->where($map)->order('favorites_id desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $shop_ids = array();
        foreach ($list as $k => $val) {
            $shop_ids[$val['shop_id']] = $val['shop_id'];
        }
        $this->assign('shops', D('Shop')->itemsByIds($shop_ids));
        $this->assign('prices', D('Shopdetails')->itemsByIds($shop_ids));
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display();
    }

    public function deletefavo($favorites_id) {
        $favorites_id = (int) $favorites_id;
        if ($detial = D('Shopfavorites')->find($favorites_id)) {
            if ($detial['user_id'] == $this->uid) {
                D('Shopfavorites')->delete($favorites_id);
                $this->baoSuccess('取消收藏成功!', U('member/favorites'));
            }
        }
        $this->baoError('参数错误');
    }
    
}
