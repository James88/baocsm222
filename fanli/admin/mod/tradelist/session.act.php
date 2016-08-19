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

if($_POST['sub']!=''){
	unset($_POST['sub']);
	if($_POST['taobao_session']['value']==''){
		$_POST['taobao_session']['time']=0;
	}
	else{
		$_POST['taobao_session']['time']=TIME;
	}
	
	$duoduo->set_webset('taobao_session',$_POST['taobao_session']);
	$duoduo->webset();
	jump(u('webset','center'),'保存成功');
}
else{
	if(isset($_GET['test_ssl']) && $_GET['test_ssl']==1){
		if($webset['taobao_session']['value']==''){
			jump(-1,'请先获取淘宝授权');
		}
	
		$url='https://oauth.taobao.com/token?client_id='.$webset['taoapi']['jssdk_key'].'&client_secret='.$webset['taoapi']['jssdk_secret'].'&grant_type=refresh_token&refresh_token='.$webset['taobao_session']['refresh_token'];
	
		$a=dd_get($url,'post');
		$a=json_decode($a,1);
		if(!is_array($a)){
			jump(-1,'不可用');
		}
		if(isset($a['error'])){
			if($a['error_description']=='refresh times limit exceed'){
				$duoduo->update_serialize('taobao_session','day',TODAY);
				jump(-1,'自动刷新淘宝授权可用');
			}
			else{
				jump(-1,$a['error_description']);
			}
		}
		if(urldecode($a['taobao_user_nick'])==$webset['taobao_nick']){
			$duoduo->update_serialize('taobao_session','day',TODAY);
			jump(-1,'自动刷新淘宝授权可用');
		}
		else{
			jump(-1,'检测失败，请核对后台淘宝账号是否正确。');
		}
	}
}
?>