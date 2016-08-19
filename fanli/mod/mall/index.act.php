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
* @name 商城列表
* @copyright duoduo123.com
* @example 示例mall_lists();
* @param $pagesize 每页显示多少
* @return $parameter 结果集合
*/
function act_mall_index($pagesize=30,$field='id,title,url,img,cid,fan,des,score,pjnum'){
	global $duoduo;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	$page = isset($_GET['page'])?intval($_GET['page']):1;
	$frmnum=($page-1)*$pagesize;
	$mall_name=isset($_GET['q'])?trim($_GET['q']):'';
	$q=isset($_GET['cid'])?$_GET['cid']:'';
	$where='1';
	$page_arr=array();
	
	//商城类型
	$type_all=dd_get_cache('type');
	$mall_type=$type_all['mall'];
	
	$parameter['thiscatname']='返利商城';
	
	if(is_numeric($q)){ //cid是数组，栏目搜索
		$where.=" and cid = '$q'";
		$parameter['thiscatname']=$mall_type[$q];
	}
	elseif(preg_match('/^[a-zA-Z]{1}$/',$q)){ //cid不是数字 拼音首字母搜索
		$q=strtolower($q);
		$where='`pinyin` like "'.$q.'%"';
		$parameter['thiscatname']=$q.'-返利商城';
	}
	elseif($q!=''){
		error_html('参数错误',-1);
	}

	if($mall_name!=''){
		$where.=' and `title` like "%'.$mall_name.'%"';
		$parameter['thiscatname']=$mall_name;
	}
	
	$page_arr['q']=$q;
	
	//查找店铺数据库
	include(DDROOT.'/comm/mall.class.php');
	$mall_class=new mall($duoduo);
	
	$ajax=(int)$_GET['ajax'];
	
	if($ajax==0 && $webset['paipai']['open']==1){
		$paipai=1;
		$pagesize--;
		$paipai_arr=array(array('view'=>u('paipai','index'),'view_jump'=>u('paipai','index'),'title'=>'拍拍网','fan'=>'30%','img'=>'images/paipai.jpg','des'=>'京东旗下大型、安全网上交易平台，提供各类服饰、美容、家居、数码、母婴、珠宝'));
	}
	else{
		$paipai=0;
	}
	
	$data=$mall_class->select("$where order by sort=0 asc,sort asc,id desc limit $frmnum,$pagesize");
	
	if($paipai==1){
		$data=array_merge($paipai_arr,$data);
	}
	
	$parameter['malls']=$data;
	$parameter['mall_class']=$mall_class;
	$parameter['mall_type']=$mall_type;
	$parameter['q']=$q;
	$parameter['pagesize']=$pagesize;
	$parameter['total']=$mall_class->count();
	unset($duoduo);
	return $parameter;
}
?>