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
$code=$_GET['code'];
if($code==''){
	exit();
}
$bankuai_web_cid=$duoduo->select("bankuai",'web_cid',"code='".$code."'");
$bankuai_web_cid=unserialize($bankuai_web_cid);
$type=$duoduo->select_all('type','*',"tag='goods'");
foreach($type as $vo){
	if($bankuai_web_cid){
		if(in_array($vo['id'],$bankuai_web_cid)){
			$cid_arr[$vo['id']]=$vo['title'];
		}
	}else{
		$cid_arr[$vo['id']]=$vo['title'];
	}
}
$cid_arr[0]="不采集";
$data="";
foreach($cid_arr as $cid_key=>$cid_title){
	$data.='<option value="'.$cid_key.'">'.$cid_title.'</option>';
}
echo $data;
?>
