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
define('INDEX',1);
$keyword=$_POST['keyword']?$_POST['keyword']:'';
if($_POST['sub']!=''){
	if($keyword==''){
		jump(-1,'关键词不能为空！');
	}
}
$page_url_arr[]=array('name'=>'淘宝商品列表','url'=>u('tao','list',array('cid'=>0,'q'=>$keyword)));
$page_url_arr[]=array('name'=>'淘宝打折商品','url'=>u('tao','zhe',array('q'=>$keyword)));
$page_url_arr[]=array('name'=>'晒单分享商品','url'=>u('baobei','list',array('cid'=>0,'q'=>$keyword)));
$page_url_arr[]=array('name'=>'团购商品','url'=>u('tuan','list',array('q'=>$keyword)));
$page_url_arr[]=array('name'=>'拍拍商品','url'=>u('paipai','list',array('q'=>$keyword)));