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
$user=$duoduo->select('user','ddusername,level,type','id="'.$row['uid'].'"')
?>
<script>
<?php
foreach($webset['mallfxbl'] as $k=>$v){
	$webset['mallfxbl'][$k.'a']=$v;
	unset($webset['mallfxbl'][$k]);
}
php2js_object($webset['mallfxbl'],'fxblArr');
?>
function fxjeJifen(commission){
	type='<?=(int)$user['type']?>';
	var fxje=fenduan(commission,type,fxblArr);
	$('#fxje').val(fxje);
	var jifen=fxje*<?=$webset['jifenbl']?>;
	jifen=jifen*100;
  	jifen=jifen.toFixed(1);
  	jifen=Math.round(jifen)/100;
	$('#jifen').val(jifen);
}
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
<?php if($id>0){?>
  <tr>
    <td width="115px" align="right">商城：</td>
    <td>&nbsp;<?=$row['mall_name']?></td>
  </tr>
  <tr>
    <td align="right">联盟：</td>
    <td>&nbsp;<?=$lianmeng_arr[$row['lm']]?$lianmeng_arr[$row['lm']]:$lianmeng_arr[8]?></td>
  </tr>
  <tr>
    <td align="right">下单时间：</td>
    <td>&nbsp;<?=date('Y-m-d H:i:s',$row['order_time'])?></td>
  </tr>
  <tr>
    <td align="right">订单号：</td>
    <td>&nbsp;<?=$row['order_code']?></td>
  </tr>
  <tr>
    <td align="right">商品编号：</td>
    <td>&nbsp;<?=$row['product_code']?></td>
  </tr>
  <tr>
    <td align="right">数量：</td>
    <td>&nbsp;<?=$row['item_count']?></td>
  </tr>
  <tr>
    <td align="right">单价：</td>
    <td>&nbsp;<?=$row['item_price']?></td>
  </tr>
  <tr>
    <td align="right">总额：</td>
    <td>&nbsp;<?=$row['sales']?></td>
  </tr>
  <tr>
    <td align="right">佣金：</td>
    <td>&nbsp;<input type="text" id="commission" name="commission" onblur="fxjeJifen($(this).val());" value="<?=$row['commission']?>" /> <span class="zhushi">填写佣金后系统会自动从新计算返利和积分</span></td>
  </tr>
  <tr>
    <td align="right">返利：</td>
    <td>&nbsp;<input type="text" id="fxje" name="fxje" value="<?=$row['fxje']?>" /></td>
  </tr>
  <tr>
    <td align="right">积分：</td>
    <td>&nbsp;<input type="text" id="jifen" name="jifen" value="<?=$row['jifen']?>" /></td>
  </tr>
  
  <?php if($row['status']==1 || $row['status']==-1){?>
  <tr>
    <td align="right">状态：</td>
    <td>&nbsp;<?=$status_arr2[$row['status']]?></td>
  </tr>
  <tr>
    <td align="right">会员：</td>
    <td>&nbsp;<?=$user['ddusername']?></td>
  </tr>
  <?php }elseif($row['status']==0){?>
  <tr>
    <td align="right">状态：</td>
    <td>&nbsp;<?=select($status_arr2,$row['status'],'status')?></td>
  </tr>
  <tr>
    <td align="right">会员：</td>
    <td>&nbsp;<input type="text" name="uname" value="<?=$duoduo->select('user','ddusername','id="'.$row['uid'].'"')?>" /></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 确 认 " /></td>
  </tr>
  <?php }?>
<?php }else{?>
  <tr>
    <td width="115px" align="right">商城：</td>
    <td>&nbsp;<?=select($malls,0,'mall_id')?></td>
  </tr>
  <tr>
    <td align="right">联盟：</td>
    <td>&nbsp;<?=select($lianmeng_arr,0,'lm')?></td>
  </tr>
  <tr>
    <td align="right">下单时间：</td>
    <td>&nbsp;<input type="text" name="order_time" id="sdatetime" /></td>
  </tr>
  <tr>
    <td align="right">订单号：</td>
    <td>&nbsp;<input type="text" name="order_code" /></td>
  </tr>
  <tr>
    <td align="right">商品编号：</td>
    <td>&nbsp;<input type="text" name="product_code" /></td>
  </tr>
  <tr>
    <td align="right">数量：</td>
    <td>&nbsp;<input type="text" name="item_count" /></td>
  </tr>
  <tr>
    <td align="right">单价：</td>
    <td>&nbsp;<input type="text" name="item_price" /></td>
  </tr>
  <tr>
    <td align="right">总额：</td>
    <td>&nbsp;<?=$row['sales']?><input type="text" name="sales" /></td>
  </tr>
  <tr>
    <td align="right">佣金：</td>
    <td>&nbsp;<input type="text" name="commission" /></td>
  </tr>
  <tr>
    <td align="right">状态：</td>
    <td>&nbsp;<?=select($status_arr2,$row['status'],'status')?></td>
  </tr>
  <tr>
    <td align="right">会员：</td>
    <td>&nbsp;<input type="text" name="uname" /></td>
  </tr>
  <?php if($need_zhlm==1){?>
  <tr>
    <td align="right">唯一编号：</td>
    <td>&nbsp;<input type="text" name="unique_id" /> <span class="zhushi">亿起发专用</span></td>
  </tr>
  <?php }?>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 确 认 " /></td>
  </tr>
<?php }?>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>