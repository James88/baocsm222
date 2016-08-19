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

include(ADMINTPL.'/header.tpl.php');
?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">服务器时间：</td>
    <td style="padding:5px; line-height:20px">
    电脑时间：<?php echo date('Y-m-d H:i:s');?> 程序时间：<?php echo date('Y-m-d H:i:s',TIME);?><br/>
    北京时间：<?=date('Y-m-d H:i:s',$beijing_time)?> 差值（程序时间减北京时间）：<?=abs(TIME-$beijing_time)?>秒<br/>
    <span class="zhushi">此数值大于300秒钟请联系系统管理员予以修正。</span></td>
  </tr>
  <tr>
    <td align="right">时间纠错：</td>
    <td>&nbsp;<input type="submit" class="sub" name="sub" value="点击校对时间" /> <span class="zhushi">(注意：时间纠错并没有修改您的系统时间，只是在程序的应用上填补时间差，所以如果您把系统时间更正后，这里必须从新校对时间)</span></td>
  </tr>
  <tr>
    <td align="right">服务器域名：</td>
    <td>&nbsp;<?php echo $_SERVER['SERVER_NAME']; ?></td>
  </tr>
  <tr>
    <td align="right">服务器IP：</td>
    <td>&nbsp;<?php echo dd_get(DUODUO_URL.'/ip.php'); ?></td>
  </tr>
  <tr>
    <td align="right">服务器端口：</td>
    <td>&nbsp;<?php echo $_SERVER['SERVER_PORT']; ?></td>
  </tr>
  <tr>
    <td align="right">服务器总类：</td>
    <td>&nbsp;<?php echo @PHP_OS;?></td>
  </tr>
  <tr>
    <td align="right">服务器类型：</td>
    <td>&nbsp;<?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
  </tr>
  <tr>
    <td align="right">服务器目录：</td>
    <td>&nbsp;<?php echo $_SERVER['DOCUMENT_ROOT']; ?></td>
  </tr>
  <tr>
    <td align="right">MYSQL版本号：</td>
    <td>&nbsp;<?php echo $duoduo->get_version(); ?></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>