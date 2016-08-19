<?php
/**
这个计划任务是删除临时缓存
**/

if(!defined('DDROOT')){
	exit('Access Denied');
}

define('STIME',$_SERVER['REQUEST_TIME']);
define('DEL_SESS',1);
$word='临时目录';
$path=DDROOT.'/data/temp/session';

del_cache($path,$word,$admin_run);

if($admin_run==1){
	if(is_dir($path)){
		del_cache($path,$word);
		define('CRON_ADMIN_TIP','执行完毕');
	}
	else{
		define('CRON_ADMIN_TIP','执行完毕');
	}
}
?>