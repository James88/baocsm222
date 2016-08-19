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
$se = $_GET['se']?$_GET['se']:0;
$q = $_GET['q'];
$where = '1=1';
if($se==1 && $q!=''){
	$uid = $duoduo->select('user','id','ddusername="'.$q.'"');
	$where.= ' and uid="'.$uid.'"';
}elseif($se==0 && $q!=''){
	$uid = $duoduo->select('user','id','ddusername="'.$q.'"');
	$where.= ' and fuid="'.$uid.'"';
}
$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$page2=($page-1)*$pagesize;
$total=$duoduo->count('ddtuiguang',$where);
$tuiguang=$duoduo->select_all('ddtuiguang','*',$where." order by id desc limit $page2,$pagesize");
		
foreach($tuiguang as $k=>$row){
	$tuiguang[$k]['username']=$duoduo->select('user','ddusername','id="'.$row['uid'].'"');
	$tuiguang[$k]['fenxiangren']=$duoduo->select('user','ddusername','id="'.$row['fuid'].'"');
	if($row['code']=='goods'){
		if($tuiguang[$k]['title']==''){
			$tuiguang[$k]['title']=$duoduo->select('goods','title','id="'.$row['shuju_id'].'"');
		}
		$tuiguang[$k]['type']='普通商品';
		$tuiguang[$k]['url']=SITEURL.'/index.php?mod=goods&act=view&id='.$row['shuju_id'];
	}
	elseif($row['code']=='share'){
		if($tuiguang[$k]['title']==''){
			$tuiguang[$k]['title']=$duoduo->select('baobei','title','id="'.$row['shuju_id'].'"');
		}
		$tuiguang[$k]['type']='晒单分享';
		$tuiguang[$k]['url']=SITEURL.'/index.php?mod=baobei&act=view&id='.$row['shuju_id'];
	}
}
?>