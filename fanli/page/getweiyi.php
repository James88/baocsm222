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

/**

 * 参数说明：
cdate		定单日期	格式为yyyyMMddhhmmss
 * websitid		网站编号	字符
 * uid			反馈标签	字符
 * merchantid	广告主		字符
 * orderid		定单号		字符
 * pid			商品号		字符
 * pnum		商品数量	整型
 * price			商品单价	整型（单位：分）
 * sumprice		商品总价	整型（单位：分）
 * unit			佣金类型	整型（0为按商品总价百分比提成，1为按单笔交易提成，单位为分）
 * mper		佣金比例	浮点（佣金类型为0时表示百分比数，为1时单位为分）
 * commission	佣金		整型（单位：分）
 * stat			确认状态	整型（0=未核对 1=已确认(可以支付佣金) 2=确认无效）
 */

/*$_GET=array (
  'from' => 'weiyi',
  'cdate' => '20121107163410',
  'websitid' => 'A100055404',
  'uid' => '1',
  'merchantid' => 'dangdang',
  'merchantname' => '当当网上商城',
  'orderid' => '5183749720',
  'pid' => '特例品',
  'code' => 'C',
  'pnum' => '1',
  'price' => '13900',
  'sumprice' => '13900',
  'unit' => '0',
  'mper' => '0.5',
  'commission' => '69',
  'stat' => '2',
  'token' => '8C6F5CC8054375D19F0F74BD2A08476E',
);*/

$lm=5;//唯一联盟的ID号码
if(!empty($_GET)){
	$get = var_export($_GET, true).'|'.$_SERVER['REMOTE_ADDR'] . "\r\n";
	$dir = DDROOT . '/data/weiyi_'.substr(md5(DDKEY),0,16).'/' . date("Y") . '/' . date('md') . '.txt';
	create_file($dir, $get, 1);
}

$weiyiid = $_GET['merchantid']; //广告主
$mall = $duoduo -> select('mall', 'id,title,type', 'weiyiid="' . $weiyiid . '" and lm=5');
if ($_GET['merchantid'] == "weiyi") {
	dd_exit('err weiyi');//有比订单是唯一联盟注册赠送20元的删了，免的影响
} 
$websitid = $_GET['websitid'];
if ($websitid != $webset['weiyi']['wzbh']) {
	dd_exit('err Does not belong to this site');;//网站编号不一致，不是这个网站的K掉
} 

$mall_name = $mall['title']; //活动名
$uid = $_GET['uid']; //	网站主设定的反馈标签
list($uid,$code,$fuid,$shuju_id)=do_back_code($uid);
$order_code = $_GET['orderid']; //	定单号
$product_code = $_GET['pid']; //	商品号
$order_time =strtotime($_GET['cdate']); //下单时间
$item_count = (int)$_GET['pnum']; //商品数量
$item_price = round((float)$_GET['price']/100,2); //商品单价
$sales = round($_GET['sumprice']/100,2); // 总价
$unit = $_GET['unit']; //佣金类型
$mper = $_GET['mper']; //佣金比例
$commission = round((float)$_GET['commission']/100,2); //佣金
$status = $_GET['stat']; //确认状态	整型（0=未核对 1=已确认(可以支付佣金) 2=核对无效）
if ($status == 2) { // 订单状态  -1 无效 0 未确认 1 确认 2 结算
	$status = -1;
} 
if ($status == 1) {
	$qrsj = TIME;
} 

$chkcode = $_GET['token']; //验证密钥  那个验证参数token已经增加。验证的规则是token=MD5(MD5(登录密码)+订单编号+商品编号)
$code = strtoupper(md5(strtoupper(md5($webset['weiyi']['pwd'])).$order_code.$product_code));
if($code!=$chkcode){
	dd_exit('Does not match');
}

$unique_id = $order_code . '*' . $product_code; //唯一编号，定单号+商品编号可确定唯		
$mall_order = $duoduo -> select("mall_order", "*", 'unique_id="' . $unique_id . '"  and lm=5');
if($mall_order['uid']>0){
	$uid=$mall_order['uid'];
}

if ($uid > 0) {
	$dduser = $duoduo -> select('user', 'id,ddusername,type,tjr', 'id="' . $uid . '"');
} else {
	$dduser = array('level' => 0, 'tjr' => 0);
} 

$fxje = fenduan($commission, $webset['mallfxbl'], $dduser['type']);
$jifen = round($fxje * $webset['jifenbl']);
if ($mall['type'] == 2) { // 返积分
	$fxje = 0;
} 
if ($user['tjr'] > 0) {
	$tgyj = round($fxje * $webset['tgbl']);
} else {
	$tgyj = 0;
} 
$field_arr = array ('adid' => $weiyi_merchant,
	'lm' => 5,
	'adid' => $weiyiid,
	'order_time' => $order_time,
	'mall_name' => $mall_name,
	'mall_id' => (int)$mall['id'],
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
	'addtime' => TIME,
	'unique_id' => $unique_id,
);
if ($status == 1) {
	$field_arr['qrsj'] = $qrsj;
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
echo '[success]';
?>