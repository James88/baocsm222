<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class LifeserviceAction extends CommonAction {

 public function _initialize() {
        parent::_initialize();
        $s = D('Lifeservicecate')->channel_list();
    }

    public function index() {
		$list1 = D('LifeServiceCate') -> where('channel_id = 1') -> limit(8) -> select();
		$list2 = D('LifeServiceCate') -> where('channel_id = 2') -> limit(8) -> select();
		$list3 = D('LifeServiceCate') -> where('channel_id = 3') -> limit(8) -> select();
		$this->assign('list1',$list1);$this->assign('list2',$list2);$this->assign('list3',$list3);
                $this->display();
    }

    public function cate(){
        
        $channel_id = I('channel_id','','intval,trim');
        
        $cate_id = I('cate_id','','intval,trim');
        
        if(!$channel_id || !$cate_id){
            $this->error('不存在的分类或频道！');
        }
        
        $this->assign('channel_id',$channel_id);
        $this->assign('cate_id',$cate_id);
        
        $this->display();
        
    }
    
    
    public function lists(){
           
        $this->display();
        
    }
    
    
    public function detail(){
        
        $this->display();
        
    }
}