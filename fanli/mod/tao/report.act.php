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

if (!defined('INDEX')) {
	exit ('Access Denied');
}

if(TAOTYPE==1){
	if($webset['alimama']['open']==1 || isset ($_GET['show'])){

		$code = $_GET['code'];
		$num = (int)$_GET['num'];
		$pagesize=(int)$_GET['pagesize'];
		$sday = $_GET['sday'] ? date('Y-m-d', strtotime($_GET['sday'])) : date('Y-m-d');
		$eday = $_GET['eday'] ? date('Y-m-d', strtotime($_GET['eday'])) : date('Y-m-d');
		if ($eday > date('Y-m-d')) {
			$eday = date('Y-m-d');
		}
		if (isset ($_GET['show']) && authcode($_GET['show'], 'DECODE') == 1) {
			$admin = 1;
			$day=$sday;
			
		} else {
			if (TIME - authcode($code, 'DECODE', DDKEY) > 60) {
				PutInfo('访问超时');
			}
			$admin = 0;
			if($webset['alimama']['day']<date('Ymd')){
				$day=date("Y-m-d",strtotime("-1 days"));
			}
			else{
				$day=date('Y-m-d');
			}
		}
		
		$a=$duoduo->select('tradelist','trade_id','1 order by id asc');
		$b=$duoduo->select('tradelist','trade_id','1 order by id desc');
		if(($a!='' && preg_match('/_\d{1,12}/',$a)==0) || ($b!='' && preg_match('/_\d{1,12}/',$b)==0)){
			if($admin==1){
				PutInfo('请从新提取订单号');
			}
			else{
				exit;
			}
		}
		
		$alimama_class=fs('alimama');
		$alimama_class->set_name_pwd($webset['alimama']['username'],$webset['alimama']['password'],$_GET['yzm']);
		
		if(!isset($_GET['paystatus'])){//0和3状态随机获取
			$pay_array=array('0'=>0,'1'=>3);
			$paystatus=$pay_array[array_rand($pay_array)];
		}
		else{
			$paystatus=(int)$_GET['paystatus'];
		}

		$excel=$alimama_class->get_excel($day,$day,$paystatus);
		if($alimama_class->error==1){
			$duoduo->update_serialize('alimama','error_msg',$excel['r'].':'.SJ);
			/*if(isset($excel['yzm'])){
				$duoduo->update_serialize('alimama','open',0);
			}*/
			$duoduo->webset();
			exit($excel['r']);
		}
			
		include DDROOT . '/comm/readxls.php';
		$data = new Spreadsheet_Excel_Reader();
    	$data->setOutputEncoding('utf-8');
		$data->read($excel,2);
    	$result=$duoduo->trade_import($data->sheets[0]['cells']);
		$num+=$result['total'];
		$insert_num+=$result['insert_num'];
		if($admin==0){
			$duoduo->update_serialize('alimama','day',date('Ymd'));
			$duoduo->set_webset('tao_report_time', TIME);
			$duoduo->webset();
		}
		else{
			$sday = date('Y-m-d', strtotime($sday . ' +1 day'));
			if($sday>$eday){
				$jump_url=$_GET['admin_dir']."/index.php?mod=tradelist&act=list_temp&pagesize=".$_GET['pagesize']."&do=daoru";
				$jump_url=substr($jump_url,1);
				PutInfo("此EXCEL一共".$num."个订单，实际插入".$insert_num.'操作完成，<br/><br/><img src="../images/wait2.gif" />',$jump_url);
			}
			else{
				$url = u('tao', 'report').'&sday=' . $sday . '&eday=' . $eday . '&num=' . $num.'&show=' . urlencode(authcode(1, 'ENCODE')).'&paystatus='.$paystatus."&pagesize=".$pagesize."&insert_num=".$insert_num."&admin_dir=".urlencode($_GET['admin_dir']);
				PutInfo('<b style="color:red">'.$sday.' 订单获取中，不要操作浏览器！</b><br/><br/><img src="images/wait2.gif" />', $url);
			}
		}	
	}
}
elseif (TAOTYPE == 2) {
	if (!defined('SJ')) {
		define('SJ', date('Y-m-d H:i:s'));
	}

	$total = 0;
	$i = 0; //插入订单
	$j = 0; //返利订单
	$n = 0; //本次处理订单
	$code = $_GET['code'];
	$sdatetime = $_GET['sdatetime'] ? $_GET['sdatetime'] : date('Y-m-d') . ' 00:00:00';
	$edatetime = $_GET['edatetime'] ? $_GET['edatetime'] : SJ;
	if ($edatetime > SJ) {
		$edatetime = SJ;
	}
	$page_no = $_GET['page_no'] ? intval($_GET['page_no']) : 1;

	if (isset ($_GET['show']) && authcode($_GET['show'], 'DECODE') == 1) {
		$admin = 1;
		$start_time = $_GET['start_time'] ? $_GET['start_time'] : $sdatetime;
	} else {
		//自动获取，增加锁文件
		/*$lock_file = DDROOT . '/data/lock/tao_report.txt';
		if (file_exists($lock_file)) {
			$lock_time = file_get_contents($lock_file);
			if (TIME - $lock_time > 60) { //重置过期锁文件
				file_put_contents($lock_file, TIME);
			} else {
				exit ('lock');
				return false;
			}
		} else {
			file_put_contents($lock_file, TIME); //加锁文件
		}*/

		$admin = 0;
		if (TIME - authcode($code, 'DECODE', DDKEY) > 60) {
			//PutInfo('访问超时');
		}
		if (isset ($_GET['start_time'])) {
			$start_time = $_GET['start_time'];
			if ($start_time > SJ) {
				$start_time = SJ;
			}
		} else {
			$time = $duoduo->select('webset', 'val', 'var="tao_report_time"');
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
	$url = u('tao', 'report');

	$time = $start_time;
	//记录时间
	if ($admin != 0) {
		file_put_contents(DDROOT.'/data/tb_report_time.txt',$start_time);
	}
	$data = $ddTaoapi->taobao_taobaoke_rebate_report_get($start_time);
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
		//echo date('Y-m-d H:i:s',$time);
		//file_put_contents(DDROOT.'/t.txt',"\r\n",FILE_APPEND);
		$duoduo->set_webset('tao_report_time', $time);
		$duoduo->webset();
		unlink($lock_file); //执行完毕，清理锁文件
	} else {
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
			$param .= '&show=' . urlencode(authcode(1, 'ENCODE'));
			$url = $url . $param;
			PutInfo($msg, $url);
		} else {
			$msg = "<b style='color:red'>获取订单完毕！</b><br/>共有订单" . $num . '条';
			PutInfo($msg);
		}
	}
}
?>