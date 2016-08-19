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

if(isset($_GET['mini'])){
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$pagesize=1000;
	$frmnum=($page-1)*$pagesize;
	
	$a=$duoduo->select_all(MOD,'id,trade_id,num_iid','1 order by id desc limit '.$frmnum.','.$pagesize);
	if(empty($a) || $page>=10){
		jump(u(MOD,ACT),'提取完毕');
	}
	
	foreach($a as $vo){
		$arr=array();
		$arr['trade_id_former'] =preg_replace('/_\d+$/','',$vo['trade_id']);
		$arr['mini_trade_id'] = substr($arr['trade_id_former'],0,8).substr($arr['trade_id_former'],-4,4);
		$arr['trade_id']=$arr['trade_id_former']."_".$vo['num_iid'];
		$id=(int)$duoduo->select('tradelist','trade_id','trade_id="'.$arr['trade_id'].'" and id<>"'.$vo['id'].'"');
		if($id>0){
			echo "更新错误，订单号重复".$arr['trade_id'];
			exit;
		}
		$duoduo->update('tradelist', $arr, 'id="' . $vo['id'] . '"');
	}
	
	$page++;
	PutInfo('提取订单号。。。<br/><br/><img src="../images/wait2.gif" />',u(MOD,ACT,array('mini'=>1,'page'=>$page)));
}


$select_arr=array('trade_id'=>'订单号','item_title'=>'商品名','uname'=>'会员名','uid'=>'会员id');
$select2_arr=array('0'=>'全部','1'=>'电脑','2'=>'手机');

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;
$q=$_GET['q'];
$se=$_GET['se'];
$status=$_GET['status'];
$se2=$_GET['se2'];
$checked=$_GET['checked'];

$page_arr=array('q'=>$q,'se'=>$se,'se2'=>$se2,'checked'=>$checked,'status'=>$status);

if($checked==''){
    unset($checked);
}

if(!isset($checked)){
    $where=' ';
}
else{
    $where=' a.checked="'.$checked.'" and ';
}

if(!array_key_exists($se,$select_arr)){
    $se='trade_id';
}

if($se=='uname'){
    $uid=$duoduo->select('user','id','ddusername="'.$q.'"');
	$where.='a.uid="'.$uid.'"';
}
else{
    $where.='a.`'.$se.'` like "%'.$q.'%"';
}
$status=gbk2utf8($status);
if($status){
	$where.=" and a.`status`=".$status;
	$page_arr['status']=$status;
}
if(isset($se2) && $se2>0){
	$where.=' and a.`platform`='.$se2;
	$page_arr['se2']=$se2;
}
if($_GET['reycle']==1){
	$reycle=1;
	$where.=' and  a.`del`='.$reycle;
	$page_arr['reycle']=$reycle;
}else{
	$where.=' and a.`del`="0"';
}

$stime=$_GET['stime'];
$dtime=$_GET['dtime'];
if(isset($stime) && isset($dtime)){
	$where.=' and pay_time >= "'.$stime.'" and pay_time < "'.$dtime.'"';
	$page_arr['stime']=$stime;
	$page_arr['dtime']=$dtime;
}

if(TAOTYPE==1){
	$order_by='create_time';
}
else{
	$order_by='pay_time';
}

$by_field_arr=array('pay_time','create_time');

foreach($_GET as $k=>$v){
    if(in_array($k,$by_field_arr)){
	    $by_field=$k;
	}
}

if($by_field!=''){
    if($_GET[$by_field]!='desc' && $_GET[$by_field]!='asc'){
	    $_GET[$by_field]='asc';
	}
	$by='a.'.$by_field.' '.$_GET[$by_field].',';
	$page_arr[$by_field]=$_GET[$by_field];
}
else{
    $by='';
}

if($_GET[$by_field]=='desc'){
    $listorder='asc';
}
else{
    $listorder='desc';
}

$total=$duoduo->count(MOD.' as a',$where);
$row=$duoduo->select_all(MOD.' as a','*',$where.' order by '.$by.' a.'.$order_by.' desc,id desc limit '.$frmnum.','.$pagesize);

foreach($row as $k=>$arr){
	$row[$k]['uname']=$duoduo->select('user','ddusername','id="'.$arr['uid'].'"');
	if($arr['checked']!=0 && $arr['uid']==0){
		$duoduo->update('tradelist',array('checked'=>0),'id="'.$arr['id'].'"');
	}
}

if(TAOTYPE==1){
    $_act='import';
    $_act_name='导入订单';
	/*if($total>0){
		$a=$duoduo->select(MOD,'trade_id','1 order by id asc');
		$b=$duoduo->select(MOD,'trade_id','1 order by id desc');
		if(($a!='' && preg_match('/_\d{1,12}/',$a)==0) || ($b!='' && preg_match('/_\d{1,12}/',$b)==0)){
			echo script("alert('系统升级，需从新提取订单号！')");
			$tiqu_mini=1;
		}
	}*/
	$order_by='create_time';
}
else{
    $_act='report';
    $_act_name='获取订单';
	$tiqu_mini=0;
	$order_by='pay_time';
}
?>