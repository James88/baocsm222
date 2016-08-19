<?php

/*
 * @author Lmy
 * QQ:6232967
 * Create at 2016-8-13 16:06:10
 */
$map = array('code'=>'alipay');
if($setting = D('Payment')->where($map)->getField('setting')){
    $setting= unserialize($setting);
    $data   = array('status'=>self::BAO_REQUEST_SUCCESS,'config'=> $setting);
}else{
    $data   = array('status'=>self::BAO_DETAIL_NO_EXSITS,'msg'=>'数据不存在！');
}


?>

