<?php
class collect {
	public $num = 3;
	public $val = '';
	public $connect_timeout = 15; //超时时间
	public $head='';
	public $charset='utf-8';
	public $target_charset='utf-8';
	public $sock_name='';
	public $set_func='';

	function fun($url, $method) {
		if($this->set_func!=''){
			$set_func=$this->set_func;
			return $this->$set_func($url,$method);
		}
		$collect=dd_get_cache('collect');
		foreach($collect as $k=>$v){
			if($k=='fsockopen'){
				if(function_exists('fsockopen')){
		    		$this->sock_name='fsockopen';
				}
				elseif(function_exists('pfsockopen')){
		    		$this->sock_name='pfsockopen';
				}
				if($this->sock_name!=''){
					return $this->fsockopen($url,$method);
				}
			}
			elseif($k=='curl' && function_exists('curl_exec')){
				return $this->curl($url,$method);					
			}
			elseif($k=='file_get_contents' && function_exists('file_get_contents')){
				return $this->file_get_contents($url,$method);					
			}
		}
	}

	function file_get_contents($url, $method = 'get') {
		$context['http'] = array (
			'timeout' => $this->connect_timeout,
		);
		if(!empty($this->head)){
		    $context['http']['header']=$this->head;
		}
		if ($method == 'get') {
			$output = file_get_contents($url,0,stream_context_create($context));
			return $output;
		} else {
			$a = explode('?', $url);
			$context['http']['method']='POST';
			$context['http']['content']=$a[1];
			$output = file_get_contents($a[0], false, stream_context_create($context));
			return $output;
		}
	}

	function curl($url, $method = 'get') {
		$urlinfo = parse_url($url);
	    if (empty ($urlinfo['path'])) {
		    $urlinfo['path'] = '/';
	    }
	    $host = $urlinfo['host'];
		if(!array_key_exists('query',$urlinfo)){
		    $urlinfo['query']='';
		}
	    $uri = $urlinfo['path'] . $urlinfo['query']; 

	    //$header[]= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; zh-CN; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1\r\n";
	    //$header[]= "Referer: http://" . $urlinfo['host'] . "\r\n";
	    //$header[]= "Connection: Close\r\n\r\n";
		
		/* 开始一个新会话 */
		$curl_session = curl_init();

		/* 基本设置 */
		curl_setopt($curl_session, CURLOPT_FORBID_REUSE, true); // 处理完后，关闭连接，释放资源
		curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true); //把结果返回，而非直接输出
		curl_setopt($curl_session, CURLOPT_FOLLOWLOCATION,1);  //是否抓取跳转后的页面
		curl_setopt($curl_session, CURLOPT_CONNECTTIMEOUT, $this->connect_timeout); //超时时间

