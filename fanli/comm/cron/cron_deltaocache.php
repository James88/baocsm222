<?php
/**
这个计划任务是删除淘宝api缓存
**/

if(!defined('DDROOT')){
	exit('Access Denied');
}

define('STIME',$_SERVER['REQUEST_TIME']);
$word='淘宝';
$path=DDROOT.'/data/temp/taoapi';

del_cache($path,$word,$admin_run);

if($admin_run==1){
	if(is_dir($path)){
		del_cache($path,$word);
		if(!is_dir($path)){
			define('CRON_ADMIN_TIP','执行完毕');
		}
	}
	else{
		define('CRON_ADMIN_TIP','执行完毕');
	}
}
?>