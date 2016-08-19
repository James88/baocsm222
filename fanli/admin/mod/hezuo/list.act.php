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
$reycle=(int)$_GET['reycle'];
$pagesize=20;//每页显示多少1级徒弟
$page = empty($_GET['page'])?'1':intval($_GET['page']);
$page2=($page-1)*$pagesize;
$where="1";
if($_GET['ddusername']){
	$uid=$duoduo->select('user','id',"ddusername='".trim($_GET['ddusername'])."'");
	if($uid){
		$where.=" and uid=".$uid;
	}
}
/*if(isset($_GET['status'])){
	$where.=" and a.status=".(int)$_GET['status'];
}*/
$total=$duoduo->count('hezuo as a',$where);
$hezuo=$duoduo->select_all('hezuo as a left join '.BIAOTOU.'user as b on b.id=a.uid','a.*,b.ddusername,b.qq,b.email,b.mobile',$where.' order by a.id desc limit '.$page2.','.$pagesize);
?>