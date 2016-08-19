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
$fenlei_arr[0]="全部";
ksort($fenlei_arr);

$baoyou_arr=array(0=>'不限',1=>'包邮');
$web_arr=array('0'=>'不限',1=>'选择');
$data_from_arr=array('0'=>'采集',1=>'淘宝api');

$fenlei_arr=array('关闭','网站分类');
$baoming_arr=array('0'=>'不参与',1=>'参与');
$tuijian_arr=array('0'=>'不推荐',1=>'推荐');
$quanju_arr=array('0'=>'不调用',1=>'调用');
$yugao_arr=array('0'=>'不开启',1=>'开启');
function bankuai_cache(){
	global $duoduo;
	$a=$duoduo->select_all('bankuai','*','1 order by sort=0 ASC,tuijian desc,sort asc');
	foreach($a as $row){
		$bankuai[$row['code']]=$row;
	}
	dd_set_cache('bankuai',$bankuai);
}

function bankuai_del(){
	bankuai_cache();
}
?>