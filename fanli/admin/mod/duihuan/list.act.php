<?php
/**
 * ============================================================================
 * 版权所有 2008-2012 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;

if(isset($_GET['q']) && $_GET['q']!=''){
	$q=$_GET['q'];
    $uid=$duoduo->select('user','id','ddusername="'.$q.'"');
	$where='a.uid="'.$uid.'"';
}
else{
    $where='1=1';
}
if($_GET['reycle']==1){
	$reycle=1;
	$where.=' and  a.`del`='.$reycle;
	$page_arr['reycle']=$reycle;
}else{
	$where.=' and a.`del`="0"';
}

$total=$duoduo->count('duihuan as a,user as b',$where.' and a.uid=b.id');
$row=$duoduo->select_all('duihuan as a,user as b','a.*,b.ddusername',$where.' and a.uid=b.id order by id desc limit '.$frmnum.','.$pagesize);