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

if(!isset($_POST['sub'])){
	if(isset($_POST['key'])){
		$key=trim($_POST['key']);
		$domain=get_domain(URL);
		$url=DD_YUN_URL.'/index.php?m=Api&a=one&key='.$key.'&domain='.$domain;
		dd_exit(dd_get($url));
	}
}
else{
	$plugin_set=dd_get_cache('plugin');
	$plugin_set[$_POST['code']]=$_POST['status'];
	dd_set_cache('plugin',$plugin_set);
	
	if($_POST['search_open']==1){
		$code=$_POST['code'];
		$a=dd_get_cache('plugin_nav_search');
		if(empty($a)) $a=array();
		$a[$code]=array('mod'=>$_POST['mod'],'act'=>$_POST['act'],'name'=>$_POST['search_name'],'value'=>$_POST['search_tip'],'width'=>$_POST['search_width']);
		dd_set_cache('plugin_nav_search',$a);
	}
	else{
		$code=$_POST['code'];
		$a=dd_get_cache('plugin_nav_search');
		if(isset($a[$code])){
			unset($a[$code]);
			dd_set_cache('plugin_nav_search',$a);
		}
	}
}
include(ADMINROOT.'/mod/public/addedi.act.php');
?>