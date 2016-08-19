<?php
/**
 * ============================================================================
 * 版权所有 2008-2013 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('INDEX')){
	exit('Access Denied');
}

$plugin_mod_act=dd_get_cache('plugin_mod_act');
foreach($plugin_mod_act as $row){
	if(!in_array($row['mod'],$front_mod_arr)){
		$front_mod_arr[]=$row['mod'];
	}
	$name=$row['mod'].'_act_arr';
	if(!isset($$name)){
		$$name=array();
	}
	array_push($$name,$row['act']);
}
?>