<?php
if (!defined('INDEX')) {
	exit ('Access Denied');
}

$webset['advertise']=$webset['advertise']?$webset['advertise']:'口袋中的购物返利神器！';
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

$js['a']=TPLURL.'/inc/js/jquery.js';
$js[]=TPLURL.'/inc/js/iscroll.js';
$js[]=TPLURL.'/inc/js/fun.js';
echo js($js);
unset($js);
?>
</head>
<body>
<div class="header" style="background:<?=$dd_tpl_data['color']?>;" >
  <dl>
    <dt><span class="span1 left"><img src="<?=$dd_tpl_data['logo']?>" style="width:100px;"></span><span class="span2 left"></span><span class="span3 left"><?=$dd_tpl_data['advertise']?></span><a href="<?=wap_l('user')?>" title="会员中心"><span class="span4 right"></span></a></dt>
    <dd>
<form action="" method="get" name="searchForm" target="_blank" id="searchForm" onsubmit="return s8Tijiao($(this))">
<input type="hidden" name="mod" value="tao" /><input type="hidden" name="act" value="search" />
	<input name="q" class="text keyW" id="keywords" value="<?=$webset['search_key']['wap']?>" placeholder="输入您想要买的商品名称" style="color:#999;" type="text">
	<input class="button" value="" type="submit">
</form>
</dd>
  </dl>
</div>