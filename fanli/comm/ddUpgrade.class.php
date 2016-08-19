<?php
if (!defined('DDROOT')) {
	exit('Access Denied');
} 
class duoduo_upgrade {
	var $upgradeurl = 'http://update.duoduo123.com/';//官方服务器'http://127.0.0.3/';//
	var $update_date = array();
	var $thisrelease = "";
	var $latestrelease = "";
	var $updatefile_list = array();
	var $upgradelist = array();

	public function getvalue($key) {
		return $this -> $key;
	} 
	public function setvalue($key, $value) {
		return $this -> $key = $value;
	} 

	public function check_upgrade() {
		$return = false;
		$upgradefile = $this -> upgradeurl . 'upgrade/update/index.xml';
		$response=dd_get_xml($upgradefile);
		$this -> update_date = $response['patch'];
		if (is_array($response)) {
			$upgradelist = $response['patch']['upgradelist'];
			if(isset($upgradelist['item'])){
				$upgradelist=$upgradelist['item'];
			}
			foreach($upgradelist as $k=>$vo) {
				if($this->thisrelease<$vo['release']){
					MkdirAll(UPGRADEROOT.'/'.$vo['release']);
					$dir = UPGRADEROOT.'/'.$vo['release'] . '/data';
					make_arr_cache($vo, $dir,1);
				}
				else{
					unset($response['patch']['upgradelist']['item'][$k]);
				}
			} 
			return $response['patch'];
		} else {
			$this -> savelog("官方服务器维护中");
			return;
		} 
	}


	public function download_file($update_list, $file = array(), $md5 = '', $position = 0, $offset = 0) {
		if (empty($update_list)) {
			$update_list = $this -> upgradelist;
		} 
		$dir = UPGRADEROOT . '/' . $update_list['release']  . "/uploads";
		$dir_file = iconv('gbk','utf-8//IGNORE',$dir . $file);
		if (file_exists($dir . $file)) {
			if (md5_file($dir . $file) == $md5) {
				return 2;
			} 
		}
		$this->mkdirs(dirname($dir_file));
		$downloadfileflag = true;
		if (!$position) {
			$mode = 'wb';
		} else {
			$mode = 'ab';
		} 

		$down_url = $this -> upgradeurl . $update_list['dir'] . "uploads" . $file;

		$down_url = $down_url . "sc";

		$response=dd_get($down_url);

		if ($response!='') {
			if ($offset && strlen($response) == $offset) {
				$downloadfileflag = false;
			} 
			file_put_contents($dir_file,$response);
		} 

		if ($downloadfileflag) {
			if (md5_file($dir_file) == $md5) {
				return 2;
			} else {
				@unlink($dir_file);
				return 0;
			} 
		} else {
			return 1;
		} 
	} 
	public function writefile($data, $dir, $file, $type = "w") {
		$this -> mkdirs($dir);
		$fp = fopen($dir . $file, $type);
		fwrite($fp, $data);
		fclose($fp);
	} 
	public function mkdirs($dir) {
		if (!is_dir($dir)) {
			if (!self :: mkdirs(dirname($dir))) {
				return false;
			} 
			if (!@mkdir($dir, 0777)) {
				$this -> savelog("不能创建权限777的[" . $dir . "]文件夹!");
				return false;
			} 
			@touch($dir . '/index.html');
			@chmod($dir . '/index.html', 0777);
		} 
		return true;
	} 
	function fileext($filename) {
		return trim(substr(strrchr($filename, '.'), 1, 10));
	} 
	function sockopen($url, $limit = 0, $post = '', $cookie = '', $bysocket = false, $ip = '', $timeout = 15, $block = true, $encodetype = 'URLENCODE', $allowcurl = true, $position = 0) {
		$return = '';
		$matches = parse_url($url);
		$scheme = $matches['scheme'];
		$host = $matches['host'];
		$path = $matches['path'] ? $matches['path'] . ($matches['query'] ? '?' . $matches['query'] : '') : '/';
		$port = !empty($matches['port']) ? $matches['port'] : 80;

		if (function_exists('curl_init') && function_exists('curl_exec') && $allowcurl) {
			$ch = curl_init();
			$ip && curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: " . $host));
			curl_setopt($ch, CURLOPT_URL, $scheme . '://' . ($ip ? $ip : $host) . ':' . $port . $path);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			if ($post) {
				curl_setopt($ch, CURLOPT_POST, 1);
				if ($encodetype == 'URLENCODE') {
					curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
				} else {
					parse_str($post, $postarray);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $postarray);
				} 
			} 
			if ($cookie) {
				curl_setopt($ch, CURLOPT_COOKIE, $cookie);
			} 

			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
			$data = curl_exec($ch);
			$status = curl_getinfo($ch);
			$errno = curl_errno($ch);
			curl_close($ch);
			if ($errno || $status['http_code'] != 200) {
				return;
			} else {
				return !$limit ? $data : substr($data, 0, $limit);
			} 
		} 
		if ($post) {
			$out = "POST $path HTTP/1.0\r\n";
			$header = "Accept: */*\r\n";
			$header .= "Accept-Language: zh-cn\r\n";
			$boundary = $encodetype == 'URLENCODE' ? '' : '; boundary=' . trim(substr(trim($post), 2, strpos(trim($post), "\n") - 2));
			$header .= $encodetype == 'URLENCODE' ? "Content-Type: application/x-www-form-urlencoded\r\n" : "Content-Type: multipart/form-data$boundary\r\n";
			$header .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$header .= "Host: $host:$port\r\n";
			$header .= 'Content-Length: ' . strlen($post) . "\r\n";
			$header .= "Connection: Close\r\n";
			$header .= "Cache-Control: no-cache\r\n";
			$header .= "Cookie: $cookie\r\n\r\n";
			$out .= $header . $post;
		} else {
			$out = "GET $path HTTP/1.0\r\n";
			$header = "Accept: */*\r\n";
			$header .= "Accept-Language: zh-cn\r\n";
			$header .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$header .= "Host: $host:$port\r\n";
			$header .= "Connection: Close\r\n";
			$header .= "Cookie: $cookie\r\n\r\n";
			$out .= $header;
		} 

