<?php
/**
这个计划任务是删除拍拍缓存
**/

if(!defined('DDROOT')){
	exit('Access Denied');
}

define('STIME',$_SERVER['REQUEST_TIME']);
$word='拍拍';
$path=DDROOT.'/data/temp/paipai';

del_cache($path,$word,$admin_run);

if($admin_run==1){
	if(is_dir($path)){
		del_cache($path,$word);
		if(!is_dir($path)){
			define('CRON_ADMIN_TIP','执行完毕');
			echo script('alert("删除缓存");window.close()');
		}
	}
	else{
		define('CRON_ADMIN_TIP','执行完毕');
		echo script('alert("删除缓存");window.close()');
	}
}
?>