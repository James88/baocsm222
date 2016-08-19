<?php
class ddTaoapi extends Taoapi{
    public $dduser;
	public $nowords;
	public $virtual_cid;
	public $format='json';
	public $jssdk_time='';
	public $jssdk_sign='';
	public $catch_num=3;
	public $renminbi=0;   //是否显示原始返利
	
	function __construct(){
		parent::__construct();
		if(empty($this->nowords)){
			if(REPLACE<3){
				$noword_tag='';
			}
			else{
				$noword_tag='3';
			}
			$this->nowords=dd_get_cache('no_words'.$noword_tag);
		}
		if(empty($this->virtual_cid)){
			$this->virtual_cid=include (DDROOT.'/data/virtual_cid.php');
		}
	}
	
	function taobao_tbk_item_get($data){
		if($data['q']=='' && $data['cat']==''){
			$msg['s']=0;
			$msg['r']='分类和关键字必须填写一个';
		    return $msg;
		}
		if(!isset($data['fields']) || $data['fields']==''){
		    $data['fields'] = 'num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,nick,seller_id,volume';
		}
		$this->method = 'taobao.tbk.item.get';
		$this->fields = $data['fields'];
		if(isset($data['q']) && $data['q']!=''){
            $this->q = $data['q'];
		}
		if(isset($data['cat'])){
		    $this->cat = $data['cat'];
		}
		if(isset($data['itemloc'])){
		    $this->itemloc = $data['itemloc'];
		}
		if(isset($data['sort'])){
		    $this->sort = $data['sort'];
		}
		if(isset($data['is_mall'])){
		    $this->is_tmall = $data['is_mall'];
		}
		if(isset($data['is_overseas'])){
		    $this->is_overseas = $data['is_overseas'];
		}
		if(isset($data['start_price'])){
		    $this->start_price = $data['start_price'];
			if($this->start_price==0){$this->start_price=1;}
		}
		if(isset($data['end_price'])){
		    $this->end_price = $data['end_price'];
			if($this->end_price==0){$this->end_price=999999;}
		}
		if(isset($data['start_tk_rate'])){
		    $this->start_tk_rate = $data['start_tk_rate'];
		}
		if(isset($data['end_tk_rate'])){
		    $this->end_tk_rate = $data['end_tk_rate'];
		}
		if(isset($data['platform'])){
		    $this->platform = $data['platform'];
		}
		if(isset($data['page_no'])){
		    $this->page_no = $data['page_no'];
		}
		if(isset($data['page_size'])){
		    $this->page_size = $data['page_size'];
		}
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		if(isset($TaobaokeData['code'])){
			return array('s'=>0,'r'=>$TaobaokeData['msg'].'|'.$TaobaokeData['sub_code']);
		}
		else{
			return array('s'=>1,'r'=>$this->do_TaobaokeItem($TaobaokeData['results']['n_tbk_item']),'total'=>$TaobaokeData['total_results']);
		}
	}
	
	function taobao_tbk_item_info_get($num_iids){
		$this->method = 'taobao.tbk.item.info.get';
		$this->fields='num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,nick,seller_id,volume';
		$this->num_iids=$num_iids;
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		if(empty($TaobaokeData['results'])){
			return array();
		}
		else{
			return $TaobaokeData['results']['n_tbk_item'];
		}
	}
	
	function taobao_tbk_item_recommend_get($data){
		$this->method = 'taobao.tbk.item.recommend.get';
		$this->fields='num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,nick,seller_id,volume';
		$this->relate_type=$data['relate_type'];
		$this->num_iid=$data['num_iid'];
		$this->user_id=$data['user_id'];
		$this->cat=$data['cat'];
		$this->count=$data['count'];
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		if(empty($TaobaokeData['results'])){
			return array();
		}
		else{
			return $this->do_TaobaokeItem($TaobaokeData['results']['n_tbk_item']);
		}
	}

