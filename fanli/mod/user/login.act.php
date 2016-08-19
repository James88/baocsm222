<?php
/**
 * ============================================================================
 * 版权所有 多多科技，保留所有权利。
网站地址: http://soft.duoduo123.com；
----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
使用；不允许对程序代码以任何形式任何目的的再发布。
============================================================================
 */

if (!defined('INDEX')) {
	exit('Access Denied');
} 
/**
* @name 用户登陆
* @copyright duoduo123.com
* @example 示例user_login();
* @return $parameter 结果集合
*/

function act_user_login(){
	global $duoduo;
	$parameter=$duoduo->login();
	unset($duoduo);
	return $parameter;
}
?>