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
$url='http://gb.weather.gov.hk/cgi-bin/hko/ntimec.pl';
$a=compact_html(iconv('gbk','utf-8//IGNORE',dd_get($url)));
preg_match('/<h2>时间:(.*)<br>/',$a,$b);
preg_match('#(\d\d)/(\d\d)/(\d{4})(\d\d:\d\d:\d\d)#',$b[1],$a);

$beijing_time=strtotime($a[3].'-'.$a[2].'-'.$a[1].' '.$a[4]);
if($beijing_time==0){
	$beijing_time=time();
}

if($_POST['sub']!=''){
    $a=$beijing_time-time();
	$data=array('val'=>$a);
	$duoduo->update('webset',$data,'var="corrent_time"');
	$duoduo->webset(1);
	jump(-1,'设置完毕');
}
?>