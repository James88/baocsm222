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

$top_nav_name=array(array('id'=>'zhuce','name'=>'注册营销'),array('id'=>'sign','name'=>'签到营销'),array('id'=>'share','name'=>'晒单奖励'));
include(ADMINTPL.'/header.tpl.php');
?>
<script>
$(function(){
	 $('#zhuce').show();
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
	
	<?php if($_GET['form_table_id']!=''){?>
	$('#top_name .menu').each(function(){
		$t=$(this);
		var a=$t.attr('onclick');
		if(a.indexOf('<?=$_GET['form_table_id']?>')>0){
			$t.click();
		}
	});
	<?php }?>
})
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  
  <tbody id="zhuce" class="from_table">
  <tr>
    <td align="right" width="115">注册送金额：</td>
    <td>&nbsp;<input name="user[reg_money]" value="<?=$webset['user']['reg_money']?>"/> 元</td>
  </tr>
  <tr>
    <td align="right">注册送<?=TBMONEY?>：</td>
    <td>&nbsp;<input name="user[reg_jifenbao]" value="<?=$webset['user']['reg_jifenbao']?>"/> 个</td>
  </tr>
  <tr>
    <td align="right">注册送积分：</td>
    <td>&nbsp;<input name="user[reg_jifen]" value="<?=$webset['user']['reg_jifen']?>" <?php if($webset['jifenbl']==0){?>readonly="readonly" class="disabled"<?php }?>/> 个 <?php if($webset['jifenbl']==0){?><span class="zhushi"><a href="<?=u('webset','fanli_set')?>">请先开启积分设置</a></span><?php }?></td>
  </tr>
  <tr>
    <td align="right">注册送成长值：</td>
    <td>&nbsp;<input name="user[reg_level]" value="<?=$webset['user']['reg_level']?>"/> 点</td>
  </tr>
  </tbody>
  <tbody id="sign" class="from_table">
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
    <td>&nbsp;<input name="sign[jifen]" value="<?=$webset['sign']['jifen']?>" <?php if($webset['jifenbl']==0){?>readonly="readonly" class="disabled"<?php }?>/> 个 <?php if($webset['jifenbl']==0){?><span class="zhushi"><a href="<?=u('webset','fanli_set')?>">请先开启积分设置</a></span><?php }?></td>
  </tr>
  </tbody>
   <tbody id="share" class="from_table">
  <tr>
    <td width="115px" align="right">晒单奖励积分：</td>
    <td>&nbsp;<input name="baobei[shai_jifen]" value="<?=$webset['baobei']['shai_jifen']?>" <?php if($webset['jifenbl']==0){?>readonly="readonly" class="disabled"<?php }?>/> 个 <?php if($webset['jifenbl']==0){?><span class="zhushi"><a href="<?=u('webset','fanli_set')?>">请先开启积分设置</a></span><?php }?></td>
  </tr>
  <tr>
    <td align="right">晒单奖励<?=TBMONEY?>：</td>
    <td>&nbsp;<input name="baobei[shai_jifenbao]" value="<?=$webset['baobei']['shai_jifenbao']?>"/> 个</td>
  </tr>
  <tr>
    <td align="right">红心奖励积分：</td>
    <td>&nbsp;<input name="baobei[hart_jifen]" value="<?=$webset['baobei']['hart_jifen']?>" <?php if($webset['jifenbl']==0){?>readonly="readonly" class="disabled"<?php }?>/> 个 <?php if($webset['jifenbl']==0){?><span class="zhushi"><a href="<?=u('webset','fanli_set')?>">请先开启积分设置</a></span><?php }?></td>
  </tr>
  <tr>
    <td align="right">红心奖励<?=TBMONEY?>：</td>
    <td>&nbsp;<input name="baobei[hart_jifenbao]" value="<?=$webset['baobei']['hart_jifenbao']?>"/> 个</td>
  </tr>
  <tr>
    <td align="right">分成奖励：</td>
  	<td>&nbsp;<input type="hidden" id="baoliao_jiangli_bili" name="baoliao_jiangli_bili" value="<?=$webset['baoliao_jiangli_bili']?>" /><input onblur="$('#baoliao_jiangli_bili').val(parseInt($(this).val())/100)" type="text" value="<?=(float)$webset['baoliao_jiangli_bili']*100?>" style="width:30px" />% <span class="zhushi">成交后 额外奖励比例，0 为不奖励，计算规则为购买会员返利额的百分比。<a href="<?=u('tuiguang','list')?>">奖励明细</a></span></td>
  </tr>
  </tbody>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  
  
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>