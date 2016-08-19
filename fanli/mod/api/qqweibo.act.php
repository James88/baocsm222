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

dd_session_start();
set_include_path(DDROOT.'/api/qqweibo/');
include_once 'OpenSDK/Tencent/Weibo.php';
$app = $duoduo->select('api', '`key`,secret,title,code,open', 'code="'.ACT.'"');
$do=$_GET['do']?$_GET['do']:'go';
OpenSDK_Tencent_Weibo::init($app['key'], $app['secret']);

if($do=='go'){ //登陆QQ
	$mini=true;
	$callback = SITEURL.'/index.php?mod=api&act='.ACT.'&do=back';
	$request_token = OpenSDK_Tencent_Weibo::getRequestToken($callback);
	$url = OpenSDK_Tencent_Weibo::getAuthorizeURL($request_token);
	header('Location: ' . $url);
}
elseif($do=='back'){  //回调
    if( isset($_GET['oauth_token']) && isset($_GET['oauth_verifier'])){
		OpenSDK_Tencent_Weibo :: getAccessToken($_GET['oauth_verifier']);
	    $userinfo = OpenSDK_Tencent_Weibo::call('user/info');
		if($userinfo['errcode']>0){dd_exit('错误：'.$userinfo['msg'].$userinfo['errcode']);}
	}
	
	$name=$userinfo['data']['nick'];
    if($name==''){$name='qq'.rand(1000,9999);} //个别情况名字会为空
	$id=$userinfo['data']['openid'];
	
	if ($name!='' && $id!='') {
		$webname=$name;
		$webid=$id;
		$web=ACT;
		$input=array('webname'=>$webname,'webid'=>$webid,'web'=>$web);
		echo postform(u('api','do'),$input);
	}
}
?>