	function taobao_tbk_items_get($Tapparams){
		$Tapparams['cat']=$Tapparams['cid'];
		$Tapparams['q']=$Tapparams['keyword'];
		$a=$this->taobao_tbk_item_get($Tapparams);
		$b=$a['r'];
		if(isset($Tapparams['total'])){
			$b['total']=$a['total'];
		}
		return $b;
		if($Tapparams['keyword']=='' && $Tapparams['cid']==''){
		    return 'miss keyword or cid';
		}
	    $this->method = 'taobao.tbk.items.get';
        if(!isset($Tapparams['fields']) || $Tapparams['fields']==''){
		    $Tapparams['fields'] = 'num_iid,seller_id,nick,title,price,volume,pic_url';
		}
        $this->fields = $Tapparams['fields'];
		if(isset($Tapparams['keyword'])){
            $this->keyword = $Tapparams['keyword'];
		}
		if(isset($Tapparams['cid'])){
		    $this->cid = $Tapparams['cid'];
		}
        $this->page_size = $Tapparams['page_size'];
		if(isset($Tapparams['page_no'])){
		    $this->page_no=$Tapparams['page_no'];
		}
		if(isset($Tapparams['sort'])){
		    $this->sort = $Tapparams['sort'];
		}
		else{
		    $this->sort = 'commissionNum_desc';
		}
		if(isset($Tapparams['start_commissionRate'])){
            $this->start_commissionRate=$Tapparams['start_commissionRate'];
		}
		if(isset($Tapparams['end_commissionRate'])){
            $this->end_commissionRate=$Tapparams['end_commissionRate'];
		}
		if(isset($Tapparams['start_credit'])){
            $this->start_credit=$Tapparams['start_credit'];
		}
		if(isset($Tapparams['end_credit'])){
            $this->end_credit=$Tapparams['end_credit'];
		}
		if(isset($Tapparams['start_price'])){
            $this->start_price=$Tapparams['start_price'];
		}
		if(isset($Tapparams['end_price'])){
            $this->end_price=$Tapparams['end_price'];
		}
		if(isset($Tapparams['area'])){
            $this->area=$Tapparams['area'];
		}
		if(isset($Tapparams['mall_item'])){
		   $this->mall_item=$Tapparams['mall_item'];
		}
		if(isset($Tapparams['is_mobile'])){
		    $is_mobile=$Tapparams['is_mobile'];
		}

        $TaobaokeData = $this->Send('get',$this->format)->getArrayData();
        $TaobaokeItem1 = $TaobaokeData["tbk_items"]["tbk_item"];
		
		if($is_mobile=='true'){
			return $TaobaokeItem1;
		}
		
		if(isset($tag_goods) && is_array($tag_goods) && !empty($tag_goods)){
			$TaobaokeItem1=array_merge($tag_goods,$TaobaokeItem1);
		}
		
        $TotalResults = $TaobaokeData["total_results"]; 
		if(!is_array($TaobaokeItem1[0])){
	        $TaobaokeItem[0]=$TaobaokeItem1;
        }else{
	        $TaobaokeItem=$TaobaokeItem1;
        }
		
		if($TotalResults>0){
		    $TaobaokeItem=$this->do_TaobaokeItem($TaobaokeItem,0,$this->is_mobile);
			if(isset($Tapparams['total'])){
		        $TaobaokeItem['total']=$TotalResults?$TotalResults:0;
		    }
			return $TaobaokeItem;
		}
		else{
		    return 102; 
		}
	}
	
	function do_TaobaokeItem($TaobaokeItem,$type='goods'){
		if($type=='goods'){
			foreach($TaobaokeItem as $k=>$row){
				$TaobaokeItem[$k]["title"]=dd_replace($row["title"],$this->nowords);
				$TaobaokeItem[$k]['name']=strip_tags($TaobaokeItem[$k]['title']);
	        	$TaobaokeItem[$k]['name_url']=urlencode($TaobaokeItem[$k]['name']);

				$TaobaokeItem[$k]['item_url']='http://item.taobao.com/item.htm?id='.$TaobaokeItem[$k]['num_iid'];
				$TaobaokeItem[$k]['shop_url']='http://store.taobao.com/shop/view_shop.htm?user_number_id='.$TaobaokeItem[$k]['seller_id'];
				$TaobaokeItem[$k]['jump']=u('jump','goods',array('iid'=>$TaobaokeItem[$k]['num_iid']));
	       		$TaobaokeItem[$k]['go_view']=u('tao','view',array('iid'=>$TaobaokeItem[$k]["num_iid"]));
				$TaobaokeItem[$k]['gourl']=u('tao','view',array('iid'=>$TaobaokeItem[$k]["num_iid"]));
			}
		}
		elseif($type='shop'){
			foreach($TaobaokeItem as $k=>$row){
				$TaobaokeItem[$k]['onerror']='images/tbdp.gif';
				$TaobaokeItem[$k]['shop_url']='http://store.taobao.com/shop/view_shop.htm?user_number_id='.$row['user_id'];
				$TaobaokeItem[$k]['jump']=u('jump','shop',array('user_id'=>$row["user_id"]));
			}
		}
		return $TaobaokeItem;
	}
	
