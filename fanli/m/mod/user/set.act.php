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

function set_user_info($duoduo,$uid){
	$dduser=$duoduo->select('user','*','id="'.$uid.'"');
	$old_password=trim($_GET['old_password']);
	if($_GET['email']!=''){
		$data['email']=trim($_GET['email']);
	}
	if($_GET['realname']!=''){
		$data['realname']=trim($_GET['realname']);
	}
	if($_GET['alipay']!=''){
		$data['alipay']=trim($_GET['alipay']);
	}
	if($_GET['mobile']!=''){
		$data['mobile']=trim($_GET['mobile']);
	}
	if($_GET['qq']!=''){
		$data['qq']=trim($_GET['qq']);
	}

	if(function_exists('get_4_tradeid')){
		$data['tbnick']=trim($_GET['tbnick']);
	}
			
	if($dduser['alipay']!=''){
		$data['alipay']=$dduser['alipay'];
	}
	if($dduser['realname']!=''){
		$data['realname']=$dduser['realname'];
	}
			
	if ($duoduo -> check_oldpass($old_password, $uid) == 'false') {
		$json_data=array('s'=>0,'r'=>'原密码错误！');
		return $json_data;
	} 
	if ($data['email']!='' && reg_email($data['email']) == 0) {
		$json_data=array('s'=>0,'r'=>'邮箱格式错误！');
		return $json_data;
	}
	if ($data['alipay']!='' && reg_alipay($data['alipay']) == 0) {
		$json_data=array('s'=>0,'r'=>'支付宝格式错误！');
		return $json_data;
	}
	if ($data['alipay']!='' && $duoduo -> check_my_field('alipay', $data['alipay'], $uid) > 0) {
		$json_data=array('s'=>0,'r'=>'支付宝已被使用！');
		return $json_data;
	}
		
	if ($data['mobile']!='' && reg_mobile($data['mobile']) == 0) {
		$json_data=array('s'=>0,'r'=>'手机格式错误！');
		return $json_data;
	}
	if ($data['qq']!='' && reg_qq($data['qq']) == 0) {
		$json_data=array('s'=>0,'r'=>'QQ格式错误！');
		return $json_data;
	}
	if ($duoduo -> check_my_email($data['email'], $dduser['id']) > 0) {
		$json_data=array('s'=>0,'r'=>'email已被使用！');
		return $json_data;
	}
			
	if($data['tbnick']!='' && function_exists('get_4_tradeid')){
		$trade_uid_arr=get_4_tradeid($data['tbnick']);
		foreach($trade_uid_arr as $v){
			if($v>0){
				$duoduo->trade_uid($uid,$v);
			}
		}
	}
	$duoduo->update('user',$data,'id="'.$uid.'"');
	$re=array('s'=>1);
	return $re;
}
		

function act_wap_user_set(){
	global $duoduo,$dd_tpl_data;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	
	if($dduser['id']==0){
		jump(wap_l('user','login'));
	}

	if($_GET['sub']!=''){
		$re=set_user_info($duoduo,$dduser['id']);
		exit(dd_json_encode($re));
	}
	
	$title='账号设置';
	$webtitle=$title.'-'.$dd_tpl_data['title'];
	
	$webid=$duoduo->select('apilogin','webid','uid="'.$dduser['id'].'"');
	$key_webid=dd_crc32(DDKEY.$webid);
	$key_md5webid=md5($key_webid);
	$md5webid=md5($webid);
	$md5pwd=$duoduo->select('user','ddpassword','id="'.$dduser['id'].'"');

	$default_pwd='';
	if($key_md5webid==$md5pwd){
		$default_pwd=$key_webid;
	}
	if($md5webid==$md5pwd){
		$default_pwd=$webid;
	}

	$parameter['webtitle']=$webtitle;
	$dduser['default_pwd']=$default_pwd;
	$parameter['dduser']=$dduser;
	
	unset($duoduo);
	unset($webset);
	unset($dduser);
	unset($dd_tpl_data);
	
	return $parameter;
}
?>