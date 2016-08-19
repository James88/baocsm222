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
	if($_POST['adminpass']==''){
	    unset($_POST['adminpass']);
	}
	else{
	    $_POST['adminpass']=deep_jm($_POST['adminpass']);
	}
	
    $id=empty($_POST['id'])?0:(int)$_POST['id'];
	unset($_POST['id']);
	unset($_POST['sub']);
	if($id==0){
		if(!isset($_POST['addtime']) || $_POST['addtime']==''){$_POST['addtime']=TIME;}
		$id=$duoduo->select('duoduo2010','id','adminname="'.$_POST['adminname'].'"');
		if($id>0){jump('-1','名称已存在');}
	    $id=$duoduo->insert(MOD,$_POST);
		jump('-2','保存成功');
	}
	else{
		if($_POST['adminpass']==''){unset($_POST['adminpass']);}
		unset($_POST['addtime']);
	    $duoduo->update(MOD,$_POST,'id="'.$id.'"');
		jump('-2','修改成功');
	}
}
else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
    if($id==0){
	    $row=array();
	}
	else{
	    $row=$duoduo->select(MOD,'*','id="'.$id.'"');
	}
}
?>