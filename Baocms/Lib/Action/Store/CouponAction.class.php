<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class CouponAction extends CommonAction {

    public function index() {
        if ($this->isPost()) {
            $code = $this->_post('code', false);
            foreach ($code as $v) {
                if (empty($v)) {
                     echo '<script>parent.alert("请输入电子优惠券");</script>';die();
                }
            }
            $obj = D('Coupondownload');
            $ip = get_client_ip();
            $return = array();
            foreach ($code as $key => $var) {
                $var = trim(htmlspecialchars($var));
                if (!empty($var)) {
                    $data = $obj->find(array('where' => array('code' => $var)));
                    if (!empty($data) && (int) $data['shop_id'] == $this->shop_id && (int) $data['is_used'] == 0) {
                        if (false !== $obj->save(array('download_id' => $data['download_id'], 'is_used' => 1, 'used_ip' => $ip, 'used_time' => NOW_TIME))) {
                            $return[$var] = $var;
                        }
                    } else {
                        continue;
                    }
                }
            }
            if (!empty($return)) {
                $msg = join(',',$return);
                //$this->baoSuccess("恭喜您，您成功消费的优惠券如下：".$msg); //放入foreach内循环一次后便会退出
                echo '<script>parent.used("'."恭喜您，您成功消费的优惠券如下：" .$msg.'");</script>';
            }else{
                 echo '<script>parent.alert("无效的电子优惠券");</script>';die();
            }
        } else {
            $this->display();
        }
    }

//         if($this->isPost()){
//            $code=$this->_post('code',false); 
//	
//            if(empty($code)){
//				$this->baoError('请输入电子优惠券');
//                exit('<script>parent.used("请输入电子优惠券！");</script>');
//            }
//            $obj =  D('Coupondownload');
//			
//            $return = array();
//            $ip = get_client_ip();
//            foreach($code  as $var){
//                if(!empty($var)){
//                    $data =$obj->find(array('where'=>array('code'=>$var)));
//                    if(!empty($data) && $data['shop_id'] == $this->shop_id && $data['is_used'] == 0 ){
//                      $obj->save(array('download_id'=>$data['download_id'],'is_used'=>1,'used_time'=>NOW_TIME,'used_ip'=>$ip));
//                      $return[$var] = $var;
//                    }
//                }
//            }   
//            if(empty($return)){
//				$this->baoError('请输入电子优惠券');
//                exit('<script>parent.used("没有可消费的电子优惠券！");</script>');
//				//$this->error("没有可消费的电子优惠券！");
//            }
//            if(NOW_TIME - $this->shop['ranking'] < 86400){ //更新排名
//                D('Shop')->save(array('shop_id'=>  $this->shop_id,'ranking'=>NOW_TIME));
//            }
//			$this->baoSuccess('恭喜您，您成功消费的优惠券如下');
//            //echo '<script>parent.used("恭喜您，您成功消费的优惠券如下："+"'.join(',',$return).'");</script>';
//        }else{
//            $this->display();
//        }       
}
