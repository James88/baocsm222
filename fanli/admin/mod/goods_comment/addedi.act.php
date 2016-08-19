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
	/*del_magic_quotes_gpc($_POST,1);
    $id=empty($_POST['id'])?0:(int)$_POST['id'];
	unset($_POST['id']);
	unset($_POST['sub']);
	$duoduo->update(MOD,$_POST,'id="'.$id.'"');
	jump(u(MOD,'list'),'修改完成');*/
	include(ADMINROOT.'/mod/public/addedi.act.php');
}
else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
    if($id==0){
	    $row=array();
	}
	else{
	    $comment=$duoduo->select(MOD,'*','id="'.$id.'"');
		$comment['title']=$duoduo->select('goods','title','id="'.$comment['data_id'].'"');
	}
}