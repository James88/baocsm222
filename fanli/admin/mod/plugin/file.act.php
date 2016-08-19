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
if(!defined('ADMIN')){
	exit('Access Denied');
}

$code=$_GET['code'];
if($code==''){
	jump(-1,'数据错误');
}

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;

$total=$duoduo->count('plugin_file','code="'.$code.'"');
$files=$duoduo->select_all('plugin_file','*','code="'.$code.'" order by `update_tag` desc limit '.$frmnum.','.$pagesize);

?>