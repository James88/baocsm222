<?php

//针对php脚本文件执行锁定的代码，避免脚本在同一时间重复运行，http://gump.me/
define('PHP_LOCK_FILE', dirname(__FILE__) . '/php.lock');
ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);

global $php_lock_fp;
$php_lock_fp = @fopen(PHP_LOCK_FILE, "w+") or die("Couldn't open the lock file !\n");

if (flock($php_lock_fp, LOCK_EX + LOCK_NB)) {   //排它型锁定
	register_shutdown_function('php_release_lock');  //当脚本结束时执行该方法,用于解锁
	fwrite($php_lock_fp, getmypid());
} else {
	@fclose($php_lock_fp);
	exit("Couldn't lock the file !\n");
}

function php_release_lock()
{
	global $php_lock_fp;
	if(is_resource($php_lock_fp)){
		flock($php_lock_fp, LOCK_UN);  //释放锁定
		@fclose($php_lock_fp);
	}
	@unlink(PHP_LOCK_FILE);
}
?>
