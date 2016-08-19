<?php
/**
 * ============================================================================
 * 版权所有 2008-2012 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
include_once '../comm/dd.config.php';
include (DDROOT.'/comm/checkpostandget.php');

$p_arr=array('get59miao','getchanet','getddopen','getduomai','getlinktech','getweiyi','getyiqifa','getyqh');
$p=$_GET['p'];
if(!in_array($p,$p_arr)){
	dd_exit('miss p');
}
else{
	define('PAGE',$p);
	include(DDROOT.'/page/'.$p.'.php');
}

$duoduo->close();
unset ($duoduo);
unset ($ddTaoapi);
unset ($webset);
?>