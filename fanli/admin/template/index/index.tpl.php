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
<html>
<head>
<title>管理中心</title>
<meta http-equiv=Content-Type content=text/html;charset=utf-8>
</head>
<frameset rows="64,*" id="father"  frameborder="NO" border="0" framespacing="0">
  <frame src="<?=u('index','top')?>" noresize="noresize" frameborder="no" name="topFrame" scrolling="no" marginwidth="0" marginheight="0" target="main" />
  <frameset cols="200,*"  id="frame">
    <frame src="<?=u('index','left')?>" name="leftFrame" noresize="noresize" marginwidth="0" marginheight="0" frameborder="no" scrolling="yes" target="main" />
    <frame src="<?=u($_GET['go_mod'],$_GET['go_act'])?>" name="main" noresize="noresize" marginwidth="0" marginheight="0" frameborder="no" scrolling="yes" target="_self" />
  </frameset>
</frameset>
<noframes></noframes>
</html>