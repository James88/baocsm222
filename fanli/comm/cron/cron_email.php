<?php
/**
这个计划任务是进后队列发送邮件
**/

if(!defined('DDROOT')){
	exit('Access Denied');
}

define('CRON_ADMIN_TIP','执行完毕');

$duoduo->cron(1);
?>