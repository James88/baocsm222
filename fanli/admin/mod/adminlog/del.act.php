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
jump(-1,'禁止删除操作日志');
/*if(!empty($ids)){
    $ids=implode($ids,',');
    $re=$duoduo->delete_id_in($ids);
    if($re==1){
        jump('-1','删除完成');
    }
    else{
        echo "error";
    }
}
elseif($_GET['sday']!='' || $_GET['eday']!=''){
    if($_GET['sday']==''){$sday=0;}else{$sday=strtotime($_GET['sday'].' 00:00:00');}
	if($_GET['eday']==''){$eday=9999999999;}else{$eday=strtotime($_GET['eday'].' 23:59:59');}
	$duoduo->delete(MOD,'addtime>="'.$sday.'" and addtime<="'.$eday.'"');
	jump('-1','删除完成');
}
else{
	jump('-1','请选择日期');
}*/
?>