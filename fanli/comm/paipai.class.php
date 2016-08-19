<?php
/**
 * ============================================================================
 * 版权所有 2008-2012 多多网络，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

class paipai{
	public $dduser;
	public $cache_time=0;
	public $errorlog=0;
	public $userId;
	public $qq;
	public $appOAuthID;
	public $secretOAuthKey;
	public $accessToken;
	public $paipaicpsurl='http://api.paipai.com';
	public $charset='utf-8';
	public $format='json';
	public $pureData=1;
	public $nowords;
	
	public function __construct($dduser,$paipai_set){
		$this->dduser=$dduser;
		$this->userId=$paipai_set['userId'];
		$this->qq=$paipai_set['qq'];
		$this->appOAuthID=$paipai_set['appOAuthID'];
		$this->secretOAuthKey=$paipai_set['secretOAuthKey'];
		$this->accessToken=$paipai_set['accessToken'];
		$this->fxbl=$paipai_set['fxbl'];
		$this->cache_time=(int)$paipai_set['cache_time'];
		$this->errorlog=(int)$paipai_set['errorlog'];
		if(REPLACE<3){
			$noword_tag='';
		}
		else{
			$noword_tag='3';
		}
		$this->nowords=dd_get_cache('no_words'.$noword_tag);
	}
	
	public function build_query($parame){
		$parame['charset']=$this->charset;
		$parame['format']=$this->format;
		$parame['pureData']=$this->pureData;
		$str='';
		foreach($parame as $k=>$v){
			$str.=$k.'='.rawurlencode($v).'&';
		}
		return $str=preg_replace('/&$/','',$str);
	}
	
	function cache_dir($parame){
		unset($parame['userId']); //去掉userid参数，使不同的访问者使用相同的缓存
		$cacheid=md5($this->build_query($parame));
		return $cache_dir=DDROOT.'/data/temp/paipai/'.substr($cacheid,0,2).'/'.$cacheid.'.json';
	}
	
	function get_cache($parame,$api_name){
		$cache_dir=$this->cache_dir($parame);
		if(file_exists($cache_dir) && TIME-filectime($cache_dir)<=$this->cache_time*3600 && $api_name!='/cps/etgReportCheck.xhtml'){
			return $row=json_decode(file_get_contents($cache_dir),1); 
		}
		else{
			return $cache_dir;
		}
	}
	
	function get($api_name,$parame){
		$val=$this->get_cache($parame,$api_name);
		if(is_array($val)){
			return $val;
		}
		$cache_dir=$val;
		$url=$this->paipaicpsurl.$api_name.'?'.$this->build_query($parame);
		$b=dd_get_json($url);
		if(!isset($b['errorCode']) || $b['errorCode']==0){
			if($this->cache_time>0){
				create_file($cache_dir,json_encode($b));
			}
			return $b;
		}
		else{
			if($api_name=='/cps/etgReportCheck.xhtml'){
				PutInfo('拍拍设置更新accessToken！<br/><a href="http://bbs.duoduo123.com/read-htm-tid-184333.html" target="_blank">查看说明</a>');
				//echo '拍拍设置更新accessToken！<br/>';
				//exit($b['errorMessage']);
			}
			if($this->errorlog==1){
				$error=$b['errorCode'].':'.$b['errorMessage']."\r\n";
				create_file(DDROOT.'/data/temp/paipai_error_log/'.date('Ymd').'.txt',$error,1,1);
			}
			return 102;
		}
	}
	
	public function cpsCommSearch($parame){
		$api_name='/cps/cpsCommSearch.xhtml';
		$parame['userId']=$this->userId;
		$parame['outInfo']=$this->dduser['id'];
		$parame['pageIndex']=$parame['pageSize']*($parame['pageIndex']-1)+1;
		if(is_numeric($parame['begPrice'])){
			$parame['begPrice']*=100;
		}
		if(is_numeric($parame['endPrice'])){
			$parame['endPrice']*=100;
		}
		
		$a=$this->sign($parame,$api_name);
		$parame=$a['parame'];
		$parame['sign']=$a['sign'];
		
		$row=$this->get($api_name,$parame);
		if($row==102){
			return array();
		}
		
		$row=$row['CpsCommSearchResult'];
		foreach($row['vecComm'] as $k=>$a){
			$arr['tagUrl']=$a['tagUrl'];
			$arr['commId']=$a['commId'];
			$arr['leafClassId']=$a['leafClassId'];
			$arr['smallImg']=$a['imgUri'];
			$arr['middleImg']=str_replace('0.jpg.2.jpg','0.jpg.3.jpg',$a['imgUri']);
			$arr['bigImg']=$a['bigUri'];
			$arr['title']=$a['title'];
			$arr['title']=dd_replace($arr['title'],$this->nowords);
			$arr['nickName']=$a['nickName'];
			$arr['uin']=$a['uin'];
			$arr['crValue']=$a['crValue'];
			$arr['price']=round($a['price']/100,2);
			$arr['crValue']=round($a['crValue']/100,2);
			$arr['fxje']=fenduan($arr['crValue'],$this->fxbl,$this->dduser['type']);
			$arr['level']=$a['level']==0?11:$a['level']; //等级图片网址http://static.paipaiimg.com/module/icon/credit/credit_s22.gif
			$arr['saleNum']=$a['saleNum'];
			$arr['leg4Status']=$a['leg4Status']; //假一赔三
			$arr['leg3Status']=$a['leg3Status']; //闪电发货
			$arr['leg2Status']=$a['leg2Status']; //7天包退
			$arr['leg1Status']=$a['leg1Status']; //先行赔付
			$arr['cashStatus']=$a['cashStatus']; //货到付款
			$arr['jump']=u('jump','paipaigoods',array('url'=>base64_encode($arr['tagUrl']),'name'=>$arr['title'],'pic'=>base64_encode($arr['smallImg']),'price'=>$arr['price'],'fan'=>$arr['fxje'],'id'=>$arr['commId']));
			$goods[]=$arr;
		}
		$goods['total']=$row['hitNum'];
		return $goods;
	}
	
	function cpsCommQueryAction($parame){
		$api_name='/cps/cpsCommQueryAction.xhtml';
		$parame['userId']=$this->userId;
		$parame['outInfo']=$this->dduser['id'];
		$parame['commId']=$parame['commId'];
		
		$a=$this->sign($parame,$api_name);
		$parame=$a['parame'];

		$parame['sign']=$a['sign'];
		
		$row=$this->get($api_name,$parame);
		$row=$row['CpsQueryResult']['cpsSearchCommData'];
		if(!$row){return 102;}
		$arr['title']=$row['sTitle'];
		$arr['title']=dd_replace($arr['title'],$this->nowords);
		$arr['commId']=$row['sRespCommId'];
		$arr['price']=round($row['dwPrice']/100,2);
		
		if($row['dwActiveFlag']==1){
			if($row['dwPrimaryCmm']==1){
				$arr['commission']=round($arr['price']*($row['dwPrimaryRate']/10000),2);
			}
			else{
				$arr['commission']=round($arr['price']*($row['dwClassRate']/10000),2);
			}
			$arr['fxje']=fenduan($arr['commission'],$this->fxbl,$this->dduser['type']);
		}
		
		$arr['uin']=$row['dwUin'];
		$arr['dwTransportPriceType']=$row['dwTransportPriceType'];
		$arr['dwNormalMailPrice']=$row['dwNormalMailPrice'];
		$arr['dwExpressMailPrice']=$row['dwExpressMailPrice'];
		$arr['dwEmsMailPrice']=$row['dwEmsMailPrice'];
		$arr['cid']=$row['dwLeafClassId'];	
		$arr['dwCurrAuctionPrice']=$row['dwCurrAuctionPrice'];//当前最新价格，商品最新的出价价格
		$arr['dwNum']=$row['dwNum'];//商品总数，即目前还有的商品数量
		$arr['saleNum']=$row['dwPayNum'];
		$arr['dwCurrPayNum']=$row['dwCurrPayNum'];
		$arr['smallImg']=$row['sCommImgUrl'].'.2.jpg';
		$arr['middleImg']=$row['sCommImgUrl'].'.3.jpg';
		$arr['bigImg']=$row['sCommImgUrl'];
		$row['sCommImgUrl']=str_replace('.jpg','',$row['sCommImgUrl']);
		$arr['img']=$row['sCommImgUrl'].'.400x400.jpg';
		$arr['tagUrl']=$row['sClickUrl'];
		$arr['jump']=u('jump','paipaigoods',array('url'=>base64_encode($arr['tagUrl']),'name'=>$arr['title'],'pic'=>base64_encode($arr['smallImg']),'price'=>$arr['price'],'fan'=>$arr['fxje'],'id'=>$arr['commId']));
		return $arr;
	}
	
	function sign($request_parame,$api_name){
		
		$request_parame['charset']=$this->charset;
		$request_parame['format']=$this->format;
		$request_parame['pureData']=1;
		$time = explode ( " ", microtime () );  
		$time = $time [1] . ($time [0] * 1000); 
		$time2 = explode ( ".", $time );  
		$time = $time2 [0];
		$sys_parame = array ('timeStamp' => $time, 'randomValue' => 123456, 'uin' => $this->qq,'userId'=>$this->userId, 'accessToken' => $this->accessToken, 'appOAuthID' => $this->appOAuthID);

		$parame=array_merge($sys_parame,$request_parame);
		ksort($parame);
		$str='';
		$str2='';

		foreach($parame as $k=>$v){
			$str.=$k.'='.$v.'&';
			$str2.=$k.'='.rawurlencode($v).'&';
		}
		$str=preg_replace('/&$/','',$str);
		$str2=preg_replace('/&$/','',$str2);
		$str='GET&'.rawurlencode($api_name).'&'.rawurlencode($str);
		
		$sign=base64_encode(hash_hmac('sha1',$str,$this->secretOAuthKey.'&',true));
		return array('sign'=>$sign,'parame'=>$parame);
	}
	
	function etgReportCheck($parame=array()){
		$api_name='/cps/etgReportCheck.xhtml';
		
		$request_parame = array (
			'beginTime' => $parame['beginTime']?$parame['beginTime']:date('Y-m-d'),
			'endTime'=>$parame['beginTime']?$parame['beginTime'].' 23:59:59':date('Y-m-d').' 23:59:59',
			'reportType'=>1,
			'pageIndex'=>$parame['pageIndex']?$parame['pageIndex']:1,
			'pageSize'=>$parame['pageSize']?$parame['pageSize']:40
		);
		
		$a=$this->sign($request_parame,$api_name);
		$parame=$a['parame'];
		$parame['sign']=$a['sign'];
		$row=$this->get($api_name,$parame);
		$total=$row['EtgReportResult']['totalNum'];
		$row=$row['EtgReportResult']['etgReportDatas'];
		$row['total']=$total;
		return $row;
	}
	
	function url2commId($url){
		preg_match('#[0-9A-Z]{32}#',$url,$a);
		return $a[0];
	}
}
?>