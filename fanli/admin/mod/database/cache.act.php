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
	if(!isset($_POST['static']['index']['index'])){
		$_POST['static']['index']['index']=0;
	}
}

if($_POST['sub']!=''){
	foreach($_POST as $k=>$v){
		if(is_array($v)){
			$post_arr = $duoduo->webset_part($k,$v);
			$v=$post_arr[$k];
		}
		$duoduo->set_webset($k,$v);
	}
	$duoduo->webset(); //配置缓存
	jump('-1','保存成功！');
}
?>