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

function domian_cache(){
	global $duoduo;
	$domain=$duoduo->select_all('domain','*');
	foreach($domain as $row){
		$a[$row['url']]=array('url'=>$row['url'],'mod'=>$row['mod'],'code'=>$row['code'],'close'=>$row['close']);
	}
	dd_set_cache('domain',$a);
}

function domain_del($ids){
	domian_cache();
}