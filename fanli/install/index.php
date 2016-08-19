<?php
error_reporting(0);
if(!file_exists('install.php.lock'))
{
	header('Location:install.php');
    exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>多多淘宝客 安装向导</title>
<link rel="stylesheet" href="images/style.css" type="text/css" media="all" />
<script type="text/javascript">
	function $(id) {
		return document.getElementById(id);
	}

	function showmessage(message) {
		$('notice').value += message + "\r\n";
	}
</script>
<meta content="Comsenz Inc." name="Copyright" />
<style type="text/css">
<!--
.STYLE2 {color: #FF0000}
-->
</style>
</head>
<body>
<div class="container">
	<div class="header">
		<?php include('step_header.php');?>	</div>
    <div class="main" style="margin-top:-123px;">
<table class="tb2">
<tr><th class="tbopt">
<img src="images/Alert_15.png" border="0"/></th>
<td valign="top" align="left">
<div style="font-size:20px">警告!!!</div><br/>
<p>您已经安装过该系统...</p><br/>
<p align="left" style="line-height:30px">如果需要重新安装，请先在服务器上或者ftp上打开<span class="STYLE2"> install </span>目录修改如下：<br />
1、<span class="STYLE2">install.php.lock</span> 改为 <span class="STYLE2">install.php</span>。</p>
<p align="left" style="line-height:30px">2、然后重新打开浏览器安装。</p>
<p><br/>
</p>
<p><input type="button" value="继续" onclick="window.location='install.php?step=0';" /></p>
</td>
<td>&nbsp;</td>
</tr>
</table>
	<?php include('footer.php');?>
	</div>
</div>
</body>
</html>