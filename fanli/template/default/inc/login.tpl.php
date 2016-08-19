<div class="light-box" id="light-box"></div>
<div id="jump-box" show="0" class="jump-box" style="display:none">
<div class="alert_bg" id="alert_fast_log_reg" style="left:0px; position:relative; top:0px">
	<div class="alert_box">
<div class="alert_top"><span><a style="color:#090; text-decoration:underline" target="_blank" id="gototaobao" href="" onclick="$('#jump-box,#light-box').hide();">不登录直接购买</a></span><span class="alert_close" style="cursor:pointer" onclick="hideLoginWin()"></span></div>
<div class="alert_content">

<div class="login_reg">
<ul class="l_r_menu">
  <li><a href="javascript:;" class="l_log current">登录</a></li>
  <li><a href="javascript:;" class="l_reg">注册</a></li>
</ul>
<div class="l_r_login" id="log">
  <div class="login">
  <form action="<?=u('user','login')?>" method="post" onsubmit="return ajaxLogin(this)">
  
    <span class="fl">帐号：</span><input type="text" value="" class="login_name"  tabindex="1" name="username" id="username1" />
    <div style="clear:both"></div>
    <span class="fl">密码：</span><input type="password" class="login_pwd"  tabindex="2" name="password" id="password1"/>
    <div style="clear:both"></div>
    <font><input type="checkbox" class="checkbox" value="1" name="remember" id="remember" checked="checked"><label for="checkbox">记住我<span>（3个月免登陆）</span></label></font>
    <div style="clear:both"></div>
    <input type="hidden" name="sub" value="1" />
    <div style="margin-top:10px;">
    <div style="float:left;margin-left:50px; _margin-left:20px"><input type="submit" class="button" value="登 录"  tabindex="3" /></div><div style="float:left;margin-left:20px;"><a href="<?=u('user','getpassword')?>" class="fo_psw" target="_blank">忘记密码?</a></div>
    </div>
    <div style="clear:both"></div>
  </form>
  </div>
  <?php if($app_show==1){?>
  <div class="union_login">
    <p>站外账号登录：</p>
    <?php foreach($apps as $row){?>
    <a class="l_<?=$row['code']?>" href="<?=u('api',$row['code'])?>"><img style="margin-bottom:-3px" src="<?=TPLURL?>/inc/images/login/<?=$row['code']?>_1.gif" />&nbsp;<?=$row['title']?></a>
    <?php }?>
  </div>
  <?php }?>
  </div>
  <div class="login_reg" id="reg" style="display:none; padding-top:0px;">
  <div class="l_r_reg" id="fill">
  <form id="register_form" name="form" action="<?=u('user','register')?>" method="post">
  <ul class="reg">
  <table border="0">
  
  <tr>
    <td><label for="username" class="fl">用户账号：</label></td>
    <td><input type="text" class="reg_name" id="username" tabindex="1" name="username" /></td>
    <td><label class="field_notice">用户名长度3-15位字母或数字</label><label id="checking_user" class="checking">检查中...</label></td>
  </tr>
  <tr>
    <td><label for="password" class="fl">登录密码：</label></td>
    <td><input type="password" class="reg_pwd" id="password" tabindex="2" name="password" /></td>
    <td><label class="field_notice">密码6～16位，区分大小写</label></td>
  </tr>
  <tr>
    <td><label for="password" class="fl">重复密码：</label></td>
    <td><input type="password" class="reg_pwd" id="password_confirm" tabindex="3" name="password_confirm" /></td>
    <td><label class="field_notice">密码6～16位，区分大小写</label></td>
  </tr>
  <tr>
    <td><label class="fl" for="email">电子邮箱：</label></td>
    <td><input type="text" value="" class="reg_email" id="email" tabindex="4" name="email" /></td>
    <td><label class="field_notice">请输入有效邮箱地址</label></td>
  </tr>
  <?php if($webset['user']['need_qq']==1 && $default_name==''){?>
  <tr>
    <td><label for="qq" class="fl">填写QQ：</label></td>
    <td><input type="test" class="reg_pwd" id="qq" tabindex="5" name="qq" /></td>
    <td><label class="field_notice">填写您的QQ号</label></td>
  </tr>
  <?php }?>
  <?php if($webset['user']['need_alipay']==1 && $default_name==''){?>
  <tr>
    <td><label for="qq" class="fl">填写支付宝：</label></td>
    <td><input type="test" class="reg_pwd" id="alipay" tabindex="6" name="alipay" /></td>
    <td><label class="field_notice">务必填写正确</label><label id="checking_alipay" class="checking">检查中...</label></td>
  </tr>
  <?php }?>
  <tr>
    <td><label for="captcha" class="fl">写验证码：</label></td>
    <td><input name="captcha" type="text" id="captcha" tabindex="7" maxlength="4" style="width:136px;" class="ddinput"/>&nbsp;&nbsp;<?=yzm()?></td>
    <td><label class="field_notice">填写4位验证码</label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="hidden" name="sub" value="1" />
    <input type="submit" class="button" name="sub" value="注 册" tabindex="8" id="submits" /></td>
    <td>&nbsp;</td>
  </tr>
</table>
  </ul>
  </form>
  </div>
  </div>
  </div>
</div>
</div>

<script src="js/jquery.validate.js"></script>
<script type="text/javascript">
$(function(){
    $('.l_r_menu li a').click(function(){
	    $('.l_r_menu li a').removeClass('current');
		var classname=$(this).attr('class');
		if(classname=='l_log'){
		    $('#reg').hide();
			$('#log').show();
		}
		else if(classname=='l_reg'){
		    $('#log').hide();
			$('#reg').show();
		}
		$(this).addClass('current');
	});

    $('#register_form').validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('td').next('td');
            error_td.find('.field_notice').hide();
            error_td.append(error);
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
            captcha : {
                required : '请输入右侧图片中的字符',
				rangelength    : '位数错误'
            },
            agree : {
                required : '您必须阅读并同意该协议'
            }
        },
		submitHandler: function(form) { 
		    $.ajax({
	            url: '<?=u('user','register')?>',
		        type: "POST",
		        data:$(form).serialize(),
		        dataType: "json",
		        success: function(data){
			        if(data.s==0){
			            alert(errorArr[data.id]);
			        }
			        else if(data.s==1){
						alert('注册成功！');
						buy_log('hideLoginWin');
			        }
		        }
	        });
        }
    });
});

function ajaxLogin(t){
	$.ajax({
	    url: '<?=u('user','login')?>',
		type: "POST",
		data:$(t).serialize(),
		dataType: "json",
		success: function(data){
			if(data.s==0){
				if(isNaN(data.id)){
					alert(data.id);
				}
				else{
					alert(errorArr[data.id]);
				}
			}
			else if(data.s==1){
			    buy_log('hideLoginWin');
			}
		 }
	});
	return false;
}

function showLoginWin(){
	var sW=document.documentElement.clientWidth; //屏幕宽度
	var sH=document.documentElement.clientHeight; //屏幕高度
	$box=$('#jump-box');
	$box.show();
	$('#light-box').show().css('height',document.body.clientHeight);
	var l=(sW-$box[0].offsetWidth)/2;
	var h=(sH-$box[0].offsetHeight)/2;
	$box.css('left',l+'px').css('top',h+'px').find('#gototaobao').attr('href',$theClickDom.attr('href'));
}

function hideLoginWin(){
	$('#jump-box,#light-box').hide();
	window.location=$theClickDom.attr('href');
	//window.open($theClickDom.attr('href'));
}
</script>
</div>
</div>