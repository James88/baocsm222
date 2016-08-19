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

function act_wap_list(){
	global $duoduo,$dd_tpl_data;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;

	$sort_arr=array('total_sales_desc'=>'销量','tk_total_sales_desc'=>'推广');
	$sort=$_GET['sort']?$_GET['sort']:'total_sales_desc';
	$q=$_GET['q']?$_GET['q']:'热卖';
	$_GET['page']=$_GET['page']?$_GET['page']:1;
	$page=$_GET['page'];

	$ddTaoapi = new ddTaoapi();
	$data=array('page_no'=>$page,'page_size'=>40,'q'=>$q,'sort'=>$sort);
	$shuju_data=$ddTaoapi->taobao_tbk_item_get($data);
	$shuju_data=$shuju_data['s']==1?$shuju_data['r']:'';
	$num_iids='';
	foreach($shuju_data as $k=>$row){
		$shuju_data[$k]['img']=tb_img($row['pict_url'],'b');
		$shuju_data[$k]['url']=wap_l('tao','view',array('iid'=>$row['num_iid']));
		$num_iids.=','.$row['num_iid'];
	}
	
	$num_iids=preg_replace('/^,/','',$num_iids);
	$b=$ddTaoapi->taobao_taobaoke_rebate_auth_get($num_iids,3);
	foreach($b as $k=>$row){
		$b['a'.$row['param']]=$row['rebate'];
		unset($b[$k]);
	}
	foreach($shuju_data as $k=>$row){
		if(!isset($b['a'.$row['num_iid']])){
			$b['a'.$row['num_iid']]=1;
		}
		$shuju_data[$k]['rebate']=(int)$b['a'.$row['num_iid']];
		$shuju_data[$k]['rebate_word']=$shuju_data[$k]['rebate']==1?'有返利':'无返利';
	}

	$webtitle=$q.'-'.$dd_tpl_data['title'];
	
	if(AJAX==1){
		echo dd_json_encode(array('s'=>1,'r'=>$shuju_data));
		dd_exit();
	}
	unset($duoduo);
	unset($webset);
	unset($dduser);
	unset($dd_tpl_data);
	$parameter['shuju_data']=$shuju_data;
	$parameter['sort_arr']=$sort_arr;
	$parameter['sort']=$sort;
	$parameter['page']=$page;
	$parameter['q']=$q;
	$parameter['webtitle']=$webtitle;
	return $parameter;
}
?>