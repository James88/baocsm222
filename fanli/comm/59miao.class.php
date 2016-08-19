<?php //59秒api
class wujiumiao{
	public $base_url='http://gw.api.59miao.com/Router/Rest?';
	public $charset='utf-8'; //59秒的网址参数只接受gbk编码的中文
	public $format='json';
	public $v='1.0';
	public $sign_method='md5';
	public $appkey='';
	public $appSecret='';
	public $cache_time=0;
	public $errorlog=0;
	public $partner_uid=116630;
	public $nowords;
	
	function items_search($param){
		
		if(REPLACE<3){
			$noword_tag='';
		}
		else{
			$noword_tag='3';
		}
		$this->nowords=dd_get_cache('no_words'.$noword_tag);
		
		$method='59miao.items.search';
		$fields='iid,click_url,cid,sid,seller_url,title,seller_name,desc,pic_url,price,cashback_scope';//iid,click_url,cid,sid,seller_url,title,seller_name,desc,pic_url,price,cash_ondelivery,freeshipment,installment,has_invoice,modified,price_reduction,price_decreases,original_price
		if(isset($param['total'])){
			$total=$param['total'];
			unset($param['total']);
		}
		$data=$this->get($param,$method,$fields);
		if(empty($data)){
			return 102;
		}
		else{
			$arrdata=$data['items_search_response']['items_search']['items']['item'];
			if($data['items_search_response']['total_results'] == 1){
				$arrdata = array($arrdata);
			}
			foreach($arrdata as $k=>$row){
				$arrdata[$k]['merchantId']=$row['sid'];
				$arrdata[$k]['url']=$row['click_url'];
				
				$row['title']=dd_replace($row['title'],$this->nowords);
				
				$arrdata[$k]['name_url']=rawurlencode($row['title']);
				$arrdata[$k]['base64_pic']=base64_encode($row['original_pic_url']);
				$arrdate[$k]['pic_url']=$row['original_pic_url'];
				$arrdata[$k]['mall_name']=preg_replace('/cps|\(返利站\)/i','',$row['seller_name']);
				$arrdata[$k]['mall_url']=$row['seller_url'];
				
				unset($arrdata[$k]['cash_ondelivery']);
				unset($arrdata[$k]['cashback_desc']);
				unset($arrdata[$k]['cid']);
				unset($arrdata[$k]['click_url']);
				unset($arrdata[$k]['desc']);
				unset($arrdata[$k]['freeshipment']);
				unset($arrdata[$k]['has_invoice']);
				unset($arrdata[$k]['installment']);
				unset($arrdata[$k]['modified']);
				unset($arrdata[$k]['original_pic_url']);
				unset($arrdata[$k]['original_price']);
				unset($arrdata[$k]['popular']);
				unset($arrdata[$k]['price_decreases']);
				unset($arrdata[$k]['price_reduction']);
				unset($arrdata[$k]['seller_name']);
				unset($arrdata[$k]['seller_url']);
				unset($arrdata[$k]['sid']);
			}
			
			if($total==1){
				$total=$data['items_search_response']['total_results'];
				$arrdata['total']=$total;
			}
			
			return $arrdata;
		}
	}
	
	function items_get($param){
		$method='59miao.items.get';
		$fields='iid,click_url,cid,sid,seller_url,title,seller_name,desc,pic_url,price,cash_ondelivery,freeshipment,installment,has_invoice,modified,price_reduction,price_decreases,original_price';
		$arrdata=$this->get($param,$method,$fields);
		if(empty($arrdata)){
			return 102;
		}
		else{
			$arrdata=$arrdata['items_get_response']['items']['item'];
			return $arrdata;
		}
	}
	
	function promos_list_get($param){
		$method='59miao.promos.list.get';
		$fields='click_url,sid,seller_url,title,seller_name,start_time,end_time,pid,seller_logo,pic_url_1,pic_url_2,pic_url_3';
		if(isset($param['total'])){
			$total=$param['total'];
			unset($param['total']);
		}
		$arrdata=$this->get($param,$method,$fields);
		if(empty($arrdata)){
			return 102;
		}
		else{
			if(isset($total)){
				$total=$arrdata['promos_get_response']['total_results'];
				$arrdata['promos_get_response']['promos']['promo']['total']=$total;
			}
			$arrdata=$arrdata['promos_get_response']['promos']['promo'];
			return $arrdata;
		}
	}
	
