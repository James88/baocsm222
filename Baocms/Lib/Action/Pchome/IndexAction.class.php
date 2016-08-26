<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class IndexAction extends CommonAction {
    
     public function _initialize() {
        parent::_initialize();
        $this->type = D('Keyword')->fetchAll();
        $this->assign('types', $this->type);
    }

    public function index() {
        
        if (is_mobile()) {
            header("Location:" . U('mobile/index/index'));
            die;
        }
        $map['tag'] = 'goods';
        $duoduoCates = D('DuoduoType')->where($map)->select();
        $this->assign('duoduoCates',$duoduoCates);
        $this->display();
  
    }
    
    
    public function get_arr(){
        
         if(IS_AJAX){
            
            $cate_id = I('val',0,'intval,trim');
            
            $today = date('Y-m-d');

            $t = D('Tuan');
            $map = array(
                'cate_id'=>$cate_id,
                'city_id'=>$this->city_id,
                'closed'=>0,
                'audit'=>1,
                'bg_date' => array('elt',$today),
                'end_date'=>array('egt',$today)
                
            );
            $r = $t->where($map)->limit(8)->select();
            
            if($r){
                $this->ajaxReturn(array('status'=>'success','arr'=>$r));
            }else{
                $this->ajaxReturn(array('status'=>'error'));
            }
            
        }
        
    }
    

    public function test() {

        $map = array('code'=>'weixin');
        if(!$setting = D('Payment')->where($map)->getField('setting')){
            $this->error('微信配置错误，请检查');
        }
        $setting = unserialize($setting);
        import('Baocms.wechat.wechat');
        $wechat = new Wechat($setting);
        $wechat->createCard($data);
       
    }

}
