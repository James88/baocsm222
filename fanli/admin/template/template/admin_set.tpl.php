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

if(!empty($_POST)){
	del_magic_quotes_gpc($_POST,1);
}

if(!file_exists(DDROOT.'/data/json/tpl')){
	MkdirAll(DDROOT.'/data/json/tpl');
}

$tpl=$_GET['tpl'];
$title=$_GET['title'];
$tpl_type=$_GET['tpl_type'];
define(MOBAN_NAME,$tpl);

if($tpl_type=='pc'){
	$tpl_dir='template';
}
elseif($tpl_type=='wap'){
	$tpl_dir='m/template';
}

include(DDROOT.'/'.$tpl_dir.'/'.MOBAN_NAME.'/admin_set/public.php');

$j=0;
foreach($tpl_set_nav as $k=>$v){
	if($j==0 && !isset($_GET['curnav'])){
		$_GET['curnav']=$k;
	}
	$j++;
	$top_nav_name[]=array('url'=>u(MOD,ACT,array('tpl_admin_file'=>$k,'tpl'=>$tpl,'title'=>$title,'curnav'=>$k,'tpl_type'=>$tpl_type)),'name'=>$v,'curnav'=>$k);
}

$tpl_admin_file=$_GET['tpl_admin_file']?$_GET['tpl_admin_file']:$_GET['curnav'];

if(!isset($_GET['no_header']) && !isset($_POST['no_header'])){
	include(ADMINTPL.'/header.tpl.php');
}

$action_url='index.php?mod='.MOD.'&act='.ACT.'&tpl='.MOBAN_NAME.'&tpl_type='.$tpl_type.'&tpl_admin_file='.$tpl_admin_file.'&no_header=1';

include(DDROOT.'/'.$tpl_dir.'/'.MOBAN_NAME.'/admin_set/'.$tpl_admin_file.'.php');

if(!isset($_GET['no_header']) && !isset($_POST['no_header'])){
	include(ADMINTPL.'/footer.tpl.php');
}
?>