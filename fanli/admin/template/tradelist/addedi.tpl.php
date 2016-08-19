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
unset($_status_arr[0]);
?>
<script>
$(function(){
	$('input[name="caozuo"]').click(function(){
		if($(this).val()==1){
			$('.caozuo_guanlian').hide();
	
		}
		else{
			$('.caozuo_guanlian').show();
		}
	});
	if($('input[name="caozuo"]:checked').val()==1){
		$('.caozuo_guanlian').hide();
	}
	else{
		$('.caozuo_guanlian').show();
	}
});
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<input type="hidden" name="category_id" value="0" /><input type="hidden" name="category_name" value="" />
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">商品：</td>
    <td>&nbsp;<input type="text" name="item_title" class="required" value="<?=$row['item_title']?>" /></td>
  </tr>
  <tr>
    <td align="right">店铺：</td>
    <td>&nbsp;<input type="text" class="required" name="shop_title" value="<?=$row['shop_title']?>" /></td>
  </tr>
  <tr>
    <td align="right">掌柜：</td>
    <td>&nbsp;<input type="text" class="required" name="seller_nick" value="<?=$row['seller_nick']?>" /></td>
  </tr>
  <tr>
    <td align="right">商品id：</td>
    <td>&nbsp;<input type="text" class="required" num="y" name="num_iid" value="<?=$row['num_iid']?>" /></td>
  </tr>
  <tr>
    <td align="right">订单号：</td>
    <td>&nbsp;<input type="text" class="required" num="y" name="trade_id" value="<?=preg_replace('/_\d+$/','',$row["trade_id"])?>" /></td>
  </tr>
  <tr>
    <td align="right">单价：</td>
    <td>&nbsp;<input type="text" class="required" name="pay_price" value="<?=$row['pay_price']?>" />元</td>
  </tr>
  <tr>
    <td align="right">数量：</td>
    <td>&nbsp;<input type="text" class="required" name="item_num" value="<?=$row['item_num']?>" /></td>
  </tr>
  <tr>
    <td align="right">总额：</td>
    <td>&nbsp;<input type="text" value="<?=$row['item_num']*$row['pay_price']?>" />元</td>
  </tr>
  <tr>
    <td align="right">成交额：</td>
    <td>&nbsp;<input type="text" class="required" name="real_pay_fee" value="<?=$row['real_pay_fee']?>" />元</td>
  </tr>
  <tr>
    <td align="right">佣金比例：</td>
    <td>&nbsp;<input type="text" class="required" num="y" name="commission_rate" value="<?=$row['commission_rate']?>" /><span class="zhushi">即<?=$row['commission_rate']*100?>% &nbsp;（数据格式 <b>0.12</b> 表示12%）</span></td>
  </tr>
  <tr>
    <td align="right">佣金：</td>
    <td>&nbsp;<input type="text" class="required" num="y" onblur="fxjeJifen($(this).val());" name="commission" value="<?=$row['commission']?>" />元</td>
  </tr>
  <tr>
    <td align="right">返利：</td>
    <td>&nbsp;<input id="fxje" type="text" class="required" num="y" name="fxje" value="<?=$row['fxje']?>" />元</td>
  </tr>
  <tr>
    <td align="right"><?=TBMONEY?>：</td>
    <td>&nbsp;<input id="jifenbao" type="text" class="required" num="y" name="jifenbao" value="<?=$row['jifenbao']?>" /></td>
  </tr>
  <tr>
    <td align="right">积分：</td>
    <td>&nbsp;<input id="jifen" type="text" name="jifen" value="<?=$row['jifen']?>" /></td>
  </tr>
  <tr>
    <td align="right">下单时间：</td>
    <td>&nbsp;<input id="sdatetime" type="text" class="required" name="create_time" value="<?=$row['create_time']?>" /></td>
  </tr>
  <tr>
    <td align="right">结算时间：</td>
    <td>&nbsp;<input id="edatetime" type="text" name="pay_time" value="<?=$row['pay_time']?>" /></td>
  </tr>
  <?php if($row['checked']==2){?>
  <tr>
    <td align="right">会员名：</td>
    <td>&nbsp;<?=$duoduo->select('user','ddusername','id="'.$row['uid'].'"')?> <span class="zhushi">对应的会员ID：<?=$row['uid']?></span></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="hidden" name="do" value="-1" /><input type="submit" class="sub" name="sub" value="确 认 退 款 " /></td>
  </tr>
  <?php }elseif($row['checked']==3){?>
  <tr>
    <td align="right">会员名：</td>
    <td>&nbsp;<?=$duoduo->select('user','ddusername','id="'.$row['uid'].'"')?> <span class="zhushi">对应的会员ID：<?=$row['uid']?></span></td>
  </tr>
  <tr>
    <td align="right">订单截图：</td>
    <td>
    <?php if($row['ddjt']){?>
    &nbsp;<img src="../<?=$row['ddjt']?>"/>
    <?php }else{?>
    &nbsp;没有订单截图
    <?php }?>
    </td>
  </tr>
  <tr>
    <td align="right">订单状态：</td>
    <td>&nbsp;<?=select($_status_arr,$row['status'],'status');?></td>
  </tr>  
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="hidden" name="do" value="2" /><input type="submit" class="sub" name="sub" value="确 认 返 现" /></td>
  </tr>
  <?php }elseif($row['checked']==1){?>
  <tr>
    <td align="right">会员名：</td>
    <td>&nbsp;<input type="text" name="uname" value="<?=$duoduo->select('user','ddusername','id="'.$row['uid'].'"')?>" /> <span class="zhushi">对应的会员ID：<?=$row['uid']?></span></td>
  </tr>
  <tr>
    <td align="right">订单截图：</td>
    <td>
    <?php if($row['ddjt']){ if(strpos($row['ddjt'],'http://')===false){echo $row['ddjt']='../'.$row['ddjt'];}?>
    &nbsp;<img src="<?=$row['ddjt']?>"/>
    <?php }else{?>
    &nbsp;没有订单截图
    <?php }?>
    </td>
  </tr>
    <tr>
    <td align="right">&nbsp;操作：</td>
    <td>&nbsp;&nbsp;<label><input checked="checked" name='caozuo' type='radio' value='1' /> 认领通过</label>&nbsp;&nbsp;<label><input  name='caozuo' type='radio' value='2' />认领失败</label></td>
  </tr>
  <tr class="caozuo_guanlian">
    <td align="right">&nbsp;认领失败原因：</td>
    <td>&nbsp;<input type="text" name="shuoming" style="width:300px;" value="" /></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="hidden" name="do" value="3" /><input type="submit" class="sub" name="sub" value="确认操作" /></td>
  </tr>
  <?php }elseif($row['checked']==0){?>
  <tr>
    <td align="right">会员名：</td>
    <td>&nbsp;<input type="text" name="uname" value="" /> <span class="zhushi">对应的会员ID：<?=$row['uid']?></span></td>
  </tr>
  <tr>
    <td align="right">订单状态：</td>
    <td>&nbsp;<?=select($_status_arr,$row['status'],'status');?> <span class="zhushi">&nbsp;<a href="http://bbs.duoduo123.com/read-1-1-198009.html" target="_blank">状态说明</a></span></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="hidden" name="do" value="2" />
    <?php if($row['status']=="1" || $row['status']=="2" || $row['status']=="4"){
		$click=" onclick=\"return confirm('订单结算并且有会员会立即返现，其他的只是修改状态，确认操作?')\" ";
	}?>
    <input type="submit" class="sub" name="sub" <?php echo $click;?> value=" 确 认 返 现" /></td>
  </tr>
  <?php }elseif($row['checked']==-1){?>
  <tr>
    <td align="right">会员名：</td>
    <td>&nbsp;<?=$duoduo->select('user','ddusername','id="'.$row['uid'].'"')?> <span class="zhushi">对应的会员ID：<?=$row['uid']?></span></td>
  </tr>
  <?php }?>
</table>
</form>
<script>
MONEYBL=<?=TBMONEYBL?>;
DATA_TYPE=2;
<?php
foreach($webset['fxbl'] as $k=>$v){
	$webset['fxbl'][$k.'a']=$v;
	unset($webset['fxbl'][$k]);
}
php2js_object($webset['fxbl'],'fxblArr');
?>
function fxjeJifen(commission){
	type=<?=$row['uid']>0?$duoduo->select('user','type','id="'.$row['uid'].'"'):0?>;
	var fxje=fenduan(commission,type,fxblArr);
	$('#fxje').val(fxje);
	$('#jifenbao').val(fxje*<?=TBMONEYBL?>);
	var jifen=fxje*<?=$webset['jifenbl']?>;
	jifen=jifen*100;
  	jifen=jifen.toFixed(1);
  	jifen=Math.round(jifen)/100;
	$('#jifen').val(jifen);
}
</script>
<?php include(ADMINTPL.'/footer.tpl.php');?>