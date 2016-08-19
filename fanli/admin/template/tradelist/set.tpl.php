<?php 
/**
 * ============================================================================
 * 版权所有 多多科技，保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
if(!defined('ADMIN')){
	exit('Access Denied');
}
$top_nav_name=$top_nav_name=get_lm($need_zhlm);
include(ADMINTPL.'/header.tpl.php');
if(!defined('TAOTYPE')){
	define(TAOTYPE,1);
}
?>
<style>
.has_api_guanlian{ display:none}
</style>
<script>
$(function(){
	if(parseInt($('input[name="TAOTYPE:checked').val())==2){
		$('#key').show();
		$('#secret').show();
	}else{
		$('#key').hide();
		$('#secret').hide();
	}
	
	$('input[name="TAOTYPE"]').click(function(){
		alert('注意，两种形式不要任意切换，你是有返利类api的就一直选择有返利类api，不要没事儿选择一会数据类，一会选择返利类，后果自负。怎么鉴别我有没有返利类api，如果你对这个有疑问，你就是没有，有的人他自己知道有');
	});
	
	$('input[name="HASAPI"]').click(function(){
		has_api_radio($(this));
	});
	has_api_radio($('input[name="HASAPI"]:checked'));
})
	
function has_api_radio($t){
	if($t.val()==1){
		$('.HASAPI_guanlian').show();
	}
	else{
		$('.HASAPI_guanlian').hide();
	}
}

function checkApi(){
	$('#ckapi').html('检测中...');
	$.get('<?=u(MOD,ACT)?>&checkApi=1',function(data){
		$('#ckapi').html('检测中');
		if(data!=1){
			alert(data);
		}
		else{
			alert('appkey正常');
		}
	});
}

</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115" align="right">淘宝API：</td>
    <td>&nbsp;<?=html_radio(array(0=>'无',1=>'有'),HASAPI,'HASAPI')?> </td>
  </tr>
  <tbody class="HASAPI_guanlian">
  <tr>
    <td align="right">Appkey：</td>
    <td>&nbsp;<input name="taoapi[appkey]" value="<?=$webset['taoapi']['appkey']?>" style="width:250PX;" /> <span class="zhushi"> <a href="http://bbs.duoduo123.com/read-1-1-198076.html" target="_blank">申请API</a></span></td>
  </tr>
  <tr>
    <td align="right">Secret：</td>
    <td>&nbsp;<input name="taoapi[secret]" value="<?=$webset['taoapi']['secret']?>" style="width:250PX;" /> <span class="zhushi">请先保存后在点检测 <a id="ckapi" href="javascript:checkApi()">检测</a></span></td>
  </tr>
  <tr>
    <td align="right">API类型：</td>
    <td>&nbsp;<?=html_radio(array(1=>'普通api',2=>'返利类api'),TAOTYPE,'TAOTYPE')?> <span class="zhushi">一般为普通API <a href="http://bbs.duoduo123.com/read-1-1-197248.html" target="_blank">如何查看？</a></span></td>
  </tr>
  </tbody>
  <!--<tr>
    <td align="right">淘点金设置：</td>
    <td><span class="zhushi">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="400" style="padding:5px 5px;"><textarea style="width:360px; height:340px" id="taodianjin"><?=$webset['taodianjin_pid']?$taodianjin_set:''?></textarea></td>
          <td style=" line-height:30px; padding:5px 5px;">
          <?php if(DLADMIN!=1){?>
          <a href="http://bbs.duoduo123.com/read-htm-tid-159578.html" target="_blank">淘点金代码获取教程</a></br>
          1、首次开通淘点金代码，大约需要1小时生效！（<a href="http://www.alimama.com" target="_blank">前往阿里妈妈</a>）</br>
          2、淘点金代码必须在你申请淘点金的域名下才可使用</br>
          3、如何判断是否正常了？一般审核为2个工作日以内，前台点击可正常到爱淘宝并到商品详细的PID为自己的那说明正常了。
          <?PHP }?>
          </td>
        </tr>
      </table></span> </td>
  </tr>-->
  <!--<tr>
    <td align="right">搜索pid：</td>
    <td>&nbsp;<span>无需设置，系统默认淘点金pid，如果需要特别设置，请点击<b style="cursor:pointer; color:#F00" onclick="$('.set_search_pid').show();$(this).parent().hide()">“我要设置”</b></span><span class="set_search_pid" style="display:none"><input name="taoapi[tb_search_pid]" value="<?=$webset['taoapi']['tb_search_pid']?>" style="width:250PX;"/>&nbsp;<span class="zhushi">例：mm_16611111_23456789_34567890（如无特别需求，填写淘点金pid即可） <a href="http://bbs.duoduo123.com/forum.php?mod=viewthread&tid=195741" target="_blank">详细教程</a></span></span></td>
  </tr>-->
  <!--<tr>
    <td align="right">淘点金申请网址：</td>
    <td>&nbsp;<input name="TDJ_URL" value="<?=defined('TDJ_URL')?TDJ_URL:SITEURL?>" style="width:250px;"/>&nbsp;<span class="zhushi">http://开头，结尾不加/。应为当前网址，如被扣分更换请看 <a href="http://bbs.duoduo123.com/read-1-1-198077.html" target="_blank">更换教程</a></span></td>
  </tr>-->
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
     <input type="hidden" name="taodianjin_pid" id="taodianjin_pid" value="<?=$webset['taodianjin_pid']?>" />
     <input type="hidden" name="taoapi[s8]" value="1" />
  </tr>
</table>
</form>
<script>
$(document).ready(function(){
  $("#taodianjin").focus();
}); 

$("#taodianjin").blur(function(){
	var patrn=/mm_[0-9]+_[0-9]+_[0-9]+/ig; 
	if($("#taodianjin").val()!=''){
		var pid=patrn.exec($("#taodianjin").val());
		$("#taodianjin_pid").val(pid);
	}
	else{
		$("#taodianjin_pid").val('');
	}
});
</script>
<?=$taodianjin_set?>
<?php include(ADMINTPL.'/footer.tpl.php');?>