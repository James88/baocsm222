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
	$duoduo->set_webset('search_key',$_POST['search_key']);
	$duoduo->webset();
	jump(u(MOD,ACT),'设置完成');
}
else{
	$search_key=$webset['search_key'];
	$search_key_arr=array(
		array('code'=>'s8','val'=>'热卖','tag'=>'淘宝搜索'),
		array('code'=>'head','val'=>'热卖','tag'=>'页面头部'),
		array('code'=>'mall','val'=>'京东','tag'=>'商城搜索'),
		array('code'=>'paipai','val'=>'热卖','tag'=>'拍拍搜索'),
		array('code'=>'wap','val'=>'热卖','tag'=>'wap搜索'),
	);
}