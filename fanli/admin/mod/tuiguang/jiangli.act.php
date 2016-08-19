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

$huobi_arr=array(1=>'金额',TBMONEY,'积分');
if($webset['baoliao_jiangli_huobi']==''){
	$webset['baoliao_jiangli_huobi']=1;
}
if($webset['baoliao_jiangli_value']==''){
	$webset['baoliao_jiangli_value']=0;
}
if($webset['baoliao_jiangli_bili']==''){
	$webset['baoliao_jiangli_bili']=0;
}
include(ADMINROOT.'/mod/public/set.act.php');