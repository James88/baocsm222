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
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
  <tr>
    <td width="115px" align="right">晒单奖励积分：</td>
    <td>&nbsp;<input name="baobei[shai_jifen]" value="<?=$webset['baobei']['shai_jifen']?>"/> 个</td>
  </tr>
  <tr>
    <td align="right">分享奖励积分：</td>
    <td>&nbsp;<input name="baobei[share_jifen]" value="<?=$webset['baobei']['share_jifen']?>"/> 个</td>
  </tr>
  <tr>
    <td align="right">红心奖励积分：</td>
    <td>&nbsp;<input name="baobei[hart_jifen]" value="<?=$webset['baobei']['hart_jifen']?>"/> 个</td>
  </tr>
  <tr>
    <td width="115px" align="right">晒单奖励<?=TBMONEY?>：</td>
    <td>&nbsp;<input name="baobei[shai_jifenbao]" value="<?=$webset['baobei']['shai_jifenbao']?>"/> 个</td>
  </tr>
  <tr>
    <td align="right">分享奖励<?=TBMONEY?>：</td>
    <td>&nbsp;<input name="baobei[share_jifenbao]" value="<?=$webset['baobei']['share_jifenbao']?>"/> 个</td>
  </tr>
  <tr>
    <td align="right">红心奖励<?=TBMONEY?>：</td>
    <td>&nbsp;<input name="baobei[hart_jifenbao]" value="<?=$webset['baobei']['hart_jifenbao']?>"/> 个</td>
  </tr>
  
  <tr>
    <td align="right">分享购买奖励：</td>
    <td>&nbsp;<input name="baobei[jiangli_bili]" value="<?=(float)$webset['baobei']['jiangli_bili']?>"/> 个 <span class="zhushi">分享商品别人购买，给分享人的奖励（金额），设置小数，如0.1，不奖励设置为0</span></td>
  </tr>
  
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </form>
</table>

<?php include(ADMINTPL.'/footer.tpl.php');?>