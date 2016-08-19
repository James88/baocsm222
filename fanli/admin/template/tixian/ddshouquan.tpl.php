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
?>
<style>
#qiehuan{float:left}
#qiehuan .tip{text-decoration:underline; cursor:pointer; font-weight:blod; }
</style>
<script>
var TITLE_BG='获取校验码';
$(function(){
	$('#getddshouquan').jumpBox({  
	    title: TITLE_BG,
		titlebg:1,
		height:180,
		width:450,
		contain:'<div id="ddform">验证类型：<label class="radio inline"><input  type="radio" name="ddopentype" value="send_sms"checked="checked"/><span>手机验证</span></label><label class="radio inline"><input  type="radio" name="ddopentype" value="send_email" /><span>邮箱验证</span></label><br/><br/>平台密码：<input id="ddopenpwd" type="password" name="ddopenpwd" value="" /> <input type="submit" onclick="shouquan($(this))" value="获取校验码" /></div><br/><div><div id="qiehuan"><div onclick="set_sms_form()" class="tip">直接输入校验码</div></div><div style=" float:right"><a href="<?=DD_OPEN_JFB_REG_URL?><?=urlencode(URL)?>">注册</a> <a href="<?=DD_OPEN_URL?>/index.php?m=user&a=getpwd_email&name=<?=urlencode(DOMAIN)?>">找回密码</a> <a target="_blank" href="<?=DD_OPEN_SMS_HELP_URL?>">短信购买</a> <?php if(DLADMIN!=1){?><a target="_blank" href="http://bbs.duoduo123.com/read.php?tid=166841">教程</a><?php }?></div><div style=" clear:both"></div></div>',
		LightBox:'show'
    });
});

function set_sms_form(){
	$('#ddform').html('安全校验码：<input id="checksum" name="checksum" value="" /> <input type="submit" onclick="save_checksum($(this));" value="保存" />');
	$('#qiehuan').html('<div class="tip" onclick="set_mima_form()">输入平台密码</div>');
}

function set_mima_form(){
	$('#ddform').html('平台登陆密码：<input id="ddopenpwd" type="password" name="ddopenpwd" value="" /> <input type="submit" onclick="shouquan($(this))" value="获取校验码" />');
	$('#qiehuan').html('<div class="tip" onclick="set_sms_form()">直接输入安全校验码</div>');
}

function shouquan($t){
	var ddopenpwd=$('#ddopenpwd').val();
	if(ddopenpwd==''){
		alert('登录密码不能为空');
		$('#ddopenpwd').focus();
		return false;
	}
	
	var ddopentype=$('input[name="ddopentype"]:checked').val();
	if(ddopentype==''){
		alert('验证类型不能为空');
		return false;
	}
	
	$t.attr('disabled',true);
	var url='<?=u(MOD,ACT,array('send_checksum'=>1))?>&ddopenpwd='+encodeURIComponent(ddopenpwd)+"&ddopentype="+ddopentype;
	$.getJSON(url,function(data){
		if(data.s==0){
			alert(data.r);
			$('#jfbtip').html(data.r);
			$t.attr('disabled',false);
		}
		else{
			if(ddopentype=='send_sms'){
				var word='手机号：'+data.r.phone;
			}
			else{
				var word='邮箱：'+data.r.email;
			}
			$('.titlebg').html(TITLE_BG+'   <b style=" color:red">'+word+'</b>');
			set_sms_form();
		}
	});
}

function save_checksum($t){
	var checksum=$('#checksum').val();
	if(checksum==''){
		alert('校验码不能为空');
		$('#checksum').focus();
		return false;
	}
	$t.attr('disabled','true');
	var url='<?=u(MOD,ACT,array('save_checksum'=>1))?>&checksum='+encodeURIComponent(checksum);
	$.get(url,function(data){
		if(isNaN(data)){
			alert(data);
			$t.attr('disabled',false);
		}
		else{
			location.replace(location.href);
		}
	});
}
</script>
<?php if(ACT=='list'){?>
<script src="<?=DD_OPEN_URL?>/alert.js"></script>
<div class="explain-col">
<table cellspacing="0" width="100%">
        <tr>
          <td width="120" style="color:#F00">&nbsp;集分宝监控信息</td>
              <td width="120" height="15">&nbsp;服务器状态：<?php if($dd_open_status=='ok'){?><span style="color:#060" title="与集分宝自动发放平台连接正常">正常</span><?php }else{?><span style="color:red" title="与集分宝自动发放平台连接异常">异常</span><?php }?></td> 
              <td width="400">自动发送状态：<span id="jfbtip"></span><?=$jfb_tip?> </td>
              <?php if(DLADMIN!=1){?>
              <td width="112"><a href="<?=DD_OPEN_JFB_HELP_URL?>" target="_blank" style=" color:#F00" title="淘宝购买充值集分宝费率仅7%">购买集分宝</a></td>
              <td width="">&nbsp;&nbsp;<a href="<?=DD_OPEN_URL?>/top/zizhu.php?domain=<?=get_domain(URL)?>" style=" color:#F0F" title="淘宝购买付款后点次来自助获取集分宝">自助充值集分宝</a></td>
              <?php }?>
            </tr>
      </table>
</div>
<?php }?>