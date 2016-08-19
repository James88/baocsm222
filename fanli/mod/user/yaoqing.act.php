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
 * 
 * @name 邀请好友
 * @copyright duoduo123.com
 * @example 示例user_shoutu();
 * @param  $field 字段
 * @param  $pagesize 每页显示多少
 * @return $parameter 结果集合
 */
function dd_act($pagesize = 10,$field= 'id,ddusername,level,loginnum,regtime') {
	global $duoduo;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	if ($webset['user']['shoutu'] == 0) {
		jump('index.php');
	} 

	$do = $_GET['do']?$_GET['do']:'url';
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$page2 = ($page-1) * $pagesize;

	if ($do == 'list') {
		$total = $duoduo -> count('user', " tjr='" . $dduser["id"] . "'");
		$tuiguang = $duoduo -> select_all('user',$field, " tjr='" . $dduser["id"] . "' order by id desc limit $page2,$pagesize");

		foreach($tuiguang as $k => $row) {
			$tuiguang[$k]['yj'] = (float)$duoduo -> select('tgyj', 'money', 'tjrid="' . $dduser["id"] . '" and uid="' . $row['id'] . '"');
		} 
	} elseif ($do == 'list2') {
		$total = $duoduo -> count('user', " tjr_over='" . $dduser["id"] . "'");
		$tuiguang = $duoduo -> select_all('user',$field, " tjr_over='" . $dduser["id"] . "' order by id desc limit $page2,$pagesize");

		foreach($tuiguang as $k => $row) {
			$tuiguang[$k]['yj'] = (float)$duoduo -> select('tgyj', 'money', 'tjrid="' . $dduser["id"] . '" and uid="' . $row['id'] . '"');
		} 
	}
	unset($duoduo);
	$parameter['do']=$do;
	$parameter['tuiguang']=$tuiguang;
	$parameter['total']=$total;
	$parameter['pagesize']=$pagesize;
	$parameter['page2']=$page2;
	$parameter['rec']=urlencode(ddStrCode($dduser['id'],DDKEY));
	return $parameter;
} 

?>