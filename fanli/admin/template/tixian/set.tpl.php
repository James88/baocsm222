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
$check_arr['tixian']['need_alipay'] = $webset['tixian']['need_alipay'];
$check_arr['tixian']['need_tenpay'] = $webset['tixian']['need_tenpay'];
$check_arr['tixian']['need_bank'] = $webset['tixian']['need_bank'];

if($_GET['ddopenpwd']!=''){
	$url=DD_OPEN_URL.'/?m=user&a=getweb&url='.urlencode(URL).'&pwd='.md5(md5($_GET['ddopenpwd']));
	$a=dd_get($url);
	echo $a;
	exit;
}
$top_nav_name=array(array('url'=>u(MOD,'set'),'name'=>'提现设置'),array('url'=>u(MOD,'bank'),'name'=>'银行设置'));
$bank=dd_get_cache('bank');
include(ADMINTPL.'/header.tpl.php');
?>
<script>
$(function(){
	if(parseInt($('input[name="tixian[ddpay]"]:checked').val())==1){
		$('#ddkey').show();
	}
	
	$('input[name="tixian[ddpay]"]').click(function(){
		if(parseInt($(this).val())==1){
			$('#ddkey').show();
		}
		else{
			$('#ddkey').hide();
		}
	});
	
	$('#getddshouquan').jumpBox({  
	    title: '获取通信字符串',
		titlebg:1,
		height:140,
		width:450,
		contain:'<div id="ddform">平台登陆密码：<input id="ddopenpwd" type="password" name="ddopenpwd" value="" /> <input type="submit" onclick="shouquan($(this))" value="登录获取" /></div><br> <a style="float:right" href="http://issue.duoduo123.com/index.php?m=user&a=getpwd_email&name=<?=urlencode(URL)?>">找回密码？&gt;&gt;</a> <a style="float:right" href="<?=DD_OPEN_JFB_REG_URL?><?=urlencode(URL)?>">没有？点击去注册&gt;&gt;</a>',
		LightBox:'show'
    });
	<?=check_box($check_arr,1);?>
	/*$('input[id="tixian[need_alipay]"]').click(function(){
			if($('input[name="tixian[need_alipay]"]').val()==0){
			$('input[name="tixian[need_alipay]"]').val(1);
			}else{
			$('input[name="tixian[need_alipay]"]').val(0);
			}
	});
	
	$('input[id="tixian[need_tenpay]"]').click(function(){
			if($('input[name="tixian[need_tenpay]"]').val()==0){
			$('input[name="tixian[need_tenpay]"]').val(1);
			}else{
			$('input[name="tixian[need_tenpay]"]').val(0);
			}
	});
	$('input[id="tixian[need_bank]"]').click(function(){
			if($('input[name="tixian[need_bank]"]').val()==0){
			$('input[name="tixian[need_bank]"]').val(1);
			}else{
			$('input[name="tixian[need_bank]"]').val(0);
			}
	});*/
	if($('input[name="tixian[need_bank]"]').val()==0){
		$('.need_bank').hide();
	}
	$('input[id="tixian[need_bank]"]').click(function(){
		if($('input[name="tixian[need_bank]"]').val()==0){
			$('.need_bank').hide();
		}
	});
})

function shouquan($t){
	var ddopenpwd=$('#ddopenpwd').val();
	if(ddopenpwd==''){
		alert('登录密码不能为空');
		$('#ddopenpwd').focus();
		return false;
	}
	
	$t.attr('disabled','true');
	var url='<?=u(MOD,ACT)?>&ddopenpwd='+encodeURIComponent(ddopenpwd);
	$.getJSON(url,function(data){
		if(data.s==1){
			$('#tixian_key').val(data.r.key);
			jumpboxClose();
		}
		else{
			alert('密码错误');
			$t.attr('disabled',false);
		}
	});
}
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="150" align="right">淘宝最低提现限额：</td>
    <td>&nbsp;<input style=" width:60px;"  name="tixian[tblimit]" value="<?=$webset['tixian']['tblimit']?>" /><?=TBMONEY?></td>
  </tr>
  <tr>
    <td align="right">淘宝提现必须是：</td>
    <td height="30">&nbsp;<input style=" width:60px;"  name="tixian[tbtxxz]" value="<?=$webset['tixian']['tbtxxz']?>" />的整数倍<span class="zhushi">（0 表示不限制）</span></td>
  </tr>
  <tr>
    <td align="right">金额最低提现限额：</td>
    <td>&nbsp;<input style=" width:60px;"  name="tixian[limit]" value="<?=$webset['tixian']['limit']?>" /><span class="zhushi">元</span></td>
  </tr>
  <tr>
    <td align="right">提现最低等级：</td>
    <td>&nbsp;<input style=" width:60px;"  name="tixian[level]" value="<?=$webset['tixian']['level']?>" /> <span class="zhushi">会员达到多少等级才能提现，不限制请填写0</span></td>
  </tr>
  <tr>
    <td align="right">金额提现必须是：</td>
    <td>&nbsp;<input style=" width:60px;"  name="tixian[txxz]" value="<?=$webset['tixian']['txxz']?>" /><span class="zhushi">的整数倍（0 表示不限制）</span></td>
  </tr>
  <tr>
    <td align="right">集分宝自动发放：</td>
    <td>&nbsp;<?=html_radio(array('0'=>'关闭',1=>'开启'),$webset['tixian']['ddpay'],'tixian[ddpay]')?> <span class="zhushi">后台确认集分宝提现，由统一接口为您代发 &nbsp;</span></td>
  </tr>
  <tr id="ddkey" style="display:none">
    <td align="right">平台集分宝通信字符串：</td>
    <td>&nbsp;<input name="tixian[key]" id="tixian_key" value="<?=$webset['tixian']['key']?>" /><button class="sub" id="getddshouquan">获取数据</button><span class="zhushi">&nbsp;作为平台与您的通信证书 <a href="http://bbs.duoduo123.com/read-1-1-198029.html" target="_blank">设置教程</a></span></td>
  </tr>
<?=check_box($check_arr,2);?>
  <tr>
    <td align="right">提现可选字段：</td>
    <td>&nbsp;<label><input  value="1" <?php if($webset['tixian']['need_alipay']==1){?> checked="checked"<?php }?> type="checkbox" id="tixian[need_alipay]" />支付宝</label> 
              <label><input value="1" <?php if($webset['tixian']['need_tenpay']==1){?> checked="checked"<?php }?> type="checkbox" id="tixian[need_tenpay]" />财付通</label>
              <label><input  value="1" <?php if($webset['tixian']['need_bank']==1){?> checked="checked"<?php }?> type="checkbox" id="tixian[need_bank]" />银行</label>&nbsp;&nbsp;<?php if($webset['tixian']['need_bank']==1){?> <span class="zhushi need_bank"><a href="index.php?mod=tixian&amp;act=bank">银行设置</a> </span><?php }?></td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>