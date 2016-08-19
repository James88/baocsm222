<?php
header("Content-type: text/html; charset=utf-8");
error_reporting(0);
date_default_timezone_set('PRC');
define('DDROOT', str_replace(DIRECTORY_SEPARATOR,'/',dirname(dirname(__FILE__))));
if($_SERVER['PHP_SELF']==''){
	$_SERVER['PHP_SELF']=$_SERVER['SCRIPT_NAME'];
}
if($_SERVER['REQUEST_URI']==''){
	$_SERVER['REQUEST_URI']=$_SERVER['REDIRECT_URL'];
}

if(!is_file(DDROOT.'/data/conn.php')){
    header('Location:install/index.php');
}

function catch_fatal_error(){
	$last_error =  error_get_last();
	if($last_error['type']==1 || $last_error['type']==4 || $last_error['type']==64 || $last_error['type']==4096){
		print_r($last_error['message']);
		print_r("<br/>");
		print_r(str_replace(DDROOT,'',str_replace(DIRECTORY_SEPARATOR,'/',$last_error['file'])).':'.$last_error['line']);
	}
}
register_shutdown_function('catch_fatal_error');

define('TODAY',date('Ymd'));

include (DDROOT . '/data/conn.php');
include (DDROOT . '/comm/lib.php');

$banben=include(DDROOT.'/data/banben.php');
include_once(DDROOT.'/data/array/global.php');
define('BANBEN',$banben);

$duoduo = new duoduo();
$duoduo->dbserver=$dbserver;
$duoduo->dbuser=$dbuser;
$duoduo->dbpass=$dbpass;
$duoduo->dbname=$dbname;
$duoduo->BIAOTOU=BIAOTOU;
$duoduo_link=$duoduo->connect();
$errorData=include (DDROOT . '/data/error.php');
$duoduo->errorData=$errorData;

if(!defined('ADMIN')){
	$webset=dd_get_cache('webset');
	$constant=dd_get_cache('constant');
	
	if(empty($webset) || empty($constant)){  //个别网站配置文件没了
		$duoduo->webset();
		$webset=dd_get_cache('webset');
	}
	$duoduo->webset=$webset;
	
	foreach($constant as $k=>$v){
		if(!defined($k)){
			define($k,$v);
		}
	}
}
else{
	$webset=$duoduo->webset(101);
	$duoduo->webset=$webset;
	$duoduo->errorData=$errorData;
}

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' || isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME']=='https'){
	define('HTTP','https://');
}
else{
	define('HTTP','http://');
}
define('CURURL',HTTP.$_SERVER['HTTP_HOST'].URLMULU);
define('SITEURL',HTTP.URL);
define('DOMAIN',get_domain());
define('TIME',$_SERVER['REQUEST_TIME']+$webset['corrent_time']);
$sj=date('Y-m-d H:i:s',TIME);
define('SJ',$sj);
define('CUR_URL',HTTP.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
define('WEBNICK',WEBNAME);
define('CUR_WEB',$_SERVER['HTTP_HOST']);

$plugin_include=dd_get_cache('plugin_include');
if(!empty($plugin_include)){
	foreach($plugin_include as $code){
		$dir=DDROOT.'/plugin/'.$code.'/comm.php';
		$plugin_data=dd_get_cache('plugin/'.$code);
		if(file_exists($dir) && $plugin_data['status']==1){
			include($dir);
		}
	}
}
?>