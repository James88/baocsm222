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

function set_user_tbnick($duoduo,$uid){
	$tbnick=$_GET['tbnick'];
	foreach($tbnick as $k=>$v){
		if($v==''){
			unset($tbnick[$k]);
		}
	}
	if(empty($tbnick)){
		$json_data=array ("s" => 0,'r'=>'请输入淘宝帐号或者订单号！');
		return $json_data;
	}
	//先取数据
	$trade_uid_arr=array();
	$u_trade_uid="";
	if(!empty($tbnick)){
		foreach($tbnick as $v){
			$a=get_4_tradeid($v);
			if($a['0']>0){
				$trade_uid_arr[]=$a['0'];//存进去
				$u_trade_uid.=($u_trade_uid?',':'').$v;
			}
		}
		if(empty($trade_uid_arr)||empty($u_trade_uid)){
			//jump(-1,'服务器异常不能修改');
			$json_data=array ("s" => 0,'r'=>'服务器异常不能修改');
			return $json_data;
		}
	}else{
		//jump(-1,'只能修改，不能提交空数据');
		$json_data=array ("s" => 0,'r'=>'只能修改，不能提交空数据');
		return $json_data;
	}
	//删除老数据
	$tbnick_arr=explode(',',$dduser['tbnick']);
	$tbnick_arr=array_unique($tbnick_arr);
	foreach($tbnick_arr as $v){
		$a=get_4_tradeid($v);
		if($a['0']>0){
			$duoduo->trade_uid($uid,$a['0'],'del');
		}
	}
	//更新数据
	foreach($trade_uid_arr as $v){
		if($v){
			$duoduo->trade_uid($uid,$v);
		}
	}
	$field_arr=array('tbnick'=>$u_trade_uid);
	$duoduo -> update('user', $field_arr, 'id=' . $uid);
	$json_data=array ("s" => 1);
	return $json_data;
}
		

function act_wap_user_tbnick(){
	global $duoduo,$dd_tpl_data;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	
	if($dduser['id']==0){
		jump(wap_l('user','login'));
	}

	if($_GET['sub']!=''){
		$re=set_user_tbnick($duoduo,$dduser['id']);
		exit(dd_json_encode($re));
	}
	
	$title='跟单设置';
	$webtitle=$title.'-'.$dd_tpl_data['title'];
	
	$tbnick_arr=explode(',',$dduser['tbnick']);
	if($tbnick_arr[0]!=''){
		$tbnick_arr[]='';
	}
	
	unset($duoduo);
	unset($webset);
	unset($dduser);
	unset($dd_tpl_data);
	$parameter['webtitle']=$webtitle;
	$parameter['tbnick_arr']=$tbnick_arr;
	return $parameter;
}
?>