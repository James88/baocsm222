<?php
//ini_set("max_execution_time", "0");
require_once 'taoapi_Config.php';
require_once 'taoapi_Cache.php';
require_once 'taoapi_Exception.php';

/**
 * 淘宝API处理类
 *
 * @category Taoapi
 * @package Taoapi
 * @copyright Copyright (c) 2008-2009 Taoapi (http://www.Taoapi.com)
 * @license    http://www.Taoapi.com
 * @version    Id: Taoapi  2009-12-22  12:30:51  浪子 ；多多淘宝客优化：http://www.duoduo123.com
 */
class Taoapi
{
    protected $taobaoData;

    private $_userParam = array();

    public $_errorInfo;
    /**
     * @var Taoapi_Config
     */
    public $ApiConfig;

    /**
     * @var Taoapi_Cache
     */
    public $Cache;
	
	public $cache_id;

	private $_ArrayModeData;

    public function __construct ()
    {  
		$Config = Taoapi_Config::Init();

		$this->ApiConfig = $Config->getConfig();
		
        $this->Cache = new Taoapi_Cache();
        $this->Cache->setClearCache($this->ApiConfig->ClearCache);
    }
    
    public function __set ($name, $value)
    {
        if ($this->taobaoData && $this->ApiConfig->AutoRestParam) {

            $this->_userParam = array();
			$this->taobaoData = null;
        }
        $this->_userParam[$name] = $value;
    }
    
	public function setUserParam($userParam)
	{
		$this->_userParam = $userParam;
	}

    public function __get ($name)
    {
        if (! empty($this->_userParam[$name])) {

            return $this->_userParam[$name];
        }
    }
    public function __unset ($name)
    {
        unset($this->_userParam[$name]);
    }

    public function __isset ($name)
    {
        return isset($this->_userParam[$name]);
    }

    public function __destruct ()
    {
        $this->_userParam = array();
    }

    public function __toString ()
    {
        return $this->createStrParam($this->_userParam);
    }

    /**
     * @return Taoapi
     */
    public function setRestNumberic ($rest)
    {
        $this->ApiConfig->RestNumberic = intval($rest);

		return $this;
    }
    
    /**
     * @return Taoapi
     */
    public function setVersion ($version, $signmode = 'md5')
    {
        $this->ApiConfig->Version  = intval($version);

        $this->ApiConfig->SignMode  = $signmode;

        return $this;
    }

    /**
     * @return Taoapi
     */
    public function setCloseError()
    {
        $this->ApiConfig->CloseError  = false;

        return $this;
    }

	private function FormatUserParam($param)
	{
		if(strtoupper($this->ApiConfig->Charset) != 'UTF-8')
		{
			if(function_exists('mb_convert_encoding'))
			{
			    if(is_array($param))
			    {
			        foreach($param as $key => $value)
			        {
				        $param[$key] = @mb_convert_encoding($value,'UTF-8',$this->ApiConfig->Charset);
			        }
			    }else{
				    $param = @mb_convert_encoding($param,'UTF-8',$this->ApiConfig->Charset);
			    }
			}elseif(function_exists('iconv'))
			{
			    if(is_array($param))
			    {
			        foreach($param as $key => $value)
			        {
				        $param[$key] = @iconv($this->ApiConfig->Charset,'UTF-8//IGNORE',$value);
			        }
			    }else{
				    $param = @iconv($this->ApiConfig->Charset,'UTF-8//IGNORE',$param);
			    }
			}
		}

		return $param;
	}

	private function FormatTaobaoData($data)
	{
		if(strtoupper($this->ApiConfig->Charset) != 'UTF-8')
		{
			if(function_exists('mb_convert_encoding'))
			{
				$data = str_replace('utf-8',$this->ApiConfig->Charset,$data);
				$data = @mb_convert_encoding($data,$this->ApiConfig->Charset,'UTF-8');
			}elseif(function_exists('iconv'))
			{
				$data = str_replace('utf-8',$this->ApiConfig->Charset,$data);
				$data = @iconv('UTF-8',$this->ApiConfig->Charset.'//IGNORE',$data);
			}
		}

		return $data;
	}

