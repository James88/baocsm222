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

//获取推荐人信息
if(isset($_GET["rec"])){
	if(!is_numeric($_GET["rec"])){
		$_GET["rec"]=ddStrCode($_GET["rec"],DDKEY,'DECODE');
	}
    if((int)$_GET["rec"]>0){
        set_cookie('tjr',(int)$_GET["rec"],3600);
    }
}

$apps = dd_get_cache('apps');
if(!empty($apps)){
	$app_show=1;
}
else{
	$app_show=0;
}

$nav=dd_get_cache('nav');

if($webset['bijia']['open']==1 || $webset['yiqifaapi']['open']==1 || $webset['wujiumiaoapi']['open']==1){
	$mallapiopen=1;
}

$userlogininfo=unserialize(get_cookie('userlogininfo')); 

$hcookieuid = $userlogininfo['uid']; 
$hcookiepassword = $userlogininfo['ddpassword']; 
$hcookiesavetime = $userlogininfo['ddsavetime'];

$dduser['name'] = '';
$dduser['id'] = 0;
$dduser['level'] = 0;
if($hcookieuid>0 && $hcookiepassword<>NULL){	
	$user=$duoduo->select('user','*',"id='".$hcookieuid."' and ddpassword='".$hcookiepassword."'");
	if($user['id']>0){
		$dduser=$user;
		$dduser['name'] = $user['ddusername'];
		$dduser['type'] = (int)$dduser['type'];
		$dduser['level'] = (int)$dduser['level'];
		unset($dduser['ddusername']);
		list($dduser['reg_from'],$dduser['email'])=reg_web_email($dduser['email']);
		$dduser['jifenbao'] = jfb_data_type($user['jifenbao']);
		$dduser['mobile'] = $user['mobile']=='0'?'':$user['mobile'];
		if($dduser['mobile']==''){
			$dduser['mobile_test']=0;
		}
		$dduser['bank_code']=$user['bank_code']!=0?$user['bank_code']:'';
		$msgnum = $duoduo->count('msg',"uid='".$dduser['id']."' and see=0");
		$dduser=$duoduo->freeze_user($dduser);
    }
	else{
        set_cookie('userlogininfo','',0);
    }
}
else{
    set_cookie('userlogininfo','',0);
}
$duoduo->dduser=$dduser;

$dd_have_tdj=1;
$t=app_status();
if($t===0){
	$app_status=0;
}
else{
	$app_status=1;
	$webset['app']['erweima']=$t['sj']['erweima'];
}
?>