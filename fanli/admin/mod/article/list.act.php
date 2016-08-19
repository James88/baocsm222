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
include(DDROOT.'/comm/article.class.php');
$article_class=new article($duoduo);
$table_list=include(DDROOT.'/data/table_list.php');
if(isset($table_list[MOD])){
	$title=$table_list[MOD]['title'];
	$table_sort=$table_list[MOD]['sort'];
}
else{
	$title='title';
}

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;
$q=$_GET['q'];
$cid=(int)$_GET['cid'];
if(isset($_GET['sort'])){
    $by='sort asc,';
	$page_arr['sort']=$_GET['sort'];
}
else{
	if($table_sort!=''){
		$by=$table_sort.',';
	}
	else{
		$by='';
	}
}

if($cid>0){
    $where=' and cid="'.$cid.'"';
	$page_arr['cid']=$cid;
}
else{
    $where='';
}
if($_GET['reycle']==1){
	$reycle=1;
	$where.=' and `del`='.$reycle;
	$page_arr['reycle']=$reycle;
}else{
	$where.=' and `del`="0"';
}
$page_arr['q']=$q;
$list = $article_class->select_all('`'.$title.'` like "%'.$q.'%" '.$where.' order by '.$by.' sort asc,id desc limit '.$frmnum.','.$pagesize,1,'*');
$total = $list['total'];
$row = $list['data'];