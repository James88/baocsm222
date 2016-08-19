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
$top_nav_name=array(array('url'=>u('msgset','list'),'name'=>'信息模版设置'),array('url'=>u('smtp','set'),'name'=>'邮件服务器设置'),array('url'=>u('sms','set'),'name'=>'短信设置'));
if($_GET['ddopenpwd']!=''){
	$url=DD_OPEN_URL.'/?m=user&a=getweb&url='.urlencode(URL).'&pwd='.md5(md5($_GET['ddopenpwd']));
	$a=dd_get($url);
	echo $a;
	exit;
}

$do=$_GET['do'];

include(ADMINTPL.'/header.tpl.php');
?>
<script>
var myDate = new Date();
$(function(){
	$('#testMobile').click(function(){
		var sms={};
		sms.mobile=$('#test_mobile').val();
		sms.test=1;
		$sub=$(this);
		$sub.attr({'disabled':true});
		if(regMobile(sms.mobile)==false){
			alert('手机号码格式错误');
			$sub.attr({'disabled':false});
		}
		else{
			$.post('<?=u(MOD,ACT)?>',sms,function(data){
			    //data=parseInt(data);
				if(data==1){
				    alert('短信发送成功！');
					/*var $a=$('.explain-col .tip span b');
					var t=parseInt($a.text())-1;
					$a.html(t);*/
				}
				else{
				    alert(data);
				}
			    $sub.attr({'disabled':false});
		    });
	    }
    });
	
	$('#getddshouquan').jumpBox({  
	    title: '获取短信密钥',
		titlebg:1,
		height:140,
		width:450,
		contain:'<div id="ddform">平台登陆密码：<input id="ddopenpwd" type="password" name="ddopenpwd" value="" /> <input type="submit" onclick="shouquan($(this))" value="登录获取" /></div><br><a style="float:right"" href="<?=DD_OPEN_JFB_REG_URL?><?=urlencode(URL)?>">没有？点击去注册&gt;&gt;</a>',
		LightBox:'show'
    });
	if(parseInt($('input[name="sms[open]"]:checked').val())==0){
		$('.smsopen').hide();
		$('.smsopen1').hide();
	}
	$('input[name="sms[open]"]').click(function(){
        if($(this).val()==1){
		    $('.smsopen').show();
		}
		else if($(this).val()==0){
		    $('.smsopen').hide();
			 $('.smsopen1').hide();
		}
	});
});

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
			$('#sms_sign').val(data.r.sms_sign);
            $('#sms_pwd').val(data.r.sms_pwd);
			jumpboxClose();
		}
		else{
			alert('密码错误');
			$t.attr('disabled',false);
		}
	});
}

function subF(){
	
	if($('input[name="sms[open]"]:checked').val()==1){
		var sign=$('#sms_sign').val();
		var pwd=$('#sms_pwd').val(); 
		if(sign=='' || pwd==''){
			alert('短信签名或短信密钥不能为空');
			return false;
		}
		if($('#sms_sign').val().length>4){
			alert('短信签名不能大于4个字符');
			return false;
		}
	}

	return true;
}
</script>
<script src="<?=DD_OPEN_URL?>/alert.js"></script>

<div class="explain-col">
<table cellspacing="0" width="100%">
        <tr>
          <td width="120" style="color:#F00">&nbsp;短信监控信息</td>
          <td width="120">&nbsp;<a href="<?=u(MOD,ACT,array('do'=>'iframe'))?>">短信发送模版</a></td>
          <td width="180" height="15">&nbsp;服务器状态：<?php if($dd_open_status=='ok'){?><span style="color:#060" title="与平台连接正常">正常</span><?php }else{?><span style="color:red" title="与平台连接异常">异常</span><?php }?></td> 
          <td width="380" class="tip">状态信息：<?=$sms_tip?> </td>
          <?php if(DLADMIN!=1){?>
          <td width="112"><a href="<?=DD_OPEN_SMS_HELP_URL?>" target="_blank" style=" color:#F00" title="购买短信">购买短信</a></td>
          <td width="">&nbsp;&nbsp;<a href="<?=DD_OPEN_URL?>/top/zizhu.php?type=sms&domain=<?=get_domain(URL)?>" style=" color:#F0F" title="淘宝购买付款后点次来自助充值短信">自助充值短信</a></td>
          <?php }?>
        </tr>
      </table>
