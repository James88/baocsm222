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
$q = trim($_GET['q']);
$parent_id = trim($_GET['parent_id']);
if($parent_id>0){
	$where = 'parent_id = "'.$parent_id.'"';
}else{
	$where = '1=1';
}
$page_arr = array('q'=>$q,'parent_id'=>$parent_id);
$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;
$slist = $duoduo->select_all('menu','*',$where.' and `title` like "%'.$q.'%" and parent_id>0 order by id desc limit '.$frmnum.','.$pagesize);
$total=$duoduo->count(MOD,$where.' and `title` like "%'.$q.'%" and parent_id>0');

foreach($slist as $k=>$v){
	$slist[$k]['p_title'] = $duoduo->select('menu','title','id="'.$v['parent_id'].'"');
	$slist[$k]['url'] = $slist[$k]['url']?$slist[$k]['url']:u($v['mod'],$v['act']);
}