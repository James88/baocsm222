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

$q=$_GET['q'];
$url=$q;
$t=0;
if($q==''){
	jump(-1,'搜索内容不能为空');
}
$domain=get_domain($url);
if($domain!=''){//判断是否是网址
	if(strpos($url,'http')!==0){
		$url='http://'.$url;
	}
	$taobao_r = strpos($url,'taobao.com');
	$tmall_r = strpos($url,'tmall.com');
	
	if($taobao_r>0 || $tmall_r>0){//判断是否是淘宝网址
		$t=1;
		jump(l('tao','view',array('q'=>$url)));
	}
	
	$paipai_r = strpos($url,'paipai.com');
	$wanggou_r = strpos($url,'wanggou.com');
	if($paipai_r>0 || $wanggou_r>0){//判断是否是拍拍网址
		$t=1;
		jump(l('paipai','list',array('q'=>$url)));
	}
	
	$chong_mall_url=include(DDROOT.'/data/chong_mall_url.php');
	foreach($chong_mall_url as $vo){
		if($vo['type']==1){
			if(strpos($url,$vo['host'])!==false){
				$mid=(int)$duoduo->select(get_mall_table_name(),'id','url like "%'.$vo['host'].'%" and is_search=0 and del=0 and edate>"'.strtotime(date('Ymd')).'"');
			}
		}elseif($vo['type']==0){
			if(strpos($url,get_domain($vo['host']))!==false){
				$mid=(int)$duoduo->select(get_mall_table_name(),'id','url like "%'.$vo['host'].'%" and is_search=0 and del=0 and edate>"'.strtotime(date('Ymd')).'"');
			}
		}
		if($mid){
			break;
		}
	}
	if(empty($mid)){
		$mid=(int)$duoduo->select(get_mall_table_name(),'id','domain="'.$domain.'" and is_search=0 and del=0 and edate>"'.strtotime(date('Ymd')).'"');
	}

	if($mid > 0){//判断是否网站是否添加了该商城
		$t=1;
		$url=l('mall','view',array('id'=>$mid,'url'=>$url));
		jump($url);
	}else{
		/*$mid = $duoduo->select('mall','id','domains like "%'.$domain.'%"');
		if($mid>0){
			$t=1;
			$url=SITEURL.'/?mod=mall&act=view&id='.$mid.'&url='.urlencode($url);
			jump($url);
		}*/
	}
	if($t==0){
		jump(-1,'暂不支持该网址搜索');
	}
}else{//不是网址时做以下处理
	$mid = $duoduo->select(get_mall_table_name(),'id','title like "%'.$q.'%" and is_search=0 and del=0 and edate>"'.strtotime(date('Ymd')).'"');
	if($mid > 0){//判断是否网站是否添加了该商城
		$t=1;
		jump(l('mall','view',array('id'=>$mid)));
	}
	if($_GET['do']=='mall'){
		echo script('alert("没有匹配商城");window.close()');
	}
	jump(l('jump','s8',array('name'=>$q)));
}
?>