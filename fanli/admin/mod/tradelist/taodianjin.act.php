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

if($_POST['sub']!=''){
	$taodianjin_pid=$_POST['taodianjin_pid'];
	$TAODATATPL=$_POST['TAODATATPL'];
	$duoduo->set_webset('TAODATATPL',$TAODATATPL);
    if($taodianjin_pid){
       $duoduo->set_webset('taodianjin_pid',$taodianjin_pid);
	   jump(-1,'保存成功');
    }else{
	   jump(-1,'淘点金代码解析错误');
	}
}
else{
	$taodianjin_set=file_get_contents(DDROOT.'/comm/tdj_tpl.php');
	$taodianjin_set=str_replace('<?=$webset[\'taodianjin_pid\']?>',$webset['taodianjin_pid'],$taodianjin_set);
	$taodianjin_set=preg_replace('/appkey: "\d+",/','appkey: "",',$taodianjin_set);
	$taodianjin_set=str_replace('<?=$dduser[\'id\']?>','',$taodianjin_set);
	$taodianjin_set=str_replace('<?=SITEURL?>',SITEURL,$taodianjin_set);
}
?>