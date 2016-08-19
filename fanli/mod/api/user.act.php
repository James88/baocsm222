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

if(!defined('INDEX')){
	exit('Access Denied');
}

$uid=(int)$_GET['uid'];
$username=trim($_GET['username']);
$password=trim($_GET['password']);
$do=trim($_GET['do']);

if($do=='check'){
	$id=(int)$duoduo->select('user','id','id="'.$uid.'" and ddpassword="'.$password.'"');
	if($id>0){
		$re=array('s'=>1);
	}
	else{
		$re=array('s'=>0,'r'=>'帐号密码错误');
	}
}
echo dd_json_encode($re);