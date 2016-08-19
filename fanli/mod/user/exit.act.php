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

$ucid=$dduser['ucid'];
$user['id']=$dduser['id'];
$user['name']=$dduser['name'];
$user['password']=0;
$user['email']=$dduser['email'];
$user['cookietime']=0;

set_cookie("userlogininfo",'',0);
set_cookie("tjr",'',0);
if($webset['ucenter']['open']==1 && $ucid>0){
	include DDROOT.'/comm/uc_define.php';
	include DDROOT.'/uc_client/client.php';
	echo uc_user_synlogout($dduser['ucid']);
}
if($_GET['from']!=''){
	$goto=$_GET['from'];
}
else{
	$goto=u('index');
}
if($webset['phpwind']['open']==1){
	if(isset($_GET['forward'])){
		$goto=$_GET['forward'];
	}
    $goto=$duoduo->phpwind($user,$goto);
}
jump($goto);
?>