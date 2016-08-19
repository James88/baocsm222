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
	del_magic_quotes_gpc($_POST,1);
	$add=array();
	$add['status']=$_POST['status'];
	$add['title']=$_POST['title'];
	$add['beizhu']=$_POST['beizhu'];
	$add['code']=$_POST['code'];
	$add['laiyuan']=$_POST['laiyuan'];
	$add['admin_name']=$_SESSION['ddadmin']['name'];
	$id=$_POST['id'];
	if($add['laiyuan']==2){
		//淘宝api独有的
		$add['web_cid']=$_POST['web_cid'];
		$add['api_kwd']=$_POST['api_kwd'];
		$add['api_cid']=$_POST['api_cid'];
		$add['api_sort']=$_POST['api_sort'];
		$add['is_mall']=$_POST['is_mall'];
		$add['start_price']=(float)$_POST['start_price'];
		$add['end_price']=(float)$_POST['end_price'];
		$add['start_tk_rate']=(float)$_POST['start_tk_rate']*100;
		$add['end_tk_rate']=(float)$_POST['end_tk_rate']*100;
		$add['page_no']=(float)$_POST['page_no'];
		$add['page_size']=(float)$_POST['page_size'];
	}else{
		//综合平台
		$add['api_url']=$_POST['api_url'];
		$add['sprice']=(float)$_POST['sprice'];
		$add['eprice']=(float)$_POST['eprice'];
		$add['yun_cid']=serialize($_POST['yun_cid']);
	}
	if($id==0){
	    $id=$duoduo->insert('collect',$add);
		echo mysql_error();
		$word='保存成功';
	}
	else{
	    $duoduo->update('collect',$add,'id="'.$id.'"');
		echo mysql_error();
		$word='修改成功';
	}
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
	$collect_api=$ddu_class->collect_api_list();
	if($data['s']==0&&$data['r']){
		jump(-1,$data['r']);
	}
	$collect_api_list=$collect_api['r'];

	$bankuai=$duoduo->select_all('bankuai','id,code,title','1 order by id desc');
	foreach($bankuai as $key=>$vo){
		if($key==0){
			$bankuai_first=$vo['code'];
		}
		$bankuai_arr[$vo['code']]=$vo['title'];
	}
	$type=$duoduo->select_all('type','id,title',"tag='goods'");
	foreach($type as $vo){
		$web_cid_arr[$vo['id']]=$vo['title'];
	}
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
	$do=$_GET['do'];
    if($id==0){
	    $row=array();
	}
	else{
	    $row=$duoduo->select('collect','*','id="'.$id.'"');
		$row['start_tk_rate']=$row['start_tk_rate']/100;
		$row['end_tk_rate']=$row['end_tk_rate']/100;
		$row['yun_cid']=unserialize($row['yun_cid']);
	}
	if($row['code']||$bankuai_first){
		$bankuai_web_cid=$duoduo->select("bankuai",'web_cid',"code='".($row['code']?$row['code']:$bankuai_first)."'");
		$bankuai_web_cid=unserialize($bankuai_web_cid);
	}
	$type=$duoduo->select_all('type','*',"tag='goods'");
	
	foreach($type as $vo){
		if($bankuai_web_cid){
			if(in_array($vo['id'],$bankuai_web_cid)){
				$cid_arr[$vo['id']]=$vo['title'];
			}
		}else{
			$cid_arr[$vo['id']]=$vo['title'];
		}
	}
	$cid_arr[0]="不采集";
}
?>