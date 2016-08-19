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
    <td width="115px" align="right">敏感词：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td width="115px" align="right">敏感词拆分：</td>
    <td>&nbsp;<input name="title_arr" type="text" id="title_arr" value="<?=$row['title_arr']?>" style="width:300px" /> <span class="zhushi">拆分成单个词组，方便程序识别，用逗号隔开（中英文均可），此内容仅用于替换模式3</span></td>
  </tr>
  <tr>
    <td width="115px" align="right">替换为：</td>
    <td>&nbsp;<input name="replace" type="text" id="replace" value="<?=$row['replace']?>" style="width:300px" /> <span class="zhushi">默认为****</span></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>