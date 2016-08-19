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
    <?php foreach($search_key_arr as $row){ ?>
        <tr>
        <td align="right" width="115"><?=$row['tag']?>默认：</span>
        </td>
        <td >&nbsp;<input name="search_key[<?=$row['code']?>]" value="<?=$search_key[$row['code']]?$search_key[$row['code']]:$row['val']?>" /></td>
      </tr>
    <?php }?>
  <tr>
	<td align="right"></td>
	<td>&nbsp;<input type="submit" name="sub" class="sub" value=" 保 存 设 置 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>