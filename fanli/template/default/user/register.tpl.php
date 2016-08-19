<?php
if(!defined('INDEX')){
	exit('Access Denied');
}
$parameter=act_user_register();
extract($parameter);
$css[]=TPLURL."/inc/css/usercss.css";
include(TPLPATH.'/inc/header.tpl.php');
?>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="<?=TPLURL?>/inc/js/jquery.emailmatch.js"></script>
<div class="mainbody">
<div class="mainbody1000">
<?=AD(14)?>
	<div class="register biaozhun5">
    <div class="register_left">
     <p class="title">新用户注册</p>
     <form id="register_form" name="form" method="post" action="<?=u('user','register')?>">
<table width="680" border="0" align="left" cellpadding="0" cellspacing="0">
		<?php if($default_name!=''){list($dduser['reg_from'],$a)=reg_web_email($webid . '@' . $web . '.com');?>
        <tr><td></td><td height="55" align="left" colspan="2" style="line-height:23px" ><?=$default_name?>，您好！您已经用<?=$dduser['reg_from']?>成功登录<?=WEBNAME?>，<br/>请完善以下信息以便更好使用我们网站。</td></tr><tr>
        <?php }?>
        <tr>
		  <td height="55" align="right" >邮箱 *&nbsp;&nbsp;</td>
		  <td><li id="emailMatch_list"><input name="email" type="text" id="email" value="<?=$default_email?>" class="ddinput" autocomplete="off"/></li></td>
		  <td id="ckemail"><label class="field_notice">请务必填写正确，取回密码用</label><label id="checking_email" class="checking">检查中...</label></td>
		</tr>
        <?php if($default_name!=''){?>
		<input type="hidden" name="password" id="password" value="<?=$default_pwd?>" /><input type="hidden" id="password_confirm" name="password_confirm" value="<?=$default_pwd2?>" />
        <?php }else{?>
		<tr>
		  <td height="55" align="right">密码 *&nbsp;&nbsp;</td>
		  <td><input name="password" type="password" id="password" class="ddinput" value="<?=$default_pwd?>"/></td>
		  <td id="ckpass"><label class="field_notice">密码为长度 6 - 20 位</label></td>
		</tr>
		<tr>
		  <td height="55" align="right">确认密码 *&nbsp;&nbsp;</td>
		  <td><input name="password_confirm" type="password" id="password_confirm" class="ddinput" value="<?=$default_pwd2?>"/></td>
		  <td id="ckpass2"><label class="field_notice">请再次输入密码</label></td>
		</tr>
        <?php }?>
        <tr>
		  <td width="20%" height="55" align="right">&nbsp;&nbsp;昵称 *&nbsp;&nbsp;</td>
		  <td><input name="username" type="text" id="username" class="ddinput" value="<?=$default_name?>" /></td>
		  <td width="50%" id="ckuser"><label class="field_notice">昵称长度3-15个字符（一个中文字2个字符）</label><label id="checking_user" class="checking">检查中...</label></td>
		</tr>
        <?php if($webset['user']['need_qq']==1){?>
        <?php if($default_name=='' || $default_name!='' && $webset['user']['autoreg']==0){?> 
		<tr>
		  <td height="55" align="right" >QQ号码 *&nbsp;&nbsp;</td>
		  <td><input name="qq" type="text" id="qq"  onkeyup="value=value.replace(/[^\d]/g,'')" value="" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" onblur="var qq=$(this).val();if(qq=='') return false;qq=qq+'@qq.com';if($('#email').val()==''){$('#email').val(qq)}" class="ddinput"/></td>
		  <td id="ckqq2"><label class="field_notice">以便客服及时联系您</label></td>
		</tr>
        <?php }?>
        <?php }?>
        <?php if($webset['user']['need_alipay']==1){?>
        <?php if($default_name=='' || $default_name!='' && $webset['user']['autoreg']==0){?>
        <tr>
		  <td height="55" align="right" >支付宝 *&nbsp;&nbsp;</td>
		  <td><input name="alipay" type="text" id="alipay" value="" onblur="if($('#email').val()==''){$('#email').val(this.value)}" class="ddinput"/></td>
		  <td id="ckalipay"><label class="field_notice">务必填写正确</label><label id="checking_alipay" class="checking">检查中...</label></td>
		</tr>
        <?php }?>
        <?php }?>
        
        <?php if($webset['user']['need_tbnick']==1&&TAOTYPE==1){?>
		<tr>
		  <td height="55" align="right" >订单号 *&nbsp;&nbsp;</td>
		  <td><input name="tbnick" type="text" id="tbnick"  value="<?php if($web=='tb'){echo $default_name;}?>"  class="ddinput"/></td>
		  <td><label class="field_notice">您的淘宝订单号 <?php if($webset['jiaocheng']['tbnick']!=''){?><a href="<?=$webset['jiaocheng']['tbnick']?>" target="_blank" style="color:#F00">如何填？</a><?php }?></label><label id="checking_tbnick" class="checking">检查中...</label></td>
		</tr>
        <?php }?>
        
        <?php if($webset['user']['need_tjr']==1){if(get_cookie("tjr")>0){$tjrname=$duoduo->select('user','ddusername','id="'.get_cookie("tjr").'"');}?>
		<tr>
		  <td height="55" align="right" >推荐人 &nbsp;&nbsp;&nbsp;</td>
		  <td><input name="tjrname" type="text" id="tjrname"  value="<?=$tjrname?>"  class="ddinput"/></td>
		  <td><label class="field_notice">推荐人帐号/邮箱</label><label id="checking_tjrname" class="checking">检查中...</label></td>
		</tr>
        <?php }?>
		
        <?php if($default_name==''){?>
        <?php if($webset['yinxiangma']['open']==0){?>
		<tr>
		  <td height="55" align="right" >验证码 *&nbsp;&nbsp;</td>
		  <td><input name="captcha" type="text" id="captcha" size="6" maxlength="4" style="width:180px;" class="ddinput"/>&nbsp;&nbsp;<?=yzm()?></td>
		  <td id="ckyzm"><label class="field_notice">请填写验证码</label><label id="checking_captcha" class="checking">检查中...</label></td>
		</tr>
        
        <?php }else{?>
        <tr>
		  <td align="right">验 证 码 *&nbsp;&nbsp;</td>
		  <td colspan="2" id="yinxiangma" style="width:300px; overflow:hidden" ><?=$yinxiangma?></td>
		</tr>
        <?php }?>
        <?php }?>
		<tr>
		  <td height="55">&nbsp;</td>
		  <td colspan="2"><input name="agree" id="agree" type="checkbox" value="checkbox" checked="checked" /><span> 我已经阅读过并同意声明</span></td>
	    </tr>
		<tr>
		  <td height="55">&nbsp;</td>
		  <td><input type="hidden" name="from" value="<?=$url_from?>" />
          <?php if(isset($web) && $web!=''){?>
          <input type="hidden" name="webid" value="<?=authcode($webid,'ENCODE',DDKEY);?>" /><input type="hidden" name="webname" value="<?=$webname?>" /><input type="hidden" name="web" value="<?=$web?>" />
          <?php }?>
          <input type="submit" name="sub" value="马上注册"  class="register_b">
          </td>
		  <td></td>
		</tr>
	  </table>
      </form>
      <div style="clear:both"></div>
      <div class="shengming"><fieldset style="padding:0px 10px 10px 10px">
      <legend>网站声明</legend>
      <div style="height:10px"></div>
      <p>1、所有提供的所有商品均通过淘宝网和其他商城（如凡客，一号店）进行交易，本网站只提供相关的链接和推广，所以不承担商品的质量及售后服务。</p>
      <p>2、本站不涉及网络支付等问题，所有商品购买最终都通过淘宝网及各大商城，故不存在账号泄露等问题，请买家放心。</p>
      <p>3、<?=WEBNAME?>祝大家购物愉快！</p>
      </fieldset>
      </div>
      </div>
      <div class="register_right">
          <div class="register_right_1">
              <p>已经有帐号？请直接登录  </p>
              <div style="margin:auto; width:80px"><a href="<?=u('user','login')?>" class="register_b2" style="display:block; line-height:29px; color:#FFF; margin-top:10px">登 陆</a></div>
              </div>
              <?php if($app_show==1){?>
              <div class="register_right_2">
              <p>您也可以用以下合作网站账号登录</p>
              <ul>
              <?php foreach($apps as $row){?>
                <li><a class="<?=$row['code']?>" href="<?=u('api','do',array('code'=>$row['code'],'do'=>'go'))?>"><img src="<?=TPLURL.'/inc/images/login/'.$row['code'].'_1.gif'?>" alt="<?=$row['title']?>" /> <?=$row['title']?></a></li>
              <?php }?>              
              </ul>
          </div>
          <?php }?>
      </div>

    </div>
