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
	if(array_search(1,$ids)!==false||array_search(2,$ids)!==false||array_search(3,$ids)!==false){
		jump(-1,'包邮、改拍和专享是系统属性，不能删除');
	}
	$ids=implode($ids,',');	
	$duoduo->delete_id_in($ids,$table);
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
        jump($to,"删除完成");
    }
    else{
        echo $error;
    }
}
?>