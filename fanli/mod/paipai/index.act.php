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
* @name 拍拍首页
* @copyright duoduo123.com
* @example 示例paipai_index();
* @param $field 字段
* @param $limit 每页显示多少
* @return $parameter 结果集合
*/
function act_paipai_index($limit=10,$field="*"){
	global $duoduo;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	$tag=dd_get_cache('paipai_index.tag');
	
	//幻灯片
	$slides=$duoduo->select_all('slides',$field,'hide=0 and cid=3 order by sort=0 asc, sort asc limit 0,'.$limit);
	unset($duoduo);
	$parameter['tag']=$tag;
	$parameter['slides']=$slides;
	return $parameter;
}