	function getMillisecond() {
		list($t1, $t2) = explode(' ', microtime());
		return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
	}
	
	function get_et(){
		$t=$this->getMillisecond();
		$t2=$t+3;
		$url='http://g.click.taobao.com/load?rf='.urlencode(SITEURL).'&dr=&pid='.$pid.'&pgid='.$pgid.'&ak=&ttype=1&iframe=false&st='.$t.'%2C'.$t2.'&lan=0%2C1&ciid=44304181548&csid=&curl=&ckeywords=&cbh=361&cbw=1440&re=1440x900&cah=860&caw=1440&ccd=32&ctz=8&chl=9&cja=1&cpl=31&cmm=54&cf=11.3&cb=jsonp_callback_05700072422623634';
		$a = dd_get($url);
		$a=preg_replace('/jsonp_callback_\d+\(/','',$a);
		$json=preg_replace('/\)$/','',$a);
		$a=json_decode($json,1);
		return $a['code'];
		
		/*$l=time();
		$r=-480*60;
		$p=$l+$r;
		$m=$p + (3600 * 8);
		$q=substr($m,2,8);
		$o=array(6, 3, 7, 1, 5, 2, 0, 4);
		$n=array();
		
		for($k=0;$k<count($o);$k++){
			$n[]=$q[$o[$k]];
		}
		$n[2] = 9 - $n[2];
		$n[4] = 9 - $n[4];
		$n[5] = 9 - $n[5];
		
		return implode("",$n);*/
	}
	

