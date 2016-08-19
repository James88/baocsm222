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

if($_GET['test']==1){
	$ip=$_GET['ip'];
	$user=$_GET['user'];
	$pwd=$_GET['pwd'];
	$port=$_GET['duankou'];
	$pasv=$_GET['pasv'];
	$timeout=$_GET['timeout'];
	$mulu=$_GET['mulu'];
	$url=$_GET['url'];
	$config=array('hostname' => $ip,'username' => $user,'password' => $pwd,'port' => $port,'pasv' => $pasv,'timeout' => $timeout,'mulu' => $mulu,'url' => $url);
	$ftp=fs('ftp',$config);
	copy(DDROOT.'/images/ftp_test.png',DDROOT.'/upload/ftp_test.png');
	echo $ftp->make_dir_file(DDROOT.'/upload/ftp_test.png',1);
	exit;
}

if($_POST['FTP_PWD']==DEFAULTPWD){
	unset($_POST['FTP_PWD']);
}

include(ADMINROOT.'/mod/public/set.act.php');