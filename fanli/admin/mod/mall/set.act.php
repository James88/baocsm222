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
	$alipay=$_POST['alipay'];
	$realname=$_POST['realname'];
	if(($realname!='' || $alipay!='' ) && $_POST['tijiao']!=1){
		if ($realname == '') {
			jump(-1, '请填写你的真实姓名'); 
		}
		$alipay_pass = reg_alipay($alipay);
		if ($alipay_pass == 0) {
			jump(-1, 35); //支付宝格式错误
		}
		$re=dd_get_json(DD_U_URL.'/?g=Home&m=DdApi&a=getweb&type=game%2Coffer&key='.$_POST['DDYUNKEY'].'&url='.urlencode(CURURL).'&alipay='.$alipay.'&realname='.$realname);
	}
	unset($_POST['alipay']);
	unset($_POST['realname']);
	unset($_POST['tijiao']);
	
	$diff_arr=array('sub');
	$_POST=logout_key($_POST, $diff_arr);
	foreach($_POST as $k=>$v){
		if($v['pwd']==DEFAULTPWD){
			$v['pwd']=$webset[$k]['pwd'];
		}
		if($v['key']==DEFAULTPWD){
			$v['key']=$webset[$k]['key'];
		}
	    $duoduo->set_webset($k,$v);
	}
	
	$duoduo->webset(); //配置缓存
	jump('-1','保存成功');
	
}
else{
	foreach($lianmeng as $arr){
		$a=glob(DDROOT.'/data/'.$arr['code'].'_*');
		if(!empty($a)){
        	$status[$arr['code']]='<span style="color:#00CC00">数据接收正常</span>';
    	}
    	else{
        	$status[$arr['code']]='<span style="color:#FF0000">没有收到数据</span>';
    	}
	}
}