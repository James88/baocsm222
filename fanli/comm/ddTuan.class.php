<?php
class tuan extends duoduo {

	public $i = 0;
	public $j = 0;
	public $id = 0;
	public $table = 'tuan_goods';
	public $tuan_cat_arr=array();
	public $city_arr=array();
	public $set=array();
	public $mall_id_i;
	public $mall_id_row;
	
	function init(){
	    $this->tuan_cat_arr=dd_get_cache('tuan_cat');
		$this->city_sort=dd_get_cache('city/city_sort');
	}
	
	function get_salt($url,$city){
		$salt=dd_crc32($city.$url);
		return $salt;
	}

	function get_tuan_cid($title) {
		foreach($this->tuan_cat_arr as $k=>$row){
			foreach($row['content'] as $value){
			    if(strpos($title,$value)!==false){
					//if($k>1){echo $k;exit;}
			        return $k;
			    }
			}
		}
	}

	function do_tuan_goods($field_arr) {
		$field_arr['title']=addslashes($field_arr['title']);
		$row = $this->select($this->table, 'id,addtime', "salt='" . $field_arr['salt'] . "'", 0);
		$this->id=$row['id'];
		if ($this->id > 0 ) {
			if(TIME-$row['addtime']>3600){ //一小时外获取的商品才会更新
				$field_arr['addtime'] = TIME;
				$this->update($this->table, $field_arr, "id='" . $this->id . "'");
				$this->j++;
			}
		} else {
			$field_arr['addtime'] = TIME;
			
			$this->insert($this->table, $field_arr, 0);
			$this->i++;
		}
	}