		$fpflag = 0;
		if (!$fp = fsocketopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout)) {
			$context = array('http' => array('method' => $post ? 'POST' : 'GET',
					'header' => $header,
					'content' => $post,
					'timeout' => $timeout,
					),
				);
			$context = stream_context_create($context);
			$fp = @fopen($scheme . '://' . ($ip ? $ip : $host) . ':' . $port . $path, 'b', false, $context);
			$fpflag = 1;
		} 

		if (!$fp) {
			return '';
		} else {
			stream_set_blocking($fp, $block);
			stream_set_timeout($fp, $timeout);
			@fwrite($fp, $out);
			$status = stream_get_meta_data($fp);
			if (!$status['timed_out']) {
				while (!feof($fp) && !$fpflag) {
					if (($header = @fgets($fp)) && ($header == "\r\n" || $header == "\n")) {
						break;
					} 
				} 

				if ($position) {
					fseek($fp, $position, SEEK_CUR);
				} 

				if ($limit) {
					$return = stream_get_contents($fp, $limit);
				} else {
					$return = stream_get_contents($fp);
				} 
			} 
			@fclose($fp);
			return $return;
		} 
	} 
	// 下载update文件夹
	public function down_update($upgradelist) {
		$file = $upgradelist['update']['file'];
		$md5 = $upgradelist['update']['md5'];
		if ($file) {
			$fileurl = $this -> upgradeurl . $upgradelist['dir'] . $file . "sc";
			$dir_file = UPGRADEROOT . '/' . $upgradelist['release'] . '/' . $file;
		} 
		$a=dd_get($fileurl);
		file_put_contents(DDROOT.'/update.php',$a);
		
	} 
	// 判断当前是什么版本
	public function judgerelease() {
		$listdata = $this -> update_date;
		$upgradelist = $listdata['upgradelist'];
		
		if(isset($upgradelist['item'])){
			$upgradelist=$upgradelist['item'];
		}
		
		if (empty($upgradelist)) {
			return false;
		} 
		foreach($upgradelist as $key => $vo) {
			if ($this -> thisrelease < $vo['release']) {
				$thiskey = $key;
			} 
		} 
		$return = $upgradelist[$thiskey];
		$this -> upgradelist = $return;
		return $return;
	} 
	// 获取当前版本的文件列表生成缓存
	public function fetch_updatefile_list($update_list) {
		if (empty($update_list['release'])) {
			return false;
		} 
		$file = UPGRADEROOT.'/'. $update_list['release'] . '/md5.txt';
		$upgradedataflag = true;
		$upgradedata = @file_get_contents($file);
		$filemd5=$update_list['filemd5']['md5'];
		if(file_exists($file)){
			if(md5_file($file)!=$filemd5){
				$copmd5=true;
			}
		}
		if (!$upgradedata|$copmd5) {
			$upgradedata = dd_get($this -> upgradeurl . $update_list['dir'] . "md5.txt");
			if (empty($upgradedata)) {
				$this -> savelog("服务器上" . $update_list['release'] . "版本的md5.txt文件不存在，联系管理员");
				exit();
			} 
			$upgradedataflag = false;
		} 
		$return = array();
		$upgradedataarr = explode("\r\n", $upgradedata);
		foreach($upgradedataarr as $k => $v) {
			if (!$v) {
				continue;
			} 
			$return['file'][$k] = gbk2utf8(trim(substr($v, 34)));
			$return['md5'][$k] = substr($v, 0, 32);
			if (trim(substr($v, 32, 2)) != '*') {
				@unlink($file);
				return array();
			} 
		} 

		if (!$upgradedataflag) {
			$this -> mkdirs(dirname($file));
			$fp = fopen($file, 'w');
			if (!$fp) {
				return array();
			} 
			fwrite($fp, $upgradedata);
		} 
		$return['release'] = $update_list['release'];
		$return['dir'] = $update_list['dir'];
		$this -> updatefile_list = $return;
		return $return;
	} 
	public function cover_update($update_list, $file, $md5) {
		$dir = UPGRADEROOT.'/' . $update_list['release'] . "/uploads";
		$update_file = iconv('utf-8','gbk//IGNORE',$dir . $file); //要更新的文件
		if(preg_match('#^'.$dir.'/admin/#',$update_file)==1){
			$admin_name=str_replace(DDROOT,'',ADMINROOT);
			$admin_name=str_replace('/','',$admin_name);
			$file=preg_replace('#^/admin/#','/'.$admin_name.'/',$file);
		}
		$duoduo_file = iconv('utf-8','gbk//IGNORE',DDROOT.'/' . $file); //被更新的文件
		$beifen_file = UPGRADEROOT.'/' . $update_list['release'] . "/backup" . $file;
		if (!file_exists($update_file)) {
			return 5; //更新文件不存在
		} 
		if (file_exists($duoduo_file)) {
			$state = $this -> copy_file($duoduo_file, $beifen_file);
			if ($state == false) {
				return 1; //备份失败
			} 
		} 
		else{
			create_file($beifen_file,'');
		}
		$state = $this -> copy_file($update_file, $duoduo_file);
		if ($state == false) {
			// 覆盖失败的话还原
			$this -> copy_file($beifen_file, $duoduo_file);
			$this -> del_file($beifen_file);
			return 2; //覆盖失败
		} else {
			if (md5_file($update_file) == $md5) {
				return 3; //更新成功
			} else {
				return 4; //md5不符合但是更新成功
			} 
		} 
	} 

	public function copy_file($srcfile, $desfile, $type = "file") {
		if (empty($srcfile) | empty($desfile)) {
			return false;
		} 
		if (!is_file($srcfile)) {
			return false;
		} 
		if ($type == 'file') {
			$this -> mkdirs(dirname($desfile));
			copy($srcfile, $desfile);
		} elseif ($type == 'ftp') {
			echo "ftp功能目前没写";
		} 
		if (file_exists($desfile)) {
			if (md5_file($srcfile) == md5_file($desfile)) {
				return true;
			} else {
				return false;
			} 
		} else {
			return false;
		} 
	} 
	// 删除文件夹
	public function del_file($dir) {
		if (!file_exists($dir)) {
			return false;
		} 
		if (is_file($dir)) {
			unlink($dir);
			return true;
		} 
		if ($dh = opendir($dir)) {
			$dir = realpath($dir);
			while (($file = readdir($dh)) !== false) {
				if ($file != '.' && $file != '..') {
					$fullpath = $dir . DIRECTORY_SEPARATOR . $file;
					if (!is_dir($fullpath)) {
						unlink($fullpath);
					} else {
						$this -> del_file($fullpath);
					} 
				} 
			} 
			closedir($dh);
		} 
		if (rmdir($dir)) {
			return true;
		} else {
			return false;
		} 
	}  
	private function savelog($title) {
		header('Content-Type: text/html; charset=iso-8859-1');
		header('Content-Type: text/html; charset=utf-8');
		echo $title;
		echo "<script type='text/javascript'>alert('" . $title . "');</script>";
		exit();
	} 
} 

?>