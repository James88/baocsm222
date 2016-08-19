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
<meta http-equiv=Content-Type content=text/html;charset=utf-8>
<title>管理页面</title>
<script language=JavaScript>
function logout(){
	if (confirm("您确定要退出控制面板吗？"))
	top.location = "<?=u('login','exit')?>";
	return false;
}
</script>
<base target="main">
<link href="images/skin.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" style="min-width:1200px;">
<table width="100%" height="64" border="0" cellpadding="0" cellspacing="0" class="admin_topbg">
  <tr>
    <td width="" height="64"><img src="images/logo.gif" width="262" height="64"></td>
    <td width="" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="" height="38" class="admin_txt" align="right">管理员：<b><?=$ddadmin['name']?></b> 您好！<span class="left_txt" style="color:#FFF">上次登录IP：<b style="color:#FFF"><?=$adminuser['lastloginip']?></b> &nbsp;&nbsp;当前登录IP：<b style="color:#FFF"><?=get_client_ip()?></b></span></td>
        <td width="4%">&nbsp;</td>
        <td width="90px"><a href="<?=u('fun','cache')?>" target="main" class="top-bu-bg">更新缓存</a></td>
        <td width="90px"><a href="<?=u('webset','center')?>" target="main" class="top-bu-bg">后台中心</a></td>
        <td width="90px"><a href="<?=u('fun','cache',array('jump'=>1))?>" target="_blank" class="top-bu-bg">返回首页</a></td>
        <td width="90px"><a target="_self" onClick="logout();"><img src="images/out.gif" alt="安全退出" width="46" height="20" border="0"></a></td>
        <td width="">&nbsp;</td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</body>
</html>
