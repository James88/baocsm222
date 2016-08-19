<?php //短信接口
require_once('nusoaplib/nusoap.php');
class b2m_sms{
	public $name="";// 序列号,请通过亿美销售人员获取
	public $pwd="";
	public $b2mkey="";
	public $out_word=0;
	public $charset='utf-8';
	private $namespace = 'http://sdkhttp.eucp.b2m.cn/';//默认命名空间
	private $sms_url='http://sdk4report.eucp.b2m.cn:8080/sdk/SDKService';
	private $proxyhost=false;//可选，代理服务器地址，默认为 false ,则不使用代理服务器
	private $proxyport=false;//可选，代理服务器端口，默认为 false
	private $proxyusername=false;//可选，代理服务器用户名，默认为 false
	private $proxypassword=false;//可选，代理服务器密码，默认为 false
	private $timeout=0;//连接超时时间，默认0，为不超时
	private $response_timeout=30;//信息返回超时时间，默认30
	public $sessionkey="";//登录后所持有的SESSION KEY，即可通过login方法时创建
	public $log_dir="/data/log/sms_b2m/";

	function __construct()
	{
		/**
		 * 初始化 webservice 客户端
		 */	
		$this->soap = new nusoap_client($this->sms_url,false,$this->proxyhost,$this->proxyport,$this->proxyusername,$this->proxypassword,$this->timeout,$this->response_timeout); 
		$this->soap->soap_defencoding = $this->charset;//往外发送的内容的编码,默认为 utf-8
		$this->soap->decode_utf8 = true;	
	}
	function login()
	{
		if(empty($this->sessionkey)){
			$this->sessionkey =$this->b2mkey;
			$params = array('arg0'=>$this->name,'arg1'=>$this->sessionkey, 'arg2'=>$this->pwd);
			$statusCode = $this->soap->call("registEx",$params,	$this->namespace);
			if($statusCode!=null && $statusCode=="0"){
				$re['s']=1;
				$re['r']="登陆成功";
				return $re;
			}else{
				$re['s']=0;
				if($this->out_word==1){
					$re['r']=$this->error_data($statusCode);
				}
				else{
					$re['r']=$statusCode;
				}
				return $re;
			}
		}
		$re['s']=1;
		$re['r']=$this->sessionkey;
		return $re;
	}
	/**
	 * 注销操作  (注:此方法必须为已登录状态下方可操作)
	 * 
	 * @return int 操作结果状态码
	 * 
	 * 之前保存的sessionKey将被作废
	 * 如需要，可重新login
	 */
	function logout()
	{
		$params = array('arg0'=>$this->name,'arg1'=>$this->sessionkey);
		$result = $this->soap->call("logout", $params ,
			$this->namespace
		);
		return $result;
	}
	/**
	 * 获取版本信息
	 * @return string 版本信息
	 *这玩意居然没输出的
	 */
	function getVersion()
	{
		$result = $this->soap->call("getVersion",array(),$this->namespace);
		if($result!==false){
			$re['s']=1;
			$re['r']=$result;
		}else{
			$re['s']=0;
			if($this->out_word==1){
				$re['r']=$this->error_data($result);
			}else{
				$re['r']=$this->soap->getError;
			}			
		}
		return $re;
	}
	/**
	 * 短信发送  (注:此方法必须为已登录状态下方可操作)
	 * 
	 * @param array $mobiles		手机号, 如 array('159xxxxxxxx'),如果需要多个手机号群发,如 array('159xxxxxxxx','159xxxxxxx2') 
	 * @param string $content		短信内容
	 * @param string $sendTime		定时发送时间，格式为 yyyymmddHHiiss, 即为 年年年年月月日日时时分分秒秒,例如:20090504111010 代表2009年5月4日 11时10分10秒
	 * 								如果不需要定时发送，请为'' (默认)
	 *  
	 * @param string $addSerial 	扩展号, 默认为 ''
	 * @param string $charset 		内容字符集, 默认GBK
	 * @param int $priority 		优先级, 默认5
	 * @param int $priority 		信息序列ID(唯一的正整数)
	 * @return int 操作结果状态码
	 */
	function send_ex($mobile,$content,$sendTime='',$addSerial='',$priority=5,$smsId=8888)
	{
		if(is_array($mobile)){
			$mobile_array=$mobile;
		}else{
			$mobile_array[]=$mobile;
		}
		$params = array('arg0'=>$this->name,'arg1'=>$this->sessionkey,'arg2'=>$sendTime,
			'arg4'=>$content,'arg5'=>$addSerial, 'arg6'=>$this->charset,'arg7'=>$priority,'arg8'=>$smsId
		);
		foreach($mobile_array as $vo)
		{
			array_push($params,new soapval("arg3",false,$vo));	
		}
		$jilu="类型".SMS_TYPE."亿美".date("Y-m-d H:i:s").":手机".$mobile."内容".$content;
		$shuju = var_export($jilu, true);
		$dir=DDROOT . $this->log_dir;
		create_dir($dir);
		file_put_contents($dir.date("Y-m-d").".txt", $shuju. "\r\n", FILE_APPEND);
		
		$result = $this->soap->call("sendSMS",$params,$this->namespace);
		if($result!==false){
			$re['s']=1;
			$re['r']=dd_crc32($content).$mobile;
		}else{
			$re['s']=0;
			if($this->out_word==1){
				$re['r']=$this->error_data($result);
			}else{
				$re['r']=$this->soap->getError;
			}			
		}
		return $re;
	}
	/**
	 * 余额查询  (注:此方法必须为已登录状态下方可操作)
	 * @return double 余额
	 */
	function get_balance()
	{ 
		$params = array('arg0'=>$this->name,'arg1'=>$this->sessionkey);
		$result = $this->soap->call("getBalance",$params,$this->namespace);
		if($result>0){
			$re['s']=1;
			$re['r']=$result;
		}else{
			$re['s']=0;
			if($this->out_word==1){
				$re['r']=$this->error_data($result);
			}else{
				$re['r']=$this->soap->getError;
			}			
		}
		return $re;
	}
	/**
   	 * 修改密码  (注:此方法必须为已登录状态下方可操作)
   	 * @param string $newPassword 新密码
   	 * @return int 操作结果状态码
   	 */
   	function set_password($newPassword) 
   	{
   		$params = array('arg0'=>$this->name,'arg1'=>$this->sessionkey,
			'arg2'=>$this->pwd,'arg3'=>$newPassword		
		);
		$result = $this->soap->call("serialPwdUpd",$params,$this->namespace);
		if($result!==false){
			$re['s']=1;
			$re['r']=$result;
		}else{
			$re['s']=0;
			if($this->out_word==1){
				$re['r']=$this->error_data($result);
			}else{
				$re['r']=$this->soap->getError;
			}			
		}
		return $re;
		
   	}    
	/**
	 * 得到状态报告  (注:此方法必须为已登录状态下方可操作)
	 * @return array 状态报告列表, 一次最多取5个
	 */
	function getReport()
	{
		$params = array('arg0'=>$this->name,'arg1'=>$this->sessionkey);
		$result = $this->soap->call("getReport",$params,$this->namespace);
		if($result!==false){
			$re['s']=1;
			$re['r']=$result;
		}else{
			$re['s']=0;
			if($this->out_word==1){
				$re['r']=$this->error_data($result);
			}else{
				$re['r']=$this->soap->getError;
			}			
		}
		return $re;
	}
	/**
	 * 查询单条费用  (注:此方法必须为已登录状态下方可操作)
	 * @return double 单条费用
	 */
	function getEachFee()
	{
		$params = array('arg0'=>$this->name,'arg1'=>$this->sessionkey);
		$result = $this->soap->call("getEachFee",$params,$this->namespace);
		if($result>0){
			$re['s']=1;
			$re['r']=$result;
		}else{
			$re['s']=0;
			if($this->out_word==1){
				$re['r']=$this->error_data($result);
			}else{
				$re['r']=$this->soap->getError;
			}			
		}
		return $re;
	}
	/**
	 * 取消短信转发  (注:此方法必须为已登录状态下方可操作)
	 * @return int 操作结果状态码
	 */
	function cancelMOForward()
	{
		$params = array('arg0'=>$this->name,'arg1'=>$this->sessionkey);
		$result = $this->soap->call("cancelMOForward",$params,$this->namespace);
		if($result!==false){
			$re['s']=1;
			$re['r']=$result;
		}else{
			$re['s']=0;
			if($this->out_word==1){
				$re['r']=$this->error_data($result);
			}else{
				$re['r']=$this->soap->getError;
			}			
		}
	}
	
