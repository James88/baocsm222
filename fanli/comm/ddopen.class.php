<?php //多多平台接口
class ddopen{
	public $openname='';
	public $openpwd='';
	public $open_sms_pwd='';
	public $openurl='/api/';
	public $qunfaurl='/api/sms_qunfa.php';
	public $format='json';
	public $mod='jifenbao';
	
	function __construct(){
		$this->openurl=DD_OPEN_URL.$this->openurl;
		$this->qunfaurl=DD_OPEN_URL.$this->qunfaurl;
	}
	
	function ini(){
		$openpwd=get_cookie('ddopenpwd');
		$checksum=get_cookie('checksum');
		$this->openname=get_domain(URL);
		$this->openpwd=md5($openpwd);
		$this->checksum=md5($checksum);
		return 1;
	}
	
	function sms_ini($open_sms_pwd){
		$this->openname=get_domain(URL);
		if($open_sms_pwd==''){
			return 0;
		}
		$this->open_sms_pwd=$open_sms_pwd;
		return 1;
	}
	
	function sms_qunfa($sign,$content='',$mobile='',$num=0){
		$parame=array('mod'=>'sms_qunfa','act'=>'sign','sign'=>$sign,'content'=>$content,'mobile'=>$mobile,'num'=>$num);
		$row=$this->get($parame,1);
		return $row;
	}
	
	function sms_send($mobile,$content,$msgset_id=0,$data=array()){//$data 数组包含 sign 群发标记 num 群发总数
		if(is_array($content)){
			$content=json_encode($content);
		}
		if(is_array($mobile)){
			$mobile=json_encode($mobile);
			$mobile=base64_encode($mobile);
		}
		$content=base64_encode($content);

		$type=0;
		$mod='sms';
		$act='send';
		$parame=array('mod'=>$mod,'act'=>$act,'mobile'=>$mobile,'content'=>$content,'version'=>2);
		if($data['sign']!='' && $data['num']>0){//群发
			$parame['mod']='sms_qunfa';
			$parame['sign']=$data['sign'];
			$parame['num']=$data['num'];
			$type=1;
		}else{
			$parame['msgset_id']=$msgset_id;
		}
		$row=$this->get($parame,$type);
		return $row;
	}
	
	function sms_content_check($content){
		$black_words=dd_get(DD_OPEN_URL.'/data/black_words.txt');
		$black_words=explode(';;',$black_words);
		unset($black_words[0]);
		foreach($black_words as $k=>$v){
			if(strpos($content,$v)!==false){
				$re=array('s'=>1,'r'=>$v);
				return $re;
			}
		}
		return array('s'=>0);
	}
	
	function pay_jifenbao($alipay,$num,$txid,$realname,$mobile){
		$mod='jifenbao';
		$act='pay';
		$parame=array('mod'=>$mod,'act'=>$act,'alipay'=>$alipay,'num'=>(int)$num,'txid'=>$txid,'url'=>URL,'realname'=>$realname,'mobile'=>$mobile,'version'=>2);
		$row=$this->get($parame);
		return $row;
	}
	
	function cancel_jifenbao($txid){
		$mod='jifenbao';
		$act='cancel';
		$parame=array('mod'=>$mod,'act'=>$act,'txid'=>$txid,'url'=>URL);
		$row=$this->get($parame);
		return $row;
	}
	
	function get_user_info($tag='',$checksum=''){ //send_email发送邮件校验码  send_sms发送手机校验码  from_sms通过校验码获取基本信息  from_pwd为空通过帐号密码获取基本信息
		$mod='user';
		$act='get_info';
		$parame=array('mod'=>$mod,'act'=>$act,'tag'=>$tag,'checksum'=>$checksum,'version'=>2);
		$row=$this->get($parame);
		return $row;
	}
	
	function get_user_sms(){
		$mod='sms';
		$act='get_user_num';
		$parame=array('mod'=>$mod,'act'=>$act);
		$row=$this->get($parame);
		return $row;
	}
	
	function build_post($parame,$canshu,$type=0){
		if($type==1){
			$url=$this->qunfaurl.'?'.http_build_query($parame);
		}else{
			$url=$this->openurl.'?'.http_build_query($parame);
		}
		$context['http']['timeout']='10';
		$context['http']['method']='POST';
		$context['http']['content']=http_build_query($canshu);
		//echo $url;print_r($context);exit;
		$output = file_get_contents($url, false, stream_context_create($context));
		return $output;
	}
	
	function get($parame,$type=0){
		$parame['openname']=$this->openname;
		if($parame['mod']=='sms' || $parame['mod']=='sms_qunfa'){
			$parame['open_sms_pwd']=$this->open_sms_pwd;
		}
		else{
			if($parame['mod']=='jifenbao' && $parame['act']=='pay'){
				$parame['checksum']=$this->checksum;
			}
			else{
				$parame['openpwd']=$this->openpwd;
			}
		}
		
		$parame['format']=$this->format;
		$parame['client_url']=URL;
		if($parame['mod']=='jifenbao' && $parame['act']=='pay'){
			//echo $url=$this->openurl.'?'.http_build_query($parame);exit;
		}
		
		if($parame['mod']=='sms_qunfa' && $parame['act']=='sign'){
			$openname=$parame['openname'];
			$open_sms_pwd=$parame['open_sms_pwd'];
			$mobile=$parame['mobile'];
			$content=$parame['content'];
			unset($parame['openname']);
			unset($parame['open_sms_pwd']);
			unset($parame['mobile']);
			unset($parame['content']);

			$output = $this->build_post($parame,array('openname'=>$openname,'open_sms_pwd'=>$open_sms_pwd,'mobile'=>$mobile,'content'=>$content),$type);
			return json_decode($output,1);
		}
		elseif($parame['mod']=='user' && $parame['act']=='get_info'){
			$openname=$parame['openname'];
			$openpwd=$parame['openpwd'];
			unset($parame['openname']);
			unset($parame['openpwd']);
			
			$output = $this->build_post($parame,array('openname'=>$openname,'openpwd'=>$openpwd));
			return json_decode($output,1);
		}
		elseif($parame['mod']=='sms' && $parame['act']=='get_user_num'){
			$openname=$parame['openname'];
			$open_sms_pwd=$parame['open_sms_pwd'];
			unset($parame['openname']);
			unset($parame['open_sms_pwd']);
			
			$output = $this->build_post($parame,array('openname'=>$openname,'open_sms_pwd'=>$open_sms_pwd));
			$output = json_decode($output,1);
			return $output;
		}
		else{
			if($type==1){
				$url=$this->qunfaurl.'?'.http_build_query($parame);
			}else{
				$url=$this->openurl.'?'.http_build_query($parame);
			}

			//file_put_contents(DDROOT.'/a.txt',$url."\r\n",FILE_APPEND);
			if($this->format=='xml'){
				$row=dd_get_xml($url);
			}
			elseif($this->format=='json'){
				$row=dd_get_json($url);
				/*$row=file_get_contents($url);
				$row=json_decode($row,1);*/
			}
		}
		return $row;
	}
}
?>