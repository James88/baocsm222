<?php //淘宝帐号登录阿里妈妈
class alimama{
	
	public $login_url='https://login.taobao.com/member/login.jhtml?style=minisimple&from=alimama&disableQuickLogin=true';
	public $cookie_file;
	public $cur_time;
	public $charset='utf-8';
	public $cookie_expried=3000; //cookie过期时间大约是1小时，这里检测3000秒就需要从新获取
	public $parame='';
	public $xls_file="";
	public $username="";
	public $password="";
	public $yzm="";//验证码
	public $error=0;
	public $zh_type=0;//账号类型，0是淘宝账号，1是阿里妈妈账号
	public $tbauth=0;//0无证书，1证书版
	
	function __construct(){
		$this->cookie_file=DDROOT.'/data/cookie_'.dd_crc32(DDKEY.'cookie').'.txt';
		//$this->xls_file=DDROOT.'/data/alimama.xls';
	}
	
	function set_name_pwd($name,$pwd,$yzm){
		global $webset;
		$alimama_data=$webset['alimama'];
		if($alimama_data['tbauth']==1){
			$this->tbauth=1;
		}else{
			$this->tbauth=0;
		}
		$this->zh_type=$alimama_data['zh_type'];
		$this->username=$name;
		$this->password=$pwd;
		$this->yzm=$yzm;
	}
	
	function escape($str) {
		$a=array('s'=>$str);
		preg_match('/:"(.*)"/',json_encode($a),$a);
		return rawurlencode($a[1]);
	}
	
	function check_cookie($del=0,$file=''){
		if($this->username==''){
			$a=array('s'=>0,'r'=>'帐号不能为空');
			return $a;
		}
		if($file==''){
			$cookie=file_get_contents($this->cookie_file);
		}
		else{
			$cookie=$file;
		}
		if($this->zh_type==1){
			return 1;
		}
		if(reg_mobile($this->username)==1){
			return 1;
		}
		if(stristr($cookie,$this->escape($this->username))!=''){
			return 1;
		}
		else{
			if($del==1 && $file!=''){
				unlink($this->cookie_file);
			}
			return 0;
		}
	}
	function getyzm($username,$password){
		$url=DD_YUN_URL."/index.php?g=Home&m=Alimama&a=yzm&alimama=".rawurlencode($username).'&pwd='.rawurlencode($password);
		$a=dd_get_json($url);
		if(preg_match('/blank\.gif&/',$a['r'])){
			$a['r']='';
		}
		return $a['r'];
	}
	
	function get_cookie($yzm=""){
		if($this->tbauth==1){
			$url="http://tbauth.duoduo123.com/tb/index.php?alimama=".urlencode($this->username).'&pwd='.urlencode($this->password)."&url=".urlencode(SITEURL)."&zh_type=".$this->zh_type."&yzm=".$this->yzm;
			if($yzm!=''){
				$url.="&TPL_checkcode=".$yzm;
			}
		}else{
			$url=DD_YUN_URL."/index.php?g=Home&m=Alimama&a=index&alimama=".rawurlencode($this->username).'&pwd='.rawurlencode($this->password)."&url=".rawurlencode(SITEURL)."&zh_type=".$this->zh_type."&yzm=".$this->yzm;
			
		}
		$a=dd_get_json($url);
		if($a['s']==1){
			$cookie=$a['cookie'];
			$re=$this->check_cookie(1,$a['cookie']);
			if($re==1){
				dd_file_put($this->cookie_file,$cookie);
			}
			else{
				$this->error=1;
				$a=array('s'=>0,'r'=>'cookie错误，请从新获取');
				//阿里妈妈不检测用户名！所以建议错误了就删掉cookie文件
				unlink($this->cookie_file);
			}
		}
		else{
			$this->error=1;
		}
		return $a;
	}
	
	function get_excel($sday='',$eday='',$paystatus=0){
		if(!file_exists($this->cookie_file)){
			$this->get_cookie();
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
		$this->get_num++;
		if($this->get_num==3){
			$this->error=1;
			return array('s'=>0,'r'=>'获取订单失败');
		}
		if($re==''){
			$a=$this->get_cookie();
			if($a['s']==1){
				$cookie=$a['cookie'];
				dd_file_put($this->cookie_file,$cookie);
			}
			else{
				$this->error=1;
				return $a;
			}
			$re=$this->get_excel($sday,$eday,$paystatus);
		}
		return $re;
	}
	
	function test(){
		$url='http://u.alimama.com/union/newreport/taobaokeDetail.htm';
		$re=iconv('gbk','utf-8',$this->curl($url,2));
		$re=str_replace('charset=GBK','charset=UTF-8',$re);
		return $re;
	}
	
	function curl($url,$type=1,$parame='') { //type表示cookie状态，1表示存储cookie，2表示使用cookie
		$curl = curl_init();
    	curl_setopt($curl, CURLOPT_URL, $url);
    	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
    	curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    	curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		if($type==1){
			curl_setopt($curl, CURLOPT_HEADER, 1);
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
			curl_setopt($curl, CURLOPT_COOKIEJAR, $this->cookie_file);
		}
		elseif($type==2){
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION,0);
		}

		curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookie_file);
        
    	$result = curl_exec($curl);
    	curl_close($curl);
    	return $result;
	}
}
?>