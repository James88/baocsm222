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
  'yyyymmdd' => '20120806',
  'hhmiss' => '140459',
  'o_cd' => '212080631483',
  'm_id' => 'vancl',
  'mbr_id' => '',
  'comm' => '7.9',
  'u_id' => '1',
  'p_cd' => '00310329',
  'it_cnt' => '1',
  'price' => '79.00',
  'c_cd' => '',
  'sign' => '070c27962e41406fb033014f995a21cd',
);*/

$get=var_export($_GET, true).'|'.$_SERVER['REMOTE_ADDR']."\r\n";
$dir =DDROOT.'/data/linktech_'.substr(md5(DDKEY),0,16).'/'. date("Y").'/'.date('md').'.txt';
create_file($dir,$get,1);

$m_id=$_GET['m_id'];//广告主ID
$uid = $_GET['u_id']?$_GET['u_id']:0; //会员ID
list($uid,$code,$fuid,$shuju_id)=do_back_code($uid);
$order_code = $_GET['o_cd']; //订货号
$product_code = $_GET['p_cd']; //商品编号
$order_time=strtotime($_GET['yyyymmdd'].' '.$_GET['hhmiss']);//	下单时间
$item_price = $_GET['price']; //商品单价
if(strpos($item_price,',')!==false){
	$item_price=str_replace(',','',$item_price);
}
$item_count = $_GET['it_cnt']; //商品数量
$sales = $item_price * $item_count; //总额
$commission = $_GET['comm']; //返利金额
$status = 0; //订单状态

/*$checksum_md5=md5($_GET['m_id'].$_GET['o_cd'].$_GET['comm']);

if($checksum_md5!=$_GET['checksum']){
    exit('hack');
}*/

$mall=$duoduo->select('mall','id,title,type','merchant="'.$m_id.'"');
$mall_name=$mall['title']?$mall['title']:$m_id;
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

$unique_id=$order_code.'*'.$product_code;  //唯一编号，领克特订单号+商品编号可确定唯一

$mall_order = $duoduo->select("mall_order", "id,mall_name,status,fxje,jifen,commission,order_code", 'unique_id="'.$unique_id.'"'); //用订单编号查
if ($mall_order['id'] == '') { //交易不存在
	$field_arr = array (
		'adid' => $m_id,
		'lm' => 2,
		'order_time' => $order_time,
		'mall_name' => $mall_name,
		'mall_id'=>(int)$mall['id'],
		'uid' => $uid,
		'order_code' => $order_code,
		'product_code' => $product_code,
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
	$insert=$duoduo->insert("mall_order", $field_arr);
	$tuiguang_insert_data=array('fuid'=>$fuid,'uid'=>$uid,'order_id'=>$insert,'mall'=>1,'code'=>$code,'shuju_id'=>$shuju_id);
	$duoduo->ddtuiguang_insert($tuiguang_insert_data);
    echo 1;
}
?>