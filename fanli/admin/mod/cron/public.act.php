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

$leixing_arr=array(0=>'系统',1=>'插件',2=>'采集板块');
$fangshi_arr=array(1=>'定时',2=>'间歇','概率');

function cron_cache(){
	global $duoduo;
	$cron=$duoduo->select_all('cron','*');
	foreach($cron as $row){
		if(strpos($row['dev'],'a:')===0){
			$row['dev']=unserialize($row['dev']);
		}
		$_cron[$row['id']]=$row;
	}
	dd_set_cache('cron',$_cron);
}

function cron_addedi(){
	cron_cache();
}

function cron_del(){
	cron_cache();
}