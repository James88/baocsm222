<?php
if (!defined('INDEX')) {
	exit ('Access Denied');
}

$parameter=act_wap_user_pwd();
extract($parameter);
include(TPLPATH.'/inc/header_2.tpl.php');
?>
<script>
function cbCheckForm(input,$form){
	var url='<?=wap_l(MOD,ACT)?>';
	url=ddJoin(url,input);
	$.ajax({
		url: url,
		dataType:'jsonp',
		jsonp:"callback",
		success: function(data){
			if(data.s==1){
				ddAlert('设置完成',goBack);
			}
			else{
				alert(data.r);
			}
		}
	});
	return false;
}

function goBack(){
	history.back();
}
</script>
<div class="listHeader">
  <p> <b>修改密码</b> <a href="javascript:;" onclick="history.back()" class="left">返回</a> <a href='<?=wap_l(MOD,'set')?>' class="right">信息</a>  </p>
</div>
<div class="shopBody">
<div class="info" style="border-top:none;">
  <form onSubmit="return checkForm($(this),cbCheckForm)" action="">
  <?php if($dduser['default_pwd']!=''){?>
<dl><dd>默认密码</dd><dt><input type="text" value="<?=$dduser['default_pwd']?>" style="border:0; background:none" /></dt></dl>
<?php }?>
    <dl>
	 <dd>原&nbsp;密&nbsp;码</dd>     
     <dt><input id="old_pwd" name="old_pwd" placeholder="请输入登录密码" dd-required type="password" /></dt>
    </dl>
	
	<dl>
     <dd>新&nbsp;密&nbsp;码</dd>
     <dt><input id="ddpwd" name="ddpwd" placeholder="请输入新密码" dd-required type="password"></dt>
    </dl>
	<dl>
     <dd>重复密码</dd>          
     <dt><input id="pwd_confirm" name="pwd_confirm" value="" dd-equal="ddpwd" dd-required placeholder="请输重复新密码" type="password"></dt>
     </dl>
   <div style="text-align:center; margin:10px 0px; line-height:20px; font-size:16px;">
          <input type="hidden" name="do" value="pwd" /><input type="hidden" name="sub" value="1" />
          <input type="submit" value="保存" id="sub" class="submit"></div>     
    </form>
</div>
</div>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>