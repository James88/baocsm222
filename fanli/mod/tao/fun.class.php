<?php //多多
class dd_tao_class{
	public $duoduo;
	
	function __construct($duoduo){
		$this->duoduo=$duoduo;
	}
	
	function get_type($type='goods'){
		$type_all=dd_get_cache('type');
		$goods_type=$type_all[$type];
		return $goods_type;
	}

	function dd_tao_goods($data){ //如果cid为a，检索推荐数据
		$num=$data['num'];
		$frmnum=$data['frmnum']?$data['frmnum']:0;
		$cid=$data['cid'];
		$q=$data['q'];
		$total=$data['total'];
		$where='del=0';
		if((int)$cid >0){
			$where.=' and cid="'.$cid.'"';
		}
		elseif($cid=='a'){
			$where.=' and tuijian="1"';
		}
		if($q!=''){
			$where.=' and title like "%'.$q.'%"';
		}
		if($total==1){
			$total_num=$this->duoduo->count('goods',$where);
		}
    	$tao_goods=$this->duoduo->select_all('goods','*',$where.' order by sort=0 asc, sort asc,id desc limit '.$frmnum.','.$num);
		foreach($tao_goods as $k=>$row){
			if($row['promotion_price']>0 && $row['promotion_price']<$row['price']){
				$tao_goods[$k]['is_promotion']=1;
			}else{
				$tao_goods[$k]['is_promotion']=0;
				$tao_goods[$k]['promotion_price']=$row['price'];
			}
			$commission=$row['commission'];
			$tao_goods[$k]['name']=$row['title'];
        	$tao_goods[$k]['fxje']=jfb_data_type(fenduan($commission,$this->duoduo->webset['fxbl'],$this->duoduo->dduser['type'],TBMONEYBL));
	       	$tao_goods[$k]['go_view']=u('tao','view',array('iid'=>$row['iid']));
			$tao_goods[$k]['gourl']=u('tao','view',array('iid'=>$row['iid']));
			$tao_goods[$k]['go_shop']=u('shop','list',array('nick'=>$row['nick']));
			$tao_goods[$k]['detail_url']='http://item.taobao.com/item.htm?id='.$row['iid'];
    	}
		
		if($total==1){
			return array('total'=>$total_num,'data'=>$tao_goods);
		}
		else{
			return $tao_goods;
		}
	}
	
	function dd_tao_shops($shops){ //处理淘宝店铺数据
		if(empty($shops)){
			return $shops;
		}
		$total=2;
		if(!isset($shops[0])){
			$shops=array($shops);
			$total=1;
		}
		foreach ($shops as $k=>$row) {
			
			if($row["pic_path"]!='' && !preg_match('/^http/',$row["pic_path"])){
				$row["pic_path"]=TAOLOGO . $row["pic_path"];
			}
			
			if($row["logo"]==''){
				$row["logo"] = $row["pic_path"];
			}
			
			if ($row['type'] == 'B') {
				$row['level'] == 21;
			}
			if ($row['level'] == 21) {
				$row['onerror'] = 'images/tbsc.gif';
			} else {
				$row['onerror'] = 'images/tbdp.gif';
			}
			$row['detail_url'] = "http://shop" . $row["sid"] . '.taobao.com';
			if($row['user_id']!=''){
				$row['uid'] = $row['user_id'];
			}
			$row['jump'] = u('jump','shop',array('sid'=>$row["sid"],'user_id'=>$row["user_id"],'nick'=>$row["nick"]));
			
			$shops[$k]=$row;
		}
		if($total==1){
			$shops=$shops[0];
		}
		return $shops;
	}
}
?>