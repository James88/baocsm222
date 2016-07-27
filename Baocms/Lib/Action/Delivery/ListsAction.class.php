<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class ListsAction extends CommonAction {

    public function index() {
        
        
                if(!cookie('DL')){
			header("Location: " . U('login/index'));
		}else{
			$cid = $this->reid();
			$dv = D('DeliveryOrder');
			$map = array();
			
                        $ss = I('ss',0,'intval,trim');
                        $this->assign('ss',$ss);
                        
			if($ss == 2){
				$map['status'] = 2;
				$map['delivery_id'] = $cid;
			}elseif($ss == 8){
				$map['status'] = 8;
				$map['delivery_id'] = $cid;
			}else{
				$map['status'] = array('lt',2);
                                $map['delivery_id'] = 0;
			}
			$rdv = $dv -> where($map) -> order('create_time desc') -> select();
                        $this->assign('rdv',$rdv);
		}
    
		
		$this->display();      
    }
    
    
    public function handle(){
        
        if(IS_AJAX){
            
            $id = I('order_id',0,'trim,intval');
            
            $dvo = D('DeliveryOrder');
            
            if(!cookie('DL')){
                $this->ajaxReturn(array('status'=>'error','message'=>'您还没有登录或登录超时!'));
            }else{
                $f = $dvo -> where('order_id ='.$id) -> find();
                if(!$f){
                    $this->ajaxReturn(array('status'=>'error','message'=>'错误!'));
                }else{
                    $cid = $this->reid(); //获取配送员ID
                    if($cid == 5){
                       $this->ajaxReturn(array('status'=>'error','message'=>'演示站不提供数据操作!'));
                    }
                    $data = array(
                        'delivery_id' => $cid,
                        'status' => 2
                    );
                    $up = $dvo -> where('order_id ='.$id) -> setField($data);
                    if($up){
                        
                        if($f['type'] == 0){
                            $old = D('Order');
                        }elseif($f['type'] == 1){
                            $old = D('EleOrder');
                        }

                        $old_up = $old -> where('order_id ='.$f['type_order_id']) -> setField('status',2);
                        
                        $this->ajaxReturn(array('status'=>'success','message'=>'恭喜您！接单成功！请尽快进行配送！'));
                    }else{
                        $this->ajaxReturn(array('status'=>'error','message'=>'接单失败！错误！'));
                    }
                }
            }
            
        }
        
        
    }
    
    
    
    public function set_ok(){
        
        if(IS_AJAX){
            
            $id = I('order_id',0,'trim,intval');
            
            $dvo = D('DeliveryOrder');
            
            if(!cookie('DL')){
                $this->ajaxReturn(array('status'=>'error','message'=>'您还没有登录或登录超时!'));
            }else{
                
                $f = $dvo -> where('order_id ='.$id) -> find();
                if(!$f){
                    $this->ajaxReturn(array('status'=>'error','message'=>'错误!'));
                }else{
                    $cid = $this->reid(); //获取配送员ID
                    if($cid == 5){
                       $this->ajaxReturn(array('status'=>'error','message'=>'演示站不提供数据操作!'));
                    }
                    if($f['delivery_id'] != $cid){
                        $this->ajaxReturn(array('status'=>'error','message'=>'错误!'));
                    }else{
                        $up = $dvo -> where('order_id ='.$id)-> setField('status',8);
                        if(!$up){
                            $this->ajaxReturn(array('status'=>'error','message'=>'操作失败!'));
                        }else{
                            
                            if($f['type'] == 0){
                                $old = D('Order');
                            }elseif($f['type'] == 1){
                                $old = D('EleOrder');
                            }

                            $old_up = $old -> where('order_id ='.$f['type_order_id']) -> setField('status',8);
                            
                            $this->ajaxReturn(array('status'=>'success','message'=>'操作成功!'));
                            
                        }
                       
                        
                    }
                    
                }
                
            }
            
        }
        
    }



}