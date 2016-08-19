<?php
/**
 * ============================================================================
 * 版权所有 多多科技，保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}

if($_GET['qingkong']==1){
	$table=$_GET['table'];
	$duoduo->delete($table,'`del`=1');
	jump(u(MOD,ACT),'清空完成');
}

$table[]=array('table'=>'goods','title'=>'普通商品');
$table[]=array('table'=>'huan_goods','title'=>'兑换商品');
$table[]=array('table'=>'baobei','title'=>'晒单分享');
$table[]=array('table'=>'tradelist','title'=>'淘宝订单');
$table[]=array('table'=>'mall_order','title'=>'商城订单');
$table[]=array('table'=>'paipai_order','title'=>'拍拍订单');
$table[]=array('table'=>'duihuan','title'=>'兑换订单');
$table[]=array('table'=>'tixian','title'=>'提现列表');
$table[]=array('table'=>'user','title'=>'会员列表');
$table[]=array('table'=>'mall','title'=>'知名商城');
$table[]=array('table'=>'article','title'=>'文章列表');
$table[]=array('table'=>'task','title'=>'任务返利订单');
foreach($table as $k=>$v){
	$w=$v['code']?'del="1" and code="'.$v['code'].'"':'del=1';
	$recyle[$k]['num']=$duoduo->count($v['table'],$w);
	$recyle[$k]['title']=$v['title'];
	$recyle[$k]['table']=$v['table'];
	$recyle[$k]['url']=$v['code']?u($v['table'],'list',array('code'=>$v['code'],'reycle'=>1)):u($v['table'],'list',array('reycle'=>1));
}
$n=count($recyle);
$n=ceil($n/6);