		if(preg_match('|^https://|',$url)==1){
		    curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_session, CURLOPT_SSL_VERIFYHOST,  false);
		}

		$url_parts = $this->parse_raw_url($url);

		if ($method == 'get') {
			$header[]= "GET " . $urlinfo['path'] . "?" . $urlinfo['query'] . " HTTP/1.1\r\n";
	    	$header[]= "Host: " . $urlinfo['host'] . "\r\n";
			curl_setopt($curl_session, CURLOPT_HTTPGET, true);
		} else {
			$a = explode('?', $url);
			$url = $a[0];
			$params = $a[1];
			curl_setopt($curl_session, CURLOPT_POST, true);
			curl_setopt($curl_session, CURLOPT_POSTFIELDS, $params);
			//$header[]= "POST " . $urlinfo['path'] . " HTTP/1.1\r\n";
	    	//$header[]= "Host: " . $urlinfo['host'] . "\r\n";
			//$header[] = 'Content-Type: application/x-www-form-urlencoded';
			//$header[] = 'Content-Length: ' . strlen($params);
		}

		/* 设置请求地址 */
		curl_setopt($curl_session, CURLOPT_URL, $url);
		
		/* 设置头部信息 */
		if(!empty($this->head)){
			unset($header);
			$header=array($this->head);
		}
		
		if(!empty($header)){
			curl_setopt($curl_session, CURLOPT_HTTPHEADER, $header);
		}

		$http_response = curl_exec($curl_session);
		curl_close($curl_session);
		return $http_response;
	}
	
	function fsockopen($url,$method='get', $time_out = "15"){
	    $urlarr = parse_url($url);
	    $errno = "";
	    $errstr = "";
	    $transports = "";
	    if ($urlarr["scheme"] == "https") {
		    $transports = "ssl://";
		    $urlarr["port"] = "443";
	    } else {
		    $transports = "";  //加tcp://有些主机就出错
		    $urlarr["port"] = "80";
	    }
        $sock=$this->sock_name;
	    $fp =  $sock($transports . $urlarr['host'], $urlarr['port'], $errno, $errstr, $this->connect_timeout);
	    if (!$fp) {
		    //die("ERROR: $errno - $errstr<br />\n");
	    } else {
			if(!isset($urlarr["query"])){
			    $urlarr["query"]='';
				$url_query='';
		    }
			else{
				$url_query=$urlarr["query"];
				$urlarr["query"]='?'.$urlarr["query"];
			}
			if(!isset($urlarr["path"])){
			    $urlarr["path"]='/';
		    }
		    if($method=='get'){
				$headers="GET " . $urlarr["path"].$urlarr["query"] . " HTTP/1.0\r\n";
				$headers.="Host: " . $urlarr["host"] . "\r\n";
				//$headers.="Host: " . $urlarr["host"] . "\r\n";
				//$headers.="Host: " . $urlarr["host"] . "\r\n";
		    }
		    elseif($method=='post'){
				$headers="POST " . $urlarr["path"].$urlarr["query"] . " HTTP/1.0\r\n";
				$headers.="Host: " . $urlarr["host"] . "\r\n";
				$headers.="Content-type: application/x-www-form-urlencoded\r\n";
				$headers.="Content-length: " . strlen($url_query) . "\r\n";
				$headers.="Accept: */*\r\n";
				$headers.="\r\n".$url_query."\r\n";
		    }

			//$headers .='User-Agent: Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)\r\n';
			if(!empty($this->head)){
			    //unset($headers);
			    $headers.=$this->head."\r\n";
		    }
			$headers .= "\r\n";

			fputs($fp, $headers, strlen($headers));
			$info='';
			$temp_info='';
			$body=0;
		    while (!feof($fp)) {
				$temp_info=fgets($fp,500000);
				if($temp_info == "\r\n" || $body==1){
				    $info.=$temp_info;
					$body=1;
				}
		    }
	    }
		fclose($fp);
		return trim($info);
	}

	function parse_raw_url($raw_url) {
		$retval = array ();
		$raw_url = (string) $raw_url;

		// make sure parse_url() recognizes the URL correctly.
		if (strpos($raw_url, '://') === false) {
			$raw_url = 'http://' . $raw_url;
		}

		// split request into array
		$retval = parse_url($raw_url);

		// make sure a path key exists
		if (!isset ($retval['path'])) {
			$retval['path'] = '/';
		}

		// set port to 80 if none exists
		if (!isset ($retval['port'])) {
			$retval['port'] = '80';
		}

		return $retval;
	}

	function generate_crlf()
    {
        $crlf = '';

        if (strtoupper(substr(PHP_OS, 0, 3) === 'WIN'))
        {
            $crlf = "\r\n";
        }
        elseif (strtoupper(substr(PHP_OS, 0, 3) === 'MAC'))
        {
            $crlf = "\r";
        }
        else
        {
            $crlf = "\n";
        }

        return $crlf;
    }

	function get($url,$method='get') {
		/*if(!preg_match('/^http/',$url)){
		    return file_get_contents($url);
		}*/

		if(preg_match('#^http://\w+\.duoduo123\.com#',$url)==1){
			$this->set_func='file_get_contents';
		}
		$a = $this->fun($url,$method);
		$this->num--;
		if ($this->num > 0 && ($a=='' || $a=='null')) {
			$a = $this->get($url);
		} 
		else {
			if($this->charset!=$this->target_charset){
		        $a=iconv($this->target_charset,$this->charset.'//IGNORE',$a);
		    }
			$this->val = $a;
		}
	}

	function get_xml($url){
		$this->get($url);
		$xml=$this->val;
		if($this->charset!=$this->target_charset){
		    $xml=str_replace($this->target_charset,$this->charset,$xml);
		}
		
		$xmlCode = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
		$arrdata = $this->get_object_vars_final($xmlCode);
		return $arrdata;
	}
	
	function get_json($url){
		$this->get($url);
		$json=$this->val;
		$arrdata = dd_json_decode($json,1);
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
	
	function curl_get_http_status($url){
	    $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_HEADER,1);
        curl_setopt($curl,CURLOPT_NOBODY,1);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION,0);
        curl_exec($curl);
        $rtn= curl_getinfo($curl,CURLINFO_HTTP_CODE);
        curl_close($curl);
        return  $rtn;
	}
	
	function fsockopen_get_http_status($url = "localhost", $port = 80, $fsock_timeout = 10) {
		ignore_user_abort(true); // 记录开始时间
		list ($usec, $sec) = explode(" ", microtime());
		$timer['start'] = (float) $usec + (float) $sec; // 校验URL
		if (!preg_match("/^https?:\/\//i", $url)) {
			$url = "http://" . $url;
		} // 支持HTTPS
		if (preg_match("/^https:\/\//i", $url)) {
			$port = 443;
		} // 解析URL
		$urlinfo = parse_url($url);
		if (empty ($urlinfo['path'])) {
			$urlinfo['path'] = '/';
		}
		$host = $urlinfo['host'];
		$uri = $urlinfo['path'] . (empty ($urlinfo['query']) ? '' : $urlinfo['query']); // 通过fsock打开连接
		if (!$fp = fsockopen($host, $port, $errno, $error, $fsock_timeout)) {
			list ($usec, $sec) = explode(" ", microtime(true));
			$timer['end'] = (float) $usec + (float) $sec;
			$usetime = (float) $timer['end'] - (float) $timer['start'];
			return array (
				'code' => -1,
				'usetime' => $usetime
			);
		} // 提交请求
		$status = socket_get_status($fp);
		$out = "GET {$uri} HTTP/1.1\r\n";
		$out .= "Host: {$host}\r\n";
		$out .= "Connection: Close\r\n\r\n";
		$write = fwrite($fp, $out);
		if (!$write) {
			list ($usec, $sec) = explode(" ", microtime(true));
			$timer['end'] = (float) $usec + (float) $sec;
			$usetime = (float) $timer['end'] - (float) $timer['start'];
			return array (
				'code' => -2,
				'usetime' => $usetime
			);
		}
		$ret = fgets($fp, 1024);
		preg_match("/http\/\d\.\d\s(\d+)/i", $ret, $m);
		$code = $m[1];
		fclose($fp);
		list ($usec, $sec) = explode(" ", microtime());
		$timer['end'] = (float) $usec + (float) $sec;
		$usetime = (float) $timer['end'] - (float) $timer['start'];
		return $code;
		//	return array (
		//		'code' => $code,
		//		'usetime' => $usetime
		//	);
	}
	
	function get_http_status($url){
	    if (function_exists('curl_exec')) {
			return $this->curl_get_http_status($url);
		}
		elseif(function_exists('fsockopen')){
			return $this->fsockopen_get_http_status($url);
		}
	}
}

