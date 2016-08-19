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
$page_size=24;
$page=$_GET['page']?$_GET['page']:1;

$id=(int)$_GET['id'];
$bankuai=$duoduo->select('bankuai','*','id='.$id);
if($bankuai['laiyuan']!=2){
	jump(-1,'该板块不需要采集');
}
$parameters=array();
if($bankuai['diaoyong']==0){
	$parameters['sprice']=$bankuai['sprice'];
	$parameters['eprice']=$bankuai['eprice'];
	$parameters['fenlei']=$bankuai['fenlei'];
}else{
	$parameters['sprice']=0;
	$parameters['eprice']=0;
	$parameters['fenlei']=0;
	$parameters['diaoyong']=$bankuai['diaoyong'];
}
if($bankuai['web']==2){
	$parameters['web_arr']=implode(',',unserialize($bankuai['web_arr']));
}else{
	$parameters['web_arr']="";
}
$parameters['caiji_time']=$bankuai['caiji_time'];
$parameters['dianpu']=$bankuai['dianpu'];
$parameters['baoyou']=$bankuai['baoyou'];
$goods_shuju=$ddu_class->goods_shuju($parameters);
if($goods_shuju['s']==0){
	jump(-1,$goods_shuju['r']);
}
$data=$goods_shuju['data'];
foreach($data as $vo){
	$cun=$duoduo->select('goods','id',"data_id='".$vo['data_id']."'");
	if(empty($cun)){
		unset($vo['id']);
		$vo['addtime']=TIME;
		$id=$duoduo->insert('bankuai',$vo);
	}else{
		$duoduo->update('bankuai',$vo,'id='.$vo['id']);
	}
	echo mysql_error();
	exit();
}

exit();
?>