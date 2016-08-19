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

$select_arr=array('order_code'=>'订单号','uname'=>'会员名',);
$select2_arr=array('0'=>'全部','1'=>'电脑','2'=>'手机');
$status_arr1['']='全部';
$status_arr=$status_arr1+$status_arr2;

$malls=mall_pinyin($duoduo);
$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;
$q=$_GET['q'];
$mall_id=$_GET['mall_id'];
$se=$_GET['se'];
$se2=$_GET['se2'];
$status=$_GET['status'];
$stime=$_GET['stime'];
$dtime=$_GET['dtime'];

if($status==='' || !isset($_GET['status'])){
    $where=' ';
}
else{
    $where=' a.status="'.$status.'" and ';
	$page_arr['status']=$status;
}

if($mall_id>0){
	$where.='mall_id="'.$mall_id.'" and ';
	$page_arr['mall_id']=$mall_id;
}

if(!array_key_exists($se,$select_arr)){
    $se='order_code';
}

if($se=='uname'){
    $uid=$duoduo->select('user','id','ddusername="'.$q.'"');
	$where.='a.uid="'.$uid.'"';
}
else{
    $where.='a.`'.$se.'` like "%'.$q.'%"';
}
if($q!=''){
	$page_arr['q']=$q;
	$page_arr['se']=$se;
}

if(isset($se2) && $se2>0){
	$where.=' and a.`platform`='.$se2;
	$page_arr['se2']=$se2;
	$page_arr['se2']=$se2;
}

if($stime!='' && $dtime!=''){
   $where.='and a.order_time >= "'.strtotime($stime).'" and a.order_time < "'.strtotime($dtime).'"';
   $page_arr['stime']=$stime;
   $page_arr['dtime']=$dtime;
}
if($_GET['reycle']==1){
	$reycle=1;
	$where.=' and  a.`del`='.$reycle;
	$page_arr['reycle']=$reycle;
}else{
	$where.=' and a.`del`="0"';
}
$total=$duoduo->count(MOD.' as a',$where);
$row=$duoduo->left_join(MOD.' as a','user AS b ON a.uid = b.id','a.*,b.ddusername as uname',$where.' order by a.order_time desc limit '.$frmnum.','.$pagesize);
?>