<?php
if(!defined('INDEX')){
	exit('Access Denied');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=WEBNAME?></title>
<meta name="keywords" content="<?=WEBNAME?>" />
<meta name="description" content="<?=WEBNAME?>" />
</head>
<body>
<table width="550" height="176" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px dotted #ddd">
  <tr>
    <td colspan="2" align="center"><img src="images/alert.gif" width="100" height="90" /></td>
    <td width="370" style="font-size:25px; font-weight:bold;"><?=$webset['webclosemsg']?></td>
  </tr>
</table>
<table width="550" height="25" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr><td colspan="3" align="right">- by <?=WEBNAME?></td></tr>
</table>
</body>
</html>
