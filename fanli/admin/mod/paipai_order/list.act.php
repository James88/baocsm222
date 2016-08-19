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

$select_arr=array('commName'=>'商品名','dealId'=>'订单号','uname'=>'会员名','uid'=>'会员id');
$checked_arr['']='全部';
$checked_arr=$checked_arr+$checked_status;

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;
$q=$_GET['q'];
$se=$_GET['se'];
$checked=$_GET['checked'];
$stime=$_GET['stime'];
$dtime=$_GET['dtime'];

if($checked==''){
    unset($checked);
}

if(!isset($checked)){
    $where=' ';
}
else{
    $where=' a.checked="'.$checked.'" and ';
	$page_arr['checked']=$checked;
}

if(!array_key_exists($se,$select_arr)){
    $se='commName';
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
if($stime!='' && $dtime!=''){
   $where.='and a.chargeTime >= "'.strtotime($stime).'" and a.chargeTime < "'.strtotime($dtime).'"';
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
$row=$duoduo->left_join(MOD.' as a','user AS b ON a.uid = b.id','a.*,b.ddusername as uname',$where.' order by a.chargeTime desc limit '.$frmnum.','.$pagesize);
?>