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
$leixing=$_GET['leixing'];
$j_time=strtotime(date('Y-m-d 00:00:00',TIME));
$w_time=strtotime(date('Y-m-d 23:59:59',TIME));
if($_GET['wufanli']==1){
	if($leixing==1){
		$where.=" and addtime>='".$j_time."' and addtime<='".$w_time."'";
	}
	if($leixing==3){
		$where.=" and starttime>='".($j_time+3600*24)."' and starttime<='".($w_time+3600*24)."'";
	}
	$page=$_GET['page']?$_GET['page']:1;
	$page_size=50;
	$page_form=($page-1)*$page_size;
	$data=$duoduo->select_all("goods","data_id,id"," laiyuan_type<3 and endtime>".time().$where." ORDER BY id ASC LIMIT ".$page_form.",".$page_size);
	if(empty($data)){
		$duoduo->delete('goods','del=1');
		jump(u(MOD,ACT),"操作完成！");
	}
	include (DDROOT . '/comm/Taoapi.php');
	include (DDROOT . '/comm/ddTaoapi.class.php');
	$ddTaoapi = new ddTaoapi();
	foreach($data as $vo){
		if(empty($vo['data_id'])){
			$duoduo->update("goods",array('del'=>1),"id=".$vo['id']);
			continue;
		}
		$allow_fanli=$ddTaoapi->taobao_taobaoke_rebate_authorize_get($vo['data_id']);
		if($allow_fanli==0){
			$duoduo->update("goods",array('del'=>1),"id=".$vo['id']);
			continue;
		}
		
		$ju_url='http://detail.ju.taobao.com/home.htm?item_id='.$vo['data_id'];
		$ju_html=file_get_contents($ju_url);
		if($ju_html!='' && strpos(iconv('gbk','utf-8',$ju_html),'<span class="infotext J_Infotext">已结束')===false  && strpos($ju_html,'<input type="hidden" id="itemId" value="'.$vo['data_id'].'"')!==false && strpos($ju_html,'<span class="out floatright">')===false){
			$duoduo->update("goods",array('del'=>1),"id=".$vo['id']);
			continue;
		}
		echo mysql_error();
	}
	$page++;
	PutInfo("第".($page-1)."页".$page_size."件商品处理完成，接下来处理第".$page."页",u(MOD,ACT,array('page'=>$page,'wufanli'=>1,'leixing'=>$leixing)));
	exit();
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
	$update['top_stime']=$top_stime?strtotime($top_stime):0;
	$update['top_etime']=$top_etime?strtotime($top_etime):0;
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
		$where.=" and title like '%".trim($_GET['title'])."%'";
		$page_arr['title']=$_GET['title'];
	}
	if($_GET['code']){
		$where.=" and code='".$_GET['code']."'";
		$page_arr['code']=$_GET['code'];
	}
	if($_GET['cid']){
		$where.=" and cid='".(int)$_GET['cid']."'";
		$page_arr['cid']=$_GET['cid'];
	}
	if($leixing==1){
		$where.=" and starttime>='".$j_time."' and starttime<='".TIME."'";
	}
	if($leixing==3){
		$where.=" and starttime>='".($j_time+3600*24)."' and starttime<='".($w_time+3600*24)."'";
	}
	if($leixing){
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