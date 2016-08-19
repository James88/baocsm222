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

function act_wap_goods(){
	global $duoduo,$dd_tpl_data;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	
	include(DDROOT.'/comm/goods.class.php');
	$goods_class=new goods($duoduo);
	
	$page=$_GET['page']?$_GET['page']:1;
	$code=$_GET['code'];
	$cid=(int)$_GET['cid'];
	$pagesize=20;
	$fromnum=($page-1)*$pagesize;
	
	$bankuai=dd_get_cache('bankuai');
	$where='1';
	$title='全部商品';
	
	if($code!=''){
		$where.=' and code="'.$code.'"';
		$title=$bankuai[$code]['title'];
	}
	if($cid>0){
		$where.=' and cid="'.$cid.'"';
		$title=$bankuai[$code]['title'];
	}

	$shuju_data=$goods_class->index_list(array('code'=>$code),$pagesize,$page,'(laiyuan_type in(1,2) or domain="jd.com") and '.$where);
	foreach($shuju_data as $k=>$row){
		if($row['id']){
			$shuju_data[$k]['url']=wap_l('goods','view',array('id'=>$row['id'],'rec'=>$dduser['id']));
		}
		else{
			$shuju_data[$k]['url']=wap_l('goods','view',array('iid'=>$row['data_id'],'rec'=>$dduser['id']));
		}
		$shuju_data[$k]['bankuai_title']=$bankuai[$row['code']]['title'];
		$shuju_data[$k]['img']=tb_img($row['img'],200);
	}
	
	if(AJAX==1){
		echo dd_json_encode(array('s'=>1,'r'=>$shuju_data));
		dd_exit();
	}

	$parameter['shuju_data']=$shuju_data;
	$parameter['code']=$code;
	$parameter['title']=$bankuai[$code]['title'];
	$parameter['webtitle']=$title.'-首页';
	unset($duoduo);
	unset($webset);
	unset($dduser);
	unset($dd_tpl_data);
	return $parameter;
}
?>