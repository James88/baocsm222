<?php
/**
这个计划任务是自动获取淘宝订单（仅限有返利类api用户专用）
**/

if(!defined('DDROOT')){
	exit('Access Denied');
}

if(TAOTYPE==1){
	include(DDROOT.'/comm/tblm.class.php');
	$alimama_class=new tblm();
	$alimama_class->set_name_pwd($webset['taoapi']['tbname'],$webset['taoapi']['tbpwd'],$_GET['yzm']);
	$excel=$alimama_class->get_excel($_GET['sday'],$_GET['eday'],$_GET['paystatus']);
	if($excel==''){
		$a=$alimama_class->login();
		if($a['s']==1){
			$excel=$alimama_class->get_excel($_GET['sday'],$_GET['eday'],$_GET['paystatus']);
		}
		else{
			Putinfo($a['r']);
		}
	}
	
	include DDROOT . '/comm/readxls.php';
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('utf-8');
	$data->read($excel,2);
	$result=$duoduo->trade_import($data->sheets[0]['cells']);
	
	$jump_url=u('tradelist','list_temp',array('pagesize'=>$_GET['pagesize'],'do'=>'daoru'));
	$jump_url=str_replace(SITEURL,SITEURL.'/'.$_GET['admindir'],$jump_url);
	PutInfo("此EXCEL一共".$result['total']."个订单，预处理".$result['insert_num'].'操作完成，等待跳转，<br/><img src="images/wait2.gif" />',$jump_url,1);
}
elseif (TAOTYPE == 2) {
	$total = 0;
	$i = 0; //插入订单
	$j = 0; //返利订单
	$n = 0; //本次处理订单
	$sdatetime = $_GET['sdatetime'] ? $_GET['sdatetime'] : date('Y-m-d') . ' 00:00:00';
	$edatetime = $_GET['edatetime'] ? $_GET['edatetime'] : SJ;
	if ($edatetime > SJ) {
		$edatetime = SJ;
	}
	$page_no = $_GET['page_no'] ? intval($_GET['page_no']) : 1;

	if ($admin_run == 1) {
		$admin = 1;
		$start_time = $_GET['start_time'] ? $_GET['start_time'] : $sdatetime;
	} 
	else {
		$admin = 0;
		if (isset ($_GET['start_time'])) {
			$start_time = $_GET['start_time'];
			if ($start_time > SJ) {
				$start_time = SJ;
			}
		} 
		else {
			if(!is_array($cron_cache['dev'])){
				$sql="UPDATE ".BIAOTOU."cron SET dev='a:2:{s:13:\"admin_ex_time\";s:19:\"".SJ."\";s:7:\"ex_time\";s:19:\"".SJ."\";}';";
				$duoduo->query($sql);
				$this->cron_cache['dev']="a:2:{s:13:\"admin_ex_time\";s:19:\"".SJ."\";s:7:\"ex_time\";s:19:\"".SJ."\";}";
				return false;
			}
			$time=$cron_cache['dev']['ex_time'];
			$t = strtotime($time); //检测时间格式，转成时间戳
			if ($t > 0) {
				$time = $t;
			}

			if ($time > TIME || (int) $time == 0 || TIME - $time > 86400) {
				$start_time = date('Y-m-d H:i:s');
			} else {
				$time -= 1800;
				$start_time = date('Y-m-d H:i:s', $time);
			}
		}
	}

	$num = $_GET['num'] ? intval($_GET['num']) : 0;
	$url = $this->base_url;

	$time = $start_time;
	
	$ddTaoapi = new ddTaoapi();
	$data = $ddTaoapi->taobao_taobaoke_rebate_report_get($start_time);
	if($data['code']>0){
		//$this->msg($data['msg'].'|'.$data['sub_code'].'|当前时间：'.SJ.'|抓取时间'.$start_time);
		if($admin==1){
			PutInfo('接口错误：'.$data['msg'].'|'.$data['sub_code']);
		}
	}
	else{
		$this->msg('');
		$c = count($data);
	
		if ($c > 0) {
			foreach ($data as $row) {
				$duoduo->do_report($row);
				$n++;
			}
		}
		
		$time = strtotime($start_time) + 3600;
		if ($time > TIME) {
			$time = TIME;
		}
	
		if ($admin == 0) {
			$this->dev('ex_time',date('Y-m-d H:i:s',$time));
		} 
		else{
			$this->dev('admin_ex_time',SJ);
			$start_time = date('Y-m-d H:i:s', $time);
			$num = $n + $num;
			$msg = $start_time . " | 本次获取订单" . $n . '条！<br/><b style="color:red">订单获取中，不要操作浏览器！</b><br/><img src="images/wait2.gif" />';
	
			if ($edatetime < SJ) {
				$over_time = $edatetime;
			} else {
				$over_time = SJ;
			}
			if ($start_time < $over_time) {
				$param = '&sdatetime=' . urlencode($sdatetime) . '&edatetime=' . urlencode($edatetime) . '&start_time=' . urlencode($start_time) . '&num=' . $num;
				$param .= $this->admin_run_param;
				$url = $url . $param;
				PutInfo($msg, $url);
			} else {
				$msg = "<b style='color:red'>获取订单完毕！</b><br/>共有订单" . $num . '条';
				PutInfo($msg);
			}
		}
	}
}
?>