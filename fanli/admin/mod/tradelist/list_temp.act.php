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
if($_GET['do']=='daoru'){
	$result['insert_num']=(int)$_GET['insert_num'];
	$result['update_num']=(int)$_GET['update_num'];
	$result['delete_num']=(int)$_GET['delete_num'];
	$result['bubian_num']=(int)$_GET['bubian_num'];
	$pagesize=$_GET['pagesize']?$_GET['pagesize']:300;
	$tradelist_temp=$duoduo->select_all('tradelist_temp','*',' 1 ORDER BY id ASC LIMIT '.$pagesize);
	if(empty($tradelist_temp)){
		$duoduo->query('truncate  `'.BIAOTOU.'tradelist_temp`');
		$duoduo->query('OPTIMIZE TABLE  `'.BIAOTOU.'tradelist_temp`');
		$msg="操作完成共插入".$result['insert_num']."条新订单，更新".$result['update_num']."条订单，有".$result['bubian_num']."条订单不变";
		jump(u(MOD,'list'),$msg);
	}
	echo mysql_error();
	
	foreach($tradelist_temp as $vo){
		$id=$vo['id'];
		unset($vo['id']);
		if(empty($vo['pay_time'])){
			unset($vo['pay_time']);
		}
		if(empty($vo['settletime'])){
			unset($vo['settletime']);
		}
		if(empty($vo)){
			echo "chucuo";
			exit();
		}
        $result =$duoduo->trade_ruku($vo,$result);
		echo mysql_error();
		$duoduo->delete('tradelist_temp','id="'.$id.'"');
	}
	$msg="共插入".$result['insert_num']."条新订单，更新".$result['update_num']."条订单，删除".$result['delete_num']."条订单，有".$result['bubian_num']."条订单不变";
	PutInfo($msg.'<br/><img src="../images/wait2.gif" />',u(MOD,ACT,array('do'=>$_GET['do'],'pagesize'=>$pagesize,'insert_num'=>$result['insert_num'],'update_num'=>$result['update_num'],'delete_num'=>$result['delete_num'],'bubian_num'=>$result['bubian_num'])),1);
	exit();
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

$total=$duoduo->count('tradelist_temp as a',$where);
$row=$duoduo->select_all('tradelist_temp as a','*',$where.' order by '.$by.' a.'.$order_by.' desc,id desc limit '.$frmnum.','.$pagesize);

foreach($row as $k=>$arr){
	$row[$k]['uname']=$duoduo->select('user','ddusername','id="'.$arr['uid'].'"');
}
?>