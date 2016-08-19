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

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;
$q=$_GET['q'];
$sid=$_GET['sid'];
$where='1=1';
if($q!=''){
    $uid=$duoduo->select('user','id','ddusername="'.$q.'"');
	if($uid>0){
	    $where=' a.uid="'.$uid.'"';
    }
	$page_arr['q']=$q;
}
if($sid>0){
	$where=' a.baobei_id = "'.$sid.'"';
	$page_arr['sid']=$sid;
}

$total=$duoduo->count('baobei_comment as a',$where);
$row=$duoduo->select_all('baobei_comment as a,user as b,baobei as c','a.*,b.ddusername as username,c.title',$where.' and a.uid=b.id and a.baobei_id=c.id order by id desc limit '.$frmnum.','.$pagesize);