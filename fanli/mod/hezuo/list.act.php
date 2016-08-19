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
if($dduser['id']<=0){
	jump(u('user','login',array('from'=>u(MOD,ACT))),'请先登录');
}
$tag = $_GET['tag']?$_GET['tag']:'hezuo';
$pagesize=20;
$page = empty($_GET['page'])?'1':intval($_GET['page']);
$page2=($page-1)*$pagesize;
$where="uid=".$dduser['id'];
$total=$duoduo->count($tag,$where);
$ddgoods=$duoduo->select_all($tag,'*',$where.' order by id desc limit '.$page2.','.$pagesize);
foreach($ddgoods as $k=>$v){
	if($tag=='goods'){
		$ddgoods[$k]['url'] = u('goods','view',array('code'=>$v['code'],'id'=>$v['id']));
	}
}
$bankuai_data=$duoduo->select_all('bankuai','code,title',"1");
foreach($bankuai_data as $vo){
	$bankuai[$vo['code']]=$vo['title'];
}
?>