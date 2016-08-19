<?php
/**
 * ============================================================================
 * 版权所有 2008-2013 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
if(!defined('ADMIN')){
	exit('Access Denied');
}

define('PLUGIN',1);
define('PLUGIN_UPDATE',1);

$code=$_GET['code'];
$do=$_GET['do'];

if($do!='install' && $do!='uninstall' && $do!='update'){
	dd_exit('no');
}

$install_dir_1=DDROOT.'/plugin/'.$code.'/update.php';
$install_dir_2=DDROOT.'/plugin/update/'.$code.'_update.php';

if($do=='install'){
	if(file_exists($install_dir_1)){
		include(DDROOT.'/comm/plugin.class.php');
		$plugin=new plugin($duoduo,$code);
		$plugin->install();
		include($install_dir_1);
		jump(-1,'安装完成');
	}
	elseif(file_exists($install_dir_2)){
		include(DDROOT.'/plugin/plugin.class.php');
		include($install_dir_2);
	}
	else{
		echo js_confirm("安装文件不存在，需要下载插件",u('plugin','down',array('code'=>$code)),'history.go(-1)');
	}
}
elseif($do=='uninstall'){
	if(file_exists($install_dir_1)){
		include(DDROOT.'/comm/plugin.class.php');
		$plugin=new plugin($duoduo,$code);
		$plugin->uninstall();
		include($install_dir_1);
		jump(-1,'卸载完成');
	}
	elseif(file_exists($install_dir_2)){
		include(DDROOT.'/plugin/plugin.class.php');
		include($install_dir_2);
		deldir($install_dir_2);
	}
	else{
		$data=array('install'=>0);
		$duoduo->update('plugin',$data,'code="'.$code.'"');
		jump(-1,'卸载完成');
	}
}
else{
	if($_GET['over']==1){
		include(DDROOT.'/comm/plugin.class.php');
		$plugin=new plugin($duoduo,$code);
		$plugin->update_info('update');
		include($install_dir_1);
		jump(u('plugin','list'),'升级完成');
	}
	else{
		echo '<script language="javascript" type="text/javascript">if (confirm("更新插件需要下载，自动下载可能会覆盖二次开发过的文件")){location.href="'.u('plugin','down',array('code'=>$code,'update'=>1)).'";}else{location.href="'.u('plugin','list').'";};</script>';
	}
}
?>