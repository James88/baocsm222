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
<div class="explain-col">
提示：请选择获取交易的时间段。时间只能选择最近3个月内。已经获取过的交易不会覆盖原有的数据，获取过程将自动忽略。时间必须为8位，并且开始时间小于结束时间，否则将无法获取成功！
</div>
<form method="get" action="../index.php" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">时间范围：</td>
    <td>&nbsp;<input name="sday" type="text" id="sday" size="10" maxlength="8" value="<?=date('Ymd')?>" /> 到 <input name="eday" type="text" id="eday" size="10" maxlength="8" value="<?=date('Ymd')?>" /> 最近获取的时间为：2015-04-01</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="submit" class="sub" value="获取交易记录" /></td>
  </tr>
</table>
<input type="hidden" name="mod" value="cron" />
<input type="hidden" name="act" value="run" />
<input type="hidden" name="jiaoben" value="cron_paipai_order" />
<input type="hidden" name="admin" value="<?=authcode(1,'ENCODE')?>" />
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>