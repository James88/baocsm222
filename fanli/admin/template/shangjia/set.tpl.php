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
<style>
.shangjiastatus_guanlian{ display:none}
</style>
<script>
$(function(){
<?=radio_guanlian('shangjia[status]')?>
})
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115" align="right">商家报名：</td>
    <td>&nbsp;<?=html_radio($zhuangtai_arr,$webset['shangjia']['status'],'shangjia[status]')?></td>
  </tr>
  <tbody class="shangjiastatus_guanlian">
   <tr>
    <td align="right">Banner图：</td>
    <td>&nbsp;<input name="shangjia[banner]" type="text" value="<?=$webset['shangjia']['banner']?>" id="banner" class="btn3" style="width:400px" /> <input class="sub" type="button" value="上传" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'banner','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">可添加网络地址，格式不限。</span></td>
    </tr>
	<tr>
    <td align="right">报名须知：</td>
    <td style=" padding:4px 6px"><textarea name="shangjia[content]" id="content" style="width:680px;"><?=$webset['shangjia']['content']?></textarea></td>
  </tr>
  </tbody>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>