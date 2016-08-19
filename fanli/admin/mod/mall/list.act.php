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

include(DDROOT.'/comm/mall.class.php');
$mall_class=new mall($duoduo);

if(isset($_GET['update']) && $_GET['update']=='sort'){
	$id=$_GET['id'];
	$sort=$_GET['v'];
	$mall_class->update_sort($id,$sort);
	exit;
}
$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;

$q=$_GET['q'];
$cid=(int)$_GET['cid'];

$page_arr=array();
$where='1=1';

if($cid>0){
    $where.=" and cid='".$cid."'";
	$page_arr['cid']=$cid;
}

if($_GET['reycle']==1){
	$reycle=1;
	$where.=' and  `del`='.$reycle;
	$page_arr['reycle']=$reycle;
}else{
	$where.=' and `del`="0"';
}

if(isset($_GET['edate']) && $_GET['edate']!=''){
	$by='edate '.$_GET['edate'].',';
	$page_arr['edate']=$edate;
}
else{
    $by='';
}
if($_GET['edate']=='desc'){
    $listedate='asc';
}
else{
    $listedate='desc';
}

if(isset($_GET['sort']) && $_GET['sort']!=''){
	$sort=$_GET['sort'];
    $by.='sort '.$sort.',';
	$page_arr['sort']=$sort;
}
if($_GET['sort']=='asc'){
    $listsort='desc';
}
else{
    $listsort='asc';
}

if($q!=''){
	$page_arr['q']=$q;
	$where.=' and (title like "%'.$q.'%" or url like "%'.$q.'%")';
}

$data=$mall_class->select($where.' order by '.$by.' sort=0 asc,sort asc,id desc limit '.$frmnum.','.$pagesize,1);
$total=$data['total'];
$row=$data['data'];