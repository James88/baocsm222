<?php  //一起发接口多多程序扩展
class ddyiqifa extends yiqifa{
	public $nowords;
		
	function product_search($parame,$total=0){  //搜索商品
		if(REPLACE<3){
			$noword_tag='';
		}
		else{
			$noword_tag='3';
		}
		
		$this->nowords=dd_get_cache('no_words'.$noword_tag);
		$parame['fields']='pid,p_name,web_id,web_name,ori_price,cur_price,pic_url,catid,cname,p_o_url,total';
	    $goods=$this->get('open.product.search',$parame);

		$data=array();
		if(!is_array($goods)){
			return array('total'=>0);
		}
		$data['results']=$goods['response']['pdt_list']['pdt'];
		$data['total']=$goods['response']['total'];

		$row=$data['results'];

		$newrow=array();
		foreach($row as $k=>$arr){
			if(empty($arr['p_o_url']) || empty($arr['web_id'])){
				continue;
			}
		    $newrow[$k]['url']=$this->do_ad_url($arr['p_o_url']);
			$newrow[$k]['p_name']=str_replace(array('"',"'"),'',$arr['p_name']);
	        $newrow[$k]['base64_pic']=base64_encode($arr['pic_url']);
			$newrow[$k]['pic_url']=$arr['pic_url'];
			
			$newrow[$k]['title']=dd_replace($row[$k]['p_name'],$this->nowords);
			$newrow[$k]['name_url']=rawurlencode($newrow[$k]['title']);
			$newrow[$k]['merchantId']=$arr['web_id'];
			$newrow[$k]['mall_name']=$row[$k]['web_name'];
			$newrow[$k]['mall_url']=u('mall','list',array('q'=>$newrow[$k]['mall_name']));
			$newrow[$k]['price']=$row[$k]['cur_price'];
			$newrow[$k]['market_price']=$row[$k]['ori_price'];
		}
		
		if($total==1 && isset($data['total'])){
		    $newrow['total']=$data['total'];
		}
		
		return $newrow;
	}
	function website($webid,$type=1){
		$parame['fields']='web_id,web_name,web_catid,logo_url,web_url,information,begin_date,end_date,commission';
		$parame['type']=$type;
		$parame['webid']=$webid;
	    $data=$this->get('open.website.get',$parame);
		$website=$data['response']['website'];
		if($website){
			return $website;
		}else{
			return false;
		}
	}

	function do_ad_url($url){
	    $arr=explode('?',$url);
		parse_str($arr[1],$param);
		$param['w']=$this->wid;
		$param['u']=$this->uid;
		$param['e']=$this->e;
		$p=param2str($param);
		$url=$arr[0].'?'.$p;
		if(isset($arr[2])){
		    $url.='?'.$arr[2];
		}
		return $url;
	}
}
?>