<?php
class dd_wap_class{
	public $duoduo;
	
	function __construct($duoduo){
		$this->duoduo=$duoduo;
	}
	
	function is_weixin(){
		if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
			return 1;
		}
		return 0;
	}
	
	function device_type(){
		$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
		$type = 'other';
		if(strpos($agent, 'iphone') || strpos($agent, 'ipad') || strpos($agent, 'ios')){
			$type = 'ios';
		}
		if(strpos($agent, 'android')){
			$type = 'android';
		}
		return $type;
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
	
	function page(){
		global $page,$total,$page_size;
		$get=$_GET;
		$mod=$get['mod'];
		$act=$get['act'];
		unset($get['mod']);
		unset($get['act']);
		?>
		<p class="page"><span><font><?php if($page>1){$get['page']=$page-1;?><a href="<?=wap_l(MOD,ACT,$get)?>" class='left'>上一页</a><?php }?> 第<?=$page?>页 <?php if($total==$page_size){$get['page']=$page+1;?><a href="<?=wap_l(MOD,ACT,$get)?>" class='left right'>下一页</a><?php }?></font></span></p>
	<?php }
}

if($webset['wap']['status']==0){
	jump(SITEURL);
}

$dd_wap_class=new dd_wap_class($duoduo);

$dd_tpl_data=dd_get_cache('tpl/wap_'.WAP_MOBAN); //获取模板设置
$dd_tpl_data=$dd_tpl_data+$webset['wap'];