	/**
	 * 短信充值  (注:此方法必须为已登录状态下方可操作)
	 * @param string $cardId [充值卡卡号]
	 * @param string $cardPass [密码]
	 * @return int 操作结果状态码
	 * 
	 * 请通过亿美销售人员获取 [充值卡卡号]长度为20内 [密码]长度为6
	 */
	function chargeUp($cardId, $cardPass)
	{
		$params = array('arg0'=>$this->name,'arg1'=>$this->sessionkey,'arg2'=>$cardId,'arg3'=>$cardPass);
		$result = $this->soap->call("chargeUp",$params,$this->namespace);
		if($result!==false){
			$re['s']=1;
			$re['r']=$result;
		}else{
			$re['s']=0;
			if($this->out_word==1){
				$re['r']=$this->error_data($result);
			}else{
				$re['r']=$this->soap->getError;
			}			
		}
	}
	/**
	 * 得到上行短信  (注:此方法必须为已登录状态下方可操作)
	 * 
	 * @return array 上行短信列表, 每个元素是Mo对象, Mo对象内容参考最下面
	 * 
	 * 
	 * 如:
	 * 
	 * $moResult = $client->getMO();
	 * echo "返回数量:".count($moResult);
	 * foreach($moResult as $mo)
	 * {
	 * 	  //$mo 是位于 Client.php 里的 Mo 对象
	 * 	  echo "发送者附加码:".$mo->getAddSerial();
	 *	  echo "接收者附加码:".$mo->getAddSerialRev();
	 *	  echo "通道号:".$mo->getChannelnumber();
	 *	  echo "手机号:".$mo->getMobileNumber();
	 * 	  echo "发送时间:".$mo->getSentTime();
	 *	  echo "短信内容:".$mo->getSmsContent();
	 * }
	 * 
	 * 
	 */

