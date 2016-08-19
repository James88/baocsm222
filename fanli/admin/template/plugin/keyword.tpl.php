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
<div class="explain-col"> 温馨提示：如果您开启了伪静态，会输出静态地址，如果没有，会输出动态地址！
  </div>
<br />
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">关键词：</td>
    <td>&nbsp;<input type="text" name="keyword" value="<?=$keyword?>" /></td>
  </tr>
  <tr>
    <td align="right"></td>
    <td>&nbsp;<input type="submit" name="sub" class="sub" value=" 提 交 " /></td>
  </tr>
  <?php foreach($page_url_arr as $row){?>
  <tr>
    <td align="right"><?=$row['name']?>：</td>
    <td>&nbsp;<input type="text" style="width:500px" value="<?=$keyword?$row['url']:''?>" /> <button onClick="copy($(this).prev('input').val())">复制</button></td>
  </tr>
  <?php }?>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>