    /**
     * @return Taoapi
     */
    public function Send ($mode = 'GET', $format = 'xml')
    {
        $imagesArray = $this->_ArrayModeData = array();

		$tempParam = $this->_userParam;

        foreach ($tempParam as $key => $value) 
		{
            if (is_array($value)) {
                    if (! empty($value['image'])) {
                        $imagesArray = $value;
                    }
                    unset($tempParam[$key]);
            }elseif(trim($value) == '')
            {
                unset($tempParam[$key]);
            }else{
				$tempParam[$key] = $this->FormatUserParam($value);
			}
        }
        
        if (! isset($tempParam['api_key'])) {

            $systemdefault['api_key'] = key($this->ApiConfig->AppKey);
            $systemdefault['format'] = strtolower($format);
            $systemdefault['v'] = strpos($this->ApiConfig->Version,'.') ? $this->ApiConfig->Version : $this->ApiConfig->Version.'.0';
			if($this->ApiConfig->Version == 2)
			{
				$systemdefault['sign_method'] = strtolower($this->ApiConfig->SignMode);
			}
            $systemdefault['timestamp'] = date('Y-m-d H:i:s');

			$tempParam = array_merge($tempParam,$systemdefault);
			$this->_userParam = array_merge($this->_userParam,$systemdefault);
        }

        $cacheid = $tempParam;

        unset($cacheid['timestamp']);  //去掉随机性数据
		unset($cacheid['api_key']);

        $cacheid = md5($this->createStrParam($cacheid));
		
		$this->cache_id=$cacheid;

        $method = ! empty($tempParam['method']) ? $tempParam['method'] : '';

        $this->Cache->setMethod($method);

        if (! $this->taobaoData = $this->Cache->getCacheData($cacheid)) {

            $mode = strtoupper($mode);

            $ReadMode = array_key_exists($mode, $this->ApiConfig->PostMode) ? $this->ApiConfig->PostMode[$mode] : $ReadMode['GET'];

            if ($ReadMode == 'postImageSend') {
                $this->taobaoData = $this->$ReadMode($tempParam, $imagesArray);
            } else {
                $this->taobaoData = $this->$ReadMode($tempParam);
            }

            $error = $this->getArrayData($this->taobaoData);

			$this->ApiCallLog();
			
            if (isset($error['code'])) {

				/*if(in_array($error['code'],array(4,5,6,7,8,25)))
				{
					$this->_systemParam['apicount'] = empty($this->_systemParam['apicount']) ? 1 : $this->_systemParam['apicount'] + 1;
					if($this->_systemParam['apicount'] < count($this->ApiConfig->AppKey))
					{
						next($this->ApiConfig->AppKey);
						$this->_userParam['api_key'] = key($this->ApiConfig->AppKey);
						return $this->Send($mode, $format);
					}
				}*/

				if($this->ApiConfig->RestNumberic && empty($this->_systemParam['apicount'])) {

                    $this->ApiConfig->RestNumberic = $this->ApiConfig->RestNumberic - 1;

                    return $this->Send($mode, $format);
                } else {
                    $tempParam['sign'] = $this->_systemParam['sign'];

                    $this->_errorInfo = new Taoapi_Exception($error, $tempParam, $this->ApiConfig->CloseError,$this->ApiConfig->Errorlog);

					if(!$this->ApiConfig->CloseError)
					{
						echo $this->FormatTaobaoData($this->_errorInfo->getErrorInfo());
					}
                }
            } else {
				$this->cache_id=$cacheid;
            }
        }
		
        return $this;
    }

	public function ApiCallLog ()
    {
		if($this->ApiConfig->ApiLog)
		{
			$apilogpath = DDROOT . '/data/temp/taoapi_call_log';
			$logparam = $this->_userParam;
			unset($logparam['fields']);
			create_file($apilogpath . '/' .key($this->ApiConfig->AppKey).'_'. date('Y-m-d') . '.log',implode("\t", $logparam) . "\r\n",1);
		}
    }

    public function getXmlData ()
    {
        if (empty($this->taobaoData)) {
            return false;
        }		
        return $this->FormatTaobaoData($this->taobaoData);
    }

    public function getJsonData ()
    {
        if (empty($this->taobaoData)) {
            return false;
        }
        if (substr($this->taobaoData, 0, 1) != '{') {

            if ($this->_userParam['format'] == 'xml') {
				$Charset = $this->ApiConfig->Charset;
				$this->ApiConfig->Charset = "UTF-8";
                $Data = $this->getArrayData($this->taobaoData);
				$this->ApiConfig->Charset = $Charset;
            }

            $Data = json_encode($Data);
            if (strpos($_SERVER['SERVER_SIGNATURE'], "Win32") > 0) {
                $Data = preg_replace("#\\\u([0-9a-f][0-9a-f])([0-9a-f][0-9a-f])#ie", "iconv('UCS-2','UTF-8//IGNORE',pack('H4', '\\1\\2'))", $Data);
            } else {
                $Data = preg_replace("#\\\u([0-9a-f][0-9a-f])([0-9a-f][0-9a-f])#ie", "iconv('UCS-2','UTF-8//IGNORE',pack('H4', '\\2\\1'))", $Data);
            }
			$Data = $this->FormatTaobaoData($Data);

        } else {
            $Data = $this->taobaoData;
        }
        return $Data;
    }

