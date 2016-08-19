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
/**
* @name 用户首页
* @copyright duoduo123.com
* @example 示例user_index();
* @return $parameter 结果集合
*/
function act_user_index(){
	global $duoduo,$dd_user_class,$app_show;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	$spend_jifenbao=$duoduo->sum('duihuan','spend','`mode`=1 and status=1 and uid="'.$dduser['id'].'"');
	$spend_jifen=$duoduo->sum('duihuan','spend','`mode`=2 and status=1 and uid="'.$dduser['id'].'"');
	
	$data=array('lastlogintime'=>SJ);
	$duoduo->update('user',$data,'id="'.$dduser['id'].'"');
	unset($data);
	
	$dengji_img = "<img src='images/v".$dduser['type'].".gif' alt='".$v."' />";
	
	$default_pwd=$dd_user_class->get_default_pwd($dduser['id']);
	
	$sign=0;
	if($webset['sign']['open']==1){
		$todaytime=strtotime(date('Y-m-d 00:00:00'));
		if($dduser['signtime']<$todaytime){
			$sign=1;
		}
		else{
			$sign=0;
		}
	}
	
	if($app_show==1){
		$apilogin_id=$duoduo->select('apilogin','id','uid="'.$dduser['id'].'"');
		$apilogin_id=$apilogin_id>0?$apilogin_id:0;
	}
	
	if($app_show==1 && $apilogin_id==0){
		$api_login_tip=1;
	}
	else{
		$api_login_tip=0;
	}
	
	if($dduser['alipay']=='' && $dduser['tenpay']=='' && $dduser['bank_code']=='' && FANLI==1){
		$caiwu_tip=1;
	}
	else{
		$caiwu_tip=0;
	}

	if($webset['sms']['open']==1 && ($dduser['mobile']=='' || $dduser['mobile_test']==0)){
		$mobile_tip=1;
	}
	else{
		$mobile_tip=0;
	}

	if($dduser['tbnick']=='' && TAOTYPE==1 && FANLI==1){
		$tbnick_tip=1;
	}
	else{
		$tbnick_tip=0;
	}
	
	unset($duoduo);
	$parameter['spend_jifenbao']=$spend_jifenbao;
	$parameter['spend_jifen']=$spend_jifen;
	$parameter['data']=$data;
	$parameter['web_level']=$web_level;
	$parameter['m']=$m;
	$parameter['default_pwd']=$default_pwd;
	$parameter['app_show']=$app_show;
	$parameter['apilogin_id']=$apilogin_id;
	$parameter['api_login_tip']=$api_login_tip;
	$parameter['caiwu_tip']=$caiwu_tip;
	$parameter['mobile_tip']=$mobile_tip;
	$parameter['tbnick_tip']=$tbnick_tip;
	$parameter['sign']=$sign;
	$parameter['dengji_img']=$dengji_img;
	return $parameter;
}
?>