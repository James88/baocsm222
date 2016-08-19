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
	del_magic_quotes_gpc($_POST,1);
    $id=empty($_POST['id'])?0:(int)$_POST['id'];
	unset($_POST['id']);
	unset($_POST['sub']);
	unset($_POST['moshi']);
	$edate=$_POST['edate']=(int)strtotime($_POST['edate']);
	$width=(int)$_POST['width'];
	$height=(int)$_POST['height'];
	$tag=trim($_POST['tag']);
	$bgcolor=trim($_POST['bgcolor']);
	if($tag!=''){
		$tid=$duoduo->select('ad','id','tag="'.$tag.'" and id<>"'.$id.'"');
		if($tid>0){
			jump(-1,'广告标识已被占用');
		}
	}
	if($id==0){
		$_POST['addtime']=TIME;
	    $id=$duoduo->insert('ad',$_POST);
		$word='保存成功';
	}
	else{
		$_POST['id']=$_POST['ad_id'];
		unset($_POST['ad_id']);
	    $duoduo->update('ad',$_POST,'id="'.$id.'"');
		$word='修改成功';
	}
	
	$a=$duoduo->select('ad','*','id="'.$id.'"');
	ad_catch($a);
	jump('-2',$word);
}
else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
    if($id==0){
	    $row=array();
	}
	else{
	    $row=$duoduo->select('ad','*','id="'.$id.'"');
	}
}