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

include(DDROOT . "/comm/ddUpgrade.class.php");
define('UPGRADEROOT',DDROOT.'/data/upgrade');
$step = intval($_GET['step']);
$step = $step ? $step : 1;
$release = $_GET['release'];
$operation = $operation ? $operation : 'check';

if (file_exists(DDROOT . "/data/banben.php")) {
	$thisrelease = include(DDROOT . "/data/banben.php"); //当前版本
} else {
	$thisrelease = 0;
}

create_dir(UPGRADEROOT);

$upgrade = new duoduo_upgrade();
$upgrade -> setvalue('thisrelease', $thisrelease);
$upgradeurl = $upgrade -> getvalue("upgradeurl"); //服务器升级地址

if ($step==1) {
	$update_date = $upgrade -> check_upgrade(); //获取更新列表
	$latestversion = $update_date['latestversion'];
	$latestrelease = $update_date['latestrelease']; //本次升级版本日期
	$lastrelease = $update_date['lastrelease']; //升级要求日期
	$phpversion = $update_date['phpversion'];
	$upgradelist = $update_date['upgradelist']; 
	if(isset($upgradelist['item'])){
		$upgradelist=$upgradelist['item'];
	}
	krsort($upgradelist);

	// 判断当前应该更新什么版本
	$update_list = $upgrade -> judgerelease();
	$del = intval($_GET['del']);
	if (!empty($del)) {
		$del_file = UPGRADEROOT . '/' . $release;
		deldir($del_file);
		jump(u('upgrade','index',array('release'=>$release,'step'=>1)));
	}
}

// 读取数据缓存操作
if (empty($update_list)) {
	$fileseq = intval($_GET['fileseq']);
	$fileseq = $fileseq ? $fileseq : 1;
	$data_dir = UPGRADEROOT.'/' . $release . "/data.php";
	if (file_exists($data_dir)) {
		$update_list = include_once($data_dir);
	} 
} 

$updatefile_list = $upgrade -> fetch_updatefile_list($update_list);
$updatemd5filelist = $updatefile_list['md5'];
$updatefilelist = $updatefile_list['file'];
$updaterelease = $updatefile_list['release'];
$updatedir = $updatefile_list['dir'];

if($step==3){
	if($fileseq>count($updatefilelist)){
		jump(u(MOD,ACT,array('release'=>$release,'step'=>4)));
	}
	$download_file=$updatefilelist[$fileseq-1];
	$download_md5=$updatemd5filelist[$fileseq-1];
	$update_list['release']=$updaterelease;
	$update_list['dir']=$updatedir;
	$state=$upgrade->download_file($update_list,$download_file,$download_md5);
	$refurl=$_SERVER['HTTP_REFERER'];
	if($_GET['refurl']){
		$url=$refurl;
	}else{
		$url=u(MOD,ACT,array('release'=>$release,'step'=>3,'fileseq'=>$fileseq+1));
	}
}

if ($step == 4) {
	$del = intval($_GET['del']);
	if (!empty($del)) {
		$del_file = UPGRADEROOT.'/' . $release . "/uploads" . $updatefilelist[($del-1)];
		unlink($del_file);
		jump(u(MOD,ACT,array('release'=>$release,'step'=>4)));
	} 
} 

if($step==5){
	//开始覆盖更新
	if($fileseq>count($updatefilelist)){
		jump(u(MOD,ACT,array('release'=>$release,'step'=>6)));
	}
	$download_file=$updatefilelist[$fileseq-1];
	$download_md5=$updatemd5filelist[$fileseq-1];
	$update_list['release']=$updaterelease;
	$update_list['dir']=$updatedir;
	$state=$upgrade->cover_update($update_list,$download_file,$download_md5);
	$refurl=$_SERVER['HTTP_REFERER'];
	if($_GET['refurl']){
		$url=$refurl;
	}else{
		$url=u(MOD,ACT,array('release'=>$release,'step'=>5,'fileseq'=>($fileseq+1)));
	}
}

// 第六步里的备份还原
if ($step == 6) {
	$hai = intval($_GET['hai']);
	if (!empty($hai)) {
		$hai_file = realpath(UPGRADEROOT.'/' . $release . "/backup" . $updatefilelist[($hai-1)]);
		$duoduo_file = realpath(UPGRADEROOT.'/' . $updatefilelist[($hai-1)]);
		$state1 = $upgrade -> copy_file($hai_file, $duoduo_file);
		$state2 = $upgrade -> del_file($hai_file);

		if ($state1 && $state2) {
			jump(u(MOD,ACT,array('release'=>$release,'step'=>6)));
		} 
	} 
} 

if($step==7){
	if(file_exists(DDROOT.'/update.php')){
	}else{
		jump(u(MOD,ACT,array('release'=>$release,'step'=>8)));
	}
}
?>