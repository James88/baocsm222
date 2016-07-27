<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class InformationAction extends CommonAction {

	public function index() {
		$u = D('Users');
		$ud = D('UserAddr');
                $bc = D('Connect');
		$map = array('user_id' => $this->uid);
		$res = $u-> where($map) -> find();
		$addr_count = $ud -> where($map) -> count();
                $rbc = $bc -> where('uid ='.($this->uid)) -> select();
                $bind = array();
                foreach($rbc as $val){
                    $bind[$val['type']] = $val;
                }
                //print_r($bind);
		$this->assign('res',$res);
		$this->assign('addr_count',$addr_count);
                $this->assign('bind',$bind);
		$this->display(); // 输出模板
	}
        
        public function upload_face(){
                
            if(!$this->uid){
                $this->ajaxReturn(array('status'=>'error','message'=>'您没有登录或登录超时！'));
            }else{
                $avatar = I('avatar','','trim,htmlspecialchars');
                if(!$avatar){
                    $this->ajaxReturn(array('status'=>'error','message'=>'没有上传头像！'));
                }else{
                    $u = D('Users');
                    $up = $u -> where('user_id ='.($this->uid))-> setField('face',$avatar);
                    if($up){
                        $this->ajaxReturn(array('status'=>'success','message'=>'修改成功！'));
                    }else{
                       $this->ajaxReturn(array('status'=>'error','message'=>'修改失败！')); 
                    }
                }
            }
            
        }
  
}