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
	$status=$_POST['status'];
	if($id>0 && $status==0){
		$shijian=7;
		$m_id=$duoduo->select('mingxi','id','source="'.$id.'" and shijian="'.$shijian.'"');

		if(empty($m_id)){
			$jifen=(int)$webset['baobei']['shai_jifen'];
			$jifenbao=(float)$webset['baobei']['shai_jifenbao'];
			if($jifen>0 || $jifenbao>0){
				$uid=$duoduo->select('baobei','uid','id="'.$id.'"');
				$user_update=array(array('f'=>'jifen','e'=>'+','v'=>$jifen),array('f'=>'jifenbao','e'=>'+','v'=>$jifenbao));
				$duoduo->update_user_mingxi($user_update,$uid,$shijian,$id);
			}
		}
	}
}
include(ADMINROOT.'/mod/public/addedi.act.php');