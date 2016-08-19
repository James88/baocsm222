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
	$do=(int)$_POST['do'];
	if($do==1){  //退款订单
	    $re=$duoduo->refund($id,1);
		jump('-2',$re);
	}
	elseif($do==2){
		if($_POST['uname']==''){
			jump('-1','会员名不能为空');
		}
	    $user=$duoduo->select('user','id,ddusername,level,tjr','ddusername="'.$_POST['uname'].'"');
		if(!$user['id']){
		    jump('-1','会员不存在');
		}
		$trade=$duoduo->select('paipai_order','*','id="'.$id.'"');
		$duoduo->rebate($user,$trade,18); //确认拍拍返利
		jump('-2','确认成功');
	}
}
else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
    if($id==0){
	    $row=array();
	}
	else{
	    $row=$duoduo->select(MOD,'*','id="'.$id.'"');
	}
}
?>