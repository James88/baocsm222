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

$do_arr=array('to'=>'收件人','from'=>'发件人');

$do=$_GET['do'];
if(!array_key_exists($do,$do_arr)){
    $do='to';
}

if($do=='to'){
    $do_reverse='from';
}
else{
    $do_reverse='to';
}

if(isset($_GET['uname']) && $_GET['uname']!='' && $_GET['uname']!='网站客服'){
	$uname=$_GET['uname'];
    $uid=$duoduo->select('user','id','ddusername="'.$uname.'"');
}
else{
    $uid=0;
	$uname='网站客服';
}

if($do=='to'){
	if($uid==0){
	    $total=$duoduo->count(MOD,'uid=0');
        $row=$duoduo->select_all('msg as a,user as b','a.*,b.ddusername','a.uid=0 and a.senduser=b.id order by id desc limit '.$frmnum.','.$pagesize);
	}
	else{
	    $total=$duoduo->count(MOD,'uid="'.$uid.'"');
        $row=$duoduo->select_all('msg as a,user as b','a.*,b.ddusername','a.uid="'.$uid.'" and a.uid=b.id order by id desc limit '.$frmnum.','.$pagesize);
	}
}
else{
    $total=$duoduo->count(MOD,'senduser="'.$uid.'"');
    $row=$duoduo->select_all('msg as a,user as b','a.*,b.ddusername','senduser="'.$uid.'" and a.uid=b.id order by id desc limit '.$frmnum.','.$pagesize);
}
