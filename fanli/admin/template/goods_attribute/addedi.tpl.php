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
    <td width="115px" align="right">属性名称：</td>
    <td >&nbsp;&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>"/></td>
  </tr>
  <tr>
    <td align="right">字体颜色：</td>
    <td>
    <table border="0" class="yanse">
    <tr>
    <td>&nbsp;<input  name="font_color" type="text" id="font_color" value="<?=$row['font_color']?>"/></td>
    <?=seban()?>
    <td><span class="zhushi">16进制色值，字体颜色和背景颜色不要相同</span></td>
  </tr>
</table>
   </td>
  </tr>
  <tr>
    <td align="right">背景颜色：</td>
    <td>
	<table border="0" class="yanse">
    <tr>
    <td>&nbsp;<input name="bg_color" type="text" id="bg_color" value="<?=$row['bg_color']?>"/></td>
    <?=seban()?>
    <td><span class="zhushi">16进制色值，字体颜色和背景颜色不要相同</span></td>
  </tr>
</table>    
    </td>
  </tr>
  <tr>
    <td align="right">属性图标：</td>
    <td>&nbsp;<input name="ico" id="ico" value="<?=$row['ico']?>"> <input class="sub" type="button"  value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'ico','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">可使用远程图片地址，建议高度29像素，宽不限</span></td>
    <td ></td>
  </tr>
  <tr>
    <td align="right" >备注：</td>
    <td>&nbsp;<input name="beizhu" type="text" id="beizhu" value="<?=$row['beizhu']?>"/></td>
  </tr>
  <tr>
    <td align="right" >排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?>"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>