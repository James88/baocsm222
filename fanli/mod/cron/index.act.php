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

if(!defined('DDROOT')){
	exit('Access Denied');
}

include(DDROOT.'/comm/cron.class.php');
$cron=dd_get_cache('cron');
$cron_ex_array=array();
foreach($cron as $row){
	if($row['status']==0 || AJAX==1){
		continue;
	}
	
	$next_time=cron_next_time($row);
	if(time()>=strtotime($next_time) || $row['jindu']>0){
		$cron_ex_array[]=u('cron','run',array('t'=>ddStrCode(TIME,DDKEY),'cron_id'=>$row['id']));
	}
}

shuffle($cron_ex_array);
$cron_ex_array=array_slice($cron_ex_array,0,3); //每次随机取3个计划任务，防止多并发

//兼容老版本插件计划任务
if(!empty($dd_cron)){
	foreach($dd_cron as $row){
		if(rand(1,10)<=$row['rate']){
			if(!in_array($row['url'],$cron_ex_array)){
				$cron_ex_array[]=$row['url'];
			}
		}
	}
}

foreach($cron_ex_array as $v){
	if($webset['cron_chufa']==0 && INDEX==1){
		if(BACKSTAGE==1){
			only_send($v);
		}
		else{
			echo '<img style="width:1px; height:1px;filter:alpha(opacity=0);opacity:0" src="'.$v.'">'."\r\n";
		}
	}
	elseif($webset['cron_chufa']==1 && MOD=='cron' && ACT=='index'){
		dd_get($v);
	}
}
?>