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
/**
* @name 淘宝商品详情
* @copyright duoduo123.com
* @example 示例tao_view();
* @param $field 字段
* @param $q 关键字
* @param $iid 商品ID
* @return $parameter 结果集合
*/
function dd_act(){
	global $duoduo,$ddTaoapi;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	include(DDROOT.'/comm/goods.class.php');
	$goods_class=new goods($duoduo);
		
	$has_fanli=0;
	$ju_html='';
	$bankuai_title='';
	$zhuanxiang=0;
	$zhuanxiang_price=0;
	$qrcode='';
	$id=(int)$_GET['id'];
	$iid=$_GET['iid'];
	$click_url=$_GET['click_url'];
	if(!is_numeric($iid)){
		$iid=(float)iid_decode($iid);
		if($iid==0){
			$iid=dd_decrypt($_GET['iid'],URLENCRYPT);
		}
	}
	$q=trim($_GET['q']);
	if($q!=''){
		$is_url=reg_taobao_url($q);
	}

	if($iid>0 && strlen($iid)<8){
		$id=$iid;
	}
	
	if($id>0){
		$return=$goods_class->show(1,1,'*','id="'.$id.'"');
		$goods=$return[0];
		$bankuai=dd_get_cache('bankuai');
		$bankuai_title=$bankuai[$goods['code']]['title'];
		$iid=$goods['data_id'];
	}
	elseif($is_url){
		$iid=(float)get_tao_id($q);
	}
	elseif($q!=''){
		$url=$goods['jump']=TDJ_URL."/index.php?mod=jump&act=s8&url=&name=".urlencode($q);
		jump($url);
	}

	if((strpos($iid,'E')!==false || strlen($iid)>=13) && strpos($q,'ju.taobao.com')!==false){
		$ju_html=file_get_contents($q);
		$a=explode('<input type="hidden" id="itemId" value="',$ju_html);
		preg_match('/(\d+)"/',$a[1],$a);
		$iid=$a[1];
	}
	
	if($iid==0){
		error_html('数据错误',5);
	}
	
	if($ju_html==''){
		$ju_url='http://detail.ju.taobao.com/home.htm?item_id='.$iid;
		$ju_html=file_get_contents($ju_url);
	}
	
	if($ju_html!='' && strpos(iconv('gbk','utf-8//IGNORE',$ju_html),'<span class="infotext J_Infotext">已结束')===false  && strpos($ju_html,'<input type="hidden" id="itemId" value="'.$iid.'"')!==false && strpos($ju_html,'<span class="out floatright">')===false){
		error_html('聚划算商品无返利！',-1,1);
	}
	
	$a=$ddTaoapi->taobao_tbk_tdj_get($iid,1,1);

	if(!empty($goods)){
		if($goods['discount_price']>0){
			$a['ds_discount_price']=$goods['discount_price'];
		}
		if($goods['price']>0){
			$a['ds_reserve_price']=$goods['price'];
		}
		if($goods['title']!=''){
			$a['ds_title']=$goods['title'];
		}
		if($goods['img']!=''){
			$a['pic_url']['src']=$goods['img'];
		}
		$allow_fanli=1;
		$has_fanli=1;
	}

	$tao_goods['discount_price']=$a['ds_discount_price'];
	$tao_goods['rate']=$a['ds_discount_rate'];
	$tao_goods['img']=$tao_goods['pic_url']=$a['ds_img']['src'];
	$tao_goods['iid']=$a['ds_nid'];
	$tao_goods['diqu']=$a['ds_provcity'];
	$tao_goods['price']=$a['ds_reserve_price'];
	$tao_goods['sell']=$tao_goods['volume']=$a['ds_sell'];
	$tao_goods['title']=$a['ds_title'];
	$tao_goods['user_id']=$a['ds_user_id'];
	$tao_goods['taoke']=(int)$a['ds_taoke'];
	$tao_goods['click_url']=$a['ds_item_click'];
	$tao_goods['shop_click_url']=$a['ds_shop_click'];
	
	if($tao_goods['title']==''){
		error_html('数据错误',-1,1);
	}

	if($tao_goods['taoke']>0){
		$has_fanli=1;
	}
	
	$a=$ddTaoapi->taobao_tbk_tdj_get($tao_goods['user_id'],2,1);
	
	$tao_goods['logo']=$a['ds_img']['src'];
	$tao_goods['shopname']=$a['ds_shopname'];
	$tao_goods['keywords']=$a['ds_vidname'];
	$tao_goods['dsr_mas']=$a['ds_dsr_mas'];
	$tao_goods['dsr_sas']=$a['ds_dsr_sas'];
	$tao_goods['dsr_cas']=$a['ds_dsr_cas'];
	$tao_goods['nick']=$a['ds_nick'];
	if($a['ds_istmall']==1){
		$a['ds_rank']=21;
	}
	$tao_goods['level']=$a['ds_rank'];
		
	$tao_goods['jump']='';
	$tao_goods['shop_jump']='';
	$shop=array('jump'=>$tao_goods['shop_jump'],'user_id'=>$tao_goods['user_id'],'pic_url'=>$tao_goods["logo"],'title'=>$tao_goods['shopname'],'nick'=>$tao_goods['nick'],'click_url'=>$tao_goods['shop_click_url']);
	if($tao_goods['level']==21){
		$shop['onerror']='images/tbsc.gif';
	}
	else{
		$shop['onerror']='images/tbdp.gif';
	}
	
	if(!defined('TAO_SEARCH_URL')){
		define('TAO_SEARCH_URL',0);
	}
	if($is_url && !(TAO_SEARCH_URL || $dduser['search']==1)){
		$search_url_tip=1;
		$goods=$tao_goods;
	}
	else{
		$shoucang_goods = $duoduo->select('record_goods','id','type=2 and data_id="'.$iid.'" and uid="'.$dduser['id'].'"');
		if($shoucang_goods>0){
			$goods['is_shoucang'] = 1;
		}
		if($dduser['id']>0 && $search_url_tip==0){
			$cun = $duoduo->select('record_goods','*','uid="'.$dduser['id'].'" and data_id="'.$iid.'" and type=1');
			if(empty($cun)){
				$goods_ruku=$goods_class->good_api($iid);
				$copy_goods = array('type'=>1,'goods_id'=>$goods_ruku['id'],'data_id'=>$goods_ruku['data_id'],'uid'=>$dduser['id'],'laiyuan'=>$goods_ruku['laiyuan'],'laiyuan_type'=>$goods_ruku['laiyuan_type'],'cid'=>$goods_ruku['cid'],'code'=>$goods_ruku['code'],'title'=>$goods_ruku['title'],'img'=>$goods_ruku['img']
				,'discount_price'=>$goods_ruku['discount_price'],'price'=>$goods_ruku['price'],'shouji_price'=>$goods_ruku['shouji_price'],'starttime'=>$goods_ruku['starttime'],'endtime'=>$goods_ruku['endtime'],'fanli_bl'=>$goods_ruku['fanli_bl'],'fanli_ico'=>$goods_ruku['fanli_ico']
				,'price_man'=>$goods_ruku['price_man'],'price_jian'=>$goods_ruku['price_jian'],'goods_attribute'=>$goods_ruku['goods_attribute'],'sell'=>$goods_ruku['sell']);
				$duoduo->insert('record_goods',$copy_goods);
			}
		}
		
		if($webset['wap']['status']==1 && is_mobile()==1){
			$url=wap_l('tao','view',array('iid'=>$iid));
			jump($url);
		}
		
		if(WEBTYPE==0 && $click_url!=''){
			jump(u('jump','s8',array('url'=>$click_url)));
		}
		
		$search_url_tip=0;
	
		if($tao_goods['discount_price']<$tao_goods['price']){
			$price_name='<span class="tbcuxiao"><i>打折促销</i><span>';
			$tao_goods['yuanjia']=$tao_goods['price'];
			$tao_goods['price']=$tao_goods['promotion_price']=$tao_goods['discount_price'];
		}
		else{
			$price_name='商品价格';
		}
		
		if($bankuai_title!=''){
			$price_name='<span class="tbcuxiao"><i>'.$bankuai_title.'</i><span>';
		}
		
		if($has_fanli==1){
			if(BROWSER==1){  //浏览器访问获取返利授权，节约api
				$allow_fanli=$ddTaoapi->taobao_taobaoke_rebate_authorize_get($iid);
			}
			else{
				$allow_fanli=1;
			}
		}
		else{
			$allow_fanli=0;
		}
		foreach($tao_goods as $key=>$vo){
			$goods[$key]=$vo;
		}
		
		$comment_url="http://rate.taobao.com/feedRateList.htm?userNumId=".$shop['user_id']."&auctionNumId=".$iid."&currentPageNum=1";
		
		$tuijian_lanmu_title='推荐商品';
		$tuijian_lanmu_goods=$goods_class->index_list('',5,1,'laiyuan_type in (1,2)');
		foreach($tuijian_lanmu_goods as $k=>$row){
			$tuijian_lanmu_goods[$k]['view']=u('tao','view',array('iid'=>$row['data_id']));
		
		}
	}
	
	if(REPLACE<3){
		$noword_tag='';
	}
	else{
		$noword_tag='3';
	}
	
	$nowords=dd_get_cache('no_words'.$noword_tag);
	$goods['title']=dd_replace($goods['title'],$nowords);
	$goods['_url']=l('tao','view',array('iid'=>iid_encode($iid)));
	
	$parameter['goods']=$goods;
	$parameter['price_name']=$price_name;
	$parameter['comment_url']=$comment_url;
	$parameter['allow_fanli']=$allow_fanli;
	$parameter['max_fan']=$max_fan;
	$parameter['tao_coupon_str']=$tao_coupon_str;
	$parameter['has_fanli']=$has_fanli;
	$parameter['shop']=$shop;
	$parameter['tuijian_lanmu_goods']=$tuijian_lanmu_goods;
	$parameter['tuijian_lanmu_title']=$tuijian_lanmu_title;
	$parameter['tuijian_lanmu_code']=$tuijian_lanmu_code;
	$parameter['zhuanxiang']=$zhuanxiang;
	$parameter['qrcode']=$qrcode;
	$parameter['search_url_tip']=$search_url_tip;
	$parameter['shouji_youhui']=$shouji_youhui;

	unset($duoduo);
	return $parameter;
}
?>