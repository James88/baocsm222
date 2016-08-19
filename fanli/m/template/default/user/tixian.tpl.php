<?php
if (!defined('INDEX')) {
	exit ('Access Denied');
}

$parameter=act_wap_tixian();
extract($parameter);

include(TPLPATH.'/inc/header_2.tpl.php');

?>
<script>
<?php if($dduser['alipay']=='' || $dduser['realname']==''){?>
ddAlert('请先设置基本信息','<?=wap_l(MOD,'set')?>');
<?php }?>

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
				ddAlert('提取完成，等待管理员审核','<?=wap_l(MOD,'index')?>');
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
  <p> <b><?=$title_arr[$type]?>提取</b> <a href="javascript:;" onclick="history.back()" class="left">返回</a> <a href='<?=wap_l(MOD,'tixian',array('type'=>(3-$type)))?>?>' class="right"><?=$title_arr[3-$type]?></a>  </p>
</div>
<div class="shopBody">
<div class="info" style="border-top:none;">
  <form onSubmit="return checkForm($(this),cbCheckForm)" action="">
  <?php if($type==1){?>
    <dl>
	 <dd>现有</dd>     
     <dt><input  value="<?=$dduser['jifenbao'].TBMONEY?>" disabled="disabled"/></dt>
    </dl>
	
	<dl>
     <dd>提取</dd>
     <dt><input id="jifenbao" type="text" name="jifenbao" placeholder="最低提取<?=$webset['tixian']['tblimit']?>" value="" dd-type="num" dd-required /></dt>
    </dl>
	<dl>
     <dd>密码</dd>          
     <dt><input id="ddpassword" name="ddpassword" value="" placeholder="登录密码" dd-required type="password"></dt>
     </dl>
	<dl>
      <dd>说明</dd>
      <dt><input id="remark" name="remark" value="" placeholder="特别说明，没有请留空" type="text"></dt>
    </dl>
   <div style="text-align:center; margin:10px 0px; line-height:20px; font-size:16px;">
<input type="hidden" name="type" value="1" /><input type="hidden" name="sub" value="1" />
          <input type="submit" value="提交" id="sub" class="submit"></div>    
          
      <?php }else{?>
      <dl>
	 <dd>现有</dd>     
     <dt><input  value="<?=$dduser['money'].'元'?>" disabled="disabled"/></dt>
    </dl>
	
	<dl>
     <dd>提取</dd>
     <dt><input id="money" type="text" name="money" placeholder="最低提取<?=$webset['tixian']['limit']?>" value="" dd-type="num" dd-required /></dt>
    </dl>
	<dl>
     <dd>密码</dd>          
     <dt><input id="ddpassword" name="ddpassword" value="" placeholder="登录密码" dd-required type="password"></dt>
     </dl>
	<dl>
      <dd>说明</dd>
      <dt><input id="remark" name="remark" value="" placeholder="特别说明，没有请留空" type="text"></dt>
    </dl>
   <div style="text-align:center; margin:10px 0px; line-height:20px; font-size:16px;">
<input type="hidden" name="type" value="2" /><input type="hidden" name="sub" value="1" />
          <input type="submit" value="提交" id="sub" class="submit"></div>  
      <?php }?> 
    </form>
</div>


</div>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>