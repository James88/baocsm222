<?php //短信接口
class yituo_sms{
	public $name='';
	public $pwd='';
	public $out_word=0;
	public $sms_kind=808; //网关默认808
	public $sms_url='http://sdk.zyer.cn/SmsService/SmsService.asmx';
	public $charset='utf-8';
	public $log_dir="/data/log/sms_yituo/";
	function md5_16($pwd){
		$pwd=md5($pwd);
		$pwd=substr($pwd,8,16);
		return $pwd;
	}
	
	function set_out_biz_no(){ //商户业务号
		$no=date('YmdHis').rand(000,999);
		return $no;
	}
	
	function doit($method,$parame=array()){
		switch($method){
			case '/SendEx';
				$parame['LoginName']=$this->name;
				$parame['Password']=$this->md5_16($this->pwd);
				$parame['SmsKind']=$this->sms_kind;
				$parame['ExpSmsId']='';
			break;

			case '/GetBalance';
				$parame['LoginName']=$this->name;
				$parame['Password']=$this->md5_16($this->pwd);
				$parame['SmsKind']=$this->sms_kind;
			break;
			
			case '/SetPassword';
				$parame['LoginName']=$this->name;
				$parame['OldPassword']=$this->md5_16($this->pwd);
			break;
			
			case '/GetBlackWords';
				$parame['SmsKind']=$this->sms_kind;
			break;
			
			case '/SearchBlackWords';
				$parame['SmsKind']=$this->sms_kind;
			break;
		}
		
		$url=$this->sms_url.$method.'?'.http_build_query($parame);
		$filename=DDROOT.$this->log_dir.date('Ym').'/'.date('d').'_url.log';
		create_file($filename,date('Y-m-d H:i:s').'---'.$url."\r\n",1,1);
		$a=dd_get_xml($url);
		$filename=DDROOT.$this->log_dir.date('Ym').'/'.date('d').'_array.log';
		create_file($filename,date('Y-m-d H:i:s').'---'.var_export($a,1)."\r\n",1,1);
		
		if(!isset($a['Code'])){
			$re['s']=0;
			$re['r']='未知错误';
		}
		elseif($a['Code']==0){
			$re['s']=1;
			if($method=='/GetBalance'){
				$re['r']=$a['Balance'];
			}
			elseif($method=='/SendEx'){
				$re['r']=$this->set_out_biz_no();
			}
			elseif($method=='/SearchBlackWords'){
				$re['r']=$a['BlackWords'];
			}
		}
		elseif($a['Code']>0){
			$re['s']=0;
			if($this->out_word==1){
				$re['r']=$this->error_data($a['Code']);
				/*if($a['Code']==15){
					$re['r']=$re['r'].'：'.$a['BlackWords'];
				}*/
			}
			else{
				$re['r']=$a['Code'];
			}
		}
		return $re;
	}
	
	function send_ex($sim,$content){
		$method='/SendEx';
		$parame['SendSim']=$sim;
		
		if($this->charset=='utf-8'){
			$parame['MsgContext']=iconv('utf-8','gbk',$content);
		}
		else{
			$parame['MsgContext']=$content;
		}
		
		$jilu="类型".SMS_TYPE."一拓".date("Y-m-d H:i:s").":手机".$sim."内容:".$content;
		$shuju = var_export($jilu, true);
		$dir=DDROOT.$this->log_dir;
		create_dir($dir);
		file_put_contents($dir.date("Y-m-d").".txt", $shuju. "\r\n", FILE_APPEND);
		return $this->doit($method,$parame);
	}
	
	function get_balance(){
		$method='/GetBalance';
		return $this->doit($method);
	}
	
	function set_password($NewPassword){
		$method='/SetPassword';
		$parame['NewPassword']=$this->md5_16($NewPassword);
		return $this->doit($method,$parame);
	}
	
	function get_black_words(){
		$method='/GetBlackWords';
		return $this->doit($method);
	}
	
	function search_black_words($MsgContext){
		$method='/SearchBlackWords';
		if($this->charset=='utf-8'){
			$parame['MsgContext']=iconv('utf-8','gbk',$MsgContext);
		}
		else{
			$parame['MsgContext']=$MsgContext;
		}
		return $this->doit($method,$parame);
	}
	
	function error_data($code){
		$sms_error = array (
			-1 => '其他错误',
			0 => '调用成功',
			10 => '用户认证失败',
			11 => 'IP 或域名认证失败',
			12 => '余额不足',
			13 => '手机号不合格,手机号在黑名单中',
			14 => '提交的手机号超量',
			15 => '短信内容含有屏蔽关键字',
			16 => '由于登录失败超过10 次被临时锁定30 秒',
			20 => '无效类型',
			22 => '号码无效',
			23 => '无数据',
			24 => '同一号同一内容不能连续提交',
			24 => '同一号同一内容当时发送超量',
			25 => '没有开通上行',
		);
		if(!isset($sms_error[$code])){
			return '未知错误';
		}
		else{
			return $sms_error[$code];
		}
	}
}
?>