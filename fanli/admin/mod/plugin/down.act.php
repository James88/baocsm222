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
set_time_limit(0);
$file_url=$_GET['file_url'];
$code=urldecode($_GET['code']);
$md5file=$_GET['md5file'];
$update=$_GET['update'];
$version=$_GET['version'];
if($file_url){
	//由于插件安装后具体用了一个返回跳转只能这么做
	//修改开始
	$dir_1=DDROOT.'/plugin/'.$code.'/update.php';
	$dir_2=DDROOT.'/plugin/update/'.$code.'_update.php';
	
	if(file_exists($dir_1) &&stripos($_SERVER['HTTP_REFERER'],DD_YUN_URL)===false&&$update!=1){
		jump("index.php?mod=plugin&act=list");
		exit();
	}
	elseif(file_exists($dir_2)&&stripos($_SERVER['HTTP_REFERER'],DD_YUN_URL)===false&&$update!=1){
		jump("index.php?mod=plugin&act=list");
		exit();
	}
	//修改结束
	$yun_url=DD_YUN_URL."/index.php?g=Home&m=Bbx&a=view&code=".$code;
	$dir_file=DDROOT."/data/plugin_down/";
	$file_name=$dir_file.$code.".zip";
	$dd_md5file = md5_file($file_name);
	if($dd_md5file!=$md5file){
		unlink($file_name);
		jump($yun_url,"插件下载过程中改变了，请手动下载");
	}
	//引入解压方式
	include (DDROOT.'/comm/Zip.class.php');
	$zip = new PclZip($file_name);
	if (($list = $zip->listContent()) == 0) {
		$error=$zip->errorInfo(true);
		if($error){
			unlink($file_name);
			jump($yun_url,"获取插件压缩包内容出错，请手动下载");
		}
	}
	$filelist=array();
	$list=diconv($list);
	//修改开始
	$jy_dir=substr($list[0]['filename'],0,strpos($list[0]['filename'],"/"))."/";
	//修改结束
	if($jy_dir==""){
		unlink($file_name);
		jump($yun_url,"插件包文件结构不对，请手动下载并且联系插件作者");
	}
	
	//对admin路径进行替换
	$cundir=DDROOT."/";//文件解压路径,结尾必须/
	//进行读写权限判断
	foreach($list as $vo){
		//统一放到upload文件夹下面，那肯定每个路径都包含upload，没的话就说明不是最新版本
		if(strpos($vo['filename'],$jy_dir)===false) {
			jump($yun_url,"该插件不支持自动下载安装，请手动下载或者联系作者修改！");
			exit();
		}
		//有的人喜欢放在upload文件夹下面！处理替换掉
		if($jy_dir){
			$vo['filename'] =str_replace($jy_dir,"",$vo['filename']);
		}
		if(strpos($vo['filename'],$cundir."admin")!==false) {
		  $vo['filename'] =str_replace($cundir."admin",$cundir.ADMINDIR,$vo['filename']);
		}
		$file=$cundir.$vo["filename"];
		//不存在的文件不要去检测
		if(!file_exists($file)){
			continue;
		}else{
			if(iswriteable($file)==0){
				unlink($file_name);
				jump($yun_url,$vo["filename"]."plugin目录没读写权限，不能自动安装插件，请手动覆盖！");
			}
		}
	}	
	function myPreExtractCallBack($p_event, &$p_header)
	{
		global $cundir;
		if(strpos($p_header['filename'],'Thumbs.db')!==false){
			$p_header['filename']="";
			return 0;
		}
		if(strpos($p_header['filename'],$cundir."admin")!==false) {
		  $p_header['filename'] =str_replace($cundir."admin",$cundir.ADMINDIR,$p_header['filename']);
		  return 1;
		}else{
		  return 1;
		}
	}
	$list = $zip->extract(PCLZIP_OPT_BY_NAME,$jy_dir,PCLZIP_OPT_REMOVE_PATH,$jy_dir,PCLZIP_OPT_PATH,$cundir,PCLZIP_CB_PRE_EXTRACT, 'myPreExtractCallBack',PCLZIP_OPT_REPLACE_NEWER);
	$list=diconv($list);
	unlink($file_name);
	//删除说明文档
	$dir=DDROOT."/说明.txt";
	$dir=iconv("UTF-8", "GB2312//IGNORE", $dir);
	$file_contents=file_get_contents($dir);
	if($file_contents){
		$file_content=iconv("GB2312//IGNORE","UTF-8", $file_contents);
		//如果本来就是utf-8就不转化
		if(empty($file_content)){
			$file_content=$file_contents;
		}
		if($file_content){
			$file_content =str_replace("\r\n","<br>",$file_content);
		}
	}
	unlink($dir);
	if($update==1){
		$up['version']=(float)$version;
		$duoduo->update("plugin",$up,"code='".$code."'");
	}
	foreach($list as $vo){
		if($vo['folder']!=1){//不是文件夹
			//修改开始
			//$vo["filename"]=substr($vo["filename"],strripos($vo["filename"],"/"));
			$vo["filename"]=str_replace($cundir,"",$vo["filename"]);
			$file_list[]=str_replace(DDROOT, '',$vo["filename"]); 
			//修改结束
		}
	}
	$file_list=array_filter($file_list);
	$total=count($file_list);
}else{
	$code=$_GET['code'];
	$yun_url=DD_YUN_URL."/index.php?g=Home&m=Bbx&a=down&code=".$code."&zidong=1&domain=".urlencode(get_domain(URL))."&adminurl=".urlencode("http://".URL.ADMINDIR)."&update=".$update;//自动下载
	jump($yun_url);
}

function diconv($value) {
	if(is_array($value)){
		$value=array_map("diconv", $value);
	}else{
		$value=gbk2utf8($value);
		return $value;
	}
	return $value;
} 
?>