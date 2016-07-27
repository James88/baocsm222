<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class ExtendAction extends CommonAction { //推广页面

    public function index() {
        $this->assign('nextpage', LinkTo('extend/loaddata', array('t' => NOW_TIME, 'p' => '0000')));
        $this->display(); // 输出模板   
    }

    public function loaddata() {
        $goods = D('Goods');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('audit' => 1, 'closed' => 0,'city_id'=>$this->city_id, 'commission' => array('GT', 0), 'price' => array('GT', 0), 'mall_price' => array('GT', 0));
        $count = $goods->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 10); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }
        $list = $goods->where($map)->order(array('orderby' => 'asc','goods_id'=>'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display();
    }
    public function detail() {
        $goods_id = (int) $this->_param('goods_id');
        if (!$detail = D('Goods')->find($goods_id)) {
            $this->error('该商品不存在');
            die;
        }
        if ($detail['closed']) {
            $this->error('该商品已经被删除');
            die;
        }
        if ($detail['audit'] != 1) {
            $this->error('该商品未通过审核');
            die;
        }
        $this->assign('detail', $detail);
        $this->assign('user_id',  $this->uid);
        $this->display();
    }

    public function extend() {

        $this->display();
    }

}
