<?php   //一起发开放平台接口 
class yiqifa{
    public $key;
	public $secret;
	public $getBaseUrl='http://openapi.yiqifa.com/api2';
	public $charset='utf-8';
	public $format='json';
	public $cache_open=0;
	public $cache_time=8;
	public $cache_root='';
	public $target_charset='gbk'; //一起发是gbk格式
    public static $collect;
	
	public function __construct (){
        if (self::$collect == NULL) {
            self::$collect = new collect();
        }
    }
	
	function get($method,$parame=array()){
		if($this->cache_open==1){
		    $cache_dir=$this->cache_root.'/'.$this->cache_dir($method,$parame);
		    if(file_exists($cache_dir)){
				$creat_time=filemtime($cache_dir);
				if(TIME-$creat_time<$this->cache_time*3600){
					$cache_data=file_get_contents($cache_dir);
					$cache_data=json_decode($cache_data,1);
					return $cache_data;
				}
		    }
		}
		if($parame['keyword']){
			$parame['keyword']=iconv("UTF-8","GBK//IGNORE",$parame['keyword']);
		}
		$parame_str=param2str($parame);
		$url=$this->getBaseUrl.'/'.$method.'.'.$this->format.'?'.$parame_str;
		$head='Authorization: '.$this->get_head($url);
		self::$collect->head=$head;
		self::$collect->charset=$this->charset;
		self::$collect->target_charset=$this->target_charset;

		$array=self::$collect->get_json($url);
		
		$empty=$this->check_empty($method,$array);
	
		if($empty==1){
		    return '';
		}
		
		if($this->cache_open==1){
			$c=json_encode($array);
		    create_file($cache_dir,$c,0,1);
		}
		
		return $array;
	}
	
	function check_empty($method,$array){
		if(!is_array($array)){
			return 1;
		}
		$re=0;
	    switch($method){
		    case 'open.product.search':
			    if(empty($array['response']['pdt_list']['pdt'])){
				    $re=1;
				}
			break;
		}
		return $re;
	}
	
	function cache_dir($method,$parame=array()){
		$p='';
	    if(strpos($method,'/')!==false){
		    $method=str_replace('/','_',$method);
		}
		$p=param2str($parame);
		$p=md5($p);
		return $method.'/'.substr($p,0,3).'/'.$p.'.json';
	}
	
	function get_head($url){
	    $authparam = $this->get_auth_params();       
        $params = $authparam;
        
        $basestr = $this->get_base_str($url,$params);
                
        $tk = $this->secret."&openyiqifa";
        $sign = $this->hmacsha1($tk,$basestr);
        $str = "";
        foreach($authparam as $k=>$v){
            if($str=="") $str .= $k."=\"".urlencode($v)."\"";
            else $str.= (",".$k."=\"".urlencode($v)."\"");    
        }
        
        $str = "OAuth ".$str.",oauth_signature=\"".urlencode($sign)."\"";
        return $str;
	}
	
	function get_auth_params(){
        $ts = TIME;
        $nonce = $ts + rand();
        $authparam = array(
            "oauth_consumer_key"=>$this->key,
            "oauth_signature_method"=>"HMAC-SHA1",
            "oauth_timestamp"=>$ts,
            "oauth_nonce"=>$nonce,
            "oauth_version"=>"1.0",
            "oauth_token"=>"openyiqifa"
        );       
        return $authparam;    
    }
	
	function parse_get_params($url){
        $params = array();
        $i = strpos($url,"?");
        
        if(!$i){
            return $params;
        }
        
        $sp = explode("&",substr($url,$i+1,strlen($url)));
        
        foreach($sp as $p){
            $spi = explode("=",$p);
            if(count($spi)>1) $params[urldecode($spi[0])] = urldecode($spi[1]);
        }
        return $params;
    }
	
	function get_base_str($url,$params){
        $params = $this->sort_params($params);        
         
        $basestr = "GET&".urlencode($this->construct_request_url($url)).'&'.urlencode($this->normalize_request_parameters($params));
        return $basestr;
    }
	
	function sort_params($params){
        $keys = array_keys($params); 
        sort($keys);
        $newparams = array();
        foreach($keys as $k){
            $newparams[$k] = $params[$k];    
        } 
        return $newparams;  
    }
	
	function construct_request_url($url){
        $i = strpos($url,"?"); 
        if(!$i){
            return $url;
        }else{
            return substr($url,0,$i);    
        }  
    }
	
	function normalize_request_parameters($params){
        $s = "";
        foreach($params as $k=>$v){
            if($s==""){
                $s = $k."=".urlencode($v);
            }else{
                $s = $s."&".$k."=".urlencode($v);   
            }
        }
        return $s;   
    }
	
	function hmacsha1($key,$data) {
        $blocksize=64;
        $hashfunc= 'sha1';
        if (strlen($key)>$blocksize)
            $key=pack('H*',$hashfunc($key));
        $key=str_pad($key,$blocksize,chr(0x00));
        $ipad=str_repeat(chr(0x36),$blocksize);
        $opad=str_repeat(chr(0x5c),$blocksize);
        $hmac = pack(
                    'H*',$hashfunc(
                        ($key^$opad).pack(
                            'H*',$hashfunc(
                                ($key^$ipad).$data
                            )
                        )
                    )
                );
        
        return base64_encode($hmac);
    }
}
?>