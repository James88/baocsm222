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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>菜单列表</title>
<script src="../js/jquery.js" type="text/javascript"></script>
<script src="js/prototype.lite.js" type="text/javascript"></script>
<script src="js/moo.fx.js" type="text/javascript"></script>
<script src="js/moo.fx.pack.js" type="text/javascript"></script>
<style>
body {
	font:12px Arial, Helvetica, sans-serif;
	color: #000;
	background-color: #EEF2FB;
	margin: 0px;
}
#container {
	width: 182px;
}
H1 {
	font-size: 12px;
	margin: 0px;
	width: 182px;
	cursor: pointer;
	height: 30px;
	line-height: 20px;	
}
H1 a {
	display: block;
	width: 182px;
	color: #000;
	height: 30px;
	text-decoration: none;
	moz-outline-style: none;
	background-image: url(images/menu_bgs.gif);
	background-repeat: no-repeat;
	line-height: 30px;
	text-align: center;
	margin: 0px;
	padding: 0px;
}
.content{
	width: 182px;
	height: auto;
	overflow:hidden
	
}
.MM ul {
	list-style-type: none;
	margin: 0px;
	padding: 0px;
	display: block;
}
.MM li {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 26px;
	color: #333333;
	list-style-type: none;
	display: block;
	text-decoration: none;
	height: 26px;
	width: 182px;
	padding-left: 0px;
}
.MM {
	width: 182px;
	margin: 0px;
	padding: 0px;
	left: 0px;
	top: 0px;
	right: 0px;
	bottom: 0px;
	clip: rect(0px,0px,0px,0px);
}
.MM a {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 26px;
	color: #333333;
	background-image: url(images/menu_bg1.gif);
	background-repeat: no-repeat;
	height: 26px;
	width: 182px;
	display: block;
	text-align: center;
	margin: 0px;
	padding: 0px;
	overflow: hidden;
	text-decoration: none;
}
.MM a.cur{color: #006600; background-image:url(images/menu_bg2.gif); font-weight:bold}
.MM a.hover{color: #006600; font-weight:bold}

</style>
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEF2FB">
  <tr>
    <td width="182" valign="top"><div id="container">
     <div style="width:170px; margin:5px auto; height:23px;"><form name="form1" action="" method="get" target="main"><input type="hidden" name="mod" value="menu"><input type="hidden" name="act" value="s_list"><input style="width:110px; color:#999" type="text" name="q" value="搜索后台管理菜单" onclick="this.value=''"/>&nbsp;<input type="submit" value="搜索" /></form>
     </div>
    <?php 
	foreach($menu_arr as $key=>$row){
	if($parent_menu[$key]['hide']==0){
	?>
      <h1 class="type"><a href="javascript:void(0)"><?=$parent_menu[$key]['title']?></a></h1>
      <div class="content">
        <div><img src="images/menu_topline.gif" width="182" height="5" /></div>
        <ul class="MM" style="background:#999">
        <?php foreach($row as $arr){if($arr['hide']==0){ if($arr['url']!=''){$daohang_url=$arr['url'];}else{$daohang_url=u($arr['mod'],$arr['act']);}?>
          <li><a href="<?=$daohang_url?>" target="main"><?=$arr['title']?></a></li>
        <?php }}?>
        </ul>
      </div>
    <?php }}?>
      </div>
    </td>
  </tr>
</table>
<script type="text/javascript">
var contents = document.getElementsByClassName('content');
var toggles = document.getElementsByClassName('type');
	
var myAccordion = new fx.Accordion(
	toggles, contents, {opacity: true, duration: 400}
);
myAccordion.showThisHideOpen(contents[0]);

jQuery.noConflict();
jQuery(function(){
    jQuery('.MM a').click(function(){
		jQuery('.MM a').removeClass('cur');
        jQuery(this).addClass('cur');
	});
	
	jQuery('.MM a').hover(function(){
	     jQuery(this).addClass('hover');
	},function(){
	     jQuery(this).removeClass('hover');
	});
})

/*delay=200;
timeUnit=1;
heightUnit=5;

function showMenu(t,liNum){
	lastH=parseInt($(t).height());
	nowH=lastH+heightUnit;
	$(t).height(nowH);
	if(nowH>=26*liNum){
		$(t).height('auto')
	    window.clearInterval(int);
	}
}

$(function(){
    $('.content').hide();
	$theMenu=$('.content').eq(0);
	$theMenu.css('height','1px').show();
	liNum=$theMenu.find('li').size();
	setTimeout('int=self.setInterval("showMenu($theMenu,liNum)",timeUnit)',delay);
	$('.type').click(function(){
	    $('.content').hide('slow');
		$theMenu=$(this).next('.content');
	    $theMenu.css('height','1px').show();
		liNum=$theMenu.find('li').size();
	    setTimeout('int=self.setInterval("showMenu($theMenu,liNum)",timeUnit)',delay);
	});
	$('.MM a').click(function(){
		$('.MM a').removeClass('hover');
        $(this).addClass('hover');
	});
})*/
</script>
</body>
</html>