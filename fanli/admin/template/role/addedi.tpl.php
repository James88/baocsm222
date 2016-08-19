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
$need='';
if($id==1){
	$need=' need_role';
}
include(ADMINTPL.'/header.tpl.php');
?>
<script>
var id=<?=$id?>;
function checkNode(t){
	if(id==1){
		return false;
	}
	classname=$(t).attr('id');
    if($(t).attr('checked')=='checked'){
		$('.'+classname).attr('checked',true);
	}
	else{
		$('.'+classname).attr('checked',false);
	}
}

$(function(){
    $('.children input').click(function(){
		var node=$(this).attr('node');
		if($(this).attr('checked')=='checked'){
		    $('#'+node).attr('checked',true);
		}
		else{
		    var classname=$(this).attr('class');
			var ok=1;
			$('.'+classname).each(function(){
			    if($(this).attr('checked')=='checked'){
				    ok=1;
					return false;
				}
				else{
				    ok=0;
				}
			});
			if(ok==0){
			    $('#'+node).attr('checked',false);
			}
		}
	});
	$('.need_role').click(function(){
		if(id==1 && $(this).attr('checked')!='checked'){
			alert('超级管理员，不能取消该权限');
			return false;
		}
		var c=$(this).attr('checked');
		if(c!='checked'){
			$(this).attr('checked','checked');
		}
	});
})
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">名称：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>"/><input type="hidden" name="id" value="<?=$row['id']?>" /></td>
  </tr>
  <tr>
    <td align="right">菜单：</td>
    <td style="padding-left:5px">
    <?php foreach($menus as $key=>$row){?>
    <div><label><input type="checkbox" class="<?=$need?>"  id="<?=$row['node']?>" name="ids[]" <?php if($role_menu_arr[$key]){?> checked="checked"<?php }?> value="<?=$key?>" onclick='javascript:checkNode($(this));'/>&nbsp;<span style="font-size:12px;font-family:wingdings">1</span>&nbsp;<?=$row['title']?></label></div>
    <?php foreach($row['children'] as $k=>$v){?>
    <div style="line-height:28px"><label class="children">└─<input node="<?=$row['node']?>" class="<?=$row['node']?><?=$need?>" <?php if($role_menu_arr[$v['id']]){?> checked="checked"<?php }?> type="checkbox" name="ids[]" value="<?=$v['id']?>" />&nbsp;<span style="font-size:12px;font-family:wingdings">2</span>&nbsp;<?=$v['title']?><span class="zhushi">(模块：<?=$v['mod']?> 行为：<?=$v['act']?>)</span></label></div>
    <?php }?>
	<?php }?>
    </td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>