    public function getArrayData ()
    {
        if (empty($this->taobaoData)) {
            return false;
        }
		
		if(!empty($this->taobaoData) && is_array($this->taobaoData)){
			if($this->_userParam['format'] == 'json'){
			    foreach($this->taobaoData as $k=>$row){
				    return $row;
				}
			}
		}

		if(!empty($this->_ArrayModeData[$this->ApiConfig->Charset]))
		{
			return $this->_ArrayModeData[$this->ApiConfig->Charset];
		}

        if ($this->_userParam['format'] == 'json') {
            $arr = dd_json_decode($this->taobaoData, true);
			if(is_array($arr) && !isset($arr['error_response'])){
			    $this->Cache->saveCacheData($this->cache_id, $this->taobaoData);
			}
            if($this->_userParam['format'] == 'json' && is_array($arr)){
			    foreach($arr as $k=>$row){
				    return $row;
				}
			}
			return array();
        } 
		elseif ($this->_userParam['format'] == 'xml') {

            $xmlCode = simplexml_load_string($this->taobaoData, 'SimpleXMLElement', LIBXML_NOCDATA);

			if(is_object($xmlCode)){
				$this->Cache->saveCacheData($this->cache_id, $this->taobaoData);
			}
			
			$taobaoData = $this->get_object_vars_final($xmlCode);

			if(strtoupper($this->ApiConfig->Charset) != 'UTF-8')
			{
				$taobaoData = $this->get_object_vars_final_coding($taobaoData);
			}

			$this->_ArrayModeData[$this->ApiConfig->Charset] = $taobaoData;

            return $taobaoData;

        } else {
            return false;
        }
    }

    /**
     * 返回错误提示信息
     *
     * @return array
     */
    public function getErrorInfo ()
    {
        if ($this->_errorInfo) {
            if (is_object($this->_errorInfo)) {

                return $this->FormatTaobaoData($this->_errorInfo->getErrorInfo());
            } else {
                return $this->FormatTaobaoData($this->_errorInfo);
            }
        }
    }
    /**
     * 返回提交参数
     *
     * @return array
     */
    public function getParam ()
    {
        return $this->_userParam;
    }

    private function JoinSign($paramArr)
    {
       $sign = '';
       foreach ($paramArr as $key => $val) {
               if(is_array($val))
               {
                   $sign .= $this->JoinSign($val);
                   
               }elseif ($key != '' && $val != '') {
                    $sign .= $key . $val;
                }
        }
        
        return $sign;
    }
    public function SignVersion2 ($paramArr)
    {
        if (strtolower($this->ApiConfig->SignMode) == 'hmac') {
            ksort($paramArr);
            $sign = $this->JoinSign($paramArr);
            $sign = strtoupper(bin2hex(mhash(MHASH_MD5, $sign,current($this->ApiConfig->AppKey))));
        } else {
            ksort($paramArr);
            $sign = $this->JoinSign($paramArr);
            $sign  = strtoupper(md5(current($this->ApiConfig->AppKey) . $sign . current($this->ApiConfig->AppKey)));
        }
        return $sign;
    }

    public function SignVersion1 ($paramArr)
    {
            $sign = current($this->ApiConfig->AppKey);
            ksort($paramArr);
            $sign .= $this->JoinSign($paramArr);
            $sign = strtoupper(md5($sign));

        return $sign;
    }

    public function createSign ($paramArr)
    {
		$Version = 'SignVersion'.intval($this->ApiConfig->Version);

		if(method_exists($this,$Version))
		{
			$sign = $this->{$Version}($paramArr);
		}

		$this->_systemParam['sign'] = $sign;
        return $sign;
    }

    static public function createStrParam ($paramArr)
    {
        $strParam = array();
        foreach ($paramArr as $key => $val) {
            if ($key != '' && $val != '') {
                $strParam []= $key . '=' . urlencode($val);
            }
        }
        return implode('&',$strParam);
    }

    private $_systemParam;
	
