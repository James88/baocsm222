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

$ids=$_GET['ids'];
$table=$_GET['table']?$_GET['table']:MOD;
if($ids==''){
    jump('-1','无效参数');
}
else{
	$d=$duoduo->get_table_struct(MOD);
	$ids=implode($ids,',');
	$do=$_GET['do'];
	if($do=='' && empty($d['del'])){
		$do='del';
	}
	if($do=='' && !empty($d['del'])){
		$duoduo->update($table,array('del'=>1),'id IN('.$ids.')',DEFAULT_SORT);
		$reycle=1;
		$word='已经转移至回收站';
	}
	elseif($do=='del'){
		$duoduo->delete_id_in($ids,$table);
		$word='删除完成';
	}
	elseif($do=='reset'){
		$duoduo->update($table,array('del'=>0),'id IN('.$ids.')',DEFAULT_SORT);
		$word='还原完成';
	}
	$error=mysql_error();
	
	if(function_exists(MOD.'_'.ACT)){
		$fun=MOD.'_'.ACT;
		$fun($ids);
	}
	
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
		
		if(in_array(MOD,$duoduo->sql_cache_table_arr)){
			del_ddcache('','sql/'.MOD);
		}
		
        jump($to,$word);
    }
    else{
        echo $error;
    }
}
?>