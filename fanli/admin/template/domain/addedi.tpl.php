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

$bankuai_arr=$duoduo->select_2_field('bankuai','code,title');
unset($dd_mod_act_arr['index']);

$has_tao_arr=array(0=>'不含',1=>'含有');

include(ADMINTPL.'/header.tpl.php');
?>
<style>
.bankuai_name,.close_guanlian{ display:none}
</style>
<script>
var domain='<?=get_domain(URL)?>';

$(function(){
	$('#mod').click(function(){
		mod_name_radio($(this));
	});
	mod_name_radio($('#mod'));
	
	$('input[name=close]').click(function(){
		close_radio();
	});
	close_radio();
	
	$('input[name=has_tao]').click(function(){
		has_tao_radio();
	});
	
	$('#code').change(function(){
		if($(this).val()!=''){
			$('input[name=has_tao]:eq(1)').attr('checked',true);
			has_tao_radio();
		}
	});
	<?php if(empty($row)){?>
	mod_select();
	<?php }?>
	$('#mod').change(function(){
		mod_select();
	});
	
	$('#code').change(function(){
		m=$('#code').val();
		var url=m+'.'+domain;
		$('#url').val(url);
	});
})

function close_radio(){
	if($("input[name='close']:checked").val()==1){
		$('.close_guanlian').hide();
	}
	else{
		$('.close_guanlian').show();
	}
}

function has_tao_radio(){
	/*if($("input[name='has_tao']:checked").val()==1){
		alert('注意：如果该页有淘宝商品，且直接跳转到爱淘宝，系统默认使用淘点金申请的域名，域名设置里的无效');
	}*/
}

function mod_name_radio($t){
	if($t.val()=='goods'){
		$('.bankuai_name').show();
		if($('#code').val()!=''){
			$('input[name=has_tao]:eq(1)').attr('checked',true);
			has_tao_radio();
		}
	}
	else{
		$('.bankuai_name').hide();
	}
}

function checkUrl($t){
	var str=$t.val();
	if(str==''){
		alert('域名必须填写');
	}
	if(str.match(/^http/)!=null){
		alert('开始不要http');
	}
	if(str.match(/\/$/)!=null){
		alert('结尾不要/');
	}
}

function mod_select(){
	var m=$('#mod').val();
	if(m=='goods'){
		m=$('#code').val();
	}
	var url=m+'.'+domain;
	$('#url').val(url);
}

</script>
<div class="explain-col">提醒：如果给淘宝模块绑定二级域名，此域名需要在阿里妈妈里进行渠道备案（就是添加这个站点）</div>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>&code=<?=$code?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">状态：</td><!--根据实际调用-->
    <td >&nbsp;<?=html_radio($_zhuangtai_arr,$row['close'],'close')?></td>
  </tr>
  <tbody class="close_guanlian">
  <tr>
    <td align="right">模块：</td><!--根据实际调用-->
    <td >&nbsp;<?=select($dd_mod_act_arr,$row['mod'],'mod')?> <span class="zhushi"><a href="http://bbs.duoduo123.com/read-1-1-198037.html" target="_blank">设置教程</a></span></td>
  </tr>
  <tr class="bankuai_name">
    <td align="right">板块：</td><!--根据实际调用-->
    <td >&nbsp;<?=select($bankuai_arr,$row['code'],'code')?>  </td>
  </tr>
  <!--<tr>
    <td align="right">淘宝商品：</td>
    <td>&nbsp;<?=html_radio($has_tao_arr,$row['has_tao'],'has_tao')?> <span class="zhushi">如果该页有淘宝商品，且直接跳转到爱淘宝，系统默认使用淘点金申请的域名，域名设置里的无效</span></td>
  </tr>-->
  <tr>
    <td align="right">绑定域名：</td>
    <td>&nbsp;<input type="text" name="url" id="url" value="<?=$row['url']?>" onblur="checkUrl($(this))" /> <span class="zhushi">开头不带http://，结尾不带/，如aa.baidu.com</span></td>
  </tr>
  </tbody>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>