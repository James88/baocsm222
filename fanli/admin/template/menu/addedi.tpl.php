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
$act_arr=array('list','addedi','del','set');
?>
<script>
$(function(){
    $('#node_id').change(function(){
	    var node = $(this).val();
		$('#node').val(node);
	});
	$('#mod_id').change(function(){
	    var node = $(this).find("option:selected").text();
		$('#mod').val(node);
	});
	$('#act_id').change(function(){
	    var node = $(this).find("option:selected").text();
		$('#act').val(node);
	});
})
</script>
<div class="explain-col">
  说明：如要添加新节点，模块和行为两项为空即可。
</div>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable"  align="center" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">权限组：</td>
    <td>&nbsp;<?php foreach($role_arr as $k=>$v){?><label><input <?php if($k==1){?> disabled="disabled" checked="checked"<?php }?> type="checkbox" name="role[<?=$k?>]" <?php if(in_array($k,$role_select_arr)){?> checked="checked"<?php }?> value="1" /><?=$v?></label> <?php }?><input type="hidden" value="1" name="role[1]" /></td>
  </tr>
  <tr>
    <td align="right">名称：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>"/></td>
  </tr>
  <tr>
    <td align="right">节点：</td>
    <td>&nbsp;<input name="node" type="text" id="node" value="<?=$row['node']?$row['node']:'base'?>"/>&nbsp;<?=select($node_arr,$row['node'],'node_id')?> <span class="zhushi">默认节点，可自行添加</span></td>
  </tr>
  <tr>
    <td align="right">模块：</td>
    <td>&nbsp;<input name="mod" type="text" id="mod" value="<?=$row['mod']?>"/>&nbsp;<?=select($mod_arr,$row['mod'],'mod_id')?> <span class="zhushi">默认节点，可自行添加</span></td>
  </tr>
  <tr>
    <td align="right">行为：</td>
    <td>&nbsp;<input name="act" type="text" id="act" value="<?=$row['act']?>"/>&nbsp;<?=select($act_arr,'','act_id')?> <span class="zhushi">常用行为，可自行添加</span></td>
  </tr>
  <tr>
    <td align="right">网址：</td>
    <td>&nbsp;<input name="url" type="text" id="url" value="<?=$row['url']?>"/>&nbsp;<span class="zhushi">自定义网址的优先级高于模块和行为</span></td>
  </tr>
  <tr>
    <td align="right">状态：</td>
    <td>&nbsp;<?=html_radio($hide_arr,$row['hide'],'hide')?></td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?$row['sort']:$row['listorder']?>" /> <span class="zhushi">数字越大越靠前</span></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>