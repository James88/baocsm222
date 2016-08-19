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

/*$_GET=array (
  'unique_id' => '252796384',
  'create_date' => '2012-11-09 07:01:18',
  'action_id' => '5227',
  'action_name' => '聚美优品CPS',
  'sid' => '66593',
  'wid' => '216636',
  'order_no' => '32268203',
  'order_time' => '2012-11-09 07:01:12',
  'prod_id' => '',
  'prod_name' => '',
  'prod_count' => '1',
  'prod_money' => '79.9',
  'feed_back' => '1',
  'status' => 'F',
  'comm_type' => 'basic',
  'commision' => '6.7915',
  'chkcode' => 'c1a3fd8003e9447754e688e3662b4376',
  'prod_type' => '',
  'am' => '0.0',
  'exchange_rate' => '0.0',
);
*/
$get=var_export($_GET, true).'|'.$_SERVER['REMOTE_ADDR']."\r\n";
$dir =DDROOT.'/data/yiqifa_'.substr(md5(DDKEY),0,16).'/'. date("Y").'/'.date('md').'.txt';
create_file($dir,$get,1);

$unique_id=$_GET['unique_id']; //数据唯一编号
$action_id=$_GET['action_id']; //活动id
$action_name=$_GET['action_name'];
$action_name=iconv('gbk','utf-8//IGNORE',$action_name);
$order_code=$_GET['order_no']; //订单编号
$order_time=$_GET['order_time']?strtotime($_GET['order_time']):TIME; //下单时间
$product_code=trim(iconv('gbk', 'utf-8//IGNORE', $_GET['prod_id'])); //商品编号
if($product_code=='汇总'){ //商品数量
	$item_count=1;
}
else{
	$item_count=$_GET['prod_count'];
}
$item_price=$_GET['prod_money']; //商品单价
$sales = $item_price; //总额
$commission=$_GET['commision']; //网站主佣金
$uid=$_GET['feed_back']; //反馈标签
list($uid,$code,$fuid,$shuju_id)=do_back_code($uid);
$status=$_GET['status']; //订单状态
$chkcode=$_GET['chkcode']; //验证密钥   action_id+order_no+prod_money+order_time+ 站点push数据key值
$code=md5($_GET['action_id'].$_GET['order_no'].$_GET['prod_money'].$_GET['order_time'].$webset['yiqifa']['key']);
if($code!=$chkcode){
    dd_exit('err code');
}
switch($status){
    case 'R': $status=0;
	break;
	case 'A': $status=1;
	break;
	case 'F': $status=-1;
	break;
}

if(strpos($uid,'_')!==false){
    $abc=explode('_',$uid);
	$uid=$abc[0];
}
else{
	$uid=rep($uid);
}
if($uid=='null'){
	$uid=0;
}

$uid=(int)$uid;

$mall=$duoduo->select('mall','id,title,type','yiqifaid="'.$action_id.'"');

$mall_name=$mall['title']?$mall['title']:preg_replace('/cps/i','',$action_name); //如果没有

$mall_order = $duoduo->select("mall_order", "id,mall_name,status,fxje,jifen,commission,order_code,unique_id,uid", 'unique_id="'.$unique_id.'"'); //一起发用唯一编号查
if($mall_order['uid']>0){
	$uid=$mall_order['uid'];
}

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
$field_arr = array (
	'adid' => $action_id,
	'lm' => 3,
	'order_time' => $order_time,
	'mall_name' => $mall_name,
	'mall_id'=>(int)$mall['id'],
	'uid' => $uid,
	'order_code' => $order_code,
	'item_count' => $item_count,
	'item_price' => $item_price,
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