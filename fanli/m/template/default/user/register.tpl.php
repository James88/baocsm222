<?php
if (!defined('INDEX')) {
	exit ('Access Denied');
}

$parameter=act_wap_register();
extract($parameter);

if($_GET['web']){
	$web=$_GET['web'];
	$webid=$_GET['webid'];
	$webname=$_GET['webname'];
}

include(TPLPATH.'/inc/header_2.tpl.php');
?>
<script>
function cbCheckForm(input,$form){
	var url='<?=wap_l('user',ACT)?>';
	url=ddJoin(url,input);
	$('#tijiao').val('提交中...');
	$.ajax({
		url: url,
		dataType:'jsonp',
		jsonp:"callback",
		success: function(data){
			if(data.s==1){
				ddAlert('注册成功','<?=wap_l('user')?>');
			}
			else{
				getYzm();
				alert(data.r);
				$('#tijiao').val('注册');
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
  <p> <b>免费注册</b> <a href="javascript:;" onclick="history.back()" class="left">返回</a> <a href='<?=wap_l('user','login')?>' class="right">登录</a>  </p>
</div>
<div class="shopBody">
<div class="info" style="border-top:none;">
<form onSubmit="return checkForm($(this),cbCheckForm)">
	<?php if($_GET['web']){?>
	<dl><div style="line-height:2em; padding-left:2em"><?=$webname?>，您好！您已经用<?php $t=reg_web_email($webid . '@' . $web . '.com');echo $t[0]?>成功登录<?=WEBNAME?>，<br/>请完善以下信息以便更好使用我们网站。</div></dl>
    <?php }?>
    <dl><dd>电子邮箱</dd><dt><input id="email" name="email" value="" placeholder="输入您的邮箱" dd-required dd-type="email"></dt></dl>
    <dl>
	 <dd>账　　号</dd>     
     <dt><input id="username" name="username" placeholder="请输入用户名" value="<?=$webname?>" dd-required type="text" />
	 </dt>
    </dl>
	
	<dl>
     <dd>密　　码</dd>
     <dt><input id="password" name="password" placeholder="请输入密码" value="" dd-required type="password"></dt>
    </dl>
	<dl>
     <dd>确认密码</dd>          
     <dt><input id="password_confirm" name="password_confirm" dd-required placeholder="重复上面的密码" value="" type="password"></dt>
     </dl>
    
    <?php if($webset['user']['need_qq']==1){?>
    <dl><dd>QQ号码</dd><dt><input id="qq" name="qq" value="" dd-type="num" placeholder="输入您的QQ账号" dd-required></dt></dl>
    <?php }?>
    
	
    
    <?php if($webset['user']['need_tbnick']==1){?>
    <dl><dd>淘宝订单号</dd><dt><input id="tbnick" name="tbnick" value="" placeholder="输入您的淘宝订单号" dd-required></dt></dl>
    <?php }?>
    <?php if($webset['user']['need_alipay']==1){?>
    <dl><dd>支付宝</dd><dt><input id="alipay" name="alipay" dd-type="alipay" dd-required value="" placeholder="输入您的支付宝账号"></dt></dl>
    <?php }?>
    <?php 
	if($webset['user']['need_tjr']==1){
		$tjr = (int) get_cookie("tjr");
		if($tjr>0){
			$trjname=$duoduo->select('user','ddusername','id="'.$tjr.'"');
		}
		else{
			$trjname='';
		}
	?>
    <dl><dd>推荐人</dd><dt><input id="tjrname" name="tjrname" value="<?=$trjname?>" placeholder="输入您的推荐人账号"></dt></dl>
    <?php }?>
    
	<dl>
    <dd id="passwd_quesetion">验证码</dd>
    <dt><table border="0"><tr>
    <td><input id="captcha" name="captcha" value="" placeholder="验证码" dd-required dd-type="num" dd-minl="4" dd-maxl="4" style='width:100px;'/></td>
    <td><img id="yzmimg" src=""  onClick="getYzm()" style=""></td>
    </tr>
    </table>
    </dt>
    </dl>
<script>
getYzm();
</script>   		
   <div style="text-align:center; margin:10px 0px; line-height:20px; font-size:16px;">
   <?php if($_GET['web']){?>
   <input type="hidden" name="web" value="<?=$web?>"/><input type="hidden" name="webid" value="<?=$webid?>"/><input type="hidden" name="webname" value="<?=$webname?>"/>
   <?php }?>
          <input type="hidden" name="sub" value="1"/>
          <input type="submit" value="立即注册" id="tijiao" class="submit"></div>      
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