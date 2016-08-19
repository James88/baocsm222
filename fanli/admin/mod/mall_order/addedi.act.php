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
    $id=empty($_POST['id'])?0:(int)$_POST['id'];
	unset($_POST['id']);
	unset($_POST['sub']);
	
	if($_POST['uname']!=''){
		$user=$duoduo->select('user','*','ddusername="'.$_POST['uname'].'"');
		if(!$user['id']){
		   	jump('-1','会员不存在');
		}
	}
	
	if($id>0){
		$data=array('commission'=>(float)$_POST['commission'],'fxje'=>(float)$_POST['fxje'],'jifen'=>(int)$_POST['jifen'],'uid'=>$user['id']);
		$duoduo->update('mall_order',$data,'id="'.$id.'"');
		
		if($_POST['status']==1){
			$mall_order=$duoduo->select('mall_order','*','id="'.$id.'"');
			$duoduo->rebate($user,$mall_order,12); //确认商城返利
		}
		elseif($_POST['status']==-1){
	    	$data=array('f'=>'status','e'=>'=','v'=>-1);
			$duoduo->update('mall_order',$data,'id="'.$id.'"');
		}
		jump('-2','确认成功');
	}
	else{
		if($user['tjr']>0){
			$tgyj=round($fxje*$webset['tgbl']);
		}
		else{
			$tgyj=0;
		}
		$_POST['tgyj']=(float)$tgyj;
		unset($_POST['uname']);
		$_POST['uid']=(int)$user['id'];
		$_POST['order_time']=strtotime($_POST['order_time']);
		$adid_field=$lianmeng[$_POST['lm']]['adid'];
		$mall=$duoduo->select(get_mall_table_name(),'*','id="'.$_POST['mall_id'].'"');
		$_POST['adid']=$mall[$adid_field];
		$_POST['mall_name']=$mall['title'];
		
		$_POST['fxje']=fenduan($_POST['commission'],$webset['mallfxbl'],$user['type']);
        $_POST['jifen']=round($_POST['fxje']*$webset['jifenbl']);
		if($mall['type']==2){ //返积分
			$_POST['fxje']=0;
		}
		$_POST['addtime']=TIME;
		if($lianmeng[$_POST['lm']]['unique']=='o'){ //成果和多麦通过订单号可确定唯一
			$_POST['unique_id']=$_POST['order_code'];
		}
		elseif($lianmeng[$_POST['lm']]['unique']=='o*p'){ //领科特订单号加商品号确定唯一
			$_POST['unique_id']=$_POST['order_code'].'*'.$_POST['product_code'];
		}
		elseif($lianmeng[$_POST['lm']]['unique']=='u'){ //亿起发需填写唯一编号
			$_POST['unique_id']=$_POST['unique_id'];
		}
		
		if($_POST['status']==1){
			$_POST['qrsj']=TIME;
		}
		$mall_order=$duoduo->select('mall_order','*','unique_id="'.$_POST['unique_id'].'"');
		if($mall_order['id']>0){
			jump('-2','不能重复添加订单');
		}
		$id=$duoduo->insert('mall_order',$_POST);

		$_POST['relate_id']=$id;
		$_POST['id']=$id;
		if($user['id']>0 && $_POST['status']==1){
			$duoduo->rebate($user,$_POST,12); //确认商城返利
		}
		
		jump('-2','添加完成');
	}
}
else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
    if($id==0){
		$malls=mall_pinyin($duoduo);
	}
	else{
	    $row=$duoduo->select(MOD,'*','id="'.$id.'"');
	}
}
?>