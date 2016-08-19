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

if(isset($_POST['sub']) && $_POST['sub']!=''){
	del_magic_quotes_gpc($_POST,1);
	$from = $_POST['from'];
	$diff_arr=array('sub','from');
	$_POST=logout_key($_POST, $diff_arr);
	foreach($_POST as $k=>$v){
		if(is_array($v)){
			$post_arr = $duoduo->webset_part($k,$v);
			$v=$post_arr[$k];
		}
		else{
			$v=trim($v);
		}
		$duoduo->set_webset($k,$v);
	}
	$duoduo->webset(); //配置缓存
	if($from==''){
		$from=-1;
	}
	if($_GET['from_url']!=''){
		jump($_GET['from_url'],'保存成功');
	}
	else{
		jump(-1,'保存成功');
	}
}
else{
}