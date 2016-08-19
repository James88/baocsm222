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
if($_GET['guoqi']==1){
	$duoduo->delete('goods','endtime<'.time());
	jump(u('goods','list'),'删除成功！');
}
$reycle=(int)$_GET['reycle'];
$type=$duoduo->select_all('type','*',"tag='goods'");
$cid_arr[0]="全部";
foreach($type as $vo){
	$cid_arr[$vo['id']]=$vo['title'];
}
$leixing_arr[0]="全部商品";
$leixing_arr[1]="已上线";
$leixing_arr[2]="仅预告";

$shangpin_s_arr=array(0=>'商品名称','1'=>'商品id');

$bankuai_data=$duoduo->select_all('bankuai','code,title',"1");
$bankuai[0]="全部";
foreach($bankuai_data as $vo){
	$bankuai[$vo['code']]=$vo['title'];
}
if($_GET['do']=='set_top'){
	if(empty($_GET['id'])){
		jump(-1,'参数错误');
	}
	$id=(int)$_GET['id'];
	$top=(int)$_GET['top'];
	$top_stime=$_GET['top_stime'];
	$top_etime=$_GET['top_etime'];
	
	$update=array();
	$update['top']=$top;
	if($top==0){
		$update['top_stime']=0;
		$update['top_etime']=0;
	}else{
		$update['top_stime']=$top_stime?strtotime($top_stime):0;
		$update['top_etime']=$top_etime?strtotime($top_etime):0;
	}
	$duoduo->update('goods',$update,'id="'.$id.'"');
	$re=array('id'=>$id,'top'=>$top,'top_stime'=>$top_stime,'top_etime'=>$top_etime);
	echo json_encode($re);exit;
}
if($_GET['update']=='sort'){
	$id=$_GET['id'];
	$v=$_GET['v'];
	$f=$_GET['f'];
	$table=$_GET['table'];
	$data=array($f=>$v);
	$duoduo->update($table,$data,'id="'.$id.'"');
	dd_exit(1);
}
else{
	$duoduo->update('goods',array('top'=>0,'top_stime'=>0,'top_etime'=>0),"top_etime<'".time()."' and top_etime<>0");
	
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$pagesize=20;
	$frmnum=($page-1)*$pagesize;
	
	$where.=" and del=".$reycle;
	if($_GET['ddusername']){
		$uid=$duoduo->select('user','id',"ddusername='".trim($_GET['ddusername'])."'");
		if($uid){
			$where.=" and uid=".$uid;
		}
	}
	if($_GET['title']){
		$shangpin_s=(int)$_GET['shangpin_s'];
		if($shangpin_s==0){
			$where.=" and title like '%".trim($_GET['title'])."%'";
		}
		else{
			$where.=" and data_id = '".trim($_GET['title'])."'";
		}
		$page_arr['title']=$_GET['title'];
		$page_arr['shangpin_s']=$shangpin_s;
	}
	if($_GET['code']){
		$where.=" and code='".$_GET['code']."'";
		$page_arr['code']=$_GET['code'];
	}
	if($_GET['cid']){
		$where.=" and cid='".(int)$_GET['cid']."'";
		$page_arr['cid']=$_GET['cid'];
	}
	$leixing=$_GET['leixing'];
	if($leixing==1){
		$where.=" and starttime<='".TIME."' and endtime>'".TIME."'";
	}
	if($leixing==2){
		$where.=" and starttime>'".TIME."'";
	}
	if($leixing>0){
		$page_arr['leixing']=$_GET['leixing'];
	}

	$total=$duoduo->count('goods',"1 ".$where);
	$data=$duoduo->select_all('goods','*',' 1 '.$where.' order by top desc,sort=0 asc,sort asc,starttime desc,id desc limit '.$frmnum.','.$pagesize);
	foreach($data as $key=>$vo){
		$data[$key]['bankuai_title']=$bankuai[$vo['code']];
		$data[$key]['cid_title']=$cid_arr[$vo['cid']];	
		if($vo['uid']){
			$data[$key]['ddusername']=$duoduo->select('user','ddusername',"id=".$vo['uid']);
		}
	}
	echo mysql_error();
}