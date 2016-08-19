<?php
if(!defined('INDEX')){
	exit('Access Denied');
}

$bankuai_cache=dd_get_cache('bankuai');
$bankuai_tpl=$bankuai_cache[$_GET['code']]['bankuai_tpl'];
if($bankuai_tpl==''){
	$bankuai_tpl=$dd_tpl_data['bankuai_tpl'];
}
include(TPLPATH."/goods/".$bankuai_tpl."/list.tpl.php");
if(!defined('VIEW_PAGE')){exit;}
?>