	function insert_tuan_goods($arr, $mall_id, $rule = 'baidu') {
		$city_arr=$this->city_sort;
		if($rule=='baidu' || $rule=='hao123' || $rule=='lashou' || $rule=='dida' || $rule=='f') {
			if($arr['@attributes']['count']==1){$t=$arr['url'];unset($arr);$arr['url'][0]=$t;}
			foreach ($arr['url'] as $row) {
				if(in_array($row['data']['display']['city'],$city_arr)){
					$field_arr['title'] = $row['data']['display']['title'];

					$field_arr['city']=$row['data']['display']['city'];
					$field_arr['url'] = $row['loc'];
					$field_arr['cid'] = $this->get_tuan_cid($field_arr['title']) ? $this->get_tuan_cid($field_arr['title']) : $this->set['cid'];
					if($rule=='lashou'){
					    $field_arr['img'] = 'http://s1.lashouimg.com/'.$row['data']['display']['image'];
					}
					else{
					    $field_arr['img'] = $row['data']['display']['image'];
					}
					$field_arr['sdatetime'] = $row['data']['display']['startTime'];
					$field_arr['edatetime'] = $row['data']['display']['endTime'];
					if(!is_numeric($field_arr['sdatetime'])){
						$field_arr['sdatetime']=strtotime($field_arr['sdatetime']);
					}
					if(!is_numeric($field_arr['edatetime'])){
						$field_arr['edatetime']=strtotime($field_arr['edatetime']);
					}
					$field_arr['bought'] = $row['data']['display']['bought'];
					$field_arr['price'] = (float)$row['data']['display']['price'];
					$field_arr['value'] = (float)$row['data']['display']['value'];
					$field_arr['rebate'] = $row['data']['display']['rebate'];
					
					if(strstr($field_arr['title'],'{discountPrice}')){ //特殊api处理 http://tuan.xiu.com/api/baidu.php
					    $field_arr['title']=str_replace('{discountPrice}',$field_arr['price'],$field_arr['title']);
						$field_arr['title']=str_replace('{marketPrice}',$field_arr['value'],$field_arr['title']);
						$field_arr['title']=str_replace('{discount}',$field_arr['rebate'],$field_arr['title']);
					}
					
					if($field_arr['rebate']==''){$field_arr['rebate']=round($row['data']['display']['price']/$row['data']['display']['value'],2)*10;}
					$field_arr['mall_id'] = $mall_id;
			        $field_arr['salt'] = $this->get_salt($field_arr['url'],$field_arr['city']);
					if($field_arr['edatetime']>TIME){
						$this->do_tuan_goods($field_arr);
					}
				}
			}
		}
		/*elseif($rule=='lashou'){
		    foreach ($arr['url'] as $row) {
				if(in_array($row['data']['display']['city'],$city_arr)){
					$field_arr['title'] = $row['data']['display']['title'];
					$field_arr['city']=$row['data']['display']['city'];
					$field_arr['url'] = $row['loc'];
					$field_arr['cid'] = $this->get_tuan_cid($field_arr['title']) ? $this->get_tuan_cid($field_arr['title']) : $this->set['cid'];
					$field_arr['img'] = $row['data']['display']['image'];
					$field_arr['sdatetime'] = $row['data']['display']['startTime'];
					$field_arr['edatetime'] = $row['data']['display']['endTime'];
					$field_arr['bought'] = $row['data']['display']['bought'];
					$field_arr['price'] = $row['data']['display']['price'];
					$field_arr['value'] = $row['data']['display']['value'];
					$field_arr['rebate'] = $row['data']['display']['rebate'];
					$field_arr['mall_id'] = $mall_id;
				    $field_arr['salt'] = $this->get_salt($field_arr['url'],$field_arr['city']);
				    if($field_arr['edatetime']>TIME){
						$this->do_tuan_goods($field_arr);
					}
				}
			}
		}*/
		elseif($rule=='360'){
		    foreach ($arr['goodsdata']['goods'] as $row) {
				$field_arr['city']=$row['city_name'];
				if(in_array($field_arr['city'],$city_arr)){
					$field_arr['url'] = $row['goods_url'];
					$field_arr['title'] = $row['desc'];
					$field_arr['cid'] = $this->get_tuan_cid($field_arr['title']) ? $this->get_tuan_cid($field_arr['title']) : $this->set['cid'];
					$field_arr['img'] = $row['img_url'];
					$field_arr['sdatetime'] = strtotime($row['start_time']);
					$field_arr['edatetime'] = strtotime($row['close_time']);
					$field_arr['bought'] = $row['sales_num'];
					$field_arr['price'] = $row['sale_price'];
					$field_arr['value'] = $row['original_price'];
					$field_arr['rebate'] = $row['sale_rate'];
					$field_arr['mall_id'] = $mall_id;
					$field_arr['salt'] = $this->get_salt($field_arr['url'],$field_arr['city']);
					if($field_arr['edatetime']>TIME){
						$this->do_tuan_goods($field_arr);
					}
				}
			}
		}
		elseif($rule=='like'){
		    foreach ($arr['goods'] as $row) {
				if(in_array($row['cityname'],$city_arr)){
					$field_arr['city']=$row['cityname'];
					$field_arr['url'] = $row['url'];
					$field_arr['title'] = $row['title'];
					$field_arr['cid'] = $this->get_tuan_cid($field_arr['title']) ? $this->get_tuan_cid($field_arr['title']) : $this->set['cid'];
					$field_arr['img'] = $row['bigimg'];
					$field_arr['sdatetime'] = strtotime($row['begintime']);
					$field_arr['edatetime'] = strtotime($row['endtime']);
					$field_arr['bought'] = $row['buycount']?$row['buycount']:0;
					$field_arr['price'] = $row['groupprice'];
					$field_arr['value'] = $row['marketprice'];
					$field_arr['rebate'] = sprintf("%01.1f",($row['groupprice']*10)/$row['marketprice']);
					$field_arr['mall_id'] = $mall_id;
					$field_arr['salt'] = $this->get_salt($field_arr['url'],$field_arr['city']);
					 if($field_arr['edatetime']>TIME){
						$this->do_tuan_goods($field_arr);
					}
				}
			}
		}
		elseif($rule=='meituan'){
		    /*foreach ($arr['deals']['data'] as $aaa) {
				$row=$aaa['deal'];
				if(in_array($row['city_name'],$city_arr)){
					$field_arr['url'] = $row['deal_url'];
					$field_arr['title'] = $row['deal_title'];
					$field_arr['cid'] = $this->get_tuan_cid($field_arr['title']) ? $this->get_tuan_cid($field_arr['title']) : $this->set['cid'];
					$field_arr['img'] = $row['deal_img'];
					$field_arr['city'] = $row['city_name'];
					$field_arr['sdatetime'] = $row['start_time'];
					$field_arr['edatetime'] = $row['end_time'];
					$field_arr['bought'] = $row['sales_num'];
					$field_arr['price'] = $row['price'];
					$field_arr['value'] = $row['value'];
					$field_arr['rebate'] = $row['rebate'];
					$field_arr['mall_id'] = $mall_id;
				    $field_arr['salt'] = $this->get_salt($field_arr['url'],$field_arr['city']);
					if($field_arr['edatetime']>TIME){
						$this->do_tuan_goods($field_arr);
					}
				}
			}*/
			
			foreach ($arr['deals']['data'] as $row) {
				//美团的城市名称可能是多个,这里将城市拆成数组处理
				if(strpos($row['deal']['city_name'],',')!==false){
					$city_name_arr = explode(',',$row['deal']['city_name']);
				}
				else{
					$city_name_arr=array($row['deal']['city_name']);
				}
				foreach($city_name_arr as $city_name){
					if(in_array($city_name,$city_arr)){
						$field_arr['url'] = $row['deal']['deal_url'];
						$field_arr['title'] = $row['deal']['deal_title'];
						$field_arr['cid'] = $this->get_tuan_cid($field_arr['title']) ? $this->get_tuan_cid($field_arr['title']) : $this->set['cid'];
						$field_arr['img'] = $row['deal']['deal_img'];
						$field_arr['city'] = $city_name;
						$field_arr['sdatetime'] = $row['deal']['start_time'];
						$field_arr['edatetime'] = $row['deal']['end_time'];
						$field_arr['bought'] = $row['deal']['sales_num'];
						$field_arr['price'] = $row['deal']['price'];
						$field_arr['value'] = (float)$row['deal']['value'];
						$field_arr['rebate'] = (float)$row['deal']['rebate'];
						$field_arr['content']=$row['deal']['deal_tips'];
						$field_arr['mall_id'] = $mall_id;
						$field_arr['salt'] = $this->get_salt($field_arr['url'],$field_arr['city']);
						if($field_arr['edatetime']>TIME){
							$this->do_tuan_goods($field_arr);
						}
					}
				}
			}
		}
		$mall_id_arr=explode(',',$_GET['mallid']);
		$cur_mall_id=$mall_id_arr[$_GET['mall_id_i']];
		$cur_city_id=$_GET['cityid'];
		return '入库商品'.$this->i . "件|更新商品" . $this->j.'件'.'，商城id：'.$mall_id.' | 城市索引：'.(int)$cur_city_id.'<br/><br/><img src="images/wait2.gif"/>';
	}