	/**
	 * 得到上行短信状态报告  (注:此方法必须为已登录状态下方可操作)
	 * 
	 * @return array 状态报告列表, 每个元素是StatusReport对象, StatusReport对象内容参考最下面
	 * 
	 * 
	 * 如:
	 * 
	 * $reportResult = $client->getReport();
	 * echo "返回数量:".count($reportResult);
	 * foreach($reportResult as $report)
	 * {
		//获取状态报告的信息
	 * }
	 * 
	 * 
	 */
	function getMO()
	{
		$ret = array();
		$params = array('arg0'=>$this->name,'arg1'=>$this->sessionkey);
		$result = $this->soap->call("getMO",$params,$this->namespace);
		if (is_array($result) && count($result)>0)
		{
			if (is_array($result[0]))
			{
				foreach($result as $moArray)
					$ret[] = new Mo($moArray);	
			}else{
				$ret[] = new Mo($result);
			}
				
		}
		return $ret;
	}
	/**
	 * 企业注册  [邮政编码]长度为6 其它参数长度为20以内
	 * 
	 * @param string $eName 	企业名称
	 * @param string $linkMan 	联系人姓名
	 * @param string $phoneNum 	联系电话
	 * @param string $mobile 	联系手机号码
	 * @param string $email 	联系电子邮件
	 * @param string $fax 		传真号码
	 * @param string $address 	联系地址
	 * @param string $postcode  邮政编码
	 * 
	 * @return int 操作结果状态码
	 * 
	 */
	function registDetailInfo($eName,$linkMan,$phoneNum,$mobile,$email,$fax,$address,$postcode)
	{
		$params = array('arg0'=>$this->name,'arg1'=>$this->sessionkey,
			'arg2'=>$eName,'arg3'=>$linkMan,'arg4'=>$phoneNum,
			'arg5'=>$mobile,'arg6'=>$email,'arg7'=>$fax,'arg8'=>$address,'arg9'=>$postcode		
		);
		
		$result = $this->soap->call("registDetailInfo",$params,$this->namespace);
		if($result!==false){
			$re['s']=1;
			$re['r']=$result;
		}else{
			$re['s']=0;
			if($this->out_word==1){
				$re['r']=$this->error_data($result);
			}else{
				$re['r']=$this->soap->getError;
			}			
		}
	}
	/**
   	 * 
   	 * 短信转发
   	 * @param string $forwardMobile 转发的手机号码
   	 * @return int 操作结果状态码
   	 * 
   	 */
   	function setMOForward($forwardMobile)
   	{
   		$params = array('arg0'=>$this->name,'arg1'=>$this->sessionkey,
			'arg2'=>$forwardMobile	
		);
		$result = $this->soap->call("setMOForward",$params,$this->namespace);
		if($result!==false){
			$re['s']=1;
			$re['r']=$result;
		}else{
			$re['s']=0;
			if($this->out_word==1){
				$re['r']=$this->error_data($result);
			}else{
				$re['r']=$this->soap->getError;
			}			
		}
   	}
   	
