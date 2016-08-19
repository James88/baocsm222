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
<link rel="stylesheet" type="text/css" href="css/login.css"  />
<script>
if(self!=top) top.location=self.location;

window.onload = function(){
	var oInput = document.getElementById("username");
	oInput.focus();
}
</script>
<title>后台管理系统</title>
</head>
<body>
<br /><br /><br /><br />
<form  method="post" action="" name="form">
<div class="login">
  <table width="417" height="195" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="28" height="122">&nbsp;</td>
      <td width="220">&nbsp;</td>
      <td width="169">&nbsp;</td>
    </tr>
    <tr>
      <td height="30">&nbsp;</td>
      <td height="30"><input  type="text" name="username" id="username" tabindex="1" /></td>
      <td rowspan="3">&nbsp;<input type="image" src="images/login_submit.gif" class="submit" /></td>
    </tr>
    <tr>
      <td height="30">&nbsp;</td>
      <td height="30"><input type="password" name="password" id="password" tabindex="2" /></td>
      </tr>
    <tr>
      <td height="30">&nbsp;</td>
      <td height="30"><input type="text" name="yzm" id="yzm" tabindex="3" size="4" maxlength="4"/> 
        <?=yzm('../')?></td>
      </tr>
  </table>
</div>
<input type="hidden" name="mod" value="login" /><input type="hidden" name="act" value="checklogin" /><input type="hidden" name="sub" value="1" />
</form>
</body>

</html>