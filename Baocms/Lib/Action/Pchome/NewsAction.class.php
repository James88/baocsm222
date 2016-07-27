<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class  NewsAction extends CommonAction{
    
    public function index(){
        $Shopnews = D('Shopnews');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('audit'=>1);
        $cates = D('Shopcate')->fetchAll();
        $cat = (int) $this->_param('cat');
        if ($cates[$cat]) {
            $catids = D('Shopcate')->getChildren($cat);
            if (!empty($catids)) {
                $map['cate_id'] = array('IN', $catids);
            } else {
                $map['cate_id'] = $cat;
            }
           $this->assign('parent_id',$cates[$cat]['parent_id'] == 0 ? $cates[$cat]['cate_id'] : $cates[$cat]['parent_id']);
           $this->seodatas['cate_name'] = $cates[$cat]['cate_name'];
        }
        $this->assign('cat', $cat);
        
        $order = (int)  $this->_param('order');
        switch($order){
            case 3:
                $orderby = array('news_id'=>'desc');
                break;
            case 2:
                 $orderby = array( 'views'=>'desc');
                break;
            default:
                $orderby = array( 'orderby'=>'asc', 'news_id'=>'desc');
                break;          
        }        
        $count = $Shopnews->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 10); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $Shopnews->where($map)->order($orderby)->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $shop_ids = array();
        foreach($list as $k=>$val){
            if($val['shop_id']){
                $shop_ids[$val['shop_id']] = $val['shop_id'];
            }
        }
        if($shop_ids){
            $this->assign('shops',D('Shop')->itemsByIds($shop_ids));
        }
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->assign('cates', $cates);
        $this->display(); // 输出模板
    }
    
    
    public function detail(){
        $news_id = (int)  $this->_get('news_id');
        if(empty($news_id)){
            $this->error('请访问正常的内容!');die;
        }
        if(!$detail=D('Shopnews')->find($news_id)){
            $this->error('请访问正常的内容!');die;
        }
        if(!$detail['audit']){
            $this->error('该文章正在审核中!');die; 
        }
        $cates = D('Shopcate')->fetchAll();
        $this->assign('cate',$cates[$detail['cate_id']]);
        $this->assign('shop',D('Shop')->find($detail['shop_id']));
        $this->assign('ex',D('Shopdetails')->find($detail['shop_id']));
        $this->assign('cates',$cates);
        $this->assign('detail',$detail);
        $this->assign('domain',D('Shopdomain')->domain($detail['shop_id']));
        D('Shopnews')->updateCount($news_id,'views');
        $this->seodatas['title'] = $detail['title'];
        $this->display();
    }
    
    
    
    
}