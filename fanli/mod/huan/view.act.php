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
* @name 兑换详情
* @copyright duoduo123.com
* @example 示例huan_view();
* @param $pagesize 每页数量12
* @param $field 字段
* @return $parameter 结果集合
*/
function act_huan_view($pagesize=12,$field="id,title,img,jifenbao,jifen,num,`limit`,content,sdate,edate"){
	global $duoduo;
	$webset=$duoduo->webset;
	$dduser=$duoduo->dduser;
	$msgset=dd_get_cache('msgset');
	
	if(($webset['sms']['open']==1 && $webset['sms']['need_yz']==1) && ($msgset[4]['sms_open']==1 || $msgset[5]['sms_open']==1) && $dduser['mobile_test']==0){ //提现短信开启
		$huan_sms_open=1;
	}
	else{
		$huan_sms_open=0;
	}
	
	if($huan_sms_open==1 && $dduser['id']>0 && ($dduser['mobile']=='' || $dduser['mobile_test']==0)){
		jump(u('user','info',array('do'=>'mobile')),'请验证您的手机号码');
	}
	
	//类型
	$type_all=dd_get_cache('type');
	$huan_type=$type_all['huan_goods'];
	foreach($huan_type as $k=>$v){
		$huan_type_arr[$k]['url']=u('huan','list',array('cid'=>$k));
		$huan_type_arr[$k]['title']=$v;
	}
	$id =(int)$_GET['id'];
	$good=$duoduo->select('huan_goods',$field,'id="'.$id.'"');
	$good['_jifenbao']=jfb_data_type($good['jifenbao']);
	$good['_sdate']=date('Y-m-d',$good['sdate']);
	$good['_edate']=date('Y-m-d',$good['edate']);
	if($good['limit']==0){ //兑换无限制，最多兑换商品全部数量
		$good['limit']=$good['num'];
	}
	else{
		if($good['limit']<=$good['num']){ //兑换限制比商品总数少
			$good['limit']=$good['limit'];
		}
		else{
			$good['limit']=$good['num'];
		}
	}
	
	$jifenbao_dh_status=1;
	$jifen_dh_status=1;
	$jifenbao_dh_msg=TBMONEY.'兑换';
	$jifen_dh_msg='积分兑换';
	
	if($good['num']<=0){
		$jifenbao_dh_status=0;
		$jifen_dh_status=0;
		$jifenbao_dh_msg='暂无库存';
		$jifen_dh_msg='暂无库存';
	}
	
	if($dduser['id']>0){
		if($dduser['dhstate']==1){
			$jifenbao_dh_status=0;
			$jifenbao_dh_msg='您提交的兑换申请正在处理中';
			$jifen_dh_status=0;
			$jifen_dh_msg='您提交的兑换申请正在处理中';
		}
		else{
			if($dduser['live_jifenbao']<$good['jifenbao']){
				$jifenbao_dh_status=0;
				$jifenbao_dh_msg='您的'.TBMONEY.'不足';
			}
			if($dduser['live_jifen']<$good['jifen']){
				$jifen_dh_status=0;
				$jifen_dh_msg='您的积分不足';
			}
		}
	}
	unset($duoduo);
	$parameter['good']=$good;
	$parameter['huan_type']=$huan_type;
	$parameter['huan_type_arr']=$huan_type_arr;
	$parameter['jifen_dh_status']=$jifen_dh_status;
	$parameter['jifen_dh_msg']=$jifen_dh_msg;
	$parameter['jifenbao_dh_msg']=$jifenbao_dh_msg;
	$parameter['jifenbao_dh_status']=$jifenbao_dh_status;
	$parameter['id']=$id;
	$parameter['form1_url']=u('ajax','huan');
	return $parameter;
}
?>