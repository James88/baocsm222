<?php
if(!defined('INDEX')){
	exit('Access Denied');
}
$from=$_GET['from'];
$parameter=act_user_info();
extract($parameter);
$css[]=TPLURL."/inc/css/usercss.css";
include(TPLPATH.'/inc/header.tpl.php');

$tbnick_arr=explode(',',$dduser['tbnick']);
if($tbnick_arr[0]!=''){
	$tbnick_arr[]='';
}
?>
<?php if($dduser['mobile_test']==1){?>
<style>
tr.change{ display:none}
</style>
<?php }?>
<script charset="utf-8" type="text/javascript" src="js/jquery.validate.js" ></script>
<script>
YZM_EFFE=<?=MOBILE_YZM_EFFECT?>;
YZM_EFFE_USE=YZM_EFFE;

if(document.referrer!=''){
	var urlFrom=document.referrer;
}
else{
	var urlFrom='<?=$from?>';
}
function delete_tr(id){
	$("#"+id).remove();
}
function daojishi(){
	YZM_EFFE_USE--;
	if(YZM_EFFE_USE==0){
		$('#get_mobile_yzm').attr('disabled',false).val('从新获取验证码');
		clearInterval(daojishiProcess);
		YZM_EFFE_USE=YZM_EFFE;
	}
	else{
		$('#get_mobile_yzm').val('发送中（'+YZM_EFFE_USE+'）');
	}
	
}
$(function(){
	<?php if($dduser['bank_code']!=''){?>
	$('#bank_id,#bank_code').attr('disabled','disabled');
	<?php }?>
	
	$('#change').click(function(){
		$(this).hide();
		$(this).next('div').show();
		$('tr.change').show();
	});
	
	/*$('#pyzm').blur(function(){
		var s=$(this).val();
		var $t=$(this);
		if(s.length==4){
			$.getJSON('<?=u(MOD,ACT,array('do'=>'yzm'))?>&yzm='+s,function(data){
				if(data.s==1){
					$('#get_mobile_yzm').attr('disabled',false);
				}
				else{
					alert('验证码填写错误');
					$t.select().next('img').click();
				}
			});
		}
		else{
			alert('验证码填写错误');
		}
	});*/
	
	$('#mobileset').submit(function(){
		var mobile=$(this).find('#mobile').val();
		if(regMobile(mobile)==false){
			alert('手机号码格式错误');
			return false;
		}
		var yzm=$(this).find('#yzm').val();
		if(yzm.length!=6 || isNaN(yzm)){
			alert('验证码格式错误');
			return false;
		}
		var query=$(this).serialize();
	    var url=$(this).attr('action');
	    ajaxPost(url,query);
		return false;
	});
	
	$('#get_mobile_yzm').click(function(){
		var mobile=$('#mobileset').find('#mobile').val();
		if(typeof mobile=='undefined'){
			mobile='<?=$dduser['mobile']?>';
		}
		if(regMobile(mobile)==false){
			alert('手机号码格式错误！');
		}
		else{
			$(this).attr('disabled','disabled').val('发送中（'+YZM_EFFE_USE+'）');
			$.ajax({
		    	url:'<?=u(MOD,ACT,array('do'=>'mobile','send_yzm'=>1))?>&time=<?=TIME?>',
				dataType:'json',
				type: "POST",
				data:{mobile:mobile,yzm:$('#pyzm').val()},  //手机验证
				success: function(data){
			    	if(data.s==0){
						alert(errorArr[data.id]);
						$('#get_mobile_yzm').attr('disabled',false).val('获取验证码');
					}
					else if(data.s==1){
						daojishiProcess=window.setInterval(daojishi, 1000);
					}
		    	}
			});
		}
	});
	
	$('#caiwuset').validate({
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
            old_password : {
                required : true,
                byteRange: [6,20],
				remote   : {
                    url :'index.php?mod=ajax&act=check_oldpass',
                    type:'post',
                    data:{
                        oldpass : function(){ return $('#old_password').val();},dduserid:<?=$dduser['id']?>
                    },
                    beforeSend:function(){
                        var _checking = $('#checking_oldpass');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#checking_oldpass').hide();
                    }
                }
            },
			alipay : {
				alipay: true,
				remote   : {
                    url :'index.php?mod=ajax&act=check_my_alipay',
                    type:'post',
                    data:{
                        oldpass : function(){ return $('#alipay').val();},dduserid:<?=$dduser['id']?>
                    },
                    beforeSend:function(){
                        var _checking = $('#checking_my_alipay');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#checking_my_alipay').hide();
                    }
                }
			},
			tenpay : {
				tenpay: true,
				remote   : {
                    url :'index.php?mod=ajax&act=check_my_tenpay',
                    type:'post',
                    data:{
                        oldpass : function(){ return $('#tenpay').val();},dduserid:<?=$dduser['id']?>
                    },
                    beforeSend:function(){
                        var _checking = $('#checking_my_tenpay');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#checking_my_tenpay').hide();
                    }
                }
			},
			bank_code : {
				number   : true,
				byteRange: [16,19],
				remote   : {
                    url :'index.php?mod=ajax&act=check_my_bank_code',
                    type:'post',
                    data:{
                        bank_code : function(){ return $('#bank_code').val();},dduserid:<?=$dduser['id']?>
                    },
                    beforeSend:function(){
                        var _checking = $('#checking_my_bank_code');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#checking_my_bank_code').hide();
                    }
                }
			},
			txtool : {
				required : true
			},
			yzm : {
				required : true,
				number : true,
				byteRange : [6,6]
			}
        },
        messages : {
            old_password : {
                required : '您必须填写密码',
                byteRange: '密码必须在6-30个字符之间',
				remote   : '密码错误'
            },
			alipay : {
                alipay:'支付宝格式错误',
				remote:'支付宝已被注册'
            },
			tenpay : {
                tenpay:'财付通格式错误',
				remote:'财付通已被注册'
            },
			bank_code : {
				number:'银行账号格式错误',
                byteRange:'银行账号格式错误',
				remote:'银行账号已被注册'
            },
			txtool : {
				required : '平台必须选择'
			},
			yzm : {
				required : '手机验证码必须填写',
				number : '验证码必须是数字',
				byteRange : '验证码位数错误'
			}
        },
		submitHandler: function(form) {   
            var query=$(form).serialize();
	        var url=$(form).attr('action');
	        ajaxPost(url,query);
        } 
    });

    $('#infoset').validate({
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
			<?php if($dduser['email']==''){?>
			ddpwd : {
                required : true,
                minlength: 6
            },
            pwd_confirm : {
                required : true,
                equalTo  : '#ddpwd'
            },
			email : {
                required : true,
                email    : true,
				remote   : {
                    url :'index.php?mod=ajax&act=check_my_email',
                    type:'post',
                    data:{
                        email : function(){return $('#email').val();},dduserid:<?=$dduser['id']?>
                    },
                    beforeSend:function(){
                        var _checking = $('#check_my_email');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#check_my_email').hide();
                    }
                }
            }
			<?php }else{?>
            old_password : {
                required : true,
                byteRange: [6,20],
				remote   : {
                    url :'index.php?mod=ajax&act=check_oldpass',
                    type:'post',
                    data:{
                        oldpass : function(){ return $('#old_password').val();},dduserid:<?=$dduser['id']?>
                    },
                    beforeSend:function(){
                        var _checking = $('#checking_oldpass');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#checking_oldpass').hide();
                    }
                }
            },
			
            email : {
                required : true,
                email    : true,
				remote   : {
                    url :'index.php?mod=ajax&act=check_my_email',
                    type:'post',
                    data:{
                        email : function(){return $('#email').val();},dduserid:<?=$dduser['id']?>
                    },
                    beforeSend:function(){
                        var _checking = $('#check_my_email');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#check_my_email').hide();
                    }
                }
            },
			/*tbnick : {
                byteRange: [3,100,'utf-8'],
				remote   : {
                    url :'index.php?mod=ajax&act=check_tbnick',
                    type:'post',
                    data:{
                        tbnick : function(){return $('#tbnick').val();}
                    },
                    beforeSend:function(){
                        var _checking = $('#check_my_tbnick');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#check_my_tbnick').hide();
                    }
                }
            },*/
            qq : {
                required : true,
                range:[1000,999999999999]
            },
			realname: {
			    required : true
			},
            mobile: {
			    required : true,
				mobile   : true
			}
			<?php }?>
        },
        messages : {
			<?php if($dduser['email']==''){?>
			ddpwd  : {
                required : '您必须提供一个密码',
                minlength: '密码长度应在6-20个字符之间'
            },
            pwd_confirm : {
                required : '您必须再次确认您的密码',
                equalTo  : '两次输入的密码不一致'
            },
			email : {
                required : '您必须提供您的电子邮箱',
                email    : '这不是一个有效的电子邮箱',
				remote   : '邮箱已存在'
            }
			<?php }else{?>
            old_password : {
                required : '您必须填写旧密码',
                byteRange: '密码必须在6-30个字符之间',
				remote   : '密码错误'
            },
            email : {
                required : '您必须提供您的电子邮箱',
                email    : '这不是一个有效的电子邮箱',
				remote   : '邮箱已存在'
            },
			qq : {
                required : '您必须提供您的QQ号码',
                range:'QQ号码位数错误'
            },
			realname : {
			    required : '真实姓名必须填写'
			},
			mobile : {
			    required : '手机号码必须填写',
				mobile   : '手机号码格式错误'
			}
			<?php }?>
        },
		submitHandler: function(form) {   
	        ajaxPostForm(form,urlFrom,'保存成功');
        } 
    });
	
	$('#tixianpwdset').validate({
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
            old_tixianpwd : {
                required : true,
                byteRange: [6,20]
            },
            tixianpwd : {
                required : true,
                minlength: 6
            },
            tixianpwd_confirm : {
                required : true,
                equalTo  : '#tixianpwd'
            }
        },
        messages : {
            old_tixianpwd : {
                required : '您必须填写旧密码',
                byteRange: '密码必须在6-30个字符之间',
				remote   : '密码错误'
            },
            tixianpwd  : {
                required : '您必须提供一个密码',
                minlength: '密码长度应在6-20个字符之间'
            },
            tixianpwd_confirm : {
                required : '您必须再次确认您的密码',
                equalTo  : '两次输入的密码不一致'
            }
        },
		submitHandler: function(form) {   
	        var query=$(form).serialize();
	        var url=$(form).attr('action');
	        ajaxPost(url,query);
        }
    });
	
	$('#pwdset').validate({
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
            old_pwd : {
                required : true,
                byteRange: [6,20],
				remote   : {
                    url :'index.php?mod=ajax&act=check_oldpass',
                    type:'post',
                    data:{
                        oldpass : function(){ return $('#old_pwd').val();},dduserid:<?=$dduser['id']?>
                    },
                    beforeSend:function(){
                        var _checking = $('#checking_oldpass');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#checking_oldpass').hide();
                    }
                }
            },
            ddpwd : {
                required : true,
                minlength: 6
            },
            pwd_confirm : {
                required : true,
                equalTo  : '#ddpwd'
            }
        },
        messages : {
            old_pwd : {
                required : '您必须填写旧密码',
                byteRange: '密码必须在6-30个字符之间',
				remote   : '密码错误'
            },
            ddpwd  : {
                required : '您必须提供一个密码',
                minlength: '密码长度应在6-20个字符之间'
            },
            pwd_confirm : {
                required : '您必须再次确认您的密码',
                equalTo  : '两次输入的密码不一致'
            }
        },
		submitHandler: function(form) {   
	        var query=$(form).serialize();
	        var url=$(form).attr('action');
	        ajaxPost(url,query);
        }
    });
	<?php if(TAOTYPE==1){?>
	$('#tbnickForm').validate({
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
			<?php foreach($tbnick_arr as $k=>$v){?>
            'tbnick[<?=$k?>]' : {
				byteRange: [3,100,'utf-8'],
				remote   : {
                    url :'index.php?mod=ajax&act=check_tbnick&t=<?=TIME?>',
                    type:'post',
                    data:{tbnick : function(){return $('#tbnick_<?=$k?>').val();},type:1},
                    beforeSend:function(){
                        var _checking = $('#checking_tbnick_<?=$k?>');
                        _checking.prev('.field_notice').hide();
                        _checking.next('label').hide();
                        $(_checking).show();
                    },
                    complete :function(){
                        $('#checking_tbnick_<?=$k?>').hide();
                    }
                }
            }
			<?php if($k+1<count($tbnick_arr)){echo ',';}}?>
        },
        messages : {
			<?php foreach($tbnick_arr as $k=>$v){?>
            'tbnick[<?=$k?>]' : {
                byteRange: '订单号位数错误',
				remote   : '订单号异常'
            }
			<?php if($k+1<count($tbnick_arr)){echo ',';}}?>
        }
		/*,
		submitHandler: function(form) {   
	        var query=$(form).serialize();
	        var url=$(form).attr('action');
	        ajaxPost(url,query);
        }*/
    });
	<?php }?>
});
</script>

