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
if($_GET['ddopenpwd']!=''){
	$url=DD_U_URL.'/?g=Home&m=user&a=getuser&url='.urlencode(URL).'&pwd='.md5(md5($_GET['ddopenpwd']));
	$a=dd_get($url);
	echo $a;
	exit;
}

if($_POST['sub']!=''){
	if($_POST['app']['erweima']==''){
		$erweima_url='http://qr.liantu.com/api.php?text='.urlencode(SITEURL.'/plugin.php?mod=phone_app&act=phone').'&w=300&bg=ffffff&gc=cc00000&m=10&logo='.urlencode($_POST['app']['applogo']);
		file_put_contents(DDROOT.'/plugin/phone_app/erweima.png',file_get_contents($erweima_url));
		$_POST['app']['erweima']=SITEURL.'/plugin/phone_app/erweima.png';
	}

	$plist=file_get_contents(DDROOT.'/mod/app/ipa.plist');
	$plist=str_replace(array('{ipa_url}','{ipa_logo}','{ipa_name}','{web_url}','{version}'),array($_POST['app']['iphone_file'],$_POST['app']['applogo'],$_POST['app']['appname'].'最新版',URL,$_POST['app']['version']),$plist);
	file_put_contents(DDROOT.'/data/ipa.txt',$plist);
	
	if(!empty($_POST['wap']['slides'])){
		foreach($_POST['wap']['slides'] as $k=>$row){
			if(preg_match('#^http://(item\.taobao\.com)|(detail\.tmall\.com)|(h5\.m\.taobao\.com)|(detail\.m.tmall\.com)#',$row['iid'])){
				$iid=(float)get_tao_id($row['iid']);
				if($iid>0){
					$_POST['wap']['slides'][$k]['iid']=$iid;
				}
			}	
		}
	}
	
	include(ADMINROOT.'/mod/public/set.act.php');
}
else{
	$dd_open_status=dd_get(DD_OPEN_URL.'/1.txt');

	if($webset['sms']['pwd']!=''){
		$ddopen=fs('ddopen');
		$ddopen->sms_ini($webset['sms']['pwd']);
		$a=$ddopen->get_user_sms();
		if($a['s']==1){
			$sms_tip='<span style="color:#060">您的剩余短信（<b>'.$a['r']['sms'].'</b>条）</span>';
		}
		else{
			$sms_tip=$a['r'];
		}
	}
	
	$re = $duoduo->select_all('api','*');

	foreach($re as $k=>$v){
		if($v['open']==1){
			$temp_arr =array('code'=>$v['code'],'name'=>$v['title']);
			$apilogin_arr[] = $temp_arr;
		}
	}
}