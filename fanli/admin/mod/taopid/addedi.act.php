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
if($_GET['do']=='check'){
	$id=$duoduo->select('taopid','id','title="'.trim($_GET['title']).'" and id<>"'.(int)$_GET['id'].'"');
	if($id>0){
		echo 1;
	}else{
		echo 0;
	}
	dd_exit();
}
if($_POST['sub']!=''){
	$id=empty($_POST['id'])?0:(int)$_POST['id'];
	$status=$_POST['status'];
	unset($_POST['id']);
	unset($_POST['sub']);
	if($_POST['default']==1 && $_POST['url']!='' && $_POST['pid']!=''){
		$duoduo->update(MOD,array('default'=>0),'`default`=1 and id<>"'.$id.'"');
	}
	$_POST['addtime']=TIME;
	if($id==0){
		$id=$duoduo->insert(MOD,$_POST);
		$word='保存';
	}
	else{
		$duoduo->update(MOD,$_POST,'id="'.$id.'"');
		$word='修改';
	}
	if(mysql_error()!=''){
		echo $duoduo->lastsql;
		exit(mysql_error());
	}
	if($_POST['default']==1){
		$duoduo->set_webset('TDJ_URL',$_POST['url']);
		$duoduo->set_webset('taodianjin_pid',$_POST['pid']);
		$duoduo->webset(); //配置缓存
	}
	taopid_cache();//配置pid缓存
	jump('-2',$word.'成功');
}else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
    if($id==0){
	    $row=array();
	}
	else{
	    $row=$duoduo->select(MOD,'*','id="'.$id.'"');
	}
}