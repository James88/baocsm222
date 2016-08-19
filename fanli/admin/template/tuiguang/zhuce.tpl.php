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
    $('input[name="yinxiangma[open]"]').click(function(){
        if($(this).val()==1){
		    $('.yinxiangmakey').show();
		}
		else if($(this).val()==0){
		    $('.yinxiangmakey').hide();
		}
	});
})
</script>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
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
    <td>&nbsp;<input name="user[reg_jifen]" value="<?=$webset['user']['reg_jifen']?>"/> 个</td>
  </tr>
  <tr>
    <td align="right">注册送等级：</td>
    <td>&nbsp;<input name="user[reg_level]" value="<?=$webset['user']['reg_level']?>"/> 点</td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </form>
</table>
<?php include(ADMINTPL.'/footer.tpl.php');?>