   	/**
   	 * 短信转发扩展
   	 * @param array $forwardMobiles 转发的手机号码列表, 如 array('159xxxxxxxx','159xxxxxxxx');
   	 * @return int 操作结果状态码
   	 */
   	function setMOForwardEx($forwardMobiles=array())
   	{
		$params = array('arg0'=>$this->name,'arg1'=>$this->sessionkey);
		/**
		 * 多个号码发送的xml内容格式是 
		 * <arg2>159xxxxxxxx</arg2>
		 * <arg2>159xxxxxxx2</arg2>
		 * ....
		 * 所以需要下面的单独处理
		 * 
		 */
		foreach($forwardMobiles as $mobile)
		{
			array_push($params,new soapval("arg2",false,$mobile));	
		}
		$result = $this->soap->call("setMOForwardEx",$params,$this->namespace);
		if($result!==false){
			$re['s']=1;
			$re['r']=$result;
		}else{
			$re['s']=0;
			if($this->out_word==1){
				$re['r']=$this->error_data($result);
			}else{
				$re['r']=$this->soap->getError;
			}			

		}
   	}
	function error_data($code){
		if($code===""){
			return $this->soap->getError();
		}
		$sms_error = array (
			-2=>'客户端异常',
			-9000=>'数据格式错误,数据超出数据库允许范围',
			-9001=>'序列号格式错误',
			-9002=>'密码格式错误',
			-9003=>'客户端Key格式错误',
			-9004=>'设置转发格式错误',
			-9005=>'公司地址格式错误',
			-9006=>'企业中文名格式错误',
			-9007=>'企业中文名简称格式错误',
			-9008=>'邮件地址格式错误',
			-9009=>'企业英文名格式错误',
			-9010=>'企业英文名简称格式错误',
			-9011=>'传真格式错误',
			-9012=>'联系人格式错误',
			-9013=>'联系电话',
			-9014=>'邮编格式错误',
			-9015=>'新密码格式错误',
			-9016=>'发送短信包大小超出范围',
			-9017=>'发送短信内容格式错误',
			-9018=>'发送短信扩展号格式错误',
			-9019=>'发送短信优先级格式错误',
			-9020=>'发送短信手机号格式错误',
			-9021=>'发送短信定时时间格式错误',
			-9022=>'发送短信唯一序列值错误',
			-9023=>'充值卡号格式错误',
			-9024=>'充值密码格式错误',
			-9025=>'客户端请求sdk5超时',
			0=>'成功',
			-1=>'系统异常',
			-101=>'命令不被支持',
			-102=>'RegistryTransInfo删除信息失败',
			-103=>'RegistryInfo更新信息失败',
			-104=>'请求超过限制',
			-111=>'企业注册失败',
			-117=>'发送短信失败',
			-118=>'接收MO失败',
			-119=>'接收Report失败',
			-120=>'修改密码失败',
			-122=>'号码注销激活失败',
			-110=>'号码注册激活失败',
			-123=>'查询单价失败',
			-124=>'查询余额失败',
			-125=>'设置MO转发失败',
			-126=>'路由信息失败',
			-127=>'计费失败0余额',
			-128=>'计费失败余额不足',
			-1100=>'序列号错误,序列号不存在内存中,或尝试攻击的用户',
			-1103=>'序列号Key错误',
			-1102=>'序列号密码错误',
			-1104=>'路由失败，请联系系统管理员',
			-1105=>'注册号状态异常, 未用 1',
			-1107=>'注册号状态异常, 停用 3',
			-1108=>'注册号状态异常, 停止 5',
			-113=>'充值失败',
			-1131=>'充值卡无效',
			-1132=>'充值密码无效',
			-1133=>'充值卡绑定异常',
			-1134=>'充值状态无效',
			-1135=>'充值金额无效',
			-190=>'数据操作失败',
			-1901=>'数据库插入操作失败',
			-1902=>'数据库更新操作失败',
			-1903=>'数据库删除操作失败'
		);
		if(!isset($sms_error[$code])){
			return '未知错误';
		}
		else{
			return $sms_error[$code];
		}
	}
}
class Mo{
	/**
	 * 发送者附加码
	 */
	var $addSerial;
	/**
	 * 接收者附加码
	 */
	var $addSerialRev;
	/**
	 * 通道号
	 */
	var $channelnumber;
	/**
	 * 手机号
	 */
	var $mobileNumber;
	/**
	 * 发送时间
	 */
	var $sentTime;
	/**
	 * 短信内容
	 */
	var $smsContent;
	function Mo(&$ret=array())
	{
		$this->addSerial = $ret[addSerial];
		$this->addSerialRev = $ret[addSerialRev];
		$this->channelnumber = $ret[channelnumber];
		$this->mobileNumber = $ret[mobileNumber];
		$this->sentTime = $ret[sentTime];
		$this->smsContent = $ret[smsContent];
	}
	function getAddSerial()
	{
		return $this->addSerial;
	}
	function getAddSerialRev()
	{
		return $this->addSerialRev;
	}
	function getChannelnumber()
	{
		return $this->channelnumber;
	}
	function getMobileNumber()
	{
		return $this->mobileNumber;
	}
	function getSentTime()
	{
		return $this->sentTime;
	}
	function getSmsContent()
	{
		return $this->smsContent;
	}
}
?>