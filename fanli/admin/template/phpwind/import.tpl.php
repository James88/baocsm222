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
<form action="" method="get" name="form">
<input type="hidden" name="mod" value="<?=MOD?>" />
<input type="hidden" name="act" value="import" />
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">提示：</td>
    <td>&nbsp;<?php if($daoru_num>=$num){echo '<b style="color:red">会员导入完毕</b>';}else{echo "phpwind网站现有会员".$num."人，已导入会员".$daoru_num."人";} ?></td>
  </tr>
  <tr>
    <td align="right">注意：</td>
    <td>&nbsp;导入会员的前提是duoduo内没有会员，如果phpwind和网站内同时都有会员，导入时会发生用户名重复的问题，此时phpwind内此会员的登陆密码会作废，以网站为准！</td>
  </tr>
  <tr>
    <td align="right">必读：</td>
    <td>&nbsp;导入完成后，删除phpwind根目录下的phpwind2dd.php文件</td>
  </tr>
  <tr>
    <td align="right">每轮导入会员：</td>
    <td>&nbsp;<input style="width:30px" type="text" name="size" value="<?=$pagesize?>"/>(个)根据您的网速，每轮导入会员个数建议设置100-1000之间</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="daoru_num" value="<?=$daoru_num?>" /><input type="submit" class="sub" name="sub" value=" 导 入 " /></td>
  </tr>
</table>
</form>
<?php if($daoru_num>=$num){echo script("$('.sub').attr('disabled','true')");}?>
<?php include(ADMINTPL.'/footer.tpl.php');?>