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
    <td width="115px" align="right">栏目：</td>
    <td>&nbsp;<select name="cid"><?php getCategorySelect($row['cid']?$row['cid']:$_GET['cid']);?></select></td>
  </tr>
  <tr>
    <td align="right">标题：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>" style="width:300px"/></td>
  </tr>
  <!--<tr>
    <td align="right">缩略图：</td>
    <td>&nbsp;<input name="img" type="text" id="img" value="<?=$row['img']?>" style="width:300px" /> <input class="sub" type="button" value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'img','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">可直接添加网络地址</span></td>
  </tr>-->
  <tr>
    <td align="right">来源：</td>
    <td>&nbsp;<input name="source" type="text" id="source" value="<?=$row['source']?>"/> <span class="zhushi">为空默认为：<?=WEBNAME?></span></td>
  </tr>
  <tr>
    <td align="right">关键词：</td>
    <td>&nbsp;<input name="keyword" type="text" id="keyword" value="<?=$row['keyword']?$row['keyword']:WEBNAME?>" style="width:300px"/> <span class="zhushi">使用半角逗号“,”隔开</span></td>
  </tr>
  <tr>
    <td align="right">摘要：</td>
    <td>&nbsp;<textarea id="desc" style="width:400px" name="desc"><?=$row['desc']?></textarea></td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?>"/> <span class="zhushi">数字越小越靠前,1为最小值</span></td>
  </tr>
  <tr>
    <td align="right">内容：</td>
    <td>&nbsp;<textarea id="content" name="content"><?=$row['content']?></textarea></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>