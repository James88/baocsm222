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

if(!defined('INDEX')){
	exit('Access Denied');
}

/**
* @name 宝贝列表
* @copyright duoduo123.com
* @example 示例baobei_list();
* @param $field 字段
* @param $pagesize 每页默认20篇
*/
function act_baobei_list(){
	global $duoduo;
	$webset=$duoduo->webset;
	$dduser=$duoduo->dduser;
	$cat_arr=$webset['baobei']['cat'];
	$face_img=include(DDROOT.'/data/face_img.php');
	$face=include(DDROOT.'/data/face.php');

	$type=$duoduo->select_all('type','*',"tag='goods'");
	foreach($type as $k=>$vo){
		$cat_arrs[$k]['url']=u('baobei','list',array('cid'=>$vo['id']));
		$cat_arrs[$k]['title']=$vo['title'];
		$cat_arrs[$k]['cid']=$vo['id'];
	}
	$parameter['cat_arrs']=$cat_arrs;
	$parameter['shaidan_url']=u('user','tradelist');
	$parameter['cat_url']=u('baobei','index');
	unset($duoduo);
	return $parameter;
}
?>