	function get_tuan_city($arr, $mall_id,$rule='meituan') {
		$city_arr=$this->city_sort;
		if($rule=='meituan'){
			foreach ($arr['divisions']['division'] as $row) {
			    if(in_array($row['name'],$city_arr)){
			        $city[] = $row['id'];
			    }
		    }
		}
		elseif($rule=='lashou' || $rule=='dida'){
		    foreach ($arr['city'] as $row) {
			    if(in_array($row['name'],$city_arr)){
			        $city[] = $row['id'];
			    }
		    }
		}
		elseif($rule=='f'){
		    foreach ($arr['city'] as $row) {
			    if(in_array($row['cnname'],$city_arr)){
			        $city[] = $row['enname'];
			    }
		    }
		}
		dd_set_cache('city/mall_city_' . $mall_id,$city);
		return $city;
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

	function collect($key) {
		$key = authcode($key, 'DECODE');
		if ($key != '1') {
			echo 'miss key';
			exit;
		}

		$mall_id_i = $this->mall_id_i;
		$mall_id_row = $this->mall_id_row;
		$mall_id = $mall_id_row[$mall_id_i];
		$re=array('word'=>'','url'=>'');

		$mall_arr = $this->select('mall', 'api_url,api_rule', 'id="' . $mall_id.'"');

		if($mall_arr['api_rule']=='baidu' || $mall_arr['api_rule']=='hao123' ||  $mall_arr['api_rule']=='360' ||  $mall_arr['api_rule']=='like'){
		    $arr = dd_get_xml($mall_arr['api_url']);
			$re['word'] = $this->insert_tuan_goods($arr, $mall_id, $mall_arr['api_rule']);
			if ($mall_id_row[$mall_id_i +1] > 0) {
				$mall_id_i++;
				$data = array (
					'mod'=>MOD,
					'act'=>ACT,
					'auto' => $_GET['auto'],
					'mallid' => $_GET['mallid'],
					'mall_id_i' => $mall_id_i,
					'cityid' => 0,
					'key' => authcode('1','ENCODE')
				);
				$next_url="http://" . $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.param2str($data);
				$re['url']=$next_url;
			} else {
				$re['word']='采集完成';
				$re['url']='';
				return $re;
			}
		}
		elseif($mall_arr['api_rule']=='meituan' || $mall_arr['api_rule']=='lashou' || $mall_arr['api_rule']=='dida' || $mall_arr['api_rule']=='f'){
		    $city_id = $_GET['cityid'] ? $_GET['cityid'] : 0;
			$mall_city = dd_get_cache('city/mall_city_' . $mall_id);
			if($mall_arr['api_rule']=='meituan' || $mall_arr['api_rule']=='dida' || $mall_arr['api_rule']=='f'){
			    $api_url = str_replace('beijing', $mall_city[$city_id], $mall_arr['api_url']);
			}
			elseif($mall_arr['api_rule']=='lashou'){
			    $api_url = str_replace('2419', $mall_city[$city_id], $mall_arr['api_url']);
			}
			if ($mall_city[$city_id]!='') {
				$arr = dd_get_xml($api_url);
				$re['word'] = $this->insert_tuan_goods($arr, $mall_id, $mall_arr['api_rule']);
				$city_id++;
				$data = array (
					'mod'=>MOD,
					'act'=>ACT,
					'auto' => $_GET['auto'],
					'mallid' => $_GET['mallid'],
					'mall_id_i' => $mall_id_i,
					'cityid' => $city_id,
					'key' => authcode('1','ENCODE')
				);
				$next_url="http://" . $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.param2str($data);
				$re['url']=$next_url;
			} else {
				if ($mall_id_row[$mall_id_i +1] > 0) {
					$mall_id_i++;
					$data = array (
						'mod'=>MOD,
					    'act'=>ACT,
						'auto' => $_GET['auto'],
						'mallid' => $_GET['mallid'],
						'mall_id_i' => $mall_id_i,
						'cityid' => 0,
						'key' => authcode('1','ENCODE')
					);
					$next_url="http://" . $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.param2str($data);
				    $re['url']=$next_url;
				} else {
					$re['word']='采集完成';
					$re['url']='';
				    return $re;
				}
			}
		}
		else{
			dd_exit('api规则不识别');
		}
		return $re;
	}
}
?>