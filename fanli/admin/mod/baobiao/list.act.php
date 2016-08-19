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
include(ADMINTPL.'/baobiao/statement.php');

$page = !isset($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;

$date=plugin_statement_insert();
$total=$duoduo->count('statement','1');
$row=$duoduo->select_all('statement','*','1 order by date desc limit '.$frmnum.','.$pagesize);


//总数据
$list=$duoduo->sum('statement','taoyj,taolr,paiyj,pailr,mallyj,malllr,taskyj,tasklr','1');

//图表数据
$t=isset($_GET['t'])?$_GET['t']:'taoyj';
$n=isset($_GET['n'])?$_GET['n']:'淘宝总佣金';
$dataxml=plugin_statement_data($n,$t);

include(ADMINTPL.'/baobiao/FusionCharts.php');

$gourl='index.php?mod='.MOD.'&act='.ACT;
?>