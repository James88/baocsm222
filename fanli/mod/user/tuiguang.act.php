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
* @name 用户推广
* @copyright duoduo123.com
* @example 示例user_tuiguang();
* @param $field  字段
* @param $pagesize 每页显示多少
* @return $parameter 结果集合
*/
function  user_tuiguang($pagesize=10){
	global $duoduo;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	
	$do=$_GET['do']?$_GET['do']:'url';
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$page2=($page-1)*$pagesize;
	
	$total=$duoduo->count('ddtuiguang'," fuid='".$dduser["id"]."'");
	$tuiguang=$duoduo->select_all('ddtuiguang','*'," fuid='".$dduser["id"]."' order by id desc limit $page2,$pagesize");
		
	foreach($tuiguang as $k=>$row){
		$tuiguang[$k]['username']=$duoduo->select('user','ddusername','id="'.$row['uid'].'"');
		if($row['code']=='zdm'){
			if($tuiguang[$k]['title']==''){
				$tuiguang[$k]['title']=$duoduo->select('ddzhidemai','title','id="'.$row['shuju_id'].'"');
			}
			$tuiguang[$k]['type']='值得买';
			$tuiguang[$k]['url']=u('zhidemai','view',array('id'=>$row['shuju_id']));
		}
		elseif($row['code']=='share'){
			if($tuiguang[$k]['title']==''){
				$tuiguang[$k]['title']=$duoduo->select('baobei','title','id="'.$row['shuju_id'].'"');
			}
			$tuiguang[$k]['type']='晒单分享';
			$tuiguang[$k]['url']=u('baobei','view',array('id'=>$row['shuju_id']));
		}
	}
		
	unset($duoduo);
	$parameter['total']=$total;
	$parameter['tuiguang']=$tuiguang;
	$parameter['pagesize']=$pagesize;
	return $parameter;
}