function dd_get($url,$method='get',$cache_time=0){
	if(is_numeric($method)){
		$cache_time=$method;
		$method='get';
	}
	if($cache_time>0){
		$re=get_ddcache($url,'url',$cache_time);
	}
	else{
		$re=false;
	}
	
	if($re===false){
		$c=fs('collect');
		$c->get($url,$method);
		$re=$c->val;
		if($cache_time>0){
			set_ddcache($url,$re,'url');
		}
	}
	return $re;
}

function dd_get_xml($url){
    $c=fs('collect');
	return $c->get_xml($url);
}

function dd_get_json($url){
    $c=fs('collect');
	return $c->get_json($url);
}

function DownHost($host,$data='',$method='GET',$showagent=null,$port=null,$user='',$pwd='',$timeout=30)
{
    $reval = array();
    $parse = parse_url($host);
    if (empty($parse)) return false;
    if ((int)$port>0) {
        $parse['port'] = $port;
    } elseif (!isset($parse['port'])) {
        $parse['port'] = '80';
    }
    if(!empty($user)) $parse['user'] = $user;
    if(!empty($pwd)) $parse['pass'] = $pwd;

    $parse['host'] = str_replace(array('http://','https://'),array('','ssl://'),"$parse[scheme]://").$parse['host'];
	$sock=function_exists('fsockopen')?'fsockopen':'pfsockopen';
    if (!$fp=$sock($parse['host'],$parse['port'],$errnum,$errstr,$timeout)) {
        return false;
    }
    $method = strtoupper($method);
    $wlength = $wdata = $responseText = '';
    $parse['path'] = str_replace(array('\\','//'),'/',$parse['path'])."?$parse[query]";

    $headers = '';
    $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2)';
    $headers .= "User-Agent: " . $agent . "\r\n";

    $accept = 'image/gif, image/x-xbitmap, image/jpeg, image/pjpeg, */*';
    $headers .= "Accept: " . $accept . "\r\n";

    if (! empty($parse['user']) || ! empty($parse['pass']))
    $headers .= "Authorization: Basic " . base64_encode($parse['user'] . ":" . $parse['pass']) . "\r\n";

    $content_type = '';
    if(!empty($content_type))
    {
        $headers .= "Content-type: $content_type";
        if ($content_type == "multipart/form-data")
            $headers .= "; boundary=dede" . md5(uniqid(microtime()));
        $headers .= "\r\n";
    }

    if ($method=='GET') {
        $separator = $parse['query'] ? '&' : '';
        substr($data,0,1)=='&' && $data = substr($data,1);
        $parse['path'] .= $separator.$data;
    } elseif ($method=='POST') {
        $wlength = "Content-length: ".strlen($data)."\r\n";
        $wdata = $data;
    }

    $write = "$method $parse[path] HTTP/1.0\r\nHost: $parse[host]\r\n{$wlength}{$headers}\r\n$wdata";
    // dump($write);

    @fwrite($fp,$write,strlen($write));

    while ($currentHeader = fgets($fp, 4096)) {
        if ($currentHeader == "\r\n")
            break;
        // 根据返回信息判断是否跳转
        if (preg_match("/^(Location:|URI:)/i", $currentHeader)) {
            preg_match("/^(Location:|URI:)[ ]+(.*)/i", chop($currentHeader), $matches);
            if (! preg_match("|\:\/\/|", $matches[2])) {
                $_redirectaddr = $parse["scheme"] . "://" . $parse['host'] . ":" . $parse['port'];
                if (! preg_match("|^/|", $matches[2]))
                    $_redirectaddr .= "/" . $matches[2];
                else
                    $_redirectaddr .= $matches[2];
            } else {
                $_redirectaddr = $matches[2];
            }
            return DownHost($_redirectaddr,$data,$method,$showagent,$port,$user,$pwd,$timeout);
        }
        $reval['status'] = '';
        if (preg_match("|^HTTP/|", $currentHeader)) {
            if (preg_match("|^HTTP/[^\s]*\s(.*?)\s|", $currentHeader, $status))
            {
                $reval['status'] = $status[1];
            }
        }
    }

    $reval['results'] = '';
    do {
        $_data = fread($fp, 500000);
        if (strlen($_data) == 0) {
            break;
        }
        $reval['results'] .= $_data;
    } while (true);
    @fclose($fp);
    return $reval['results'];
}

