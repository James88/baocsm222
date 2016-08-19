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

$ids_arr=$_GET['ids'];
if($ids_arr==''){
    jump('-1','无效参数');
}
else{
	$d=$duoduo->get_table_struct(MOD);
	$ids=implode($ids_arr,',');
	$do=$_GET['do'];
	
	if($do=='' && empty($d['del'])){
		$do='del';
	}
	if($do=='' && !empty($d['del'])){
		foreach($ids_arr as $id){
			$status=$duoduo->select(MOD,'status','id='.$id);
			if($status==0){
				jump(-1,'提现ID：'.$id.'状态为审核中，不能删除！');
			}
			$duoduo->update(MOD,array('del'=>1),'id ="'.$id.'"');
		}
		$reycle=1;
		$word='已经转移至回收站';
	}
	elseif($do=='del'){
		foreach($ids_arr as $id){
			$wait=$duoduo->select(MOD,'wait','id='.$id);
			if($wait==1){
				jump(-1,'提现ID：'.$id.'正等待平台返回数据，不能删除！');
			}
			$duoduo->delete(MOD,'id='.$id);
		}
		$word='删除完成';
	}
	elseif($do=='reset'){
		$duoduo->update(MOD,array('del'=>0),'id IN('.$ids.')',DEFAULT_SORT);
		$word='还原完成';
	}
	$error=mysql_error();
    if(empty($error)){
		include(ADMINROOT.'/mod/public/mod.update.php');
		if($reycle==1){
			$to=$_SERVER['HTTP_REFERER'].'&reycle=1';
			$to=preg_replace('/&page=\d+/','',$to);
			$to=str_replace('&page=','',$to);
		}
		else{
			$to=-1;
		}
        jump($to,$word);
    }
    else{
        echo $error;
    }
}
?>