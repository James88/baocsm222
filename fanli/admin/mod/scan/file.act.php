<?php
/**
 * ============================================================================
 * 版权所有 2008-2012 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}

$admin_name=str_replace(DDROOT,'',ADMINROOT);
$banben=include(DDROOT.'/data/banben.php');

$ignore_dir='/data|/upload';
$suffix='php|inc';

if($_GET['update']==1){
	$sql="TRUNCATE TABLE `".BIAOTOU."file` ";
	$duoduo->query($sql);
}

function file_select($dd_file,$path){
	foreach($dd_file as $row){
		if($row['path']==$path){
			return $row;
		}
	}
	return array();
}

function scan($dir, & $record_arr,$dd_file,$i=0) {
	global $ignore_dir,$suffix,$duoduo;
	if (is_dir($dir)) {
		if (1) {
			$dh = opendir($dir);
			while ($file = readdir($dh)) {
				if ($file != "." && $file != "..") {
					$fullpath = $dir . "/" . $file;
					if (!is_dir($fullpath)) {
						if (preg_match('/(.' . $suffix . ')$/', $fullpath)) {
							$a['md5']=md5_file($fullpath);
							$a['path']=str_replace(DDROOT,'',$fullpath);

							$file_info=file_select($dd_file,$a['path']);
							
							if($_GET['update']==1){
								$duoduo->insert('file',$a);
							}
							else{
								$a['msg']='';
								if(!$file_info['id'] || $a['md5']!=$file_info['md5']){
									if(!$file_info['id']){
										$a['msg'].='多余文件。';
									}
									else{
										if($a['md5']!=$file_info['md5']){$a['msg'].='文件内容有变化。';}
									}	
									$record_arr[]=$a;
								}
							}
							
						}
					} 
					else {
						scan($fullpath, $record_arr,$dd_file,$i);
					}
				}
			}
			closedir($dh);
		}
	} 
	else {
		$a['md5']=md5_file($dir);
		$a['path']=str_replace(DDROOT,'',$dir);
		
		$file_info=file_select($dd_file,$a['path']);
		
		if($_GET['update']==1){
			$duoduo->insert('file',$a);
		}
		else{
			$a['msg']='';
			if(!$file_info['id'] || $a['md5']!=$file_info['md5']){
				if(!$file_info['id']){
					$a['msg'].='多余文件。';
				}
				else{
					if($a['md5']!=$file_info['md5']){$a['msg'].='文件内容有变化。';}
				}	
				$record_arr[]=$a;
			}
		}
		
	}
}

if ($_GET['sub'] != '') {
    //print_r($_POST['dir']);
	$record_arr=array();
	if(empty($_GET['dir'])){
	    jump(-1,'所选目录不能为空！');
	}
	foreach($_GET['dir'] as $v){
		$dd_file=dd_get_cache('file');
		scan($v,$record_arr,$dd_file);
	}
	if($_GET['update']==1){
		$file=$duoduo->select_all('file','id,path,md5');
		$file=json_encode($file);
		create_file(DDROOT.'/data/file/');
		file_put_contents(DDROOT.'/data/file/'.$banben.'.txt',$file);
		jump(-1,'更新完成');
	}
} 
else { //列出根目录文件
	$filelists = Array ();
	$dh = dir(DDROOT);
	while (($filename = $dh->read()) !== false) {
		$root_filename = DDROOT . '/' . $filename;
		if(!preg_match('#^'.DDROOT.'/data#',$root_filename) && !preg_match('#^'.DDROOT.'/upload#',$root_filename) && !preg_match('#^'.DDROOT.'/install#',$root_filename)){
			if ($filename != '.' && $filename != '..' && $filename != './..') {
				if (is_dir($root_filename)) {
					$filelists1[] = iconv('gbk','utf-8//IGNORE',$filename);
				} else {
					$filelists2[] = iconv('gbk','utf-8//IGNORE',$filename);
				}
			}
		}
	}
	$dh->close();
	$dd_file=dd_get(DUODUO_URL.'/data/file/'.$banben.'.txt');
	if(preg_match('/^\[\{(.*)/',$dd_file)==0){
		$update=1;
	}
	else{
		$dd_file=json_decode($dd_file,1);
		foreach($dd_file as $k=>$row){
			if(preg_match('#^/admin/(.*)#',$row['path'])){
				$dd_file[$k]['path']=preg_replace('#^/admin/#',$admin_name.'/',$row['path']);
			}
		}
		dd_set_cache('file',$dd_file);
	}
}
?>