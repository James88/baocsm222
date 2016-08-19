<?php
if(!defined('INDEX')){
	exit('Access Denied');
}

$parameter=dd_act();
extract($parameter);

if($search_url_tip==1){
	$css[]=TPLURL."/inc/css/flbz.css";
	if($webset['taoapi']['s8']==1){
		$goods['title'] = '亲，请使用淘宝/天猫商品的标题搜索拿返利吧！';
		include(TPLPATH.'/inc/header.tpl.php');
		include(TPLPATH.'/help/search_tpl.tpl.php');
	}
	else{
		$goods['title'] = '搜索提醒';
		include(TPLPATH.'/inc/header.tpl.php');
		include(TPLPATH.'/help/guang_tip.tpl.php');
	}
	include(TPLPATH.'/inc/footer.tpl.php');
}
else{
	include(TPLPATH.'/tao/view_goods.tpl.php');
}
?>