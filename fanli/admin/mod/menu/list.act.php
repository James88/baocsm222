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

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;
$q=$_GET['q'];
if(isset($_GET['parent_id']) && $_GET['parent_id']!=0){
	$parent_id=$_GET['parent_id'];
	$where=' and parent_id="'.$parent_id.'"';
}
else{
    $where='';
}
$total=$duoduo->count(MOD,"`title` like '%$q%'".$where);
$row=$duoduo->select_all(MOD,'*','`title` like "%'.$q.'%"'.$where.' order by id desc limit '.$frmnum.','.$pagesize);