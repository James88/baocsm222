<?php
error_reporting(0);
include "../comm/phpqrcode.php";

$type=(int)$_GET['type'];

if($type==0){
	$id=(float)$_GET['id'];
	$uid=(int)$_GET['uid'];
	if($id==0 && $uid==0){exit('error');}
	$value='http://'.$_SERVER['HTTP_HOST'].($_SERVER['SCRIPT_NAME']?$_SERVER['SCRIPT_NAME']:$_SERVER['PHP_SELF']);
	$value=str_replace("api/qrcode.php",'',$value);
	$value=$value.'index.php?mod=inc&act=click_jump&type=zhannei&id='.$id.'&dduserid='.$uid;
}
elseif($type==1){
	$url=$_GET['url'];
	if(strpos($url,'http://redirect.simba.taobao.com')===0){
		$value=$url;
	}
}

$errorCorrectionLevel = "L";
$matrixPointSize = 4;
QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize);
exit;
?>