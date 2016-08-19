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

if($_GET['set_chufa']){
	include(ADMINROOT.'/mod/public/set.act.php');
}

$cron=dd_get_cache('cron');
foreach($cron as $row){
	if(is_array($row['dev'])){
		$row['dev']=serialize($row['dev']);
	}
	$data=array('last_time'=>$row['last_time'],'msg'=>$row['msg'],'jindu'=>$row['jindu'],'dev'=>$row['dev']);
	$duoduo->update('cron',$data,'id="'.$row['id'].'"');
}

include(ADMINROOT.'/mod/public/list.act.php');