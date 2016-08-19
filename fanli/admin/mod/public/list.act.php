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

if($_GET['public_sub']==1){
	$id=$_GET['id'];
	$table=$_GET['table'];
	$v=$_GET['v'];
	$f=$_GET['f'];
	
	if($f=='sort'){
		$duoduo->update_sort($id,$v,$table);
	}
	else{
		$data=array($f=>$v);
		$duoduo->update($table,$data,'id="'.$id.'"');
	}
	dd_exit(1);
}

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
$d=$duoduo->get_table_struct(MOD);
if($_GET['reycle']==1){
	$reycle=1;
	$where.=' and `del` ='.$reycle;
	$page_arr['reycle']=$reycle;
}elseif(!empty($d['del'])){
	$where.=' and `del` = "0"';
}
$page_arr['q']=$q;

$d=$duoduo->get_table_struct(MOD);
$total=$duoduo->count(MOD,"`".$title."` like '%$q%' ".$where);
if(!empty($d['sort'])){
	if(MOD=='nav'){
		if($_GET['fu']==1 || $q==''){
			$where=' and pid = 0 ';
		}
		$total_nav=$duoduo->count(MOD,"`".$title."` like '%$q%' ".$where);
		$row=$duoduo->select_all(MOD,'*','`'.$title.'` like "%'.$q.'%" '.$where.' order by '.$by.' hide asc ,sort =0 ASC , sort ASC ,id desc limit '.$frmnum.','.$pagesize);
		if($_GET['fu']==0 && $q==''){
			foreach($row as $k=>$v){
				$row[$k]['zdh'] = $duoduo->select_all(MOD,'*','pid = "'.$v['id'].'" order by hide asc ,sort =0 ASC , sort ASC,id desc');
			}
		}
	}else{
		$row=$duoduo->select_all(MOD,'*','`'.$title.'` like "%'.$q.'%" '.$where.' order by '.$by.' sort =0 ASC , sort ASC ,id desc limit '.$frmnum.','.$pagesize);
	}
}else{
	$row=$duoduo->select_all(MOD,'*','`'.$title.'` like "%'.$q.'%" '.$where.' order by '.$by.' id desc limit '.$frmnum.','.$pagesize);
}
?>