<?php
$webcache = 0;

if((BROWSER==0 || $_SERVER['HTTP_COOKIE']=='') && BACKSTAGE==0){ //如果后台执行不可用且不是浏览器访问，不执行计划任务
	return false;
}

if(rand(1,10)<=3){
	echo "<script src='".SITEURL."/index.php?mod=ajax&act=cron'></script>";
}

if(!empty($dd_cron)){
	foreach($dd_cron as $row){
		if(rand(1,10)<=$row['rate']){
			echo "\r\n<script src='".$row['url']."'></script>";
		}
	}
}

if (TIME - $webset['tao_report_time'] > 600 && TAOTYPE==2) { //自动获取淘宝订单
	$url = SITEURL . '/index.php?mod=tao&act=report&code=' . urlencode(authcode(TIME, 'ENCODE', DDKEY));
	dd_get($url);
	$webcache = 1;
}

if ($webset['paipai']['open'] == 1 && TIME - $webset['paipai_report_time'] > 3600) { //自动获取拍拍订单
	only_send(SITEURL . '/index.php?mod=paipai&act=report&code=' . urlencode(authcode(TIME, 'ENCODE', DDKEY)));
	$duoduo->update('webset', array (
		'val' => TIME
	), 'var="paipai_report_time"');
	$webcache = 1;
}

if ($webset['taoapi']['cache_time'] > 0 && TIME - $webset['tao_cache_time'] > $webset['taoapi']['cache_time'] * 3600) { //自动删除淘宝api缓存
	only_send(SITEURL . '/index.php?mod=cache&act=del&do=tao');
	$duoduo->update('webset', array (
		'val' => TIME
	), 'var="tao_cache_time"');
	$webcache = 1;
}

if ($webset['yiqifaapi']['open']==1 && $webset['yiqifaapi']['cache_time'] > 0 && TIME - $webset['yiqifa_cache_time'] > $webset['yiqifaapi']['cache_time'] * 3600) { //自动删除一起发api缓存
	only_send(SITEURL . '/index.php?mod=cache&act=del&do=yiqifa');
	$duoduo->update('webset', array (
		'val' => TIME
	), 'var="yiqifa_cache_time"');
	$webcache = 1;
}

if ($webset['wujiumiaoapi']['open']==1) {
	if($webset['wujiumiaoapi']['cache_time'] > 0 && TIME - $webset['wujiumiaoapi']['del_cache_time'] > $webset['yiqifaapi']['cache_time'] * 3600){ //自动删除59秒api缓存
		only_send(SITEURL . '/index.php?mod=cache&act=del&do=wujiumiao');
		$duoduo->update_serialize('wujiumiaoapi','del_cache_time',TIME);
	}
	$webcache = 1;
}

if ($webcache == 1) {
	$duoduo->webset(1);
}
?>