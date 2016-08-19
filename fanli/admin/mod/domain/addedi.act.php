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

function domain_addedi($data,$id){
	domian_cache();
}

if($_POST['sub']!=''){
	if($_POST['url']==''){
		jump(-1,'域名不能为空');
	}
	
	$domain_id=(int)$duoduo->select('domain','id','url="'.$_POST['url'].'"');
	if($domain_id>0 && $_POST['id']==0){
		jump(-1,'域名已存在');
	}
	
	$_POST['url']=preg_replace('#^http[s]?://#','',$_POST['url']);
	$_POST['url']=preg_replace('#/$#','',$_POST['url']);
	if($_POST['mod']!='goods'){
		$_POST['code']='';
	}
}
include(ADMINROOT.'/mod/public/addedi.act.php');