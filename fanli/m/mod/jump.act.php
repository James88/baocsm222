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

if($dduser['id']==0 && $webset['user']['login_tip']==1){
	wap_jump(wap_l('user','login'),'请先登录');
	exit;
}

$do=$_GET['a'];

if($do=='mall'){
	$url=$_GET['url'];
	if(strpos($url,'item.jd.com')!==false){
		preg_match('#/(\d+).html#',$url,$a);
		$url='http://item.m.jd.com/ware/view.action?wareId='.$a['1'];
	}
	$url=DD_U_URL.'/index.php?g=mall&m=mall&a=jump&site_id='.$webset['siteid'].'&siteurl='.urlencode(SITEURL).'&mid='.$user['id'].'&mall_url='.urlencode($url).'&chanpin=5';
}
elseif($_GET['iid']){
	$iid=$_GET['iid'];
	if(!is_numeric($iid)){
		$iid=(float)iid_decode($iid);
	}
	$url=$_GET['url'];
	if($url==''){
		jump(wap_l('tao','view',array('iid'=>$iid)));
	}
	$url=set_tao_click_uid($url,'2a'.$user['id']);
	$duoduo->buy_log(array('iid'=>$iid,'uid'=>$user['id']));
}
elseif($_GET['id']){
	$id=$_GET['id'];
	$url=$_GET['url'];
	include(DDROOT.'/comm/goods.class.php');
	$goods_class=new goods($duoduo);
	$goods=$goods_class->good($id);
	$iid=$goods['data_id'];

	$duoduo->buy_log(array('iid'=>$iid,'uid'=>$user['id']));

	if($goods['tg_url']!=''){
		$url=$goods['tg_url'];
	}

	$url=set_tao_click_uid($url,'2a'.$user['id']);
}

jump($url);