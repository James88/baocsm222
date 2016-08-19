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
$code=$_GET['code'];
$cid=$_GET['cid'];
$from=$_GET['from'];
$page=$_GET['page']?$_GET['page']:1;
$page_size=100;
$goods=$duoduo->select_all('goods','*',' sort>0 ORDER BY sort desc LIMIT '.$page_size);
if($page>1&&empty($goods)){
	jump($from?$from:u(MOD,'list'),'排序成功');
}
if(empty($goods)){
	//随机排序
	$where='1';
	if($code!=''){
		$where.=' and code="'.$code.'"';
	}
	if($cid>0){
		$where.=' and cid="'.$cid.'"';
	}
	$duoduo->query('update '.BIAOTOU.'goods set `sort`=(RAND()*10000) where '.$where.' and addtime>'.strtotime(date('Y-m-d 00:00:00')));
	$goods=$duoduo->select_all('goods','*',' sort>0 ORDER BY sort desc LIMIT '.$page_size);
}
foreach($goods as $vo){
	$duoduo->delete('goods','id='.$vo['id']);
	unset($vo['id']);
	$vo['sort']=0;
	$duoduo->insert('goods',$vo);
}
$page++;
$jump_url=u(MOD,ACT,array('page'=>$page,'from'=>$from,'code'=>$code,'cid'=>$cid));
PutInfo("接下来排序".$page.'页<br/><br/><img src="../images/wait2.gif" />',$jump_url);
?>