<body>
<div class="mainbody">
	<div class="mainbody1000">
    <?php include(TPLPATH."/user/top.tpl.php");?>
    	<div class="adminmain">
        	<div class="adminleft">
                <?php include(TPLPATH."/user/left.tpl.php");?>
            </div>
        	<div class="adminright">
            <div class="c_border" style="border-top-style:solid; border-top-width:2px;padding-top:10px;">
                <?php include(TPLPATH."/user/notice.tpl.php");?>
                <div class="admin_xfl">
                  <ul>
                    <li id="myinfo"><a href="<?=u('user','info',array('do'=>'myinfo'))?>">个人信息设置</a> </li>
                    <li id="pwd"><a href="<?=u('user','info',array('do'=>'pwd'))?>">登陆密码设置</a> </li>
                    <?php if($app_show==1){?>
                    <li id="apilogin"><a href="<?=u('user','info',array('do'=>'apilogin'))?>">账号通设置</a></li>
                    <?php }?>
                    <li id="caiwu"><a href="<?=u('user','info',array('do'=>'caiwu'))?>">个人财务设置</a> </li>
                    <?php if($webset['sms']['open']==1){?>
                    <li id="mobile"><a href="<?=u('user','info',array('do'=>'mobile'))?>">手机验证</a> </li>
                    <?php }?>
                    
                    <?php if(FANLI==1 && TAOTYPE==1){?>
                    <li id="tbnick"><a href="<?=u('user','info',array('do'=>'tbnick'))?>">淘宝订单绑定</a> </li>
                    <?php }?>
                    </ul>
                    <script>
                    $(function(){
					    $('.admin_xfl li#<?=$do?>').addClass('admin_xfl_xz');
					})
                    </script>
              	</div>
                <div class="admin_table">
                <?php if($do=='myinfo'){?>
                <form id="infoset" name="form1" action="<?=u('user','info',array('do'=>'myinfo'))?>" method="post" style=" padding-left:50px">
    <table border="0" align="left" cellpadding="0" cellspacing="0" class="no_table">
    
    	<?php if($dduser['email']==''){?>
        <tr><td colspan="3" height="35" style=""><?=$dduser['name']?>，您好！您已经用<?=$dduser['reg_from']?>成功登录<?=WEBNAME?>，请绑定邮箱以便更好使用我们网站。</td></tr>
       <?php if($webset['ucenter']['open']==1){?>
        <tr>
		  <td width="100" height="35" style="text-align:right">登录密码 *&nbsp;&nbsp;&nbsp;</td>
		  <td width="150"><input name="old_password" type="password" id="old_password" value="" style="width:130px;" class="ddinput"/></td>
		  <td width="400"><label class="field_notice">
          <?php if($default_pwd!=''){?>
          您的默认登录密码为：<b style="color:red"><?=$default_pwd?></b>，<a href="<?=u('user','info',array('do'=>'pwd'))?>">立刻修改</a>
          <?php }else{?>
          填写网站登录密码
          <?php }?>
          </label><label id="checking_oldpass" class="checking">检查中...</label></td>
		</tr>
        <?php }?>
        <tr>
		  <td width="100" height="35" style="text-align:right">电子邮箱 *&nbsp;&nbsp;&nbsp;</td>
		  <td width="150"><input name="email" type="text" id="email" value="<?=$dduser['email']?>" style="width:130px;" class="ddinput"/></td>
		  <td width="400"><label class="field_notice">请务必填写正确，取回密码用</label><label id="checking_my_email" class="checking">检查中...</label></td>
		</tr>
        <?php }else{?>
    
		<tr>
		  <td width="18%" height="35" style="text-align:right">网站登录密码 *&nbsp;&nbsp;&nbsp;</td>
		  <td width="25%"><input name="old_password" type="password" style="width:130px;" id="old_password" class="ddinput" /></td>
		  <td width="" id="ckuser"><label class="field_notice">
          <?php if($default_pwd!=''){?>
          您的默认登录密码为：<b style="color:red"><?=$default_pwd?></b>，<a href="<?=u('user','info',array('do'=>'pwd'))?>">立刻修改</a>
          <?php }else{?>
          填写网站登录密码
          <?php }?>
          </label><label id="checking_oldpass" class="checking">检查中...</label></td>
		</tr>
		<tr>
		  <td height="35" style="text-align:right">QQ号码 *&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="qq" type="text" id="qq" value="<?=$dduser['qq']?>"  onkeyup="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" size="20" maxlength="50" style="width:130px;" class="ddinput"/></td>
		  <td id="ckqq2"><label class="field_notice">以便客服及时联系您</label></td>
		</tr>
		<tr>
		  <td height="35" style="text-align:right">电子邮箱 *&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="email" type="text" id="email" value="<?=$dduser['email']?>" style="width:130px;" class="ddinput"/></td>
		  <td><label class="field_notice">请务必填写正确，取回密码用</label><label id="checking_my_email" class="checking">检查中...</label></td>
		</tr>
        <?php if($webset['sms']['open']==1){?>
        <tr>
		  <td height="35" style="text-align:right">手机号码 *&nbsp;&nbsp;&nbsp;</td>
		  <td>
          <?php if($dduser['mobile']!=''){echo show_mobile($dduser['mobile'],0);}else{echo '尚未填写';}?> &nbsp;&nbsp;&nbsp;<a style="color:#69F; text-decoration:underline" href="<?=u('user','info',array('do'=>'mobile'))?>">修改</a>
          </td>
		  <td>&nbsp;&nbsp;<?=$dduser['mobile_test']==1?'<span style=" color:green">已验证</span>':'<a href="'.u('user','info',array('do'=>'mobile')).'" title="验证手机" style=" text-decoration:underline; color:red;">未验证</a>'?></td>
		</tr>
        <?php }else{?>
        <tr>
		  <td height="35" style="text-align:right">手机号码 *&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="mobile" type="text" id="mobile" value="<?=$dduser['mobile']?>" style="width:130px;" class="ddinput"/></td>
		  <td><label class="field_notice">请务必填写正确</label></td>
		</tr>
        <?php }?>
        <?php }?>
		<tr>
		  <td height="35">&nbsp;</td>
		  <td><input type="hidden" name="sub" value="1" /><div class="img-button "><p><input type="submit" value="保存信息" /></p></div></td>
		  <td></td>
		</tr>
	  </table>
      </form>
<?php }elseif($do=='apilogin'){?>

<?php if(count($api)>0){?> 
<div style="padding-left:50px; padding-top:15px">
<div id="setting_form" class="account_bind">
<div>绑定帐号享受<?=WEBNAME?>为您带来的多种登陆方式。</div>
<ul class="bind_logo">
<?php foreach($api as $row){?>
<li>
<img alt="<?=$row['title']?>" src="<?=TPLURL?>/inc/images/login/<?=$row['code']?>_3.png">
<div class="bind_web">
<?php if(in_array($row['code'],$user_api)){?>
<span class="unbind">您已绑定<?=$row['title']?></span><br/>
<a style="color:#F00" href="<?=u('api','do',array('do'=>'del','web'=>$row['code']))?>" onclick='return confirm("确定解除?")'>解除绑定</a>
<?php }else{?>
<span class="unbind">你还未绑定<?=$row['title']?></span><br>
<a href="<?=u('api',$row['code'])?>">绑定账号</a>
<?php }?>
</div>
</li>
<?php }?>
</ul>
</div>
              </div>
<?php }?>

                      <?php }elseif($do=='pwd'){?>
                      <form id="pwdset" name="form1" action="<?=u('user','info',array('do'=>'pwd'))?>" method="post" style=" padding-left:50px">
    <table border="0" align="left" cellpadding="0" cellspacing="0" bordercolorlight="#9acd32" class="no_table">
		<tr>
		  <td width="25%" height="35"  style="text-align:right">网站登录密码 *&nbsp;&nbsp;&nbsp;</td>
		  <td width="25%"><input name="old_pwd" type="password" style="width:130px;" id="old_pwd" class="ddinput" /></td>
		  <td id="ckuser"><label class="field_notice">
          <?php if($default_pwd!=''){?>
          您的默认登录密码为：<b style="color:red"><?=$default_pwd?></b>，<a href="<?=u('user','info',array('do'=>'pwd'))?>">立刻修改</a>
          <?php }else{?>
          填写网站登录密码
          <?php }?>
          </label><label id="checking_oldpass" class="checking">检查中...</label></td>
		</tr>
		<tr>
		  <td height="35" style="text-align:right">新网站登录密码 *&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="ddpwd" type="password" id="ddpwd" size="20" maxlength="20" style="width:130px;" class="ddinput"/></td>
		  <td id="ckpass"><label class="field_notice">密码为长度 6 - 20 位</label></td>
		</tr>
		<tr>
		  <td height="35" style="text-align:right">确认新网站登录密码 *&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="pwd_confirm" type="password" id="pwd_confirm" style="width:130px;" class="ddinput"/></td>
		  <td id="ckpass2"><label class="field_notice">请再次确认密码</label></td>
		</tr>
		<tr>
		  <td height="35">&nbsp;</td>
		  <td><input type="hidden" name="sub" value="1" /><div class="img-button "><p><input type="submit" value="保存信息"/></p></div></td>
		  <td></td>
		</tr>
	  </table>
      </form>
      <?php }elseif($do=='mobile'){?>
      <form id="mobileset" name="form1" action="<?=u(MOD,ACT,array('do'=>'mobile'))?>" method="post" style=" padding-left:50px">
    <table border="0" align="left" cellpadding="0" cellspacing="0" bordercolorlight="#9acd32" class="no_table">
   	    <tr class="change">
		  <td height="35" style="text-align:right">验证码 *&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="pyzm" id="pyzm" style="width:60px;" class="ddinput"/> <?=yzm()?></td>
		  <td>填写完成后可获取手机验证码</td>
		</tr>
      <?php if($dduser['mobile_test']==1){?>
		<tr>
		  <td width="25%" height="35" style="text-align:right">已验证手机号 *&nbsp;&nbsp;&nbsp;</td>
		  <td width="25%"><?=show_mobile($dduser['mobile'])?><input name="mobile" value="<?=$dduser['mobile']?>" type="hidden" id="mobile" class="ddinput" /></td>
		  <td style=" padding-left:10px"><div style="cursor:pointer" id="change" class="img-button"><p><input type="button" value="更改手机号码"/></p></div><div style="display:none" class="img-button"><p><input id="get_mobile_yzm" type="button" value="获取验证码"/></p></div></td>
		</tr>
      <?php }else{?>
    	
        <tr class="change">
		  <td width="25%" height="35"  style="text-align:right"><?php if($dduser['mobile_test']==1){?>新<?php }?>手机号码 *&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="mobile" value="<?php if($dduser['mobile_test']==0){?><?=$dduser['mobile']?><?php }?>" style="width:130px;" id="mobile" class="ddinput" /></td>
		  <td style=" padding-left:10px">
          <?php if($dduser['mobile_test']==0){?>
		  <div class="img-button"><p><input id="get_mobile_yzm" type="button" value="获取验短信"/></p></div>
		  <?php }?>
          </td>
		</tr>
       <?php }?>
		<tr class="change">
		  <td height="35" style="text-align:right">短信验证码 *&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="yzm" id="yzm" style="width:130px;" class="ddinput"/>&nbsp;&nbsp;</td>
		  <td>&nbsp;&nbsp;<?php if($dduser['mobile_test']==1){?><span class="zhushi">请先输入短信验证码解绑</span><?php }?></td>
		</tr>
		<tr class="change">
		  <td height="35">&nbsp;</td>
		  <td><input type="hidden" name="sub" value="1" /><div class="img-button "><p><input type="submit" value="保存信息"/></p></div></td>
		  <td></td>
		</tr>
	  </table>
      </form>
      <div class="adminright_yuye" style="width:750px; height:120px">
                    <div class="tishitubiao"></div>
                    <p>以下是<?=WEBNAME?>官方短信号码为，请注意保存，以防被手机软件拦截！<br/>
                    移动：<b style="color:red"><?=$webset['sms']['yidong']?$webset['sms']['yidong']:'106575219050'?></b><br/>
                    联通：<b style="color:red"><?=$webset['sms']['liantong']?$webset['sms']['liantong']:'10655059366'?></b><br/>
                    电信：<b style="color:red"><?=$webset['sms']['dianxin']?$webset['sms']['dianxin']:'106590551816'?></b><br/>
                    </p>
                </div>
      
                      <?php }elseif($do=='caiwu'){?>
                       <form id="caiwuset" name="form1" action="<?=u('user','info',array('do'=>'caiwu'))?>" method="post" style=" padding-left:50px">
    <table border="0" align="left" cellpadding="0" cellspacing="0" bordercolorlight="#9acd32" class="no_table">
    	<?php if($webset['sms']['open']==1){?>
        <tr>
		  <td height="35" style="text-align:right">验证码 *&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="pyzm" id="pyzm" style="width:60px;" class="ddinput"/> <?=yzm()?></td>
		  <td>填写完成后可获取手机验证码</td>
		</tr>
		<tr>
		  <td width="18%" height="35" style="text-align:right">已验证手机号 *&nbsp;&nbsp;&nbsp;</td>
		  <td width="25%"><?php if($dduser['mobile']!=''){echo show_mobile($dduser['mobile']);}else{echo '尚未填写';}?></td>
		  <td style=" padding-left:20px"><?php if($dduser['mobile']!=''){?><div class="img-button"><p><input id="get_mobile_yzm" type="button" value="获取短信"/></p></div><?php }else{?><a style="color:#69F; text-decoration:underline" href="<?=u('user','info',array('do'=>'mobile','from'=>u(MOD,ACT,array('do'=>$do))))?>">添加/修改</a><?php }?></td>
		</tr>
        <tr>
		  <td height="35" style="text-align:right">短信验证码 *&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="yzm" id="yzm" style="width:130px;" class="ddinput"/></td>
		  <td><label class="field_notice"></label></td>
		</tr>
    	<?php }?>
    
		<tr>
		  <td width="18%" height="35"  style="text-align:right">网站登录密码 *&nbsp;&nbsp;&nbsp;</td>
		  <td width="25%"><input name="old_password" type="password" style="width:130px;" id="old_password" class="ddinput" /></td>
		  <td><label class="field_notice">
          <?php if($default_pwd!=''){?>
          您的默认登录密码为：<b style="color:red"><?=$default_pwd?></b>，<a href="<?=u('user','info',array('do'=>'pwd'))?>">立刻修改</a>
          <?php }else{?>
          填写网站登录密码
          <?php }?>
          </label><label id="checking_oldpass" class="checking">检查中...</label></td>
		</tr>
        <tr>
		  <td height="35" style="text-align:right">真实姓名 *&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="realname" type="text" id="realname" value="<?=$dduser['realname']?>" maxlength="50" <?php if ($dduser['realname']!=""){ echo "readonly='readonly' disabled";}?> style="width:130px;" class="ddinput"/></td>
		  <td><label class="field_notice">填写后不可更改</label></td>
		</tr>
		<?php if($webset['tixian']['need_alipay']==1){?>
		<tr>
		  <td height="35" style="text-align:right">支付宝账号 *&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="alipay" type="text" id="alipay"  style="width:130px;" value="<?=$dduser['alipay']?>" maxlength="50" <?php if ($dduser['alipay']!=""){ echo "readonly='readonly' disabled";}?> class="ddinput"/></td>
		  <td><label class="field_notice">填写后不可更改</label><label id="checking_my_alipay" class="checking">检查中...</label></td>
		</tr>
        <?php }?>
        <?php if($webset['tixian']['need_tenpay']==1){?>
        <tr>
		  <td height="35" style="text-align:right">财付通账号 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="tenpay" type="text" id="tenpay"  style="width:130px;" value="<?=$dduser['tenpay']?>" maxlength="50" <?php if ($dduser['tenpay']!=""){ echo "readonly='readonly' disabled";}?> class="ddinput"/></td>
		  <td><label class="field_notice">填写后不可更改</label><label id="checking_my_tenpay" class="checking">检查中...</label></td>
		</tr>
        <?php }?>
        
		<?php if($webset['tixian']['need_bank']==1){?>
        <tr>
		  <td height="35" style="text-align:right">选择银行 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		  <td><?=select($bank,$dduser['bank_id'],'bank_id')?></td>
		  <td><label class="field_notice">填写后不可更改</label></td>
		</tr>
        
        <tr>
		  <td height="35" style="text-align:right">银行账号 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="bank_code" type="text" id="bank_code" value="<?=$dduser['bank_code']?>" style="width:130px;" class="ddinput"/></td>
		  <td id="ckbank_code"><label class="field_notice">填写后不可更改</label><label id="checking_my_bank_code" class="checking">检查中...</label></td>
		</tr>
        <?php }?>
        <?php if(count($txtool_arr)>1){?>
        <tr>
		  <td height="35" style="text-align:right">金额提取平台 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		  <td><?=html_radio($txtool_arr,$dduser['txtool'],'txtool')?></td>
		  <td id=""><label class="field_notice">商城返利和拍拍返利的提取平台选择</label></td>
		</tr>
        <?php }?>
		<tr>
		  <td height="35">&nbsp;</td>
		  <td><input type="hidden" name="sub" value="1" /><div class="img-button "><p><input type="submit" value="保存信息"/></p></div></td>
		  <td></td>
		</tr>
	  </table>
      </form>

<?php }elseif($do=='tbnick'){?>

                      <form id="tbnickForm" name="form1" action="<?=u('user','info',array('do'=>'tbnick'))?>" method="post" style=" padding-left:50px">
    <table border="0" align="left" cellpadding="0" cellspacing="0" class="no_table">
    <?php foreach($tbnick_arr as $k=>$v){?>
        <tr <?php if($v){?>id="tbnick_tr_<?=$k?>"<?php }?>>
		  <td height="35" style="text-align:right">淘宝订单号 *&nbsp;&nbsp;&nbsp;</td>
		  <td><input name="tbnick[<?=$k?>]" type="text" id="tbnick_<?=$k?>" value="<?=$v?>" style="width:130px;" class="ddinput"/></td>
<?php if($v){?><td><span onClick="delete_tr('tbnick_tr_<?=$k?>')" title="点击删除该账号" style="color:#666; cursor:pointer; margin-left:5px;">删除</span></td><?php }?>
		  <td><?php if($k==0){?><label class="field_notice">登记拿返利用，不会作为其他用途，请放心。<?php if($dd_tpl_data['jiaocheng']['tbnick']!=''){?><a href="<?=$dd_tpl_data['jiaocheng']['tbnick']?>" target="_blank" style="color:#F00">如何填？</a><?php }?></label><?php }?><label id="checking_tbnick_<?=$k?>" class="checking">检查中...</label></td>
		</tr>
    <?php }?>
		<tr>
		  <td height="35">&nbsp;</td>
		  <td><input type="hidden" name="sub" value="1" /><div class="img-button "><p><input type="submit" value="保存信息" /></p></div></td>
		  <td></td>
		</tr>
	  </table>
      </form>
                      
                      
                      <?php }?>
              </div>
        	  
        	</div>
            </div>
    	</div>
  </div>
</div>
<?php
include(TPLPATH.'/inc/footer.tpl.php');
?>