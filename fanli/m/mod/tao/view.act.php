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

function act_wap_view(){
	global $duoduo,$dd_tpl_data;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;

	$type=$_GET['type'];
	$iid=$_GET['iid'];
	if(!is_numeric($iid)){
		$iid=(float)iid_decode($iid);
	}
	
	if(WEBTYPE==0){
		$url=$_GET['url'];
		if($url!=''){
			jump(wap_l('jump','index',array('iid'=>iid_encode($iid),'url'=>$url)));
		}
	}
	
	$ddTaoapi = new ddTaoapi();
	$shuju_data=$ddTaoapi->taobao_tbk_tdj_get($iid,1,1);
	$shuju_data['img']=$shuju_data['ds_img']['src'];
	$shuju_data['promotion_price']=$shuju_data['ds_discount_price'];
	$shuju_data['price']=$shuju_data['ds_reserve_price'];
	$shuju_data['title']=$shuju_data['ds_title'];
	$shuju_data['nick']=$shuju_data['ds_nick'];
	$shuju_data['volume']=$shuju_data['ds_volume'];
	$shuju_data['num_iid']=$shuju_data['ds_nid'];
	$shuju_data['user_id']=$shuju_data['ds_user_id'];
	
	$b=$ddTaoapi->taobao_taobaoke_rebate_auth_get($iid,3);
	$shuju_data['rebate']=(int)$b[0]['rebate'];
	$shuju_data['rebate_word']=$shuju_data['rebate']==1?'有返利':'无返利';
	
	if($type==5){
		$shuju_data['promotion_price']=$_GET['promotion_price'];
	}
	$share_url=wap_l('tao','view',array('q'=>$shuju_data['num_iid'],'rec'=>$dduser['id']));
	$webtitle=$shuju_data['title'].'-'.$dd_tpl_data['title'];
	
	unset($duoduo);
	unset($webset);
	unset($dduser);
	unset($dd_tpl_data);
	$parameter['shuju_data']=$shuju_data;
	$parameter['webtitle']=$webtitle;
	$parameter['share_url']=$share_url;
	return $parameter;
}
?>