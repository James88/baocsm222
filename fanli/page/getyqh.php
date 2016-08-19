<?php
/**
 * ============================================================================
 * 版权所有 2008-2012 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
if(!defined('PAGE')) exit('miss page');
//$_GET=array (
//  'ads_id' => '62',
//  'ads_name' => '凡客cps推广',
//  'euid' => '1',
//  'link_id' => '0',
//  'order_sn' => '9745164',
//  'order_time' => '2013-04-20 14:58:44',
//  'orders_price' => '68.00',
//  'site_id' => '52244',
//  'siter_commission' => '1.38',
//  'status' => '0',
//  'checksum' => '350e96f404cf55a58d293cc6362b99db',
//);

$get=var_export($_GET, true)."\r\n";
$dir =DDROOT.'/data/yqh_'.substr(md5(DDKEY),0,16).'/'. date("Y").'/'.date('md').'.txt';
create_file($dir,$get,1);

if(empty($_GET)){
    echo -1;
	exit;
}
if($_GET['ads_id']==0){
	echo 1;
	dd_exit();
}

$ads_id=$_GET['ads_id'];//活动ID
$ads_name=$_GET['ads_name'];
$site_id=$_GET['site_id'];//网站ID
$link_id=$_GET['link_id'];//活动链接ID
$uid=$_GET['euid'];//	网站主设定的反馈标签
list($uid,$code,$fuid,$shuju_id)=do_back_code($uid);
$order_sn=$_GET['order_sn'];//	订单编号
$order_time=strtotime($_GET['order_time']);//	下单时间
$orders_price=$_GET['orders_price'];//订单金额
$commission=$_GET['confirm_siter_commission']?$_GET['confirm_siter_commission']:$_GET['siter_commission'];//	订单佣金
$status=$_GET['status'];//订单状态  -1 无效 0 未确认 1 确认 2 结算
if($status==1) $status=0;
elseif($status==2) $status=1;

$checksum_md5=md5($_GET['ads_id'].$_GET['ads_name'].$_GET['euid'].$_GET['link_id'].$_GET['order_sn'].$_GET['order_time'].$_GET['orders_price'].$_GET['site_id'].$_GET['siter_commission'].$_GET['status'].$webset['yqh']['key']);
if($checksum_md5!=$_GET['checksum']){
    exit('hack');
}

if($site_id!=$webset['yqh']['wzid']){
    exit('非本站订单！');
}
$sales =$orders_price;
$order_code=$order_sn; //订单编号
$mall=$duoduo->select('mall','id,title,type','yqhid="'.$ads_id.'"');
$mall_name=$mall['title']?$mall['title']:preg_replace('/cps推广/','',$ads_name);
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

$unique_id=$order_code;  //唯一编号，多麦订单号可确定唯一
$mall_order = $duoduo->select("mall_order", "id,mall_name,status,fxje,jifen,commission,order_code", 'unique_id="'.$unique_id.'"'); //用订单编号查

$field_arr = array (
	'adid' => $ads_id,
	'lm' => 7,
	'order_time' => $order_time,
	'mall_name' => $mall_name,
	'mall_id'=>(int)$mall['id'],
	'uid' => $uid,
	'order_code' => $order_code,
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
if ($mall_order['id'] == '') { //交易不存在
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