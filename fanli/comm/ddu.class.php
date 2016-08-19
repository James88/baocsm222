<?php
class ddu{
	public $cache_time=600;
	function __construct(){
		$this->openurl=DD_FANLICHENG_URL.'/api.php?mod=collect_api&key='.md5(DDYUNKEY).'&domain='.urlencode(get_domain(SITEURL))."&";
	}
	function get_url($data){
		$url=$this->openurl.http_build_query($data);
		$a=dd_get($url,get,$this->cache_time);
		$a=json_decode($a,1);
		return $a;
	}
	function goods_url($url){
		if(reg_taobao_url($url)==1){
			$data=$this->ddgoods_taobao($url);
		}elseif(get_domain($url)=='paipai.com'){
			$data=$this->goods_paipai($url);
		}else{
			$data=$this->goods_zhidemai($url);
		}
		if(empty($data)){
			$canshu['act']='goods_url';
			$data=$this->get_url($canshu);
			if($data['s']==0){
				$data['data']='';
			}
		}
		return $data;
	}
	//laiyuan_type=1是淘宝，laiyuan_type=2是天猫，laiyuan_type=3是京东等第三方，laiyuan_type=4是拍拍
	
	function ddgoods_taobao($url){
		include_once(DDROOT . '/comm/Taoapi.php');
		include_once(DDROOT . '/comm/ddTaoapi.class.php');
		$ddTaoapi = new ddTaoapi();
		if(isset($url)){
			$iid=(float)get_tao_id($url);
			if(empty($iid)){
				$iid=$url;
			}
		}
		$goods['url']='http://item.taobao.com/item.htm?id='.$iid;
		$a=$ddTaoapi->taobao_tbk_tdj_get($iid,1,1);
		if(empty($a['ds_nid'])){
			$msg['s']=0;
			$msg['r']="获取不到商品信息".$a;
			return $msg;
		}
		$goods['web']=2;
		$goods['discount_price']=$a['ds_discount_price'];
		$goods['rate']=$a['ds_discount_rate'];
		$goods['img']=$a['ds_img']['src'];
		$goods['data_id']=$a['ds_nid'];
		$goods['diqu']=$a['ds_provcity'];
		$goods['price']=$a['ds_reserve_price'];
		$goods['sell']=$a['ds_sell'];
		$goods['title']=$a['ds_title'];
		$goods['user_id']=$a['ds_user_id'];
		$goods['taoke']=$a['ds_taoke'];
		$goods['click_url']=$a['ds_item_click'];
		$goods['baoyou']=$a['ds_postfee']>0?0:1;
		$goods['shop_url']=$a['ds_shop_click'];
		$a=$ddTaoapi->taobao_tbk_tdj_get($goods['user_id'],2,1);
		$goods['logo']=$a['ds_img']['src'];
		$goods['shopname']=$a['ds_shopname'];
		$goods['keywords']=$a['ds_vidname'];
		/*$goods['dsr_mas']=$a['ds_dsr_mas'];
		$goods['dsr_sas']=$a['ds_dsr_sas'];
		$goods['dsr_cas']=$a['ds_dsr_cas'];*/
		$goods['nick']=$a['ds_nick'];
		$goods['istmall']=$a['ds_istmall'];
		if($a['ds_istmall']==1){
			$a['ds_rank']=21;
			$goods['laiyuan_type']=2;
			$goods['laiyuan']='天猫';
		}else{
			$goods['laiyuan_type']=1;
			$goods['laiyuan']='淘宝';
		}
		$goods['level']=$a['ds_rank'];
		$msg['s']=1;
		$msg['r']=$goods;
		return $msg;
	}
	function goods_paipai($url){
		global $webset,$dduser;
		include(DDROOT.'/comm/paipai.class.php');
		$paipai_set['userId']=$webset['paipai']['userId'];
		$paipai_set['qq']=$webset['paipai']['qq'];
		$paipai_set['appOAuthID']=$webset['paipai']['appOAuthID'];
		$paipai_set['secretOAuthKey']=$webset['paipai']['secretOAuthKey'];
		$paipai_set['accessToken']=$webset['paipai']['accessToken'];
		$paipai_set['fxbl']=$webset['paipaifxbl'];
		$paipai_set['cache_time']=$webset['paipai']['cache_time'];
		$paipai_set['errorlog']=$webset['paipai']['errorlog'];
		$paipai=new paipai($dduser,$paipai_set);
		$parame['commId']=$paipai->url2commId($url);
		$a=$paipai->cpsCommQueryAction($parame);
		$goods['laiyuan']='拍拍网';
		$goods['url']=$url;
		$html=dd_get($url);
		preg_match('/<em\s*id="commodityCurrentPrice"[^>]*>([^<]*)<\/em>/',$html,$match);
		$goods['discount_price']=$a['dwCurrAuctionPrice']?$a['dwCurrAuctionPrice']:$match[1];
		$goods['img']=$a['img']?$a['img']:$a['middleImg'];
		$goods['data_id']='paipai_'.$a['commId'];
		$goods['price']=$a['price'];
		$goods['sell']=$a['dwCurrPayNum']?$a['dwCurrPayNum']:$a['saleNum'];
		$goods['title']=$a['title'];
		$goods['fanli']=$a['commission'];
		$goods['laiyuan_type']=4;
		$msg['s']=1;
		$msg['r']=$goods;
		return $msg;
	}
	function goods_zhidemai($url){
		$canshu=array();
		$canshu['act']='goods_zhidemai';
		$canshu['url']=$url;
		$data=$this->get_url($canshu);
		return $data;
	}
	function goods_tishi(){
		$canshu=array();
		$canshu['act']='goods_tishi';
		$data=$this->get_url($canshu);
		return $data;
	}
	function goods_type(){
		$canshu=array();
		$canshu['act']='goods_type';
		$data=$this->get_url($canshu);
		return $data;
	}
	//获取公共规则
	function collect_api_list(){
		$canshu=array();
		$canshu['act']='collect_api_list';
		$data=$this->get_url($canshu);
		return $data;
	}
}