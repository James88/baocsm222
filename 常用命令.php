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


多多返利
http://soft.duoduo123.com/portal/buy.html
    
订单获取:
    http://bbs.duoduo123.com/read-1-1-198008.html
1.商品标：duoduo_goods 商品分类表 duoduo_type;
已新建 3个多多表的模型 在 model里

?>

