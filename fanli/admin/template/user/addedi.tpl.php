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
<script>
$(function(){
	$('#tbnickBd').click(function(){
		$('#tbnicktr').toggle();
	})
})
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">会员名：</td>
    <td>&nbsp;<input name="ddusername" type="text" id="ddusername" value="<?=$row['ddusername']?>" /> <span class="zhushi"><a href="<?=u('msg','addedi',array('name'=>$row['ddusername']))?>">发送站内信</a></span></td>
  </tr>
  <tr>
    <td align="right">登陆密码：</td>
    <td>&nbsp;<?=limit_input('ddpassword')?> <span class="zhushi">点击激活修改</span></td>
  </tr>
  <tr>
    <td align="right">真实姓名：</td>
    <td>&nbsp;<input name="realname" type="text" id="realname" value="<?=$row['realname']?>" /> </td>
  </tr>
  <tr>
    <td align="right">注册时间：</td>
    <td>&nbsp;<input name="regtime" type="text" id="regtime" value="<?=$row['regtime']?>" /></td>
  </tr>
  <tr>
    <td align="right">注册IP：</td>
    <td>&nbsp;<input name="regip" type="text" id="regip" value="<?=$row['regip']?>" /></td>
  </tr>
  <tr>
    <td align="right">登录IP：</td>
    <td>&nbsp;<input name="logip" type="text" id="logip" value="<?=$row['logip']?>" /></td>
  </tr>
  <tr>
    <td align="right">登陆次数：</td>
    <td>&nbsp;<input name="loginnum" type="text" id="loginnum" value="<?=$row['loginnum']?>" /></td>
  </tr>
  <tr>
    <td align="right">上次登录时间：</td>
    <td>&nbsp;<input name="lastlogintime" type="text" id="lastlogintime" value="<?=$row['lastlogintime']?>" /></td>
  </tr>
  <tr>
    <td align="right">上次提现时间：</td>
    <td>&nbsp;<input name="lasttixian" type="text" id="lasttixian" value="<?=$row['lasttixian']?date('Y-m-d H:i:s',$row['lasttixian']):''?>" /></td>
  </tr>
  <?php if($webset['taoapi']['auto_fanli']==1){?>
  <tr>
    <td align="right">淘宝跟踪状态：</td>
    <td>&nbsp;<?=$row['tbnick']?'<b style=" color:green">自动</b>':'<b style=" color:red">手动</b>'?><span class="zhushi">（绑定淘宝帐号，淘宝订单跟踪状态会成为自动） <b style="color:#F00; cursor:pointer" id="tbnickBd">绑定</b></span></td>
  </tr>

  <tr id="tbnicktr" <?php if($row['tbnick']==''){?> style="display:none"<?php }?>>
    <td align="right">淘宝账号/订单号：</td>
    <td>&nbsp;<input name="tbnick" type="text" id="tbnick" style="width:200px" value="<?=$row['tbnick']?>" /> <span class="zhushi">多个淘宝帐号用英文逗号分割</span></td>
  </tr>
 <!-- <tr>
    <td align="right">淘宝订单会员id：</td>
    <td>&nbsp;<input name="trade_uid" type="text" id="trade_uid" style="width:300px" value="<?=$row['trade_uid']?>" /> 淘宝订单后四位，如果你不知道这个是干嘛的，就不要去动它！</td>
  </tr>-->
  <?php }?>
  <tr>
    <td align="right">支付宝：</td>
    <td>&nbsp;<input name="alipay" type="text" id="alipay" value="<?=$row['alipay']?>" /></td>
  </tr>
  <tr>
    <td align="right">财付通：</td>
    <td>&nbsp;<input name="tenpay" type="text" id="tenpay" value="<?=$row['tenpay']?>" /></td>
  </tr>
  <tr>
    <td align="right">邮箱：</td>
    <td>&nbsp;<input name="email" type="text" id="email" value="<?=$row['email']?>" /></td>
  </tr>
  <tr>
    <td align="right">银行：</td>
    <td>&nbsp;<input name="bank_name" type="text" id="bank_name" value="<?=$row['bank_name']?>" /></td>
  </tr>
  <tr>
    <td align="right">银行账号：</td>
    <td>&nbsp;<input name="bank_code" type="text" id="bank_code" value="<?=$row['bank_code']?>" /></td>
  </tr>
  <tr>
    <td align="right"><?=TBMONEY?>总额：</td>
    <td>&nbsp;<input name="jifenbao" type="text" id="jifenbao" value="<?=$row['jifenbao']?>" /></td>
  </tr>
  <tr>
    <td align="right">金钱总额：</td>
    <td>&nbsp;<input name="money" type="text" id="money" value="<?=$row['money']?>" /></td>
  </tr>
  <tr>
    <td align="right">积分总额：</td>
    <td>&nbsp;<input name="jifen" type="text" id="jifen" value="<?=$row['jifen']?>"  /></td>
  </tr>
  <?php if($webset['taoapi']['freeze']>0){?>
  <tr>
    <td align="right">可用<?=TBMONEY?>：</td>
    <td>&nbsp;<?=$row['live_jifenbao']?></td>
  </tr>
  <tr>
    <td align="right">可用金额：</td>
    <td>&nbsp;<?=$row['live_money']?></td>
  </tr>
  <tr>
    <td align="right">可用积分：</td>
    <td>&nbsp;<?=$row['live_jifen']?></td>
  </tr>
  <tr>
    <td align="right">待结算<?=TBMONEY?>：</td>
    <td>&nbsp;<?=$row['freeze_jifenbao']?> <?php if($webset['taoapi']['freeze']==2){?><span class="zhushi">（16日内淘宝订单返<?=TBMONEY?>不准提现）</span><?php }?>
    </td>
  </tr>
  <tr>
    <td align="right">待结算金额：</td>
    <td>&nbsp;<?=$row['freeze_money']?> <?php if($webset['taoapi']['freeze']==2){?><span class="zhushi">（16日内推广佣金不准提现）</span><?php }?>
    </td>
  </tr>
  <tr>
    <td align="right">待结算积分：</td>
    <td>&nbsp;<?=$row['freeze_jifen']?></td>
  </tr>
  <?php }?>
  <tr>
    <td align="right">等级：</td>
    <td>&nbsp;<input name="level" type="text" id="level" value="<?=$row['level']?>" /><span class="zhushi">（一次成功的交易积1点等级）</span></td>
  </tr>
  <tr>
    <td align="right">帐号类型：</td>
    <td>&nbsp;<?=select($user_level_type,$row['type'],'type')?></td>
  </tr>
  <tr>
    <td align="right">红心：</td>
    <td>&nbsp;<input name="hart" type="text" id="hart" value="<?=$row['hart']?>" /></td>
  </tr>
  <tr>
    <td align="right">推荐人id：</td>
    <td>&nbsp;<?=limit_input('tjr',$row['tjr'],150,0)?> <span class="zhushi">会员：<?=$duoduo->select('user','ddusername','id="'.$row['tjr'].'"')?> （当出师后，推荐人id会为0，在“已结束”中记录）</span></td>
  </tr>
  <tr>
    <td align="right">推荐人（已结束）：</td>
    <td>&nbsp;<?=limit_input('tjr_over',$row['tjr_over'],150,0)?> <span class="zhushi">会员：<?=$duoduo->select('user','ddusername','id="'.$row['tjr_over'].'"')?></span></td>
  </tr>
  <tr>
    <td align="right">QQ：</td>
    <td>&nbsp;<input name="qq" type="text" id="qq" value="<?=$row['qq']?>" /> <?=qq($row['qq'])?></td>
  </tr>
  <tr>
    <td align="right">手机：</td>
    <td>&nbsp;<input name="mobile" type="text" id="mobile" value="<?=$row['mobile']?>" /> <?=html_radio(array(1=>'已验证',0=>'未验证'),$row['mobile_test'],'mobile_test')?></td>
  </tr>
  <tr>
    <td align="right">绑定网站：</td>
    <td>&nbsp;<?=is_kong($webnames)?></td>
  </tr>
  <tr>
    <td align="right">已提现金额：</td>
    <td>&nbsp;<?=limit_input('yitixian',$row['yitixian'],150,0)?></td>
  </tr>
  <tr>
    <td align="right">已提现<?=TBMONEY?>：</td>
    <td>&nbsp;<?=limit_input('tbyitixian',jfb_data_type($row['tbyitixian']),150,0)?></td>
  </tr>
  <tr>
    <td align="right">已兑换<?=TBMONEY?>：</td>
    <td>&nbsp;<?=(float)$spend_jifenbao?> <?=TBMONEYUNIT?></td>
  </tr>
   <tr>
    <td align="right">已兑换积分：</td>
    <td>&nbsp;<?=$spend_jifen?> 点</td>
  </tr>
  <tr>
    <td align="right">UCenter id：</td>
    <td>&nbsp;<?=limit_input('ucid',$row['ucid'],150,0)?></td>
  </tr>
  <tr>
    <td align="right">上次签到时间：</td>
    <td>&nbsp;<input name="signtime" type="text" id="signtime" value="<?=$row['signtime']>0?date('Y-m-d H:i:s',$row['signtime']):0?>" /></td>
  </tr>
  <tr>
    <td align="right">连续签到：</td>
    <td>&nbsp;<input name="signnum" type="text" id="signnum" value="<?=$row['signnum']?>" /></td>
  </tr>
  <tr>
    <td align="right">金额提现状态：</td>
    <td>&nbsp;<?=html_radio($tixian_status,$row['txstatus'],'txstatus')?></td>
  </tr>
  <tr>
    <td align="right"><?=TBMONEY?>提现状态：</td>
    <td>&nbsp;<?=html_radio($tixian_status,$row['tbtxstatus'],'tbtxstatus')?></td>
  </tr>
  <tr>
    <td align="right">兑换状态：</td>
    <td>&nbsp;<?=html_radio($duihuan_status,$row['dhstate'],'dhstate')?></td>
  </tr>
  <tr>
    <td align="right">激活：</td>
    <td>&nbsp;<?=html_radio($jihuo_status,$row['jihuo'],'jihuo')?></td>
  </tr>
  <tr>
    <td align="right">淘宝商品网址搜索：</td>
    <td>&nbsp;<?=html_radio(array(0=>'不允许',1=>'允许'),$row['search'],'search')?></td>
  </tr>
  <?php if($webset['taoapi']['auto_fanli']==1){?>
  <?php }?>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>