	function taobao_tbk_tdj_get($iid,$type=1,$return_type=0){
		if(defined('TDJ_URL') && TDJ_URL!=''){
			$rf=urlencode(TDJ_URL);
		}else{
			$rf=urlencode(SITEURL);
		}
		$pid=$this->ApiConfig->taodianjin_pid;
		$md5_cache_path=md5($iid.$pid);
		$md5_cache_path=substr($md5_cache_path,0,2).'/'.$md5_cache_path.'.json';
		$cache_path=DDROOT.'/data/temp/taoapi/taobao.taobaoke.tdj.get/'.$md5_cache_path;
			
		if(file_exists($cache_path) && $this->ApiConfig->Cache>0){
			$json=file_get_contents($cache_path);
			$is_cache=1;
		}
		else{
			$json=dd_json_encode(array());
			$pgid=md5($iid);
			$et=$this->get_et($pid,$pgid);
			if($type==1){
				$url='http://g.click.taobao.com/display?cb=jsonp_callback_06476987702772021&pid='.$pid.'&wt=0&ti=5&tl=290x380&rd=2&ct=itemid%3D'.$iid.'&st=2&rf='.$rf.'&et='.$et.'&pgid='.$pgid.'&ttype=1&v=1.2&cm=&ck=&cw=0&unid=0';
				$a = dd_get($url);
				$a=preg_replace('/jsonp_callback_\d+\(/','',$a);
				$json=preg_replace('/\)$/','',$a);
			}
			elseif($type==2){
				$url='http://g.click.taobao.com/display?cb=jsonp_callback_018103029002313714&pid='.$pid.'&wt=1&ti=3&tl=140x190&rd=2&ct=sellerid%3D'.$iid.'&st=1&rf='.$rf.'&et='.$et.'&pgid='.$pgid.'&v=2.0';
				$a = dd_get($url);
				$a=preg_replace('/jsonp_callback_\d+\(/','',$a);
				$json=preg_replace('/\)$/','',$a);
			}
			
			/*$url='http://g.click.taobao.com/load?rf='.$rf.'&pid='.$pid.'&pgid='.$pgid.'&cbh=261&cbw=1436&re=1440x900&cah=870&caw=1440&ccd=32&ctz=8&chl=2&cja=1&cpl=0&cmm=0&cf=10.0&cb=jsonp_callback_004967557514815568';
			$a = dd_get($url);
			preg_match('/jsonp_callback_\d+\(\{"code":"(.*)"\}\)/',$a,$b);
			if($b[1]!=''){
				if($type==1){
					$url='http://g.click.taobao.com/display?cb=jsonp_callback_03655084007659234&pid='.$pid.'&wt=0&ti=7&tl=628x100&rd=1&ct=itemid%3D'.$iid.'&st=2&rf='.$rf.'&et='.$b[1].'&pgid='.$pgid.'&v=2.0';
					$a = dd_get($url);
					$a=preg_replace('/jsonp_callback_\d+\(/','',$a);
					$json=preg_replace('/\)$/','',$a);
				}
				elseif($type==2){
					$url='http://g.click.taobao.com/display?cb=jsonp_callback_018103029002313714&pid='.$pid.'&wt=1&ti=3&tl=140x190&rd=1&ct=sellerid%3D'.$iid.'&st=1&rf='.$rf.'&et='.$b[1].'&pgid='.$pgid.'&v=2.0';
					$a = dd_get($url);
					$a=preg_replace('/jsonp_callback_\d+\(/','',$a);
					$json=preg_replace('/\)$/','',$a);
				}
			}*/
			$is_cache=0;
		}
		
		$a=dd_json_decode($json,1);
		if(($a['code']==400 || $a=='') && $this->catch_num>=0){
			$this->catch_num--;
			if($this->catch_num<0){
				if(defined('INDEX') && INDEX==1){
					$is_url=is_url($_GET['q']);
					$w='内容无效';
					if($is_url==0){
						$w.='，<a style="font-size:18px; padding:4px 10px;background:#F00; color:#FFF; text-decoration:underline" target="_blank" href="http://item.taobao.com/item.htm?id='.$iid.'">先去淘宝购物</a>';
					}
					else{
						$w='内容无效';
					}
					error_html($w,-1,1);
				}
				else{
					error_html('内容无效');
				}
			}
			return $this->taobao_tbk_tdj_get($iid,$type);
		}
		
		if(is_array($a)){
			if($return_type==0){
				if($type==1){
					$goods['price']=$a['data']['items'][0]['ds_reserve_price'];
					$goods['promotion_price']=$a['data']['items'][0]['ds_discount_price'];
					if($goods['price']<=$goods['promotion_price']){
						$goods['promotion_price']=0;
					}
					$goods['click_url']=$a['data']['items'][0]['ds_item_click'];
					$goods['shop_click_url']=$a['data']['items'][0]['ds_shop_click'];
				}
				elseif($type==2){
					$goods['nick']=$a['data']['items'][0]['ds_nick'];
					$goods['pic_url']=$a['data']['items'][0]['ds_img']['src'];
					$goods['shop_click_url']=$a['data']['items'][0]['ds_shop_click'];
				}
			}
			else{
				$goods=$a['data']['items'][0];
			}
			
			if($this->ApiConfig->Cache>0 && $is_cache==0 && isset($a['data']['items'][0])){
				create_file($cache_path,$json);
			}
			
			return $goods;
		}
		else{
			return array();
		}
	}
	
	function tdj_zujian($type,$uid=0){ //1为充值框
		if(defined('TDJ_URL')){
			$rf=urlencode(TDJ_URL);
		}else{
			$rf=urlencode(SITEURL);
		}
		$pid=$this->ApiConfig->taodianjin_pid;
		$pgid=md5($pid);
		$ak='21114278';
		
		$md5_cache_path=md5($uid.$pid.$type);
		$md5_cache_path=substr($md5_cache_path,0,2).'/'.$md5_cache_path.'.json';
		$cache_path=DDROOT.'/data/temp/taoapi/tbk.tdj.zujian.get/'.$md5_cache_path;

		if(file_exists($cache_path) && $this->ApiConfig->Cache>0){
			$a=file_get_contents($cache_path);
			$is_cache=1;
		}
		else{
			if($type==1){
				$url='http://g.click.taobao.com/load?rf='.$rf.'&pid='.$pid.'&pgid='.$pgid.'&ak='.$ak.'&cbh=720&cbw=1920&re=1920x1080&cah=1050&caw=1920&ccd=32&ctz=8&chl=2&cja=1&cpl=37&cmm=87&cf=11.9&cb=jsonp_callback_09713946501724422';
				$a = dd_get($url);
				$et=$this->tiqu_callback($url);
				$url='http://g.click.taobao.com/display?cb=jsonp_callback_0561472135130316&ak='.$ak.'&pid='.$pid.'&unid='.$uid.'&wt=5&ti=135&tl=210x200&rd=1&ct=&st=2&rf='.$rf.'&et='.$et.'&pgid='.$pgid.'&v=2.0';
				$json=$this->tiqu_callback($url,2);
				$a=dd_json_decode($json,1);
				$a=$a['templet'];
			}
			$is_cache=0;
		}
		if($this->ApiConfig->Cache>0 && $is_cache==0 && isset($a)){
			create_file($cache_path,$a);
		}
		return $a;
	}
	
