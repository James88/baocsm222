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

if($_POST['test']==1){
	$mobile=trim($_POST['mobile']);
	$content=array('yzm'=>rand(1000,9999));
	$ddopen=fs('ddopen');
	$ddopen->sms_ini($webset['sms']['pwd']);
	$re=$ddopen->sms_send($mobile,$content,998);
	if($re['s']==1){
		echo 1;
	}
	else{
		echo $re['r'];
	}
	exit;
}

if(isset($_POST['sub'])){
	if(str_utf8_mix_word_count($_POST['sms']['sign'])>4){
		jump(-1,'短信签名不能大于4个字符');
	}
	
	if($_POST['sms']['open']==1){
		$url=DD_OPEN_URL.'/?m=user&a=getweb&url='.urlencode(URL).'&sms_pwd='.md5(md5($_POST['sms']['pwd'])).'&sms_sign='.urlencode($_POST['sms']['sign']);
		$a=dd_get_json($url);
		if($a['s']==0 && $a['r']!=''){
			jump(-1,$a['r']);
		}
		elseif($a['s']==0 && $a['r']==''){
			jump(-1,'服务器错误');
		}
	}
	
	include(DDROOT.ADMINDIR.'/mod/public/set.act.php');
}
else{
	$dd_open_status=dd_get(DD_OPEN_URL.'/1.txt');

	if($webset['sms']['pwd']!=''){
		$ddopen=fs('ddopen');
		$ddopen->sms_ini($webset['sms']['pwd']);
		$a=$ddopen->get_user_sms();
		if($a['s']==1){
			$sms_tip='<span style="color:#060">您的通知短信（<b>'.$a['r']['sms'].'</b>条）；群发短信（<b>'.$a['r']['sms_qunfa'].'</b>条）</span>';
			$sms_sign=$a['r']['sms_sign'];
		}
		else{
			$sms_tip=$a['r'];
		}
	}
}
?>