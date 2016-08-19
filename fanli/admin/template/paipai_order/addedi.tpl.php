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
    <td width="115px" align="right">商品：</td>
    <td>&nbsp;<?=$row['commName']?></td>
  </tr>
  <tr>
    <td align="right">确认收货时间：</td>
    <td>&nbsp;<?=date('Y-m-d H:i:s',$row['chargeTime'])?></td>
  </tr>
  <tr>
    <td align="right">店铺：</td>
    <td>&nbsp;<?=$row['shopName']?></td>
  </tr>
  <tr>
    <td align="right">店铺ID：</td>
    <td>&nbsp;<?=$row['shopId']?></td>
  </tr>
  <tr>
    <td align="right">商品类别id：</td>
    <td>&nbsp;<?=$row['classId']?></td>
  </tr>
  <tr>
    <td align="right">商品类别名称：</td>
    <td>&nbsp;<?=$row['className']?></td>
  </tr>
  <tr>
    <td align="right">商品id：</td>
    <td>&nbsp;<?=$row['commId']?></td>
  </tr>
  <tr>
    <td align="right">订单号：</td>
    <td>&nbsp;<?=$row['dealId']?></td>
  </tr>
  <tr>
    <td align="right">成交价：</td>
    <td>&nbsp;<?=$row['careAmount']?>元</td>
  </tr>
  <tr>
    <td align="right">数量：</td>
    <td>&nbsp;<?=$row['commNum']?></td>
  </tr>
  <tr>
    <td align="right">佣金比例：</td>
    <td>&nbsp;<?=$row['discount']*100?>%</td>
  </tr>
  <tr>
    <td align="right">佣金：</td>
    <td>&nbsp;<?=$row['commission']?>元</td>
  </tr>
  <tr>
    <td align="right">返利：</td>
    <td>&nbsp;<?=$row['fxje']?>元</td>
  </tr>
  <tr>
    <td align="right">积分：</td>
    <td>&nbsp;<?=$row['jifen']?></td>
  </tr>
  <?php if($row['checked']==2){?>
  <tr>
    <td align="right">会员：</td>
    <td>&nbsp;<?=$duoduo->select('user','ddusername','id="'.$row['uid'].'"')?> 会员ID：<?=$row['uid']?></td>
  </tr>
  <!--<tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="hidden" name="do" value="1" /><input type="submit" class="sub" name="sub" value="退 款 " /></td>
  </tr>-->
  <?php }elseif($row['checked']==0){?>
  <tr>
    <td align="right">会员：</td>
    <td>&nbsp;<input type="text" name="uname" value="" /> <span class="zhushi">会员ID：<?=$row['uid']?></span></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="hidden" name="do" value="2" /><input type="submit" class="sub" name="sub" value=" 确 认 " /></td>
  </tr>
  <?php }elseif($row['checked']==-1){?>
  <tr>
    <td align="right">会员：</td>
    <td>&nbsp;<?=$duoduo->select('user','ddusername','id="'.$row['uid'].'"')?> 会员ID：<?=$row['uid']?></td>
  </tr>
  <?php }?>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>