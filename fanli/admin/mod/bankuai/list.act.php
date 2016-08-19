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
$reycle=(int)$_GET['reycle'];
if($_GET['update']=='sort'){
	$id=$_GET['id'];
	$v=$_GET['v'];
	$f=$_GET['f'];
	$data=array($f=>$v);
	$duoduo->update('bankuai',$data,'id="'.$id.'"');
	dd_exit(1);
}

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;

$where.=" and del=".$reycle;
$total=$duoduo->count('bankuai'," 1 ".$where);
$data=$duoduo->select_all('bankuai','*','1 '.$where.' order by sort=0 asc,sort asc,id desc limit '.$frmnum.','.$pagesize);
