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

if($_POST['sub']!=''){
	
	$duoduo->set_webset('WJT',$_POST['WJT']);
	$duoduo->set_webset('PICWJT',$_POST['PICWJT']);
	unset($_POST['WJT']);
	unset($_POST['PICWJT']);
    $name=$_POST['arr_name'];
	unset($_POST['arr_name']);
	unset($_POST['sub']);
	dd_set_cache($name,$_POST);
	
	if(MOD=='seo'){
		foreach($_POST as $k=>$row){
			$a=explode('/',$k);
			$wjt_mod_act_arr[$a[0]][$a[1]]=1;
		}
		dd_set_cache('wjt',$wjt_mod_act_arr);
		
	    echo '<script language="javascript" src="'.SITEURL.'/data/rewrite/php/hta.php"></script>';
		echo '<script language="javascript" src="'.SITEURL.'/data/rewrite/php/nginx.php"></script>';
		echo '<script language="javascript" src="'.SITEURL.'/data/rewrite/php/httpd.php"></script>';
		echo '<script language="javascript" src="'.SITEURL.'/data/rewrite/php/webconfig.php"></script>';
		echo '<script language="javascript" src="'.SITEURL.'/data/rewrite/php/lighttpd.php"></script>';
	}
	
	jump(-1,'设置成功');
}