</div>
</div>
<script>
function emailMatchOver(){
	if($('#username').val()==''){
		var email=$('#email').val()
		var a=email.split('@');
		$('#username').val(a[0]);
	}
}

$(function(){
	
	$("#email").emailMatch({wrapLayer:"#emailMatch_list"});
	
    $('#register_form').validate({
        errorPlacement: function(error, element){
            var td = element.parents('td');
			var error_td = td.next('td');
            error_td.find('.field_notice').hide();;
            error_td.append(error);
			//td.find('input').css('border','red 1px dotted');
        },
        success       : function(label){
            label.addClass('validate_right').text('OK!');
        },
        onkeyup: false,
        rules : {
            username : {
                required : true,
                byteRange: [3,15,'utf-8'],
				remote   : {
                    url :'index.php?mod=ajax&act=check_user',
                    type:'post',
                    data:{
                        username : function(){
                            return $('#username').val();
                        }
                    },
                    beforeSend:function(){
                        var _checking = $('#checking_user');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#checking_user').hide();
                    }
                }
            },
			<?php if($webset['user']['need_tjr']==1){?>
			tjrname : {
                byteRange: [3,50,'utf-8']
            },
			<?php }?>
			<?php if($webset['user']['need_tbnick']==1&&TAOTYPE==1){?>
			tbnick : {
				required : true,
				byteRange: [3,100,'utf-8'],
				remote   : {
                    url :'index.php?mod=ajax&act=check_tbnick&t=<?=TIME?>',
                    type:'post',
                    data:{tbnick : function(){return $('#tbnick').val();},type:1},
                    beforeSend:function(){
                        var _checking = $('#checking_tbnick');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#checking_tbnick').hide();
                    }
                }
            },
			<?php }?>
            password : {
                required : true,
                minlength: 6
            },
            password_confirm : {
                required : true,
                equalTo  : '#password'
            },
            email : {
                required : true,
                email    : true,
				remote   : {
                    url :'index.php?mod=ajax&act=check_email',
                    type:'post',
                    data:{
                        email : function(){
                            return $('#email').val();
                        }
                    },
                    beforeSend:function(){
                        var _checking = $('#check_email');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#check_email').hide();
                    }
                }
            },
			<?php if($webset['user']['need_alipay']==1 && $default_name==''){?>
			alipay : {
                required : true,
                alipay    : true,
				remote   : {
                    url :'index.php?mod=ajax&act=check_alipay',
                    type:'post',
                    data:{
                        alipay : function(){
                            return $('#alipay').val();
                        }
                    },
                    beforeSend:function(){
                        var _checking = $('#check_alipay');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#check_alipay').hide();
                    }
                }
            },
			<?php }?>
			<?php if($webset['user']['need_qq']==1 && $default_name==''){?>
            qq : {
                required : true,
                range:[1000,999999999999]
            },
			<?php }?>
			<?php if($auto_submit==0){?>
			captcha : {
                required : true,
                rangelength:[4,4],
				remote   : {
                    url :'index.php?mod=ajax&act=check_captcha',
                    type:'post',
                    data:{
                        captcha : function(){
                            return $('#captcha').val();
                        }
                    },
                    beforeSend:function(){
                        var _checking = $('#check_captcha');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#check_captcha').hide();
                    }
                }
            },
			<?php }?>
            agree : {
                required : true
            }
        },
        messages : {
            username : {
                required : '您必须提供一个用户名',
                byteRange: '用户名必须在3-15个字符之间',
				remote   : '用户名已存在'
            },
			<?php if($webset['user']['need_tjr']==1){?>
			tjrname : {
                byteRange: '用户名必须在3-15个字符之间',
				remote   : '推荐人不存在'
            },
			<?php }?>
			<?php if($webset['user']['need_tbnick']==1&&TAOTYPE==1){?>
			tbnick : {
				required : '您必须提供一个淘宝订单号',
                byteRange: '用户名位数错误',
				remote   : '淘宝订单号异常。'
            },
			<?php }?>
            password  : {
                required : '您必须提供一个密码',
                minlength: '密码长度应在6-20个字符之间'
            },
            password_confirm : {
                required : '您必须再次确认您的密码',
                equalTo  : '两次输入的密码不一致'
            },
            email : {
                required : '您必须提供您的电子邮箱',
                email    : '这不是一个有效的电子邮箱',
				remote   : '邮箱已存在'
            },
			<?php if($webset['user']['need_alipay']==1 && $default_name==''){?>
			alipay : {
                required : '您必须提供您的支付宝',
                alipay    : '这不是一个有效的支付宝',
				remote   : '支付宝已存在'
            },
			<?php }?>
			<?php if($webset['user']['need_qq']==1 && $default_name==''){?>
			qq : {
                required : '您必须提供您的QQ号码',
                range:'QQ号码位数错误'
            },
			<?php }?>
			<?php if($auto_submit==0){?>
            captcha : {
                required : '请输入右侧图片中的文字',
				rangelength    : '位数错误',
				remote   : '填写错误'
            },
			<?php }?>
            agree : {
                required : '您必须阅读并同意该协议'
            }
        }/*,
		submitHandler: function(form) {   
			ajaxPostForm(form,'<?=u('user','index')?>');
        } */
    });
	<?php if($auto_submit==1){?>
	//setTimeout("$('#register_form').submit();",5000);
	$('#register_form').submit();
	<?php }?>
});
</script>
<?php
include(TPLPATH.'/inc/footer.tpl.php');
?>