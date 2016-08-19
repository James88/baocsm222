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
$mall_id=$_GET['mall_id'];

if($q!=''){
    $uid=$duoduo->select('user','id','ddusername="'.$q.'"');
	if($uid>0){
        $where=' uid="'.$uid.'"';
	    $where2=' a.uid="'.$uid.'"';
    }
    else{
        $where=' uid=0';
	    $where2=' a.uid=0';
    }
}
else{
    $where=' 1=1';
	$where2=' 1=1';
}

if($mall_id>0){
    $where.=' and mall_id="'.$mall_id.'"';
	$where2.=' and a.mall_id="'.$mall_id.'"';
}
else{
    $where.='';
}

$total=$duoduo->count(MOD,$where);
$row=$duoduo->select_all('mall_comment as a,user as c','a.fen,a.content,a.addtime,a.id,a.mall_id,a.uid,c.ddusername as username',$where2.' and a.uid=c.id order by id desc limit '.$frmnum.','.$pagesize);





