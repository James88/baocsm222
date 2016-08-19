<?php
/**
这个计划任务是删除所有缓存
**/

if(!defined('DDROOT')){
	exit('Access Denied');
}

define('STIME',$_SERVER['REQUEST_TIME']);
define('DEL_SESS',1);
$word='所有目录';
$path=DDROOT.'/data/temp/';

del_cache($path,$word,$admin_run);

if($admin_run==1){
	if(is_dir($path)){
		del_cache($path,$word);
		define('CRON_ADMIN_TIP','执行完毕');
		echo script('alert("删除缓存完成");window.close()');
	}
	else{
		define('CRON_ADMIN_TIP','执行完毕');
		echo script('alert("删除缓存完成");window.close()');
	}
}
?>