	function tiqu_callback($url,$type=1){ //1为提取callback中的code，2为提取callback中的内容
		$a = dd_get($url);
		if($type==1){
			preg_match('/jsonp_callback_\d+\(\{"code":"(\d+)"\}\)/',$a,$b);
			return $b[1];
		}
		elseif($type==2){
			$a=preg_replace('/jsonp_callback_\d+\(/','',$a);
			return $json=preg_replace('/\)$/','',$a);
		}
	}
	
	function taobao_tbk_shop_recommend_get($data){
		$user_id=$data['user_id'];
		$count=$data['count'];
		$this->method = 'taobao.tbk.shop.recommend.get';
		$this->fields = 'user_id,shop_title,shop_type,seller_nick,pict_url,shop_url';
		$this->user_id = $user_id;
		$this->count = $count;
		$TaobaoData = $this->Send('get',$this->format)->getArrayData();
		if(empty($TaobaokeData['results'])){
			return array();
		}
		else{
			return $this->do_TaobaokeItem($TaobaoData['results']['n_tbk_shop'],'shop');
		}
	}
	
	function taobao_tbk_items_detail_get($iid){
		$this->method = 'taobao.tbk.items.detail.get';
        $this->fields = 'num_iid,seller_id,nick,title,price,volume,pic_url';
        $this->num_iids = $iid;
		$TaobaoData = $this->Send('get',$this->format)->getArrayData();
		
		$a=$TaobaoData['tbk_items']['tbk_item'];
		if(empty($a)){
			return 102;
		}
		$a=$this->do_TaobaokeItem($a);
		if(strpos($iid,',')===false){
			$a=$a[0];
			$b=$this->taobao_tbk_tdj_get($iid);
			$a['click_url']=$b['click_url'];
			$a['shop_click_url']=$b['shop_click_url'];
			$a['promotion_price']=$b['promotion_price'];
		}
		
		return $a;
	}
	
	function taobao_tbk_shops_detail_get($str){
	    $this->method = 'taobao.tbk.shop.get';
		$this->fields = 'user_id,shop_title,shop_type,seller_nick,pict_url,shop_url';
		$this->q=$str;
		$this->page_size=100;
		$ShopData = $this->Send('get',$this->format)->getArrayData();
		$a=$ShopData['results']['n_tbk_shop'];
		$re=array();
		foreach($a as $row){
			if($row['seller_nick']==$str){
				$re=$row;
				break;
			}
		}
		return $re;
	}
	
	function taobao_tbk_shops_get($Tapparams){
		$this->method='taobao.tbk.shop.get';
		$this->fields='user_id,shop_title,shop_type,seller_nick,pict_url,shop_url';
		$this->q=$Tapparams['q'];
		$this->start_credit=$Tapparams['start_credit'];
		$this->end_credit=$Tapparams['end_credit'];
		$this->start_commission_rate=$Tapparams['start_commissionrate'];
		$this->end_commission_rate=$Tapparams['end_commissionrate'];
		$this->start_auction_count=$Tapparams['start_auctioncount'];  //宝贝数量
		$this->end_auction_count=$Tapparams['end_auctioncount'];
		$this->start_total_action=$Tapparams['start_totalaction'];  //店铺累计推广量
		$this->end_total_action=$Tapparams['end_totalaction'];
		$this->is_tmall=$Tapparams['only_mall'];  //true  false
		$this->sort=$Tapparams['sort_type'];  //desc,asc
		$this->page_no=$Tapparams['page_no'];
		$this->page_size=$Tapparams['page_size'];
		$ShopData = $this->Send('get',$this->format)->getArrayData();
		$a=$ShopData['results']['n_tbk_shop'];
		if(empty($a)){
			return 104;
		}
		$a=$this->do_TaobaokeItem($a,'shop');
		return $a;
	}
	