function only_send($url, $method = 'get', $time_out = "15") {
	$urlarr = parse_url($url);
	$errno = "";
	$errstr = "";
	$transports = "";
	if ($urlarr["scheme"] == "https") {
		$transports = "ssl://";
		$urlarr["port"] = "443";
	} else {
		$transports = ""; //加tcp://有些主机就出错
		$urlarr["port"] = "80";
	}
	if(function_exists('fsockopen')){
		$sock = 'fsockopen';
	}
	elseif(function_exists('pfsockopen')){
		$sock = 'pfsockopen';
	}
	else{
		return '(p)fsockopen not exits';
	}

	$fp = $sock ($transports . $urlarr['host'], $urlarr['port'], $errno, $errstr, $time_out);
	if (!$fp) {
		//die("ERROR: $errno - $errstr<br />\n");
	} else {
		if (!isset ($urlarr["query"])) {
			$urlarr["query"] = '';
			$url_query = '';
		} else {
			$url_query = $urlarr["query"];
			$urlarr["query"] = '?' . $urlarr["query"];
		}
		if (!isset ($urlarr["path"])) {
			$urlarr["path"] = '/';
		}
		if ($method == 'get') {
			$headers = "GET " . $urlarr["path"] . $urlarr["query"] . " HTTP/1.0\r\n";
			$headers .= "Host: " . $urlarr["host"] . "\r\n";
			//$headers.="Host: " . $urlarr["host"] . "\r\n";
			//$headers.="Host: " . $urlarr["host"] . "\r\n";
		}
		elseif ($method == 'post') {
			$headers = "POST " . $urlarr["path"] . $urlarr["query"] . " HTTP/1.0\r\n";
			$headers .= "Host: " . $urlarr["host"] . "\r\n";
			$headers .= "Content-type: application/x-www-form-urlencoded\r\n";
			$headers .= "Content-length: " . strlen($url_query) . "\r\n";
			$headers .= "Accept: */*\r\n";
			$headers .= "\r\n" . $url_query . "\r\n";
		}

		//$headers .='User-Agent: Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)\r\n';

		$headers .= "\r\n";

		stream_set_blocking($fp, TRUE);
		stream_set_timeout($fp, $time_out);
		fwrite($fp, $headers);
		fclose($fp);
	}
}
?>