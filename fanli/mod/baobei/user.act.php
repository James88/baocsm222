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

if(!defined('INDEX')){
	exit('Access Denied');
}
/**
* @name 用户宝贝页面
* @copyright duoduo123.com
* @example 示例baobei_user();
* @param  $field字段
* @param  $field2字段
* @param  $pagesize每页数量
* @return $parameter 结果集合
*/
function act_baobei_user($pagesize=24,$field='a.`id`,a.`title`,a.`img`,a.`price`,a.`commission`,a.`hart`,a.`hits`,a.`content`,a.`uid`,a.addtime,b.ddusername',$field2='b.id,b.title,b.img,b.hart,b.hits,b.content,b.uid,c.ddusername'){
	global $duoduo;
	$webset=$duoduo->webset;
	$dduser=$duoduo->dduser;
	$uid=$_GET['uid']?intval($_GET['uid']):0;
	$cid=$_GET['cid']?intval($_GET['cid']):0;
	$xs=$_GET['xs']?intval($_GET['xs']):1;
	if($uid==0){
		jump(u('baobei','list'));
	}
	
	$type=$duoduo->select_all('type','*',"tag='goods'");
	foreach($type as $k=>$vo){
		$cat_arrs[$k]['url']=u('baobei','list',array('cid'=>$vo['id']));
		$cat_arrs[$k]['title']=$vo['title'];
		$cat_arrs[$k]['cid']=$vo['id'];
	}
	$face_img=include(DDROOT.'/data/face_img.php');
	$face=include(DDROOT.'/data/face.php');
	
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$frmnum=($page-1)*$pagesize;
	
	if($cid>0){
		$where_cid="and b.cid='".$cid."'";
	}
	elseif($cid==0){
		$where_cid="";
	}
	
	$user=$duoduo->select('user','ddusername,hart,id','id="'.$uid.'"');
	if($xs==1){//他的宝贝
		$total=$duoduo->count('baobei',"uid='".$uid."' ".$where_cid);
		$baobei=$duoduo->select_all('baobei as a,user as b',$field,"a.uid='".$uid."' and a.uid=b.id ".$where_cid." order by a.id desc limit $frmnum,$pagesize");
	}
	elseif($xs==2){//他喜欢的宝贝
		$total=$duoduo->count('baobei_hart as a,baobei as b','a.uid="'.$uid.'" and a.baobei_id=b.id '.$where_cid);
		$baobei=$duoduo->select_all('baobei_hart as a,baobei as b,user as c',$field2,'a.uid="'.$uid.'" and c.id=b.uid and a.baobei_id=b.id '.$where_cid.' order by b.id desc limit '.$frmnum.','.$pagesize);
	}

	$cur_baobei_num=count($baobei);
	for($i=0;$i<$cur_baobei_num;$i++){
		$baobei[$i]['content']=str_replace($face,$face_img,$baobei[$i]['content']);
	}
	
	$page_url=u(MOD,ACT,array('uid'=>$uid,'xs'=>$xs));
	unset($duoduo);
	$parameter['total']=$total;
	$parameter['cur_baobei_num']=$cur_baobei_num;
	$parameter['baobei']=$baobei;
	$parameter['total']=$total;
	$parameter['pagesize']=$pagesize;
	$parameter['cid']=$cid;
	$parameter['uid']=$uid;
	$parameter['page_url']=$page_url;
	$parameter['cat_arrs']=$cat_arrs;
	$parameter['face']=$face;
	$parameter['face_img']=$face_img;
	$parameter['xs']=$xs;
	$parameter['user']=$user;
	return $parameter;
}
?>