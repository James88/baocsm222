<?php //多多

class dd_user_class{
	public $duoduo;
	
	function __construct($duoduo){
		$this->duoduo=$duoduo;
	}
	
	function get_default_pwd($uid){
		$webid=$this->duoduo->select('apilogin','webid','uid="'.$uid.'"');
		$key_webid=dd_crc32(DDKEY.$webid);
		$key_md5webid=md5($key_webid);
		$md5webid=md5($webid);
		$md5pwd=$this->duoduo->select('user','ddpassword','id="'.$uid.'"');

		$default_pwd='';
		if($key_md5webid==$md5pwd){
			$default_pwd=$key_webid;
		}
		if($md5webid==$md5pwd){
			$default_pwd=$webid;
		}
		
		return $default_pwd;
	}
}

?>