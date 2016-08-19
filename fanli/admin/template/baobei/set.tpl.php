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
<script>
$(function(){
<?=radio_guanlian('baobei[share_status]')?>
})
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td style="width:115px" align="right">晒单起始时间：</td>
    <td>&nbsp;<input id="sdate" name="baobei[shai_s_time]" value="<?=$webset['baobei']['shai_s_time']?>"/> <span class="zhushi">允许大于这个时间的订单晒单</span></td>
  </tr>
  <tr>
    <td align="right">宝贝评语：</td>
    <td>&nbsp;<input name="baobei[word_num]" value="<?=$webset['baobei']['word_num']?>"/> <span class="zhushi">(个字以内) 不要过多，否则页面容易错位</span></td>
  </tr>
  <tr>
    <td align="right">宝贝评论：</td>
    <td>&nbsp;<input name="baobei[comment_word_num]" value="<?=$webset['baobei']['comment_word_num']?>"/> <span class="zhushi">(个字以内) 不要过多，否则页面容易错位</span></td>
  </tr>
  <tr>
    <td align="right">评论等级限制：</td>
    <td>&nbsp;<input name="baobei[comment_level]" value="<?=$webset['baobei']['comment_level']?>"/> <span class="zhushi">会员等级大于此设置才可评论商品</span></td>
  </tr>
   <tr>
    <td align="right">审核：</td>
    <td>&nbsp;<?=html_radio(array('不需要','需要'),$webset['baobei']['user_show'],'baobei[user_show]')?> <span class="zhushi">设置晒单是否需要审核，设置需要的话审核之后才能显示</span></td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="hidden" name="baobei[re_tao_cid]" value="<?=$webset['baobei']['re_tao_cid']?>" /><input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>