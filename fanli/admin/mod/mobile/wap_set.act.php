<?php
/**
 * ============================================================================
 * 版权所有 2008-2012 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}

$re = $duoduo->select_all('api','*');

foreach($re as $k=>$v){
	if($v['open']==1){
		$temp_arr =array('code'=>$v['code'],'name'=>$v['title']);
		$apilogin_arr[] = $temp_arr;
	}
}

if($_POST['sub']!=''){
	foreach($apilogin_arr as $row){
		if($_POST['wap']['apilogin'][$row['code']]!=1){
			$_POST['wap']['apilogin'][$row['code']]=0;
		}	
	}
	include(ADMINROOT.'/mod/public/set.act.php');
}
else{
	$phone_app_endtime=$duoduo->select('plugin','endtime','code="phone_app"');
	
	$tpl_arr=glob(DDROOT.'/template/wap_*');
	$tpls=array();
	foreach($tpl_arr as $v){
		$v=str_replace(DDROOT.'/template/','',$v);
		$tpls[$v]=$v;
	}
}
?>