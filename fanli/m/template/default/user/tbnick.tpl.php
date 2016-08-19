<?php
if (!defined('INDEX')) {
	exit ('Access Denied');
}

$parameter=act_wap_user_tbnick();
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
				ddAlert('设置完成','<?=wap_l('user')?>');
			}
			else{
				alert(data.r);
			}
		}
	});
	return false;
}

function delete_tr(id){
	$("#"+id).remove();
}
</script>
<div class="listHeader">
  <p> <b>跟单设置</b> <a href="javascript:;" onclick="history.back()" class="left">返回</a> <a href='<?=wap_l(MOD,'index')?>' class="right">会员中心</a>  </p>
</div>
<div class="shopBody">
<div class="info" style="border-top:none;">

  <form onSubmit="return checkForm($(this),cbCheckForm)" action="">
  	<?php foreach($tbnick_arr as $k=>$v){?>
	<dl <?php if($v){?>id="tbnick_tr_<?=$k?>"<?php }?> style=" width:35em">
     <dd style=" width:7.5em; font-size:1em; height:1em; display:inline-block;">淘宝订单号</dd>          
 	<dt><input name="tbnick[<?=$k?>]" type="text" id="tbnick_<?=$k?>" value="<?=$v?>" style=" width:10em; padding:0 0.5em; margin-left:0.5em;" placeholder="淘宝订单号"></dt>
     <dd style=" width:3em; height:1em;"><?php if($v){?><td><span onClick="delete_tr('tbnick_tr_<?=$k?>')" title="点击删除该账号" style="color:#666; cursor:pointer;">删除</span></td><?php }?></dd>
    </dl>	
    <?php }?>
   <div style="text-align:center; margin:10px 0px; line-height:20px; font-size:16px;">
          <input name="do" type="hidden" value="tbnick" ><input type="hidden" name="sub" value="1" />
          <input type="submit" value="保存" id="sub" class="submit"></div>     
    </form>
</div>


</div>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>