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
* @param  $field3字段
* @param  $pagesize每页数量
* @return $parameter 结果集合
*/
function act_baobei_view($pagesize=500,$field='a.*,b.ddusername,b.id as user_id,b.hart as user_hart',$field2='a.*,b.ddusername',$field3='id,title,img,price,userimg,commission'){
	global $duoduo;
	$webset=$duoduo->webset;
	$dduser=$duoduo->dduser;
	$id=$_GET['id']?intval($_GET['id']):0;
	if($id==0){
		jump(u('baobei','list'));
	}
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$frmnum=($page-1)*$pagesize;
	
	$cat_arr=$webset['baobei']['cat'];
	$face_img=include(DDROOT.'/data/face_img.php');
	$face=include(DDROOT.'/data/face.php');
	$face=include('data/face.php');
	
	
	$duoduo->update('baobei',array('f'=>'hits','e'=>'+','v'=>1),'id="'.$id.'"'); //点击
	
	$baobei=$duoduo->select('baobei as a,user as b',$field,'a.uid=b.id and a.id="'.$id.'" and a.fabu_time<="'.SJ.'"');
	$user = $duoduo->select('user','*','id='.$baobei['user_id']);
	$baobei['content']=str_replace($face,$face_img,$baobei['content']);
	$baobei['jump']=u('jump','goods',array('iid'=>iid_encode($baobei['tao_id']),'fuid'=>$baobei['uid'],'mall'=>2,'code'=>'share','shuju_id'=>$id,'goods_id'=>$baobei['tao_id']));
	$baobei['fxje']=jfb_data_type(fenduan($baobei['commission'],$webset['fxbl'],$dduser['type'],TBMONEYBL));
	$baobei['user_img']=a($baobei['uid'],'small');
	$baobei['userimg']=$baobei['userimg']?$baobei['userimg']:$baobei['img'];
	$baobei['_addtime']=date('m月d日',$baobei['addtime']);
	$baobei['_url']=l(MOD,ACT,array('id'=>$id));
	
	$comment_total=$duoduo->count('baobei_comment','baobei_id="'.$baobei['id'].'"');
	$comment_arr=$duoduo->select_all('baobei_comment as a,user as b',$field2,'a.baobei_id="'.$baobei['id'].'" and a.uid=b.id order by id desc limit 10');
	foreach($comment_arr as $k=>$row){
		$comment_arr[$k]['url']=u('baobei','view',array('id'=>$row['id']));
		$comment_arr[$k]['user_url']=u('baobei','user',array('uid'=>$row['uid']));
		$comment_arr[$k]['user_img']=a($row['uid'],'small');
		$comment_arr[$k]['_addtime']=date('m月d日 H:i',$row['addtime']);
		$comment_arr[$k]['_comment']=str_replace($face,$face_img,$row['comment']);
	}
	$user_baobei=$duoduo->select_all('baobei',$field3,'id<>"'.$id.'" and uid="'.$baobei['uid'].'" order by id desc limit 5');
	foreach($user_baobei as $k=>$row){
		$user_baobei[$k]['url']=u('baobei','view',array('id'=>$row['id']));
		$user_baobei[$k]['fxje']=jfb_data_type(fenduan($row['commission'],$webset['fxbl'],$dduser['type'],TBMONEYBL));
		$user_baobei[$k]['userimg']=$row['userimg']?$row['userimg']:$row['img'].'_250x250.jpg';
	}
	
	$orther_baobei=$duoduo->select_all('baobei as a,user as b',$field,'a.uid=b.id and a.id<>"'.$id.'" and a.cid<="'.$baobei['cid'].'" order by id desc limit 12');
	foreach($orther_baobei as $k=>$row){
		$orther_baobei[$k]['url']=u('baobei','view',array('id'=>$row['id']));
		$orther_baobei[$k]['_url']=l('baobei','view',array('id'=>$row['id']));
		$orther_baobei[$k]['userimg']=$row['userimg']?$row['userimg']:$row['img'].'_250x250.jpg';
		$orther_baobei[$k]['user_img']=a($row['uid'],'small');
		$orther_baobei[$k]['user_url']=u('baobei','user',array('uid'=>$row['uid']));
		$orther_baobei[$k]['fxje']=jfb_data_type(fenduan($row['commission'],$webset['fxbl'],$dduser['type'],TBMONEYBL));
	}
	if($dduser['id']<=0){
		$comment_id='noComment';
	}
	elseif($dduser['level']<$webset['baobei']['limit_level']){
		$comment_id='noLevelComment';
	}
	else{
		$comment_id='StartComment';
	}
	
	include(DDROOT.'/comm/goods.class.php');
	$goods_class=new goods($duoduo);
	$remai=$goods_class->index_list('',9,1,'cid="'.$baobei['cid'].'"');
	
	$seelog=array('type'=>'share','id'=>$baobei['id'],'pic'=>$baobei['img'].'_100x100.jpg','title'=>$baobei['title'],'price'=>$baobei['price']);
	
	$page_url=u(MOD,ACT,array('id'=>$id));
	unset($duoduo);
	$parameter['cat_arr']=$cat_arr;
	$parameter['face_img']=$face_img;
	$parameter['face']=$face;
	$parameter['baobei']=$baobei;
	$parameter['user']=$user;
	$parameter['comment_total']=$comment_total;
	$parameter['total']=$total;
	$parameter['comment_arr']=$comment_arr;
	$parameter['orther_baobei']=$orther_baobei;
	$parameter['user_baobei']=$user_baobei;
	$parameter['comment_id']=$comment_id;
	$parameter['page_url']=$page_url;
	$parameter['pageurl']=pageft($comment_total,$pagesize,$page_url,WJT);
	$parameter['id']=$id;
	$parameter['remai']=$remai;
	$parameter['act_seelog']=$seelog;
	$parameter['his_baobei_url']=u('baobei','user',array('uid'=>$user['id'],'xs'=>1));
	$parameter['his_xihuan_url']=u('baobei','user',array('uid'=>$user['id'],'xs'=>2));
	return $parameter;
}
?>