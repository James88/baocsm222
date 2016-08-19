<?php
class sms{
	private $type="";//yituo(一拓),b2m(亿美)
	private $mobile=array();
	private $content="";
	private $error="";
	private $sms_class="";
	private $duoduo;
	public $msgset_id;
	function __construct($duoduo){
		$this->duoduo=$duoduo;
		$type="yituo";
		$this->type=strtolower($type);
		//可以引入类文件
		if(class_exists($this->type)===false){
			$msg['s']=0;
			$msg['r']="服务商".$this->type."不存在";
			return $msg;
		}
		$this->sms_class=new $this->type();
		$this->set('duoduo123','1003960');
	}
	public function __call($name, $arguments) {
      		$msg['s']=0;
			$msg['r']="没有".$name."方法";
			return $msg;
    }
	function set($sms_count,$sms_password,$sms_key=''){
		$canshu=array();
		if(empty($sms_count)){
			$msg['s']=0;
			$msg['r']="请输入账号";
			return $msg;
		}
		$canshu['sms_count']=$sms_count;
		if(empty($sms_password)){
			$msg['s']=0;
			$msg['r']="请输入密码";
			return $msg;
		}
		$canshu['sms_password']=$sms_password;
		$canshu['sms_key']=$sms_key;
		return $this->sms_class->set($canshu);
	}
	//短信发送接口
	function send($mobile,$content){
		if($this->msgset_id>0 && is_array($content)){
			$data=$content;
			$content=$this->duoduo->select('msgset','sms','id="'.$this->msgset_id.'"');
			foreach($data as $k=>$v){
				$content=str_replace('{'.$k.'}',$v,$content);
			}
			$this->msgset_id=0;
		}
		if(empty($mobile)){
			$msg['s']=0;
			$msg['r']="请输入接收手机号码";
			return $msg;
		}
		if(empty($content)){
			$msg['s']=0;
			$msg['r']="请输入短信内容";
			return $msg;
		}
		if(empty($this->sms_class)){
			$msg['s']=0;
			$msg['r']="请先执行set方法";
			return $msg;
		}
		return $this->sms_class->send($mobile,$content);
	}
	//短信余额接口
	public function get_balance(){
		return $this->sms_class->get_balance();
	}
}
//短信接口，下面几个功能必须实现
interface sms_jiekou 
{ 
	public function send($mobile,$content);
	public function get_balance();
	public function set($canshu);
}
class yituo implements sms_jiekou{
	private $sms_class="";
	public function set($canshu){
		require_once(DDROOT.'/comm/sms/yituo/yituo_sms.class.php');
		$this->sms_class=new yituo_sms();
		$this->sms_class->name=$canshu['sms_count'];
		$this->sms_class->pwd=$canshu['sms_password'];
		$this->sms_class->out_word=1;
	}
	public function send($mobile,$content){
		return $this->sms_class->send_ex($mobile,$content);
	}
	public function get_balance(){
		return $this->sms_class->get_balance();
	}
	//设置新密码
	public function set_password($newpwd){
		return $this->sms_class->set_password($newpwd);
	}
	//获取屏蔽词
	public function get_black_words(){
		return $this->sms_class->get_black_words();
	}
	//搜索屏蔽词
	public function search_black_words($content){
		return $this->sms_class->search_black_words($content);
	}
}
class yimei implements sms_jiekou{
	private $sms_class="";
	public function set($canshu){
		if(empty($canshu['sms_key'])){
			$msg['s']=0;
			$msg['r']="请传入序列号";
			return $msg;
		}
		require_once(DDROOT.'/comm/sms/b2m/b2m_sms.class.php');
		$this->sms_class=new b2m_sms();
		$this->sms_class->name=$canshu['sms_count'];
		$this->sms_class->pwd=$canshu['sms_password'];
		$this->sms_class->b2mkey=$canshu['sms_key'];
		$this->sms_class->out_word=0;
		$return=$this->sms_class->login();
		if($return['s']==0){
			return $return;
		}
	}
	public function send($mobile,$content){
		return $this->sms_class->send_ex($mobile,$content);
	}
	public function get_balance(){
		$yue=$this->sms_class->get_balance();
		if($yue['s']==0){
			return $yue;
		}
		$eachfee=$this->sms_class->getEachFee();
		if($yue['s']==0){
			return $yue;
		}
		$num=$yue['r']/$eachfee['r'];
		return array('s'=>1,'r'=>$num);
	}
	//设置新密码
	public function set_password($newpwd){
		return $this->sms_class->set_password($newpwd);
	}
	//获取发送报告
	public function getReport(){
		return $this->sms_class->getReport();
	}
	//获取每条短信费用
	public function getEachFee(){
		return $this->sms_class->getEachFee();
	}
	//取消短信发送
	public function cancelMOForward(){
		return $this->sms_class->cancelMOForward();
	}
	//获取版本
	public function getVersion(){
		return $this->sms_class->getVersion();
	}
}
?>