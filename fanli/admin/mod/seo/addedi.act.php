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
	del_magic_quotes_gpc($_POST,1);
	$title=template_parse(str_replace("\'","'",$_POST['title']));
	$keyword=template_parse(str_replace("\'","'",$_POST['keyword']));
	$desc=template_parse(str_replace("\'","'",$_POST['desc']));

	$page_title='<title>'.$title."</title> <!--网站标题-->\r\n";
    $page_title.='<meta name="keywords" content="'.$keyword.'" />'."\r\n";
    $page_title.='<meta name="description" content="'.$desc.'" />'."\r\n";
	$pagetag=$_POST['mod'].'_'.$_POST['act'];
	create_file(DDROOT.'/data/title/'.$pagetag.'.title.php',$page_title);
	
	if($id==0){
		if(!isset($_POST['addtime']) || $_POST['addtime']==''){$_POST['addtime']=TIME;}
	    $id=$duoduo->insert(MOD,$_POST);
		$word='保存成功';
	}
	else{
		unset($_POST['addtime']);
	    $duoduo->update(MOD,$_POST,'id="'.$id.'"');
		$word='修改成功';
	}
	jump('-2',$word);
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