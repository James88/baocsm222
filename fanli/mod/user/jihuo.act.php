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
* @name 用户激活
* @copyright duoduo123.com
* @example 示例user_jihuo();
* @return $parameter 结果集合
*/
function act_user_jihuo($field='ddusername,ddpassword,email,jihuo'){
	global $duoduo;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	$step=$_GET['step']?(int)$_GET['step']:1;
	if($step==1){
		$uid=(int)$_GET['uid'];
		$user=$duoduo->select('user',$field,'id="'.$uid.'"');
		$username=$user['ddusername'];
		$ddpassword=deep_jm($user['ddpassword']);
		$email=$user['email'];
		$jihuo=$user['jihuo'];
		if($user['ddusername']==''){
			jump(-1,'账户不存在');
		}
		elseif($user['jihuo']==1){
			jump(-1,'此账号无需激活');
		}
		else{
			$jihuo_code=base64_encode($uid.'{#}'.$ddpassword);
			$jihuo_url=u('user','jihuo',array('step'=>2,'jihuo_code'=>$jihuo_code));
			$msg_data['jihuo_url']=$jihuo_url;
			$msg_data['email']=$email;
			
			$msgset=dd_get_cache('msgset');
			$msg=$msgset[8]['email'];
			$title=$msgset[8]['title'];
			$msg=str_replace('{jihuo_url}',$jihuo_url,$msg);
			mail_send($email,$title,$msg);
			
			$email_web='http://mail.'.preg_replace('/(.*)@/','',$email);
			$msg='恭喜您注册成功，我们已经向您的邮箱发送了注册激活邮件（<a style="color:red; text-decoration:underline" href="'.$email_web.'"><b>'.$email.'</b></a>），请登陆邮箱激活您的账号。';
			//$msg='邮件发送失败，请联系网站管理员。';
		}
	}
	elseif($step==2){
		$jihuo_code=base64_decode($_GET['jihuo_code']);
		$code_arr=explode('{#}',$jihuo_code);
		StopAttack($code_arr);
		$ddpassword=$duoduo->select('user','ddpassword,jihuo','id="'.$code_arr[0].'"');
		if($ddpassword['jihuo']==1){
			$msg='此账号无需激活';
		}else{
			if(deep_jm($ddpassword['ddpassword'])==$code_arr[1]){
				$duoduo->update('user',array('jihuo'=>1),'id="'.$code_arr[0].'"');
				$msg='邮件激活成功，您现在可以<a style="color:red; font-size:14px" href="'.u('user','login').'">登陆</a>网站。';
			}
			else{
				$msg='对不起，您的激活码错误！';
			}
		}
	}
	unset($duoduo);
	$parameter['step']=$step;
	$parameter['msg']=$msg;
	return $parameter;
}
?>