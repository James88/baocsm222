<?php
if (!defined('INDEX')) {
	exit ('Access Denied');
}
if($dduser['id']==0){
	jump(wap_l(MOD,'loGIN'));
}
$webtitle='帐号设置';
$from=$_GET['from'];

$dduser['default_pwd']=$dd_wap_class->get_default_pwd($dduser['id']);

include(TPLPATH.'/inc/header_2.tpl.php');
?>
<script>
function cbCheckForm(input,$form){
	var url='<?=wap_l(MOD,'set')?>';
	url=ddJoin(url,input);
	$.ajax({
		url: url,
		dataType:'jsonp',
		jsonp:"callback",
		success: function(data){
			if(data.s==1){
				alert('设置完成','<?=$from?>');
			}
			else{
				alert(data.r);
			}
		}
	});
	return false;
}
</script>
<div class="listHeader">
  <p> <b>帐号设置</b> <a href="javascript:;" onclick="history.back()" class="left">返回</a> <a href='<?=wap_l()?>' class="right">首页</a>  </p>
</div>
<div class="shopBody">
<div class="info" style="border-top:none;">
  <form onSubmit="return checkForm($(this),cbCheckForm)" action="" id="register_form">
  <input id="old_password" type="hidden" name="old_password" value="<?=$dduser['default_pwd']?>"/>
    <dl>
      <dd>邮箱</dd>
      <dt><input id="email" name="email" value="" placeholder="请输入电子邮箱" dd-required dd-type="email" type="text"></dt>
    </dl>
    
    <br />
    <dl>
     <dd></dd>
     <dt>以便网站联系您！</dt>
    </dl>
    <br />
    
  		
   <div style="text-align:center; margin:10px 0px; line-height:20px; font-size:16px;">
          <input name="do" type="hidden" value="update" ><input type="hidden" name="sub" value="1" />
          <input type="submit" value="保存" id="sub" class="submit"></div>     
    </form>
</div>


</div>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>