	function taobao_taobaoke_rebate_authorize_get($str,$type='num_iid'){
		if(TAOTYPE==1){  //无返利类api的站不检测
			return 1;
		}
		if($type=='num_iid'){
			$type=3;
		}
		elseif($type=='seller_id'){
			$type=2;
		}
		elseif($type=='nick'){
			$type=1;
		}
		$a=$this->taobao_tbk_rebate_auth_get($str,$type);
		return (int)$a[0]['rebate'];
		$this->method='taobao.taobaoke.rebate.authorize.get';
		if($type=='num_iid'){
			$this->num_iid=$str;
		}
		elseif($type=='seller_id'){
			$this->seller_id=$str;
		}
		elseif($type=='nick'){
			$this->nick=$str;
		}
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		if($TaobaokeData['rebate']==1 || $TaobaokeData['rebate']=='true'){
			$a=1;
		}
		else{
			$a=0;
		}
		return $a;
	}
	
	function taobao_taobaoke_rebate_auth_get($params,$type=3){  //1-按nick查询，2-按seller_id查询，3-按num_iid查询
		return $this->taobao_tbk_rebate_auth_get($params,$type);
		$this->method='taobao.taobaoke.rebate.auth.get';
		$this->params=$params;
		$this->type=$type;
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		return $TaobaokeData['results']['taobaoke_authorize'];
	}
	
	function taobao_tbk_rebate_auth_get($params,$type=3){  //1-按nick查询，2-按seller_id查询，3-按num_iid查询
		$this->method='taobao.tbk.rebate.auth.get';
		$this->fields='param,rebate';
		$this->params=$params;
		$this->type=$type;
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		return $TaobaokeData['results']['n_tbk_rebate_auth'];
	}
	
	function do_rebate_order($data){
		global $duoduo;
		foreach($data as $k=>$row){
			$row['app_key']=0;
			$row['category_id']=0;
			$row['category_name']='';
			$row['pay_time']=$row['earning_time'];
			$row['real_pay_fee']=$row['pay_price'];
			$row['pay_price']=$row['price'];
			$row['shop_title']=$row['seller_shop_title'];
			$row['outer_code']=$row['unid'];
			$row['commission_rate']=round($row['commission']/$row['real_pay_fee'],2);
			//category_id=1的订单删除
			$row['trade_parent_id']=number_format($row['trade_parent_id'],0,'','');
			$trade=$duoduo->select('tradelist','id,status','trade_id_former="'.$row['trade_parent_id'].'" and category_id=1');
			if($trade['id']>0){
				if($trade['status']<5){
					$duoduo->update('tradelist',array('del'=>1,'trade_id'=>$row['trade_parent_id'].'del'),'trade_id_former="'.$row['trade_parent_id'].'" and category_id=1',0);
				}
				else{
					unset($data[$k]);
					continue;
				}
			}

			unset($row['earning_time']);
			unset($row['price']);
			unset($row['seller_shop_title']);
			unset($row['trade_parent_id']);
			unset($row['unid']);
			$data[$k]=$row;
		}
		return $data;
	}
	
	function taobao_tbk_rebate_order_get($start_time){
		$goods=array();
		$page_no=1;
		
		for($i=1;$i<=6;$i++){
			$_start_time=date('Y-m-d H:i:s',strtotime($start_time)+($i-1)*600);
			if(strtotime(date('Y-m-d H:i:s'))-strtotime($_start_time)<=60){
				return $this->do_rebate_order($goods);
			}
			
			for($page_no=1;$page_no<10;$page_no++){
				$this->start_time=$_start_time;
				$this->page_no = $page_no;
				$this->method='taobao.tbk.rebate.order.get';
				$this->fields = 'tb_trade_parent_id,tb_trade_id,num_iid,item_title,item_num,price,pay_price,seller_nick,seller_shop_title,commission,commission_rate,unid,create_time,earning_time';
				$this->span=600;
				$this->page_size=TAO_REPORT_GET_NUM;
			
				$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
				if(isset($TaobaokeData['code'])){
					if(AMIND==1){
						echo $_start_time;
						print_r($TaobaokeData);exit;
					}
					else{
						return $TaobaokeData;
					}
				}
				else{
					$_goods=$TaobaokeData['results']['n_tbk_order'];
					if(!empty($_goods)){
						$goods=array_merge($goods,$_goods);
						if(count($_goods)<TAO_REPORT_GET_NUM){
							$page_no=99999;
						}
					}
					else{
						$page_no=99999;
					}
				}
			}
		}
		return $this->do_rebate_order($goods);
	}
	
