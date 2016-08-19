<?php  //多多
if(!defined('INDEX')){
	exit('Access Denied');
}

$type=$_GET['type'];
if(isset($_GET['dduserid']) && $_GET['dduserid']>0){
	$dduser['id']=$_GET['dduserid'];
}
if($type=='goods'){
	$iid=iid_decode($_GET['iid']);
	$ddTaoapi = new ddTaoapi();
	$a=$ddTaoapi->taobao_tbk_tdj_get($iid,1,1);
	$url=$a['ds_item_click'];
	$url=$url=set_tao_click_uid($url,$dduser['id']);
}
elseif($type=='shop'){
	$nick=$_GET['nick'];
	$ddTaoapi = new ddTaoapi();
	$shop=$ddTaoapi->taobao_tbk_shops_detail_get($nick);
	if(is_array($shop)){
		$user_id=$shop['user_id'];
	}
	if($user_id>0){
		$a= $ddTaoapi->taobao_tbk_tdj_get($user_id,2);
		$url=$a['shop_click_url'];
	}
	if($url==''){
		$url='http://store.taobao.com/shop/view_shop.htm?user_number_id='.$user_id;
	}
	$url=str_replace('&k=','%26unid%3D'.$dduser['id'].'&k=',$url);
}
elseif($type=='s8'){
	$url=$_GET['url'];
	if($url==''){
		$q=$_GET['q'];
		$ddTaoapi = new ddTaoapi();
		$url=$ddTaoapi->taobao_taobaoke_listurl_get($q,$dduser['id']);
	}
}elseif($type=='zhannei'){
	$id=(int)$_GET['id'];
	$data=$duoduo->select('goods','data_id,tg_url','id='.$id);
	$data_id=$data['data_id'];
	if($data['tg_url']!=''){
		$url=$data['tg_url'];
	}
	else{
		$ddTaoapi = new ddTaoapi();
		$a=$ddTaoapi->taobao_tbk_tdj_get($data_id,1,1);
		$url=$a['ds_item_click'];
	}
	$url=$url=set_tao_click_uid($url,$dduser['id']);
}
click_jump($url);