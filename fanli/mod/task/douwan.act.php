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
$offer=$webset['douwan'];
$offer['siteid'] = $webset['siteid'];

if(empty($offer['siteid']) || $offer['siteid']<=0){
	jump(u('task','index'),'请进入后台任务模块三开启');
}
if($offer['status']==0){
	jump(u('task','index'),'后台任务模块三未开启');
}
if($dduser['id']){
	$memberid=urlencode($offer['siteid'].'|'.$dduser['id']);
}else{
	$memberid='';
}

$total=$duoduo->sum('task','point','memberid="'.$dduser['id'].'" and type="douwan"');
$info=$duoduo->select_all('task as a,user as b','a.programname,a.point,b.ddusername','a.memberid=b.id  and a.type="douwan" order by addtime desc limit 0,12');
?>