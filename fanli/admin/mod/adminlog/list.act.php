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

$se_arr=array('admin_name'=>'管理员名','mod'=>'模块');
$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;
$q=$_GET['q'];
$sday=$_GET['sday']?strtotime($_GET['sday'].' 00:00:00'):0;
$eday=$_GET['eday']?strtotime($_GET['eday'].' 23:59:59'):TIME;
$se=$_GET['se']?$_GET['se']:'mod';
$total=$duoduo->count(MOD,"`".$se."` like '%$q%'");
$row=$duoduo->select_all(MOD,'*','`'.$se.'` like "%'.$q.'%" and addtime>"'.$sday.'" and addtime<"'.$eday.'" order by id desc limit '.$frmnum.','.$pagesize);