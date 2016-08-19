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
$top_nav_name=array(array('url'=>u('tuiguang','zhuce'),'name'=>'注册营销'),array('url'=>u('tuiguang','sign'),'name'=>'签到营销'),array('url'=>u('tuiguang','share'),'name'=>'晒单奖励'),array('url'=>u('ddzhidemai','set'),'name'=>'值得买奖励'));
include(ADMINROOT.'/mod/public/part_set.act.php');
include(ADMINTPL.'/header.tpl.php');
?>
<script>
$(function(){
    $('input[name="sign[open]"]').click(function(){
        if($(this).val()==1){
		    $('#s1').show();
			$('#s2').show();
			$('#s3').show();
		}
		else if($(this).val()==0){
		   $('#s1').hide();
			$('#s2').hide();
			$('#s3').hide();
		}
	});
	
	if(parseInt($('input[name="sign[open]"]:checked').val())==1){
		$('#s1').show();
			$('#s2').show();
			$('#s3').show();
	}
})
</script>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
  
  <tr>
    <td width="115px" align="right">签到开关：</td>
    <td>&nbsp;<label><input <?php if($webset['sign']['open']==1){?> checked="checked"<?php }?> name="sign[open]" type="radio" value="1"/> 开启</label>&nbsp;<label><input <?php if($webset['sign']['open']==0){?> checked="checked"<?php }?> name="sign[open]" type="radio" value="0"/> 关闭</label></td>
  </tr>
  <tr id="s1" style="display:none">
    <td align="right">签到送金额：</td>
    <td>&nbsp;<input name="sign[money]" value="<?=$webset['sign']['money']?>"/> 元 </td>
  </tr>
  <tr id="s2" style="display:none">
    <td align="right">签到送<?=TBMONEY?>：</td>
    <td>&nbsp;<input name="sign[jifenbao]" value="<?=$webset['sign']['jifenbao']?>"/> 个 </td>
  </tr>
  <tr id="s3" style="display:none">
    <td align="right">签到送积分：</td>
    <td>&nbsp;<input name="sign[jifen]" value="<?=$webset['sign']['jifen']?>"/> 个</td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </form>
</table>
<?php include(ADMINTPL.'/footer.tpl.php');?>