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
if($dduser['email']==''){
	jump(u('user','info'),'请先设置您的电子邮箱！');
}
if($dduser['qq']==''){
	jump(u('user','info'),'请先设置您的QQ！');
}
if($dduser['mobile']==''){
	jump(u('user','info'),'请先设置您的联系方式！');
}
if($webset['yinxiangma']['open'] == 1) {
	include (DDROOT . "/api/YinXiangMaLib.php"); //印象验证码
	$yinxiangma = YinXiangMa_GetYinXiangMaWidget();
}
if($_POST){
	$captcha = trim($_POST['captcha']);
	if ($webset['yinxiangma']['open'] == 0 || $captcha != '') {
		if (reg_captcha($captcha) == 0) {
			jump(-1, 5); //验证码错误
		}
	}else{
		$YinXiangMa_response = YinXiangMa_ValidResult($_POST['YinXiangMa_challenge'], $_POST['YXM_level'][0], $_POST['YXM_input_result']);
		if ($YinXiangMa_response != "true") {
			jump(-1, 5); //验证码错误
		}
	}
	$add=array();
	$add['uid']=$dduser['id'];
	$add['content']=dd_addslashes($_POST['content']);
	if($_POST['id']>0){
		$duoduo->update('hezuo',$add,'id='.$_POST['id']);
		jump(u('hezuo','list'),'修改成功');
	}
	$add['addtime']=time();
	$add['status']=0;
	$add['code']=$_POST['code']?$_POST['code']:'tejia';
	$id=$duoduo->insert('hezuo',$add);
	if($id>0){
		jump(u('hezuo','list'),'报名成功，等待管理员查看');
	}else{
		jump(-1,'报名失败');
	}
	dd_exit();
}
if($dduser['id']<=0){
	jump(u('user','login',array('from'=>u(MOD,ACT,array('code'=>$_GET['code'])))),'请先登录');
}
if($_GET['id']>0){
	$this_row = $duoduo->select('hezuo','*','id='.$_GET['id']);
}
?>