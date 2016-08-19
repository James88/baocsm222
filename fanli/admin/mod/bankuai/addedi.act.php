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
if($_POST['sub']!=''){
	if($_POST['data_from']==1&&$_POST['bankuai_tpl']=='zhi'){
		jump(-1,'值得买列表样式的数据来源不能使用淘宝api');
	}
	del_magic_quotes_gpc($_POST,1);
	if(empty($_POST['web_cid'])){
		$_POST['fenlei']=0;
		$_POST['web_cid']="";
	}else{
		$_POST['web_cid']=serialize($_POST['web_cid']);
	}
	if($_POST['fenlei']==0){
		$_POST['web_cid']="";
	}
	$_POST['yun_cid']=serialize($_POST['yun_cid']);
	$_POST['dan_api']=serialize($_POST['dan_api']);
	if(empty($_POST['code'])){
		jump(-1,'标识码参数必须有');
	}
	if($_POST['data_from']==0){
		$_POST['huodong_time']=(int)$_POST['huodong_time'];
	}else{
		$_POST['huodong_time']=0;
	}	
	$id=empty($_POST['id'])?0:(int)$_POST['id'];
	unset($_POST['sub']);
	unset($_POST['id']);
	if($id==0){
		$cun=$duoduo->select('bankuai','id',"code='".$_POST['code']."'");
		if($cun){
			jump(-1,'标识码:'.$_POST['code'].'已经被使用，请更换');
		}
		if(!isset($_POST['addtime']) || $_POST['addtime']==''){
			$_POST['addtime']=TIME;
		}
	    $id=$duoduo->insert('bankuai',$_POST);
		$word='保存成功';
	}
	else{
	    $duoduo->update('bankuai',$_POST,'id="'.$id.'"');
		$word='修改成功';
	}
	bankuai_cache();
	jump('-2',$word);
}
else{
	include(DDROOT.'/comm/ddu.class.php');
	$ddu_class=new ddu();
	$data=$ddu_class->goods_type();
	if($data['s']==0&&$data['r']){
		jump(u('mall','set'),$data['r']);
	}
	if($data['s']==1){
		$goods_type=$data['r'];
	}	
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
	$do=$_GET['do'];
    if($id){
		$where.=" and id=".$id;
	}
	if($_GET['code']){
		$where.=" and code='".$_GET['code']."'";
	}
	if($where){
		$row=$duoduo->select('bankuai','*','1 '.$where);
	}
	$type_arr=$duoduo->select_all('type','id,title',"tag='goods'");
	foreach($type_arr as $vo){
		 $web_cid_arr[$vo['id']]=$vo['title'];
	}
	$row['web_cid']=unserialize($row['web_cid']);
	$row['yun_cid']=unserialize($row['yun_cid']);
	$row['dan_api']=unserialize($row['dan_api']);
}
?>