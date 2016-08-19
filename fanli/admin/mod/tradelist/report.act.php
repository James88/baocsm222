<?php 
/**
 * ============================================================================
 * 版权所有 多多科技，保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}
if(TAOTYPE==1){
	include(DDROOT.'/comm/tblm.class.php');
	$alimama_class=new tblm();
	
	if($_GET['do']=='login'){
		$yzm=$_GET['yzm'];
		$re=array('s'=>1);
		$alimama_class->set_name_pwd($webset['taoapi']['tbname'],$webset['taoapi']['tbpwd'],$_GET['yzm']);
		$a=$alimama_class->login();
		if($a['s']==1){
			$re=$alimama_class->check_cookie();
			if($re==0){
				$re=array('s'=>0,'r'=>'cookie验证无效');
			}
		}
		elseif($a['s']==2){
			$param=$a['r']['param'];
			$target=$a['r']['target'];
			$a=$alimama_class->mobile_sendcode($param,$target);
			$a=array('param'=>$param,'target'=>$target);
			$re=array('s'=>2,'r'=>$a);
		}
		else{
			$re=array('s'=>0,'r'=>$a['r']);
		}
		echo dd_json_encode($re);
		exit;
	}
	
	if(isset($_POST['mobile_yzm']) && $_POST['mobile_yzm']!=''){
		$re=$alimama_class->mobile_checkcode($_POST['param'],$_POST['target'],$_POST['mobile_yzm']);
		echo dd_json_encode($re);
		exit;
	}
	
	if(isset($_GET['test'])){
		$alimama_class->set_name_pwd($webset['taoapi']['tbname'],$webset['taoapi']['tbpwd'],$_GET['yzm']);
		$excel=$alimama_class->get_excel();
		if($excel==''){
			$a=$alimama_class->login();
			if($a['s']==1){
				$excel=$alimama_class->get_excel();
			}
			else{
				jump(-1,$a['r']);
			}
		}

		include DDROOT . '/comm/readxls.php';
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('utf-8');
		$data->read($excel,2);
		
		$c=count($data->sheets[0]['cells'])-1;
		jump(-1,'可以正常使用，今日订单'.$c.'条！');
	}
	
	if(function_exists('curl_exec')){
		$curl_ok=1;
	}
	else{
		$curl_ok=0;
	}
	
	if($curl_ok==1){
		$yzm_url='';
		
		$re=$alimama_class->check_cookie($webset['taoapi']['tbname']);
		if($re==1){
			$cookie_ok=1;
		}
		else{
			$cookie_ok=0;
			if($webset['taoapi']['tbname']!='' && $webset['taoapi']['tbpwd']!=''){
				$alimama_class->set_name_pwd($webset['taoapi']['tbname'],$webset['taoapi']['tbpwd']);
				$yzm_url=$alimama_class->get_yzm_url();
			}
		}
	}
}
else{
	$cron=dd_get_cache('cron');
	$last_time=$cron['1']['last_time'];
}