<?php
if (!defined('INDEX')) {
	exit ('Access Denied');
}
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<title><?=$webtitle?></title>
<base href="<?=SITEURL?>/" />
<?php
$css[]=TPLURL."/inc/css/common.css";
echo css($css);
unset($css);

$js[]=TPLURL.'/inc/js/jquery.js';
$js[]=TPLURL.'/inc/js/iscroll.js';
$js[]=TPLURL.'/inc/js/fun.js';
$js[]=TPLURL.'/inc/js/base64.js';
$js[]=TPLURL.'/inc/js/jquery.lazyload.js';
echo js($js);
unset($js);
?>
</head>
<body>