	public function check_num_iids($num_iids){
	    if($num_iids==''){
		    return $re='Missing required arguments:num_iids';
		}
		if(strpos($num_iids,',')!==false){
			if(str_replace(',','',$num_iids)==''){
			    return $re='Missing required arguments:num_iids';
			}
		    $num_iids_arr=explode(',',$num_iids);
			foreach($num_iids_arr as $num_iid){
				$num_iid=(float)$num_iid;
				$num_iid_l=strlen($num_iid);
			    if($num_iid<=0 || ($num_iid_l<8 || $num_iid_l>12)){
				    return $re='invalid arguments:num_iids';
				}
			}
		}
		else{
		    $num_iid=(float)$num_iids;
		    $num_iid_l=strlen($num_iid);
			if($num_iid<=0 || ($num_iid_l<8 || $num_iid_l>12)){
				return $re='invalid arguments:num_iids';
			}
		}
	}
	
	public function check_sids($sids){
	    if($sids==''){
		    return $re='Missing required arguments:sids';
		}
		if(strpos($sids,',')!==false){
			if(str_replace(',','',$sids)==''){
			    return $re='Missing required arguments:sids';
			}
		    $sids_arr=explode(',',$sids);
			if(count(sids_arr)>10){return $re='invalid arguments:sids';}
			foreach($sids_arr as $sid){
				$sid=(float)$sid;
				$sid_l=strlen($sid);
				if(sid_l>11){return $re='invalid arguments:sids';}
			    if($sid<=0){return $re='invalid arguments:sids';}
			}
		}
		else{
		    $sid=(float)$sids;
			$sid_l=strlen($sid);
			if(sid_l>11){return $re='invalid arguments:sids';}
			if($sid<=0){return $re='invalid arguments:sids';}
		}
	}
	
	public function check_users($users){
	    if($users==''){
		    return $re='Missing required arguments:users';
		}
		if(strpos($users,',')!==false){
			if(str_replace(',','',$users)==''){
			    return $re='Missing required arguments:users';
			}
		    $users_arr=explode(',',$users);
			foreach($users_arr as $user){
			    if($user==''){
				    return $re='invalid arguments:users';
				}
			}
		}
		else{
		    $user=$users;
			if($user==''){
				return $re='invalid arguments:users';
			}
		}
	}

    public function check_error($paramArr){
	    $method=$paramArr['method'];
		$re='';
		$sort_list_arr=include(DDROOT.'/data/tao_list_sort.php');

		switch($method){
			case 'taobao.taobaoke.items.get':
				if($paramArr['keyword']=='' && $paramArr['cid']==''){
				    $re='Missing required arguments:cid or keyword';
				}
				if($paramArr['sort']!='' && !array_key_exists($paramArr['sort'],$sort_list_arr)){
		            $re=$paramArr['sort'];
		        }
				if(isset($paramArr['page_no']) && $paramArr['page_no']>10){
			        $re='max 10';
			    }
			break;
			
			case 'taobao.items.get':
				if($paramArr['q']=='' && $paramArr['cid']==''){
				    $re='Missing required arguments:cid or q';
				}
				if($paramArr['sort']!='' && !in_array($paramArr['sort'],$sort_list_arr)){
		            $paramArr['sort']=$sort_list_arr[0];
		        }
				if($paramArr['page_no']>10){
			        $re='max 10';
			    }
			break;
			
			case 'taobao_items_search':
			    if($paramArr['page_no']>99){
			        $re='max 99';
			    }
			break;
			
		    case 'taobao.users.get':
			    $re=$this->check_users($paramArr['nicks']);
			break;
			
			case 'taobao.item.get':
			    $re=$this->check_num_iids($paramArr['num_iid']);
			break;
			
			case 'taobao.taobaoke.items.convert':
			    $re=$this->check_num_iids($paramArr['num_iids']);
			break;
			
			case 'taobao.taobaoke.items.detail.get':
			    $re=$this->check_num_iids($paramArr['num_iids']);
			break;
			
			case 'taobao.taobaoke.shops.convert':
				if($paramArr['sids']!=''){
					$re=$this->check_sids($paramArr['sids']);
				}
				if($paramArr['seller_nicks']!=''){
					$re=$this->check_users($paramArr['seller_nicks']);
				}
			break;
			
			case 'taobao.shop.get':
			    if($paramArr['nick']==''){
			        $re='Missing required arguments:nick';
			    }
			break;
			
			case 'taobao.user.get':
			    if($paramArr['nick']==''){
			        $re='Missing required arguments:nick';
			    }
			break;
			
			case 'taobao.itemcats.get':
			    if($paramArr['parent_cid']=='' && $paramArr['cids']==''){
			        $re='Missing required arguments:parent_cid or cids';
			    }
			break;
			
			case 'taobao.taobaoke.listurl.get':
			    if($paramArr['q']==''){
			        $re='Missing required arguments:q';
			    }
			break;
			
			case 'taobao.taobaoke.items.relate.get':
			    if($paramArr['relate_type']==4 && is_numeric($paramArr['seller_id'])==''){
			        $re='miss seller_id';
			    }
			break;

		}
		return $re;
	}

