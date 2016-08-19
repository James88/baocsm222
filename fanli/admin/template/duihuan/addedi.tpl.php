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
    <td width="115px" align="right">会员：</td>
    <td>&nbsp;<?=$duoduo->select('user','ddusername','id="'.$row['uid'].'"')?></td>
  </tr>
  <tr>
    <td align="right">消费：</td>
    <td>&nbsp;<?=$row['spend']?>&nbsp;（<?=$row['mode']==1?TBMONEY:'积分'?>）</td>
  </tr>
  <tr>
    <td align="right">申请IP：</td>
    <td>&nbsp;<?=$row['ip']?></td>
  </tr>
  <tr>
    <td align="right">兑换商品：</td>
    <td>&nbsp;<?=$duoduo->select('huan_goods','title','id="'.$row['huan_goods_id'].'"')?> <span class="zhushi">（<a href="<?=u('huan_goods','addedi',array('id'=>$row['huan_goods_id']))?>">查看商品详细</a>）</span></td>
  </tr>
  <tr>
    <td align="right">真实姓名：</td>
    <td>&nbsp;<?=$row['realname']?></td>
  </tr>
  <tr>
    <td align="right">邮箱：</td>
    <td>&nbsp;<?=$row['email']?></td>
  </tr>
  <tr>
    <td align="right">支付宝：</td>
    <td>&nbsp;<?=$row['alipay']?></td>
  </tr>
  <tr>
    <td align="right">手机：</td>
    <td>&nbsp;<?=$row['mobile']?></td>
  </tr>
  <tr>
    <td align="right">qq：</td>
    <td>&nbsp;<?=qq($row['qq'])?></td>
  </tr>
  <tr>
    <td align="right">地址：</td>
    <td>&nbsp;<?=$row['address']?></td>
  </tr>
  <tr>
    <td align="right">备注：</td>
    <td>&nbsp;<?=$row['content']?></td>
  </tr>
  <tr>
    <td align="right">认领代码：</td>
    <td>&nbsp;<?=$row['code']?></td>
  </tr>
  <tr>
    <td align="right">兑换时间：</td>
    <td>&nbsp;<?=dd_date($row['addtime'],2)?></td>
  </tr>
  <?php if($do=='no'){?>
  <tr>
    <td align="right">退回原因：</td>
    <td>&nbsp;<input type="text" name="why" style="width:400px" value="<?=$row['why']?>" /></td>
  </tr>
  <?php }?>
  <tr>
    <td align="right">状态：</td>
    <td>&nbsp;<?=$status_arr[$row['status']]?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" id="sub" class="sub" name="sub" value=" <?php if($do=='yes'){?>确 认 兑 换<?php }elseif($do=='no'){?>退 回 兑 换<?php }?> " /></td>
  </tr>
</table>
<input type="hidden" name="do" value="<?=$do?>" />
</form>
<?php
if($row['status']!=0){echo script('$("#sub").attr("disabled","true");');}
?>
<?php include(ADMINTPL.'/footer.tpl.php');?>