<?php
/**
 * ============================================================================
 * 版权所有 2008-2012 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
if(!defined('PAGE')) exit('miss page');

//$_GET=array (
//  'created' => '1353672318',
//  'seller_id' => '1064',
//  'seller_name' => '凡客诚品',
//  'outer_code' => '1',
//  'order_code' => '212112375826',
//  'order_id' => '392423',
//  'order_amount' => '88.00',
//  'commission' => '8.80',
//  'status' => '无效',
//  'chkcode' => '9b21f5f9273c5fb4d60b3734d5837390',
//);

$get=var_export($_GET, true).'|'.$_SERVER['REMOTE_ADDR']."\r\n";
$dir =DDROOT.'/data/wujiumiao_'.substr(md5(DDKEY),0,16).'/'. date("Y").'/'.date('md').'.txt';
create_file($dir,$get,1);

$adid=$_GET['seller_id'];//活动ID
$mall_name=$_GET['seller_name'];
$uid=$_GET['outer_code'];//	网站主设定的反馈标签
list($uid,$code,$fuid,$shuju_id)=do_back_code($uid);
$product_code=$_GET['order_code'];
$order_code=$_GET['order_id'];//	订单编号
$order_time=$_GET['created'];//	下单时间
$sales=$_GET['order_amount'];//订单金额
$commission=$_GET['commission'];//	订单佣金
$chkcode=$_GET['chkcode'];
$status=$_GET['status'];//订单状态
if($status=='未确认'){
	$status=0;
}
elseif($status=='有效'){
	$status=1;
}
elseif($status=='无效'){
	$status=-1;
}

$mycheck=$_GET['created'].$_GET['seller_id'].$_GET['seller_name'].$_GET['outer_code'].$_GET['order_code'].$_GET['order_id'].$_GET['order_amount'].$_GET['commission'].$_GET['status'].$webset['wujiumiaoapi']['key'].$webset['wujiumiaoapi']['secret'];

if($chkcode!=md5($mycheck)){
    exit('hack');
}

$mall=$duoduo->select('mall','id,title,type','wujiumiaoid="'.$adid.'"');
$mall_name=$mall['title']?$mall['title']:preg_replace('/cps推广/','',$mall_name);
$dduser=$duoduo->select('user','id,ddusername,type,tjr','id="'.$uid.'"');
$fxje=fenduan($commission,$webset['mallfxbl'],$dduser['type']);
$jifen=round($fxje*$webset['jifenbl']);
if($mall['type']==2){  //返积分
	$fxje=0;
}
if($user['tjr']>0){
	$tgyj=round($fxje*$webset['tgbl']);
}
else{
	$tgyj=0;
}

$unique_id=$order_code;  //唯一编号，59秒订单号确定唯一
$mall_order = $duoduo->select("mall_order", "id,mall_name,status,fxje,jifen,commission,order_code", 'unique_id="'.$unique_id.'"'); //用订单编号查
$field_arr = array (
	'adid' => $adid,
	'lm' => 6,
	'order_time' => $order_time,
	'mall_name' => $mall_name,
	'mall_id'=>(int)$mall['id'],
	'uid' => $uid,
	'order_code' => $order_code,
	'product_code'=>$product_code,
	'item_count' => 1,
	'item_price' => $sales,
	'sales' => $sales,
	'commission' => $commission,
	'status' => $status,
	'fxje' => $fxje,
	'jifen' => $jifen,
	'tgyj' => $tgyj,
	'addtime'=>TIME,
	'unique_id'=>$unique_id
);
if($status==1){
	$field_arr['qrsj']=TIME;
}
if ($mall_order['id'] == '') { //订单不存在
	$insert=$duoduo->insert("mall_order", $field_arr);
	$tuiguang_insert_data=array('fuid'=>$fuid,'uid'=>$uid,'order_id'=>$insert,'mall'=>1,'code'=>$code,'shuju_id'=>$shuju_id);
	$duoduo->ddtuiguang_insert($tuiguang_insert_data);
	$field_arr['id']=$insert;
}
else{
	$duoduo->update('mall_order', $field_arr, "id='".$mall_order['id']."'");
	$field_arr['id']=$mall_order['id'];
}

if($mall_order['status']!=1 && $status==1){//给会员结算
	if($dduser['id']>0 && ($fxje>0 || $jifen>0)){
		$duoduo->rebate($dduser,$field_arr,3);
	}
}
/*elseif($status!=1 && $mall_order['status']==1 && $dduser['id']>0){ //商城订单退款
	$refund_arr['uid']=$dduser['id'];
	$refund_arr['money']=$fxje;
	$refund_arr['jifen']=$jifen;
	$refund_arr['source']=$mall_name.'返利，订单号'.$order_code;
	$duoduo->dd_refund($refund_arr,23);
}*/
echo 1;
?>