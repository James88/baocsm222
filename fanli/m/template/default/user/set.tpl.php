<?php
if (!defined('INDEX')) {
	exit ('Access Denied');
}

$parameter=act_wap_user_set();
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
  <p> <b>帐号设置</b> <a href="javascript:;" onclick="history.back()" class="left">返回</a> <a href='<?=wap_l(MOD,'pwd')?>' class="right">改密</a>  </p>
</div>
<div class="shopBody">
<div class="info" style="border-top:none;">

  <form onSubmit="return checkForm($(this),cbCheckForm)" action="">
  
  <?php if($dduser['default_pwd']!=''){?>
<dl><dd>默认密码</dd><dt><input type="text" value="<?=$dduser['default_pwd']?>" style="border:0; background:none" /></dt></dl>
<?php }?>
  
    <dl>
	 <dd>密　　码</dd>     
     <dt><input id="old_password" type="password" name="old_password" placeholder="请输入登录密码" value="" dd-required/></dt>
    </dl>
	<dl>
     <dd>邮　　箱</dd>
     <dt><input id="email" name="email" value="<?=$dduser['email']?>" placeholder="请输入电子邮箱" dd-required dd-type="email" type="text"></dt>
    </dl>
	<dl>
     <dd>姓　　名</dd>          
     <dt><input id="realname" name="realname" value="<?=$dduser['realname']?>" <?=$dduser['realname']?'disabled="disabled"':''?> placeholder="真实姓名" dd-required type="text"></dt>
    </dl>
	<dl>
      <dd>支 付 宝</dd>
      <dt><input id="alipay" name="alipay" value="<?=$dduser['alipay']?>" <?=$dduser['alipay']?'disabled="disabled"':''?> placeholder="常用支付宝" dd-required dd-type="alipay" type="text"></dt>
    </dl>
    <dl>
      <dd>手 机 号</dd>
      <dt><input id="mobile" name="mobile" value="<?=$dduser['mobile']?>" placeholder="用于短信提醒" dd-required dd-type="mobile" type="text"></dt>
    </dl>
    <dl>
      <dd>Q Q 号</dd>
      <dt><input id="qq" name="qq" value="<?=$dduser['qq']?>" placeholder="以便客服及时联系您" dd-type="qq" type="text"></dt>
    </dl>	        
          
  		
   <div style="text-align:center; margin:10px 0px; line-height:20px; font-size:16px;">
          <input name="do" type="hidden" value="update" ><input type="hidden" name="sub" value="1" />
          <input type="submit" value="保存" id="sub" class="submit"></div>     
    </form>
</div>


</div>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>