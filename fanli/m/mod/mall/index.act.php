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

function act_wap_mall(){
	global $duoduo,$dd_tpl_data;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	
	$url=DD_U_URL.'/index.php?m=DdApi&a=mall_list&mid='.$dduser['id'].'&is_mobile=1&limit=100&ddurl='.urlencode(SITEURL);
	$a=dd_get($url,3600);
	$a=dd_json_decode($a,1);
	foreach($a['data'] as $k=>$row){
		$a['data'][$k]['id']=$k;
		$a['data'][$k]['jump']=wap_l('jump','index',array('a'=>'mall','url'=>$row['url']));
	}
	$shuju_data=$a['data'];
	
	$webtitle='商城-'.$dd_tpl_data['title'];
	
	unset($duoduo);
	unset($webset);
	unset($dduser);
	unset($dd_tpl_data);
	$parameter['shuju_data']=$shuju_data;
	$parameter['webtitle']=$webtitle;
	return $parameter;
}
?>