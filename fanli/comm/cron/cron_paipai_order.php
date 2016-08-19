<?php
/**
这个计划任务是自动获取拍拍订单
**/

if(!defined('DDROOT')){
	exit('Access Denied');
}

include(DDROOT.'/comm/paipai.class.php');

$paipai_set['userId']=$webset['paipai']['userId'];
$paipai_set['qq']=$webset['paipai']['qq'];
$paipai_set['appOAuthID']=$webset['paipai']['appOAuthID'];
$paipai_set['secretOAuthKey']=$webset['paipai']['secretOAuthKey'];
$paipai_set['accessToken']=$webset['paipai']['accessToken'];
$paipai_set['fxbl']=$webset['paipaifxbl'];
$paipai_set['cache_time']=$webset['paipai']['cache_time'];
$paipai_set['errorlog']=$webset['paipai']['errorlog'];
$paipai=new paipai($dduser,$paipai_set);

$total = 0;
$i = 0; //插入订单
$j = 0; //返利订单
$n = 0; //本次处理订单
$code=$_GET['code'];
$sday = $_GET['sday'] ? date('Y-m-d',strtotime($_GET['sday'])) : date("Y-m-d",strtotime("-1 day"));
$eday = $_GET['eday'] ? date('Y-m-d',strtotime($_GET['eday'])) : date("Y-m-d",strtotime("-1 day"));
if ($eday > date('Y-m-d')) {
	$eday = date('Y-m-d');
}
$pageIndex = $_GET['pageIndex'] ? intval($_GET['pageIndex']) : 1;

if ($admin_run == 1) {
    $admin=1;
}
else{
	$admin=0;
}

$num = $_GET['num'] ? intval($_GET['num']) : 0;
$url = $this->base_url;

$parame['beginTime']=$sday;
$parame['pageIndex']=$pageIndex;
$data = $paipai->etgReportCheck($parame);
$total = $data['total'];
$pages = ceil($total / 40);
	
unset($data['total']);//因为返回的数组中包含个数total，需要去
	
if ($total > 0) {
	foreach ($data as $row) {
	    $duoduo->do_paipai_report($row);
	    $n++;
    }
}

$num = $n + $num;
$msg = $sday . " | 本次获取订单" . $n . '条！<br/><b style="color:red">订单获取中，不要操作浏览器！</b><br/><img src="images/wait2.gif" />';
if ($total > 40 && $pages > $pageIndex) {
	$pageIndex++;
	$param = '&sday=' . $sday . '&eday=' . $eday . '&pageIndex=' . $pageIndex . '&num=' . $num . '&n=' . $n;
	if ($admin == 0) {
		only_send($url . $param);
	} else {
		$param .= $this->admin_run_param;
		$url = $url.$param;
		PutInfo($msg, $url);
	}
}
elseif ($pages <= $pageIndex && $sday < $eday) {
	$sday = date('Y-m-d', strtotime($sday . ' +1 day'));
	$param = '&sday=' . $sday . '&eday=' . $eday . '&pageIndex=1&num=' . $num;
	if ($admin == 0) {
		only_send($url . $param);
	} else {
		$param .= $this->admin_run_param;
		$url = $url.$param;
		PutInfo($msg, $url);
	}
}
else{
	if ($admin == 1) {
		$msg = "<b style='color:red'>获取订单完毕！</b><br/>共有订单" . $num . '条';
		PutInfo($msg);
	}
	else{
		//自动获取结束，无操作
	}
}

unset($paipai);