<?php
$parameter=act_user_getpassword();
extract($parameter);
$css[]=TPLURL.'/inc/css/usercss.css';
include(TPLPATH.'/inc/header.tpl.php');
?>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<div id="maincenter" style="border:1px solid #ccc; border-top:2px solid #f36519;">
  <table style="width:800px; margin:auto" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="50" colspan="3" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td height="50" colspan="3" align="center">
    <div class="steptip">
    <div class="step1">1、填写您的邮箱</div>
    <div class="step2">2、收取取回密码邮件</div>
    <div class="step3">3、重置密码</div>
    </div>
    <script>
    $(function(){
		var $step=$('.steptip').find('.step<?=$step?>')
	    $step.addClass('current');
		$step.css('background','url(<?=TPLURL?>/inc/images/step<?=$step?>c.gif)')
	})
    </script>
    </td>
  </tr>
  <tr>
    <td colspan="3" height="15">&nbsp;</td>
  </tr>
  <?php if($step==1){?>
  <form id="form1" name="form1" method="post" action="<?=u('user','getpassword',array('step'=>2))?>">
  <tr>
    <td width="312"  align="right" style="font-size:14px">请填写您注册时的邮箱： &nbsp;</td>
    <td width="230" align="center"><input type="text" id="email" name="email" size="20" maxlength="50" style="width:200px;"  class="ddinput"/> </td>
    <td width="258" align="left"><div class="img-button "><p><input name="sub" type="submit" value="找回密码"/></p></div></td>
  </tr>
  <tr>
    <td width="312" align="right" >&nbsp;</td>
    <td width="230" id="tip"><label class="field_notice"></label></td>
    <td width="258" align="left">&nbsp;</td>
  </tr>
  </form>
  <?php }elseif($step==2 || $step==4){?>
  <tr>
    <td height="50" colspan="3" align="center" style="font-size:14px"><?=$mymsg?></td>
  </tr>
  <?php }elseif($step==3){?>
  <tr>
    <td align="center" colspan="3">
    <form id="form2" name="form2" method="post" action="<?=u('user','getpassword',array('step'=>4))?>">
    <table width="500" border="0" cellspacing="0" cellpadding="0">

      <tr>
        <td height="35" align="right">请输入新的密码：</td>
        <td width="147" height="35" align="left"><label>
          <input name="password" type="password" id="password" size="20" maxlength="20" style="width:130px;" class="ddinput"/>
        </label></td>
        <td width="188" height="35" align="left" id="ckpass"><label class="field_notice">密码为长度 6 - 20 位</label></td>
      </tr>
      <tr>
        <td height="35" align="right">请再次输入密码：</td>
        <td height="35" align="left"><label>
          <input name="password_confirm" type="password" id="password_confirm" size="20" maxlength="20" style="width:130px;" class="ddinput"/>
        </label></td>
        <td height="35" align="left" id="ckpass2"><label class="field_notice">请再次确认密码</label></td>
      </tr>
      <tr>
        <td height="35" align="right">&nbsp;</td>
        <td height="35" align="left"><input type="hidden" name="x" value="<?=$x?>" />
          <div class="img-button "><p><input type="submit" name="Submit" value="重置密码"/></p></div>
          <input type="hidden" name="ddusername" value="<?=$array_result[0]?>" /></td>
        <td height="35" align="left">&nbsp;</td>
      </tr>
    </table>
    </form>
    </td>
  </tr>
  <?php }?>
</table>
</div>
<script>
$(function(){
    $('#form1').validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('td').parent('tr').next('tr').find('#tip');
            error_td.find('.field_notice').hide();
            error_td.append(error);
        },
        success : function(label){
            label.addClass('validate_right').text('OK!');
        },
        onkeyup: false,
        rules : {
            email : {
                required : true,
                email    : true
            }
        },
        messages : {
            email : {
                required : '您必须提供您的电子邮箱',
                email    : '这不是一个有效的电子邮箱'
            }
        }
    });
	
	$('#form2').validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('label').parent('td').next('td');
            error_td.find('.field_notice').hide();
            error_td.append(error);
        },
        success : function(label){
            label.addClass('validate_right').text('OK!');
        },
        onkeyup: false,
        rules : {
            password : {
                required : true,
                minlength: 6
            },
            password_confirm : {
                required : true,
                equalTo  : '#password'
            }
        },
        messages : {
            password  : {
                required : '您必须提供一个密码',
                minlength: '密码长度应在6-20个字符之间'
            },
            password_confirm : {
                required : '您必须再次确认您的密码',
                equalTo  : '两次输入的密码不一致'
            }
        }
    });
});
</script>
<?php
include(TPLPATH.'/inc/footer.tpl.php');
?>

