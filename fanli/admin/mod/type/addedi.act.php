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
if($_GET['do']=='chongzhi'){
	include(DDROOT.'/comm/ddu.class.php');
	$ddu=new ddu();
	$data=$ddu->goods_type();
	if($data['s']==0){
		jump(-1,$data['r']);
		exit();
	}
	foreach($data['r'] as $key=>$vo){
		$add=array();
		$add['id']=$key;
		$add['title']=$vo;
		$add['sort']=0;
		$add['tag']='goods';
		$add['addtime']=time();
		$add['sys']=1;
		$id=$duoduo->replace('type',$add);
		echo mysql_error();
	}
	jump(-1,'同步完成');
	exit();
}
if($_POST['sub']!=''){
    $id=empty($_POST['id'])?0:(int)$_POST['id'];
	$_POST['sort']=$_POST['sort']?(int)$_POST['sort']:0;
	unset($_POST['id']);
	unset($_POST['sub']);
	if($id==0){
		if(!isset($_POST['addtime']) || $_POST['addtime']==''){
			$_POST['addtime']=TIME;
		}
	    $id=$duoduo->insert('type',$_POST);
		$word='保存成功';
	}
	else{
	    $duoduo->update('type',$_POST,'id="'.$id.'"');
		$word='修改成功';
	}
	include(ADMINROOT.'/mod/public/mod.update.php');
	jump('-2',$word);
}
else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
	$do=$_GET['do'];
    if($id==0){
	    $row=array();
	}
	else{
	    $row=$duoduo->select('type','*','id="'.$id.'"');
		if($do=='add'){
		    $row=array();
			$pid=$id;
		}
		elseif($do=='edi'){
		    $pid=$duoduo->select('type','pid','id="'.$id.'"');
		}
	}
}
?>