	function shops_list_get($param){
		$method='59miao.shops.list.get';
		$fields='click_url,status,name,sid,desc,logo,cashback';
		if(isset($param['total'])){
			$total=$param['total'];
			unset($param['total']);
		}
		$arrdata=$this->get($param,$method,$fields);
		if(empty($arrdata)){
			return 102;
		}
		else{
			if(isset($total)){
				$total=$arrdata['shops_get_response']['total_results'];
				$arrdata['shops_get_response']['shops']['shop']['total']=$total;
			}
			$arrdata=$arrdata['shops_get_response']['shops']['shop'];
			return $arrdata;
		}
	}
	
	function shops_get($param){
		$method='59miao.shops.get';
		$fields='click_url,status,name,sid,desc,logo,cashback';
		$arrdata=$this->get($param,$method,$fields);
		if(empty($arrdata)){
			return 102;
		}
		else{
			unset($arrdata['shops_get_response']['total_results']);
			$arrdata=$arrdata['shops_get_response']['shops']['shop'];
			return $arrdata;
		}
	}
	
	function orders_report_get($param){
		$method='59miao.orders.report.get';
		$fields='order_id,seller_id,seller_name,app_key,created,order_amount,commission,status,outer_code';
		if(isset($param['total'])){
			$total=$param['total'];
			unset($param['total']);
		}
		$arrdata=$this->get($param,$method,$fields);
		$a=$arrdata['orders_report_get_response']['orders']['order'];
	
		if(!isset($a[0])){
			$row[0]=$a;
		}
		else{
			$row=$a;
		}
		
		if($total==1){
			$total=$arrdata['orders_report_get_response']['total_results'];
			$row['total']=$total;
		}

		return $row;
	}
	
	function create_sign ($param) { 
		$sign = $this->appSecret; 
		foreach ($param as $key => $val) { 
			if ($key !='' && $val !==''){
				if($key=='keyword'){
					$val=iconv('utf-8','gbk//IGNORE',$val);
				}
				$sign .= $key . $val;
			} 
		}
		$sign = strtoupper(md5($sign));
		return $sign; 
	}
	
	function create_str_param ($param) { 
		return http_build_query($param);
	}
	
	function cache_dir($param){
		unset($param['timestamp']); //删除不定数据
		unset($param['outer_code']);
		$str=md5(http_build_query($param));
		return DDROOT.'/data/temp/wujiumiaoapi/'.substr($str,0,2).'/'.$str.'.'.$this->format;
	}
	
	function do_content($content){
		if($this->format=='json'){
			$arrdata=dd_json_decode($content);
		}
		elseif($this->format=='xml'){
			$xmlCode = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);
			$arrdata = $this->get_object_vars_final($xmlCode);
		}
		return $arrdata;
	}
	
	function get_object_vars_final($obj) {
		if (is_object($obj)) {
			$obj = get_object_vars($obj);
		}

		if (is_array($obj)) {
			foreach ($obj as $key => $value) {
				$obj[$key] = $this->get_object_vars_final($value);
			}
		}
		return $obj;
	}
	
	function get($param,$method,$fields){
		$arrdata=array();
		
		$param['method']=$method;
		if(!isset($param['fields'])){
			$param['fields']=$fields;
		}
		$param['app_key']=$this->appkey;
		$param['format']=$this->format;
		$param['partner_uid']=$this->partner_uid;
		$param['sign_method']=$this->sign_method;
		$param['timestamp']=date('Y-m-d H:i:s',TIME);
		$param['v']=$this->v;
		if(isset($param['no_cache']) && $param['no_cache']==1){
			$no_cache=1;
		}
		else{
			$no_cache=0;
		}
		unset($param['no_cache']);
		ksort($param);

		$cache_dir=$this->cache_dir($param);
		if(file_exists($cache_dir) && $no_cache!=1){
			$content=file_get_contents($cache_dir);
			$arrdata=$this->do_content($content);
		}
		else{
			$url=$this->base_url.http_build_query($param).'&sign='.$this->create_sign($param);
			$content=dd_get($url);
			$arrdata=$this->do_content($content);
			if(isset($arrdata['errorslogs'])){
				if($this->errorlog==1){
					$error=$arrdata['errorslogs']['errorslog']['code'].' '.$arrdata['errorslogs']['errorslog']['discription'];
					$errdir=DDROOT.'/data/temp/59miao_error_log/'.date('Ymd').'.txt';
					create_file($errdir,$error,1,1);
				}
			}
			elseif($this->cache_time>0){
				create_file($cache_dir,$content,0,1,1);
			}
		}
		return $arrdata;
	}
}
?>