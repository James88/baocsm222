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
<div class="explain-col">此处修改会员金额会同步添加明细和站内信，在会员信息处修改不会同步添加明细和站内信。
  </div>
<br />
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">会员名：</td>
    <td>&nbsp;<textarea style="width:400px; height:150px" name="ddusername"><?=$row['ddusername']?></textarea>&nbsp;<span class="zhushi"> 多个会员可用空格，回车或者逗号隔开。</span> </td>
  </tr>
  <tr>
    <td align="right">方式：</td>
    <td>&nbsp;<input type="radio" name="fangshi" checked="checked" value="1"/>奖励&nbsp;<input type="radio" name="fangshi" value="2"/>扣除</td>
  </tr>
  <tr>
    <td align="right">金额：</td>
    <td>&nbsp;<input name="money" type="text" id="money" value="0" /></td>
  </tr>
  <tr>
    <td align="right">积分：</td>
    <td>&nbsp;<input name="jifen" type="text" id="jifen" value="0"  /></td>
  </tr>
  <tr>
    <td align="right"><?=TBMONEY?>：</td>
    <td>&nbsp;<input name="jifenbao" type="text" id="jifenbao" value="0"/></td>
  </tr>
  <tr>
    <td align="right">操作原因：</td>
    <td>&nbsp;<input name="source" type="text" id="source"/> <span class="zhushi">站内信内容，为空则不发送站内信</span></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>