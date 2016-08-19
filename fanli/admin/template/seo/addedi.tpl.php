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
$labelarr = explode("|", $row['label']);
?>
<script>
function insertText(id, text){
	var mystr = $('#'+id).val();
	$('#'+id).focus();
	$('#'+id).val(mystr + text);
}
</script>
<div class="explain-col"> 温馨提示：每个标题设置均有独立的标签, 不能在其他标题设置里使用. &nbsp; 标签设置错误将无法解析。<br />
    示例说明：<b><font color="blue">{WEBNAME}</font></b>, 必须按照规范填写，区分大小写。<br />
  </div>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">模块：</td>
    <td>&nbsp;<input name="mod" type="text" id="mod" value="<?=$row['mod']?>"/></td>
  </tr>
  <tr>
    <td align="right">行为：</td>
    <td>&nbsp;<input name="act" type="text" id="act" value="<?=$row['act']?>"/></td>
  </tr>
  <tr>
    <td align="right">标题：</td>
    <td>&nbsp;<input name="title" type="text" id="title" style="width:90%;font-family: Verdana, Geneva, sans-serif,'宋体'" value="<?=$row['title']?>"/></td>
  </tr>
  <tr>
    <td align="right"></td>
    <td>&nbsp;
    <?php foreach($labelarr as $v) {$label = explode("-", $v);?>
    <span style="cursor:pointer; color:#03F" onClick="insertText('title', '<?=dd_addslashes($label[0],1)?>')" title="<?=$label[0]?>"><?=$label[1]?></span>&nbsp;&nbsp;
    <?php }?>
    </td>
  </tr>
  <tr>
    <td align="right">关键词：</td>
    <td>&nbsp;<input name="keyword" type="text" id="keyword" style="width:90%;font-family: Verdana, Geneva, sans-serif,'宋体'" value="<?=$row['keyword']?>"/></td>
  </tr>
  <tr>
    <td align="right"></td>
    <td>&nbsp;
    <?php foreach($labelarr as $v) {$label = explode("-", $v);?>
    <span style="cursor:pointer; color:#03F" onClick="insertText('keyword', '<?=dd_addslashes($label[0],1)?>')" title="<?=$label[0]?>"><?=$label[1]?></span>&nbsp;&nbsp;
    <?php }?>
    </td>
  </tr>
  <tr>
    <td align="right">描述：</td>
    <td>&nbsp;<input name="desc" type="text" id="desc" style="width:90%;font-family: Verdana, Geneva, sans-serif,'宋体'" value="<?=$row['desc']?>"/></td>
  </tr>
  <tr>
    <td align="right"></td>
    <td>&nbsp;
    <?php foreach($labelarr as $v) {$label = explode("-", $v);?>
    <span style="cursor:pointer; color:#03F" onClick="insertText('desc', '<?=dd_addslashes($label[0],1)?>')" title="<?=$label[0]?>"><?=$label[1]?></span>&nbsp;&nbsp;
    <?php }?>
    </td>
  </tr>
  <tr>
    <td align="right">便捷标签：</td>
    <td>&nbsp;<input name="label" type="text" id="label" style="width:90%;font-family: Verdana, Geneva, sans-serif,'宋体'" value="<?=$row['label']?>"/></td>
  </tr>
  <?php if($id>0){?>
  <tr>
    <td align="right">添加时间：</td>
    <td>&nbsp;<input name="addtime" type="text" id="addtime" value="<?=date('Y-m-d H:i:s',$row['addtime'])?>"/></td>
  </tr>
  <?php }?>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /> <span class="zhushi"><a href="http://bbs.duoduo123.com/read-1-1-198030.html" target="_blank">设置教程</a></span></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>