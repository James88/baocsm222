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

function act_wap_bankuai(){
	global $duoduo,$dd_tpl_data;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;

	$bankuai=$duoduo->select_all('bankuai','*','status=1 and mobile_status=1 ORDER BY sort =0 ASC');
	foreach($bankuai as $row){
		$bankuai_wap[]=array('img'=>$row['mobile_logo'],'title'=>$row['title'],'code'=>$row['code'],'url'=>wap_l('goods','index',array('code'=>$row['code'])));
	}
	
	$parameter['bankuai_wap']=$bankuai_wap;
	$parameter['webtitle']=$dd_tpl_data['title'].'-板块';
	unset($duoduo);
	unset($webset);
	unset($dduser);
	unset($dd_tpl_data);
	return $parameter;
}
?>