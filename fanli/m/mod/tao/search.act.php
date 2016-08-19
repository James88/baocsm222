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

function act_wap_search(){
	global $duoduo,$dd_tpl_data,$dduser;
	$webset = $duoduo->webset;
	
	$q=trim($_GET['q']);
	if($q==''){
		$jump_arr=array('url'=>-1,'word'=>'搜索不能为空');
	}elseif(is_url($q)){
		$jump_arr=array('url'=>wap_l('index','index'),'word'=>'不能搜索网址');
	}elseif($dduser['id']==0 && $webset['user']['login_tip']==1){
		jump(wap_l('user','login'),'请先登录');
	}else{
		$duoduo->buy_log(array('keyword'=>$q));
		
		$s8_url='http://ai.m.taobao.com/search.html?q='.urlencode($q).'&pid='.$webset['taodianjin_pid'].'&commend=all&unid=2a'.$dduser['id'].'&taoke_type=1';
		$s8_url=u('jump','s8',array('go_tb'=>1,'url'=>base64_encode($s8_url)));
		$jump_arr=array('url'=>$s8_url,'word'=>'跳转到淘宝');
	}
	
	unset($duoduo);
	unset($webset);
	unset($dduser);
	unset($dd_tpl_data);
	$parameter['jump_arr']=$jump_arr;
	$parameter['webtitle']=$dd_tpl_data['title'];
	return $parameter;
}
?>