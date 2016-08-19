<?php //淘宝帐号登录阿里妈妈
class tblm{
	
	public $login_url='https://login.taobao.com/member/login.jhtml?style=minisimple&from=alimama&disableQuickLogin=true';
	public $yzm_url='https://login.taobao.com/member/request_nick_check.do?_input_charset=utf-8';
	public $base_url='http://yun.duoduo123.com/alimama/api.php';
	public $cookie_file;
	public $cur_time;
	public $charset='utf-8';
	public $cookie_expried=3000; //cookie过期时间大约是1小时，这里检测3000秒就需要从新获取
	public $parame='';
	public $xls_file="";
	public $support_mobile_yz=1;
	
	function __construct(){
		$this->cur_time=time();
		$this->cookie_file=DDROOT.'/data/cookie_'.dd_crc32(DDKEY.'cookie').'.txt';
	}
	
	function change_char($str,$type=1){ //type为1表示由utf-8转gbk，2表示gbk转utf-8
		if($this->charset!='utf-8'){
			return $str;
		}
		if($type==1){
			$str=iconv("utf-8", "gbk//IGNORE",$str);
		}
		else{
			$str=iconv("gbk", "utf-8//IGNORE",$str);
		}
		return $str;
	}
	
	function set_name_pwd($username,$password='',$yzm=''){
		if(strlen($yzm)!=4){$yzm='';}
		$parame=array();
		$parame['name']=$username;
		$parame['pwd']=$password;
		$parame['yzm']=$yzm;
		$this->parame=$parame;
	}
	
	function get($param){
		$param['name']=$this->parame['name'];
		$param['pwd']=$this->parame['pwd'];
		$url=$this->base_url.'?'.http_build_query($param);
		$a=dd_get($url);
		$a=dd_json_decode($a);
		return $a;
	}
	
	function get_yzm_url(){
		$param=array('m'=>'get_yzm','name'=>$this->parame['name']);
		$a=$this->get($param);
		if($a['s']==1){
			return $a['r'];
		}
	}
	
	function escape($str) {
		$a=array('s'=>$str);
		preg_match('/:"(.*)"/',json_encode($a),$a);
		return rawurlencode($a[1]);
	}
	
	function curl($url,$type=1,$parame='') { //type表示cookie状态，1表示存储cookie
		$curl = curl_init();
    	curl_setopt($curl, CURLOPT_URL, $url);
    	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		$useragent='Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.65 Safari/537.36';
    	curl_setopt($curl, CURLOPT_USERAGENT,$useragent);
    	curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		
		if (is_array($parame)) {
        	$http_data = http_build_query($parame);
    	} else {
        	$http_data = $parame;
    	}
    	if ($http_data) {
        	curl_setopt($curl, CURLOPT_POST, 1);
        	curl_setopt($curl, CURLOPT_POSTFIELDS, $http_data);
    	} else {
        	curl_setopt($curl, CURLOPT_HTTPGET, 1);
    	}
		
		if($type==1){
			curl_setopt($curl, CURLOPT_HEADER, 1);
			curl_setopt($curl, CURLOPT_COOKIEJAR, $this->cookie_file);
		}

		curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookie_file);
        
    	$result = curl_exec($curl);
    	curl_close($curl);

		$cookie=file_get_contents($this->cookie_file);
		if($cookie!=''){
			$cookie=str_replace('#HttpOnly_','',$cookie);
			file_put_contents($this->cookie_file,$cookie);
		}
		
    	return $result;
	}
	
	
	function tiqu_url($a,$reg,$key=0){
		preg_match_all($reg, $a, $b);
    	$url = $b[$key][0];
		return $url;
	}

	function login(){
		$param=array('m'=>'login','yzm'=>$this->parame['yzm']);
		$a=$this->get($param);
		if($a['s']==1){
			file_put_contents($this->cookie_file,$a['r']);
		}
		return $a;
	}
	
	function check_cookie($name=''){
		if($name==''){
			$name=$this->parame['name'];
		}
		$s=1;
		$time=filemtime($this->cookie_file);
		if($this->cur_time-$time>$this->cookie_expried){ //cookie文件过期，从新登录
			$s=0;
		}
		else{
			$f=file($this->cookie_file);
			if(count($f)<28){ //cookie文件最少28行
				$s=0;
			}
		}

		$cookie=file_get_contents($this->cookie_file);
		if(stristr($cookie,$this->escape($name))===false){
			$s=0;
		}
		return $s;
	}
	
	function test(){
		$url='http://u.alimama.com/union/newreport/taobaokeDetail.htm';
		$return=$this->curl($url,2);
		print_r($return);
		$re=iconv('gbk','utf-8',$return);
		$re=str_replace('charset=GBK','charset=UTF-8',$re);
		return $re;
	}
	
	function mobile_sendcode($param,$target){
		
	}
	
	function mobile_checkcode($param,$target,$mobile_yzm){
		$data=array('target'=>$target,'param'=>$param,'mobile_yzm'=>$mobile_yzm,'m'=>'check_mobile');
		$a=$this->get($data);
		return $a;
	}
	
	function get_excel($sday='',$eday='',$paystatus=0){
		if(!file_exists($this->cookie_file)){
			$this->login();
		}

		if($sday=='') $sday=date("Y-m-d");
		if($eday=='') $eday=date("Y-m-d");
		if($paystatus==3){
			$url='http://pub.alimama.com/report/getTbkPaymentDetails.json?queryType=3&payStatus=3&DownloadID=DOWNLOAD_REPORT_INCOME_NEW&startTime='.$sday.'&endTime='.$eday;
		}
		else{
			$url='http://pub.alimama.com/report/getTbkPaymentDetails.json?queryType=1&payStatus=&DownloadID=DOWNLOAD_REPORT_INCOME_NEW&startTime='.$sday.'&endTime='.$eday;
		}

		$re=$this->curl($url,2);
		return $re;
	}
}
?>