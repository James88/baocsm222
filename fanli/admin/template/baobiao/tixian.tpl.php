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
$jiesuan_arr[]=array('url'=>'http://www.alimama.com/member/login.htm','pic'=>'images/alimama.png');
$jiesuan_arr[]=array('url'=>DD_U_URL.'/index.php?g=home&m=product_report&a=index&name='.URL,'pic'=>'images/duoduo.jpg');
if($webset['paipai']['open']==1){
$jiesuan_arr[]=array('url'=>'http://union.paipai.com','pic'=>'images/paipai.jpg');
}
if($webset['duomai']['status']==1){
	$jiesuan_arr[]=array('url'=>'http://www.duomai.com/index.php?m=siter&a=login','pic'=>'images/duomai.jpg');
}
if($webset['weiyi']['status']==1){
	$jiesuan_arr[]=array('url'=>'http://www.weiyi.com/','pic'=>'images/weiyi.jpg');
}
if($webset['wujiumiao']['status']==1){
	$jiesuan_arr[]=array('url'=>'http://u.59miao.com/login/','pic'=>'images/59miao.png');
}
if($webset['yiqifa']['status']==1){
	$jiesuan_arr[]=array('url'=>'http://www.yiqifa.com/','pic'=>'images/yiqifa.jpg');
}
if($webset['linktech']['status']==1){
	$jiesuan_arr[]=array('url'=>'http://www.linktech.cn/newhome/','pic'=>'images/linktech.jpg');
}
if($webset['chanet']['status']==1){
	$jiesuan_arr[]=array('url'=>'http://www.chanet.com.cn/index.htm','pic'=>'images/chanet.jpg');
}

include(ADMINTPL.'/header.tpl.php');
?>
<style>
.jiesuan{ width:220px; height:90px; float:left; margin-bottom:10px;}
.jiesuan .imgs{ padding:10px; padding-bottom:0; width:150px; margin:auto;}
.jiesuan .imgs img{ max-width:150px; max-height:60px;}
.jiesuan .title{ padding-top:10px; text-align:center;}
</style>
<?php foreach($jiesuan_arr as $v){?>
<div class="jiesuan">
    <div class="imgs"><a target="_blank" href="<?=$v['url']?>"><img src="<?=$v['pic']?>" /></a></div>
    <div class="title" ><a target="_blank" href="<?=$v['url']?>">点击查看</a></div>
</div>
<?php }?>
<?php include(ADMINTPL.'/footer.tpl.php');?>