</div>
<?php if($do==''){?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1" onsubmit="return subF()">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  
  <tr>
    <td width="150px" align="right">状态：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$webset['sms']['open'],'sms[open]')?> </td>
  </tr>
  <tr class="smsopen">
    <td align="right">账号：</td>
    <td>&nbsp;<?=get_domain(URL)?></td>
  </tr>
  <tr class="smsopen">
    <td align="right">短信密钥：</td>
    <td>&nbsp;<input id="sms_pwd" name="sms[pwd]" readonly="readonly" style="width:80px" value="<?=$webset['sms']['pwd']?>" /> <button class="sub" id="getddshouquan">获取数据</button></td>
  </tr>
  <tr class="smsopen">
    <td align="right">短信签名：</td>
    <td>&nbsp;<input id="sms_sign" name="sms[sign]" style="width:80px" value="<?=$sms_sign?>" /><span class="zhushi">网站名称，最长4个字符（中文数字字母都个算一个字符），注意：短信签名要平台审核后才能正常使用</span></td>
  </tr>
  <tr class="smsopen">
    <td align="right">验证码间隔时间：</td>
    <td>&nbsp;<input id="" name="sms[yzmjg]" style="width:50px" value="<?=$webset['sms']['yzmjg']?$webset['sms']['yzmjg']:'60'?>" />（秒） <span class="zhushi">获取手机验证码的间隔时间，默认为60秒</span></td>
  </tr>
  <tr class="smsopen">
    <td align="right">手机验证限制：</td>
    <td>&nbsp;<input id="" name="sms[limit]" value="<?=$webset['sms']['limit']?$webset['sms']['limit']:0?>" /> <span class="zhushi">24小时内最多获取验证码的次数，为0是不限制</span></td>
  </tr>
  <tr class="smsopen">
    <td width="150px" align="right">强制手机验证：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$webset['sms']['need_yz'],'sms[need_yz]')?> <span class="zhushi">提现，兑换等行为是否需要强制手机验证</span></td>
  </tr>
  <tr class="smsopen1"><td colspan="2"><hr/></td></tr>
  <tr class="smsopen1">
    <td align="right">短信号码（移动）：</td>
    <td>&nbsp;<input id="" name="sms[yidong]" value="<?=$webset['sms']['yidong']?$webset['sms']['yidong']:'1252007015917385693'?>" /> <span class="zhushi">发送短信的来源号码，未得到通知不要修改，否则后果自负</span></td>
  </tr>
  <tr class="smsopen1">
    <td align="right">短信号码（联通）：</td>
    <td>&nbsp;<input id="" name="sms[liantong]" value="<?=$webset['sms']['liantong']?$webset['sms']['liantong']:'10690259905429'?>" /> <span class="zhushi">发送短信的来源号码，未得到通知不要修改，否则后果自负</span></td>
  </tr>
  <tr class="smsopen1">
    <td align="right">短信号码（电信）：</td>
    <td>&nbsp;<input id="" name="sms[dianxin]" value="<?=$webset['sms']['dianxin']?$webset['sms']['dianxin']:'18007524761'?>" /> <span class="zhushi">发送短信的来源号码，未得到通知不要修改，否则后果自负</span></td>
  </tr>
  <tr class="smsopen1">
    <td align="right">测试手机号：</td>
    <td>&nbsp;<input id="test_mobile" value="" />&nbsp;<input type="button" value="测试短信发送"  id="testMobile" /></td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /> <span class="zhushi"><a href="http://bbs.duoduo123.com/read-1-1-198025.html" target="_blank">设置教程</a></span></td>
  </tr>
  
</table>
</form>
<?php }else{?>
<iframe src="<?=DD_OPEN_URL?>/sms.tpl.html" frameborder="0" style="width:100%; height:800px"></iframe>
<?php }?>
<?php include(ADMINTPL.'/footer.tpl.php');?>