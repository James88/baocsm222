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
* @name 用户密码找回
* @copyright duoduo123.com
* @example 示例user_getpassword();
* @param $pagesize 每页多少
* @param $nick 指定店铺卖家
* @return $parameter 结果集合
*/
function act_user_getpassword(){
	global $duoduo;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	$step=intval($_GET['step'])?intval($_GET['step']):1;
	$email=trim($_POST['email']);
	if($step==2){
		$email_pass = reg_email($email);
		if ($email_pass == 0) {
			jump(-1,'邮箱格式错误'); //邮箱格式错误
		}
		$user=$duoduo->select('user','ddusername,ddpassword','email="'.$email.'"');
		if ($user['ddusername']=='') {
			jump(-1,'邮箱不存在'); //邮箱不存在
		}
		$x = md5($user['ddusername'].'+'.$user['ddpassword']);
		$string = urlencode(base64_encode($user['ddusername']."*".$x.'*'.TIME));
		$html="请点击链接进入".WEBNAME."进行密码重置。有效时间10分钟。<a href=\"http://".URL."/index.php?mod=user&act=getpassword&step=3&str=".$string."\">http://".URL."/index.php?mod=user&act=getpassword&step=3&str=".$string."</a>";
		$title=WEBNAME."取回密码邮件";
		$mymsg=mail_send($email, $title, $html);
		$email_web='http://mail.'.preg_replace('/(.*)@/','',$email);
		if($mymsg==1){
			$mymsg='找回密码的链接已发送到您的邮箱（<a style="color:red; text-decoration:underline" href="'.$email_web.'"><b>'.$email.'</b></a>），请及时更改密码！';
		}
		else{
			$mymsg='邮件发送失败，请联系网站管理员！';
		}
	}
	elseif($step==3){
		$str=trim($_GET['str']); 
		if($str==''){
			jump(-1,'缺少必要参数'); 
		}
		
		$mingma_str=base64_decode($str);
		$array_result = explode('*',$mingma_str);
		
		StopAttack($array_result);
		if(TIME-$array_result[2]>600){
			jump(-1,'访问超时'); 
		}
		
		$user=$duoduo->select('user','ddusername,ddpassword','ddusername="'.$array_result[0].'"');
		if($user['ddusername']==''){
			jump(-1,'账号密码错误'); 
		}
		$x = md5($user['ddusername'].'+'.$user['ddpassword']);
		if($x!=$array_result[1]){
			jump(-1,'参数验证失败'); 
		}
	}
	elseif($step==4){
		$name=trim($_POST['ddusername']); 
		$pwd=trim($_POST['password']); 
		$x=trim($_POST['x']); 
		$md5pwd=md5($pwd);
	
		if($name==""||$pwd==""){
			jump(-1,'缺少必要参数'); 
		}
		
		$user=$duoduo->select('user','ddusername,ddpassword','ddusername="'.$name.'"');
		if($x != md5($user['ddusername'].'+'.$user['ddpassword'])){
			jump(-1,'参数验证失败'); 
		}
		
		if($webset['ucenter']['open']==1){
			include DDROOT.'/comm/uc_define.php';
			include_once DDROOT.'/uc_client/client.php';
			$uc_name = iconv("utf-8", "utf-8//IGNORE", $name);
			$ucresult = uc_user_edit($uc_name,'',$pwd,'',1);
			if($ucresult<0){
				jump(-1,'修改密码失败'); 
			}
		}
		
		$duoduo->update('user', array('ddpassword'=>$md5pwd), "ddusername='".$name."'");
		$mymsg="密码重置成功，现在您可以用您新设置的密码登录了。<br><br><a href=".u('user','login')."  class=redlink>用户登录</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=".u('index')." class=redlink>返回首页</a>";
	}
	unset($duoduo);
	$parameter['step']=$step;
	$parameter['mymsg']=$mymsg;
	$parameter['x']=$x;
	$parameter['array_result']=$array_result;
	return $parameter;
}
?>