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
function act_goods_index($ajax_load_num=5){
	global $duoduo;
	$webset=$duoduo->webset;
	define('VIEW_PAGE',1);
	$goods_total=1;
	
	if(isset($_GET['code'])&&$_GET['code']){
		$bankuai_code=$_GET['code'];
		$bankuai_cache=dd_get_cache('bankuai');
		$bankuai=$bankuai_cache[$bankuai_code];
		$bankuai_title=$bankuai['title'];
		$web_cid=unserialize($bankuai['web_cid']);
		$bankuai_id=(int)$bankuai['id'];
		$bankuai_tpl=$bankuai['bankuai_tpl'];
		if($web_cid){
			$where_type=" and id in(".implode(',',$web_cid).")";
		}
		$wap_canshu='&code='.$bankuai_code;
	}
	else{
		$bankuai_title='全部商品';
		$wap_canshu='';
	}

	if($webset['wap']['status']==1 && is_mobile()==1){
		$url=wap_l('goods','index').$wap_canshu;
		jump($url);
	}

	$url_arr=array('code'=>$bankuai_code,'cid'=>(int)$_GET['cid']);
	if($_GET['do']!=''){
		$url_arr['do']=$_GET['do'];
	}
	
	$goods_type=$duoduo->select_all("type","id,title","tag='goods'".$where_type." order by sort=0 asc,sort asc,id desc");
	foreach($goods_type as $k=>$vo){
		$canshu=array();
		if($bankuai_code){
			$canshu['code']=$bankuai_code;
		}
		$canshu['cid']=$vo['id'];
		if($_GET['do']){
			$canshu['do']=$_GET['do'];
		}
		$goods_type[$k]['url']=u('goods','index',$canshu);
	}
	unset($duoduo);
	$parameter['goods_type']=$goods_type;
	$parameter['bankuai_id']=$bankuai_id;
	$parameter['bankuai_tpl']=$bankuai_tpl;
	$parameter['ajax_load_num']=$ajax_load_num;
	$parameter['goods_total']=$goods_total;
	$parameter['bankuai_code']=$bankuai_code;
	$parameter['url_arr']=$url_arr;
	$parameter['bankuai']=$bankuai;
	$parameter['bankuai_title']=$bankuai_title;
	return $parameter;
}

?>