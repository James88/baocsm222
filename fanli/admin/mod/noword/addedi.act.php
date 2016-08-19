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
    $id=empty($_POST['id'])?0:(int)$_POST['id'];
	unset($_POST['id']);
	unset($_POST['sub']);
	$_POST['replace']=$_POST['replace']?$_POST['replace']:'****';
	if($_POST['title_arr']!=''){
		$_POST['title_arr']=str_replace('，',',',$_POST['title_arr']);
		$_POST['title_arr']=explode(',',$_POST['title_arr']);
		$_POST['title_arr']=serialize($_POST['title_arr']);
	}
	if($id==0){
		$id=$duoduo->insert(MOD,$_POST);
		$word='保存成功';
	}
	else{
	    $duoduo->update(MOD,$_POST,'id="'.$id.'"');
		$word='修改成功';
	}
	
	include(ADMINROOT.'/mod/public/mod.update.php');
	
	jump('-2',$word);
}
else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
    if($id==0){
	    $row=array();
	}
	else{
	    $row=$duoduo->select(MOD,'*','id="'.$id.'"');
		$row['title_arr']=unserialize($row['title_arr']);
		$row['title_arr']=implode(',',$row['title_arr']);
	}
}
?>