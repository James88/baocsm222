<?php
if (!defined('INDEX')) {
	exit ('Access Denied');
}

$parameter=act_wap_login();
extract($parameter);

include(TPLPATH.'/inc/header_2.tpl.php');
?>
<script>
function cbCheckForm(input,$form){
	var url='<?=wap_l(MOD,ACT)?>';
	url=ddJoin(url,input);
	$('#tijiao').val('提交中...');
	$.ajax({
		url: url,
		dataType:'jsonp',
		jsonp:"callback",
		success: function(data){
			if(data.s==1){
				ddAlert('登录成功','<?=$from?>');
			}
			else{
				getYzm();
				alert(data.r);
				$('#tijiao').val('登录');
			}
		}
	});
	return false;
}

function getYzm(){
	$('#yzmimg').attr('src','<?=CURURL?>/comm/showpic.php?easy=1&t='+time());
}
</script>
<div class="listHeader">
  <p><b>会员登录</b><a href="javascript:;" onclick="history.back()" class="left">返回</a> <a href='<?=wap_l('user','register',array('from'=>$from))?>' class="right">注册</a>  </p>
</div>
<div class="shopBody">
<div class="info" style="border-top:none;">
<form onSubmit="return checkForm($(this),cbCheckForm)">
<dl>
<dd>用户名</dd>
<dt><input id="username" name="username" placeholder="请输入用户名或Email" dd-required type="text" /></dt></dl>
<dl>
<dd>密　码</dd>
<dt><input id="password" name="password" value="" placeholder="请输入密码" dd-required type="password"></dt></dl>

<?php if($show_yzm==1){?>
<dl id="yzmdiv">
    <dd id="passwd_quesetion">验证码</dd>
    <dt><table border="0"><tr>
    <td><input id="yzm" name="captcha" value="" dd-required  placeholder="验证码" style='width:100px;'/></td>
    <td><img id="yzmimg" src='<?=CURURL?>/comm/showpic.php?easy=1'  onClick="getYzm()" style=""></td>
    </tr>
    </table>
    </dt>
    </dl>
<? }?>
<div class="footer footer_b" style="text-align:center; border:none;">
<p style="margin-top:20px; font-size:16px;"><input name="remember" type="hidden" value="1" /><input type="hidden" name="sub" value="1" /><input type="submit" id="tijiao" value="登录" class="submit" /></p></div>
</form>
</div>
<?php if(!empty($dd_tpl_data['apilogin'])){?>
<section class="other_login">
  <h4>其他方式登录</h4>
  <?php if(isset($dd_tpl_data['apilogin']['tb']) && $dd_tpl_data['apilogin']['tb']==1){?>
  <p><a href="<?=wap_l('user','weblogin',array('a'=>'tb','action'=>urlencode($from)))?>"><i></i>淘宝账号登录</a></p>
  <?php }?>
  <?php if(isset($dd_tpl_data['apilogin']['qq']) && $dd_tpl_data['apilogin']['qq']==1){?>
  <p><a href="<?=wap_l('user','weblogin',array('a'=>'qq','action'=>urlencode($from)))?>" style="background: #00a2ff"><i style="background-position: 2px -38px"></i>QQ账号登录</a></p>
  <?php }?>
  <?php if(isset($dd_tpl_data['apilogin']['sina']) && $dd_tpl_data['apilogin']['sina']==1){?>
  <p><a href="<?=wap_l('user','weblogin',array('a'=>'sina','action'=>urlencode($from)))?>" style="background: #f00"><i style="background-position: 2px -84px"></i>新浪微博账号登录</a></p>
  <?php }?>
</section>
<?php }?>
</div>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>