<?php
if(!defined('ADMIN')){
	exit('Access Denied');
}
set_time_limit(0);
$file_url=$_GET['file_url'];
$code=urldecode($_GET['code']);
$md5file=$_GET['md5file'];
$update=$_GET['update'];
$version=$_GET['version'];
$down=$_GET['down'];
if($down){
	$yun_url=DD_YUN_URL."/index.php?g=Home&m=Bbx&a=view&code=".$code;
	if ($code==""|$file_url==""|$md5file=="") {
		echo "插件参数不完整，请手动下载";
		exit();
	}else{
		$file_url=str_replace("\\", '/', $file_url); 
		$yun_file=DD_YUN_URL."/file_down.php?code=".$file_url;
		$dir_file=DDROOT."/data/plugin_down/";
		$response=dd_get($yun_file);
		$file_name=$dir_file.$code.".zip";
		if ($response!=''){
			create_dir($dir_file);
			file_put_contents($file_name,$response);
		}else{
			echo "平台插件文件不存在，请手动下载";
			exit();
		}
		$dd_md5file = md5_file($file_name);
		if($dd_md5file!=$md5file){
			unlink($file_name);
			echo $dd_md5file."插件下载过程中改变了，请手动下载";
			exit();
		}else{
			echo 1;
		}
	}
	exit();
}
?>