	function taobao_taobaoke_rebate_report_get($start_time){
		return $this->taobao_tbk_rebate_order_get($start_time);
		$goods=array();
		$page_no=1;
		
		for($i=1;$i<=6;$i++){
			$_start_time=date('Y-m-d H:i:s',strtotime($start_time)+($i-1)*600);
			if($_start_time>date('Y-m-d H:i:s')){
				return $goods;
			}
			
			for($page_no=1;$page_no<10;$page_no++){
				$this->start_time=$_start_time;
				$this->page_no = $page_no;
				$this->method='taobao.taobaoke.rebate.report.get';
				$this->fields = 'app_key,outer_code,trade_id,pay_time,create_time,pay_price,num_iid,item_title,item_num,category_id,category_name,shop_title,commission_rate,commission,iid,seller_nick,real_pay_fee';
				$this->span=600;
				$this->page_size=TAO_REPORT_GET_NUM;
			
				$TaobaokeData = $this->Send('get',$this->format)->getArrayData();

				if(isset($TaobaokeData['code'])){
					if(AMIND==1){
						echo $_start_time;
						print_r($TaobaokeData);exit;
					}
					else{
						return $TaobaokeData;
					}
				}
				else{
					$_goods=$TaobaokeData['taobaoke_payments']['taobaoke_payment'];
					if(!empty($_goods)){
						$goods=array_merge($goods,$_goods);
						if(count($_goods)<TAO_REPORT_GET_NUM){
							$page_no=99999;
						}
					}
					else{
						$page_no=99999;
					}
				}
			}
		}
		return $goods;
	}
	
	function taobao_taobaoke_listurl_get($q,$outer_code){ //S8接口，可以自己拼装url
		$pid=$this->ApiConfig->taodianjin_pid;
		$url='http://ai.taobao.com/search/index.htm?key='.rawurlencode($q).'&pid='.$pid.'&commend=all&unid='.$outer_code.'&taoke_type=1';
	    return $url;
	}
	
	function taobao_tbk_uatm_event_get($page_no=1,$page_size=20){ //注意：只能获取当天开始的
		$this->method='taobao.tbk.uatm.event.get';
		$this->page_size=$page_size;
		$this->page_no=$page_no;
		$this->fields='event_id,event_title,start_time,end_time';
		$data = $this->Send('get',$this->format)->getArrayData();
		print_r($data);
	}
	
	function taobao_tbk_uatm_event_item_get($adzone_id,$unid,$event_id,$page_no=1,$page_size=100){
		$this->method='taobao.tbk.uatm.event.item.get';
		$this->page_size=$page_size;
		$this->adzone_id=$adzone_id;
		$this->unid=$unid;
		$this->event_id=$event_id;
		$this->page_no=$page_no;
		$this->fields='num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick,shop_title,zk_final_price_wap,event_start_time,event_end_time,tk_rate,type,status';
		$data = $this->Send('get',$this->format)->getArrayData();
		print_r($data);
	}
	
	function taobao_tbk_uatm_favorites_get($parameter){ //选品库列表  $page_no=1,$page_size=20   key可选
		extract($parameter);
		if(!isset($page_no)){
			$page_no=1;
		}
		if(!isset($page_size)){
			$page_size=20;
		}
		
		if(isset($key)){
			$temp=$this->ApiConfig->AppKey;
			unset($this->ApiConfig->AppKey);
			$this->ApiConfig->AppKey[$key]=$secret;
		}

		$this->method='taobao.tbk.uatm.favorites.get';
		$this->page_no=$page_no;
		$this->page_size=$page_size;
		$this->fields='favorites_title,favorites_id,type';
		$this->type=-1;
		$data = $this->Send('get',$this->format)->getArrayData();
		
		if(isset($key)){
			$this->ApiConfig->AppKey=$temp;
		}
		if(isset($data['code'])){
			return array('s'=>$data['code'],'r'=>$data['msg'].'|'.$data['sub_code']);
		}
		else{
			return array('s'=>1,'r'=>$data['results']['tbk_favorites']);
		}
	}
	/*demo:
	$ddTaoapi->taobao_tbk_uatm_favorites_item_get(array('key'=>'12645078','secret'=>'840ac998ab136fc3e5423f952aa8b88f'));
	*/
	
