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

if(!defined('INDEX')){
	exit('Access Denied');
}

function act_wap_login(){
	global $duoduo,$dd_tpl_data;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	
	if($dduser['id']>0){
		jump(wap_l(MOD,'index'));
	}
	
	$webtitle=$dd_tpl_data['title'].'-登录';

	$_POST=$_GET;
	$param=$duoduo->login('wap');
	
	unset($duoduo);
	unset($webset);
	unset($dduser);
	unset($dd_tpl_data);
	$parameter['from']=$param['url_from'];
	$parameter['show_yzm']=$param['show_yzm'];
	$parameter['webtitle']=$webtitle;
	return $parameter;
}
?>