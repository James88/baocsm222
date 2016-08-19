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
/*$offer=$webset['offer']['status'];
$gametask=$webset['gametask']['status'];
$douwan=$webset['douwan']['status'];
if($offer==0 && $gametask==0 && $douwan==0){
	jump(u('index'),'请联系站长开启任务模块！');
}*/
$jump=1;
foreach($task_type_arr as $k=>$v){
	if($webset[$k]['status']==1){
		$jump=0;
		$t_num++;
	}
}
if($jump==1){
	jump(u('index'),'请联系站长开启任务模块！');
}
$n=$t_num%2;
?>