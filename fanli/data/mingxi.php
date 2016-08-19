<?php
if(!defined('DDROOT')){
	exit('Access Denied');
}

$sys_mingxi=array (
	1 => array('title'=>'注册赠送','content'=>'注册赠送：金额{money}，'.TBMONEY.'{jifenbao}，积分{jifen}'),
	2 => array('title'=>'淘宝返利','content'=>'淘宝订单号：{source}，'.TBMONEY.'：{jifenbao}，积分{jifen}'),
	3 => array('title'=>'商城返利','content'=>'{source}，返利：{money}，积分{jifen}'),
	4 => array('title'=>'每日签到','content'=>'每日签到奖励：金额：{money}，'.TBMONEY.'：{jifenbao}，积分{jifen}'),
	5 => array('title'=>'分享奖励','content'=>'分享商品奖励：积分{jifen}，'.TBMONEY.'{jifenbao}'),
	6 => array('title'=>'推荐奖励','content'=>'金额：{money}，好友：{source}'),
	7 => array('title'=>'晒单奖励','content'=>'晒单商品奖励：积分{jifen}，'.TBMONEY.'{jifenbao}'),
	8 => array('title'=>'淘宝返利','content'=>'淘宝订单号：{source}，'.TBMONEY.'：{jifenbao}，积分{jifen}'), //淘宝找回订单
	9 => array('title'=>'提现成功','content'=>'提现成功：'.TBMONEY.'{jifenbao}，金额{money}，{source}'),
	10 => array('title'=>'兑换成功','content'=>'兑换成功：'.TBMONEY.'：{jifenbao}，积分{jifen}，商品：{source}'),
	11 => array('title'=>'好友提现','content'=>'好友提现奖励：金额{money}，好友：{source}'),
	12 => array('title'=>'商城返利','content'=>'{source}，金额：{money}，积分{jifen}'), //商城返利
	13 => array('title'=>'淘宝退款','content'=>'淘宝订单号：{source}，'.TBMONEY.'：{jifenbao}，积分{jifen}'), //退款
	14 => array('title'=>'淘宝退单','content'=>'淘宝订单号：{source}，'.TBMONEY.'：{jifenbao}，积分{jifen}'), //删除订单
	15 => array('title'=>'取消推广','content'=>'取消推广奖励：金额：{money}，好友：{source}'),
	16 => array('title'=>'红心奖励','content'=>'红心奖励：积分{jifen}，分享晒单商品id：{source}'),
	17 => array('title'=>'拍拍返利','content'=>'拍拍订单号：{source}，返利：{money}，积分{jifen}'),
	18 => array('title'=>'拍拍返利','content'=>'拍拍订单号：{source}，返利：{money}，积分{jifen}'), //拍拍找回订单
	19 => array('title'=>'余额修改','content'=>'改动金额：{money}'), //兼容老版程序
	20 => array('title'=>'站长奖励','content'=>'金额：{money}，'.TBMONEY.'：{jifenbao}，积分{jifen}'),
	21 => array('title'=>'站长扣除','content'=>'金额：{money}，'.TBMONEY.'：{jifenbao}，积分{jifen}'), 
	22 => array('title'=>'金额转换','content'=>'金额：{money}，'.TBMONEY.'：{jifenbao}'), 
	23 => array('title'=>'商城退款','content' => '{source}，金额：{money}，积分{jifen}'), 
	24 => array('title'=>'爆料有效奖励','content' => '{source}，金额：{money}，'.TBMONEY.'{jifenbao}，积分{jifen}'), 
	25 => array('title'=>'爆料推广奖励','content' => '{source}，金额：{money}'), 
	26 => array('title'=>'分享推广奖励','content' => '{source}，金额：{money}'), 
	27 => array('title'=>'爆料推广退回','content' => '{source}，金额：{money}'), 
	28 => array('title'=>'分享推广退回','content' => '{source}，金额：{money}'), 
	29 => array('title'=>'任务奖励','content'=>'{source}，金额：{money}'), 
	'gametask_1' => array('title'=>'任务奖励','content'=>'{source}，金额：{money}'), 
	'task_1' => array('title'=>'任务奖励','content'=>'{source}，金额：{money}'), 
	
);

$plugin=glob(DDROOT.'/plugin/*');
$plugin_mingxi=array();
foreach($plugin as $v){
	if(is_dir($v) && file_exists($v.'/set.php')){
		$set=include($v.'/set.php');
		if($set['mingxi']==1){
			$plugin_mingxi=include($v.'/mingxi.php');
			if(is_array($plugin_mingxi)){
				foreach($plugin_mingxi as $k=>$v){
					$sys_mingxi[$k]=$v;
				}
			}
		}
	}
}

foreach($plugin_mingxi as $k=>$row){
	$sys_mingxi[$k]=$row;
}

return $sys_mingxi;
?>