    public function getSend ($paramArr)
    {
		$error=$this->check_error($paramArr);
		if($error==''){
		    //组织参数
            $this->_systemParam['sign'] = $this->createSign($paramArr);
            $paramArr['sign'] = $this->_systemParam['sign'];
            $strParam = $this->createStrParam($paramArr);
			
			if($paramArr['method']=='taobao.taobaoke.rebate.authorize.get' || $paramArr['method']=='taobao.taobaoke.rebate.auth.get' || $paramArr['method']=='taobao.tbk.rebate.auth.get'){
				$method_is_fanli=1;
			}
			else{
				$method_is_fanli=0;
			}
			
			if(HASAPI==1 && TAOTYPE==2){ //有api且是返利类，调用淘宝接口
				$this->_systemParam['url'] = $this->ApiConfig->Url . '?' . $strParam;
			}
			elseif(HASAPI==1 && TAOTYPE==1){ //有数据调用api的
				if($method_is_fanli==0){
					$this->_systemParam['url'] = $this->ApiConfig->Url . '?' . $strParam;
				}
				else{
					$uu='ddurl='.urlencode(URL). '&' . $strParam;
					$this->_systemParam['url'] = DD_YUN_URL.'/api/?'.$uu .'&ddsign='.urlencode(md5(DDYUNKEY.$uu.DDYUNKEY));
				}
			}
			else{ //无api
				$uu='ddurl='.urlencode(URL). '&' . $strParam;
				$this->_systemParam['url'] = DD_YUN_URL.'/api/?'.$uu .'&ddsign='.urlencode(md5(DDYUNKEY.$uu.DDYUNKEY));
			}

			for($i=0;$i<TAO_API_GET_NUM;$i++){
				$result = dd_get($this->_systemParam['url']);
				if($result!=''){
					$i=99;
				}
				else{
					sleep(1);
				}
			}
			
            //返回结果
            return $result;
		}
		else{
		    //exit($error);
		}
    }

    /**
     * 以POST方式访问api服务
     * @param $paramArr：api参数数组
     * @return $result
     */
    public function postSend ($paramArr)
    {
        //组织参数，Taoapi_Util类在执行submit函数时，它自动会将参数做urlencode编码，所以这里没有像以get方式访问服务那样对参数数组做urlencode编码
        $this->_systemParam['sign'] = $this->createSign($paramArr);
        $paramArr['sign'] = $this->_systemParam['sign'];
        $this->_systemParam['url'] = array($this->ApiConfig->Url , $paramArr);
        //访问服务
        self::$Taoapi_Util->submit($this->ApiConfig->Url, $paramArr);
        $result = self::$Taoapi_Util->results;
        //返回结果
        return $result;
    }
    /**
     * 以POST方式访问api服务，带图片
     * @param $paramArr：api参数数组
     * @param $imageArr：图片的服务器端地址，如array('image' => '/tmp/cs.jpg')形式
     * @return $result
     */
    public function postImageSend ($paramArr, $imageArr)
    {
        //组织参数
        $this->_systemParam['sign'] = $this->createSign($paramArr);
        $paramArr['sign'] = $this->_systemParam['sign'];
        //访问服务
        self::$Taoapi_Util->_submit_type = "multipart/form-data";
        $this->_systemParam['url'] = array($this->ApiConfig->Url , $paramArr , $imageArr);
        self::$Taoapi_Util->submit($this->ApiConfig->Url, $paramArr, $imageArr);
        $result = self::$Taoapi_Util->results;
        //返回结果
        return $result;
    }

    private function get_object_vars_final ($obj)
    {
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

    private function get_object_vars_final_coding ($obj)
    {
		foreach($obj as $key => $value)
		{
			if(is_array($value))
			{
				$obj[$key] = $this->get_object_vars_final_coding($value);
			}else{
				$obj[$key] = $this->FormatTaobaoData($value);
			}
		}
        return $obj;
    }

	public function getUrl()
	{
		return !empty($this->_systemParam['url']) ? $this->_systemParam['url'] :'';
	}
	public function getSign()
	{
		return !empty($this->_systemParam['sign']) ? $this->_systemParam['sign'] :'';
	}

	
}
?>