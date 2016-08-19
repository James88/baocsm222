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
if($_POST['sub']!=''){
	$type=$_POST['type'];
	$duoduo->set_webset($type,$_POST[$type]);
	$duoduo->webset(); //配置缓存
	jump(-1,'设置完成');
}
foreach($task_type_arr as $k=>$v){
	$top_nav_name[]=array('url'=>u('task','set',array('curnav'=>$k)),'name'=>$v,'curnav'=>$k);
}
if(empty($_GET['curnav'])){
	$_GET['curnav']='offer';
}
$curnav=$_GET['curnav'];
$flie_name=ADMINTPL.'/task/'.$curnav.'.tpl.php';
if(file_exists($flie_name)){
	include($flie_name);
}else{
	include(ADMINTPL.'/task/offer.tpl.php');
}