	function taobao_tbk_uatm_favorites_item_get($parameter){ //$adzone_id,$favorites_id,$page_no=1,$page_size=100,$platform=1,$unid='',$all adzone_id是pid的最后一段，favorites_id是在选品库api里获取  key可选
		extract($parameter);
		if(!isset($page_no)){
			$page_no=1;
		}
		if(!isset($page_size)){
			$page_size=100;
		}
		if(!isset($platform)){
			$platform=1;
		}
		if(!isset($unid)){
			$unid='';
		}
		if(isset($key)){
			$temp=$this->ApiConfig->AppKey;
			unset($this->ApiConfig->AppKey);
			$this->ApiConfig->AppKey[$key]=$secret;
		}
		$this->method='taobao.tbk.uatm.favorites.item.get';
		$this->page_size=$page_size;
		$this->adzone_id=$adzone_id;
		$this->unid=$unid;
		$this->platform=$platform;
		$this->page_no=$page_no;
		$this->favorites_id=$favorites_id;
		$this->fields='num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick,shop_title,zk_final_price_wap,event_start_time,event_end_time,tk_rate,status,type,click_url';
		$data = $this->Send('get',$this->format)->getArrayData();
		
		if(isset($key)){
			$this->ApiConfig->AppKey=$temp;
		}
		
		if(isset($data['code'])){
			return array('s'=>$data['code'],'r'=>$data['msg'].'|'.$data['sub_code']);
		}
		else{
			if(isset($all) && $all==1 && count($data['results']['uatm_tbk_item'])==100){
				$parameter['page_no']=2;
				$parameter['all']=0;
				$re=$this->taobao_tbk_uatm_favorites_item_get($parameter);
				if($re['s']==1 && !empty($re['r'])){
					$data['results']['uatm_tbk_item']=array_merge($re['r'],$data['results']['uatm_tbk_item']);
				}
			}
			
			return array('s'=>1,'r'=>$data['results']['uatm_tbk_item']);
		}
	}
	/*demo:
	$ddTaoapi->taobao_tbk_uatm_favorites_item_get(array('adzone_id'=>31386608,'favorites_id'=>213020,'key'=>'12645078','secret'=>'840ac998ab136fc3e5423f952aa8b88f'));
	*/
	
	function taobao_tbk_order_get($start_time){
		$this->method='taobao.tbk.order.get';
		$this->fields='tb_trade_parent_id,tb_trade_id,num_iid,item_title,item_num,price,pay_price,seller_nick,seller_shop_title,commission,commission_rate,unid,create_time,earning_time';
		$this->start_time=$start_time;
		$this->span=600;
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		print_r($TaobaokeData);exit('aaa');
	}
	
	function taobao_tbk_mobile_items_convert($num_iids,$outer_code=''){
		$this->method='taobao.tbk.mobile.items.convert';
		$this->fields='click_url';
		echo $this->num_iids=$num_iids;
		$this->outer_code=$outer_code;
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		print_r($TaobaokeData);exit('aaa');
		return $TaobaokeData['tbk_items']['tbk_item'][0]['click_url'];
	}
	
	function taobao_tbk_mobile_shops_convert($str,$outer_code='',$type='nick'){
		$this->method='taobao.tbk.mobile.shops.convert';
		$this->fields='click_url';
		if($type=='nick'){
			$this->seller_nicks=$str;
		}
		else{
			$this->sids=$str;
		}
		$this->outer_code=$outer_code;
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		return $TaobaokeData['tbk_shops']['tbk_shop'][0]['click_url'];
	}
	
	function taobao_item_get($data){
		return $this->taobao_tbk_items_detail_get($data['iid']);
	}
	
	function items_detail_get($data){
		return $this->taobao_tbk_items_detail_get($data['iid']);
	}
	
	function taobao_shop_get($nick){
		return $this->taobao_tbk_shops_detail_get($nick);
	}
	
	function taobao_taobaoke_items_get($data){
		return $this->taobao_tbk_items_get($data);
	}
	
	function taobao_ju_cities_get(){
		$this->method='taobao.ju.cities.get';
		$TaobaokeData = $this->Send('get',$this->format)->getArrayData();
		print_r($TaobaokeData);exit;
	}
}
?>