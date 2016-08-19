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
$top_nav_name=get_lm($need_zhlm);
include(ADMINTPL.'/header.tpl.php');
?>
<script>
$(function(){
	$('.check').change(function(){
		var t=$(this).attr('id');
		var v=$(this).val();
		if(t=='title'){
			var id=$('#id').val();
			var ajax_url='<?=u(MOD,ACT)?>&title='+encodeURIComponent(v)+'&id='+id+'&do=check&t=<?=time()?>';
			$.getJSON(ajax_url,function(result){
				if(result==1){
					$(this).val('');
					$(this).focus();
					alert('网站名称重复，请修改');
				}
			})
		}else if(t=='pid'){
			var reg = /^mm_(\d+)_(\d+)_(\d+)$/;
			if(reg.test(v)==false){
				$(this).val('');
				$(this).focus();
				alert('pid格式不对');
				
			}
		}else{
			reg = /^http[s]?:\/\/[\w-]+\.[\w-]+[\.[\w-]|]+[\/=\?%\-&~`@[\]\':+!\w]+$/;
			if(reg.test(v)==false){
				$(this).val('');
				$(this).focus();
				alert('域名格式不对');
			}
		}
	});
})
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">网站名称：</td>
    <td>&nbsp;<input name="title" type="text" id="title" class="check required" value="<?=$row['title']?>"/></td>
  </tr>
  <tr>
    <td width="115px" align="right">pid：</td>
    <td>&nbsp;<input name="pid" type="text" id="pid" class="check required" value="<?=$row['pid']?>" style="width:300px"/><span class="zhushi">mm_开头，例如mm_30558949_13792683_55592162</span></td>
  </tr>
   <tr>
    <td width="115px" align="right">申请域名：</td>
    <td>&nbsp;<input name="url" type="text" id="url" class="check required" value="<?=$row['url']?>" style="width:300px"/><span class="zhushi">http(s)://开头，结尾不加/。如http://www.baidu.com</span></td>
  </tr>
  <tr>
    <td width="115px" align="right">是否默认：</td>
    <td>&nbsp;<?=html_radio(array('否','是'),$row['default'],'default')?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input name="id" id="id" type="hidden" value="<?=$row['id']?>"/><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>