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

include(ADMINTPL.'/header.tpl.php');

?>
<div class="explain-col">除密钥外，其余信息无需填写，可通过密钥自动获取，管理员只需设置插件开启关闭。
  </div>
<br />
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">状态：</td>
    <td>&nbsp;<?=html_radio($zhuangtai_arr,$row['status'],'status')?></td>
  </tr>
  <tr>
    <td align="right">密钥：</td>
    <td>&nbsp;<input name="key" type="text" id="key" value="<?=$row['key']?>" /></td>
  </tr>
  <tr>
    <td align="right">标识码：</td>
    <td>&nbsp;<input name="code" type="text" id="code" value="<?=$row['code']?>" style="width:80px" /></td>
  </tr>
  
  <tr>
    <td align="right">名称：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>" /></td>
  </tr>
  <tr>
    <td align="right">价格：</td>
    <td>&nbsp;<input name="price" type="text" id="price" value="<?=$row['price']?>"/> 元</td>
  </tr>
  <?php 
	$endtime=strtotime($row['endtime']);
  ?>
  <tr>
    <td align="right">到期时间：</td>
    <td>&nbsp;<input type="text" id="endtime" name="endtime" value="<?=$row['endtime']?>"/> <?php if($row['endtime']!='' && $endtime<date('Y-m-d H:i:s',TIME)){?><span class="zhushi">插件已过期</span><?php }?></td>
  </tr>
  <tr>
    <td align="right">模块/行为：</td>
    <td>&nbsp;<input type="text" name="mod" id="mod" style="width:90px" value="<?=$row['mod']?>" />/ <input type="text" id="act" name="act" style="width:90px" value="<?=$row['act']?>" /> <span class="zhushi">用于插件特别设置</span></td>
  </tr>
  <tr>
    <td align="right">导航标记：</td>
    <td>&nbsp;<input type="text" name="tag" id="tag" style="width:90px" value="<?=$row['tag']?>" /> <span class="zhushi">用于前台导航自动生成</span></td>
  </tr>
  
  <tr>
    <td align="right">适用版本：</td>
    <td>&nbsp;<input type="text" name="banben" id="banben" style="width:90px" value="<?=$row['banben']?>" /> <span class="zhushi">我当前的版本<?=BANBEN?></span></td>
  </tr>
  <tr>
    <td align="right">是否有前台搜索：</td>
    <td>&nbsp;<?=html_radio($shifou_arr,$row['search_open'],'search_open')?> <span class="zhushi">该插件是否需要前台搜索</span></td>
  </tr>
  <tr class="search_open_guanlian">
    <td align="right">前台搜索名称：</td>
    <td>&nbsp;<input type="text" name="search_name" id="search_name" value="<?=$row['search_name']?>" /> </td>
  </tr>
  <tr class="search_open_guanlian">
    <td align="right">前台搜索名称宽度：</td>
    <td>&nbsp;<input type="text" name="search_width" id="search_width" value="<?=$row['search_width']?>" style="width:60px" /> <span class="zhushi">单位：像素（px）</span> </td>
  </tr>
  <tr class="search_open_guanlian">
    <td align="right">前台搜索提示：</td>
    <td>&nbsp;<input type="text" name="search_tip" id="search_tip" value="<?=$row['search_tip']?>" /> </td>
  </tr>
  
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="authcode" id="authcode" value="<?=$row['authcode']?>" /><input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>

<script>
<?=radio_guanlian('search_open')?>
<?=radio_guanlian($row['search_open'])?>
$('input[type=text]').not('#search_name,#search_width,#search_tip').attr('readonly','readonly').css('border','0');
$('#getPluginInfo').click(function(){
	var key=$('#key').val();
	if(key==''){
		alert('插件密钥必填');
		return false;
	}
	$.ajax({
		url: '<?=u(MOD,ACT)?>',
		data:{'key':key},
		type: 'POST',
		dataType: 'json',
		error: function(XMLHttpRequest,textStatus, errorThrown){
			alert('链接不通');
			return false;
		},
		success: function(data){
			if (data.s==0){
				alert(data.r);
				return false;
			}
			else{
				$('#code').val(data.r.code);
				$('input:radio[name=status]').eq(1).attr('checked','checked');
				$('#title').val(data.r.name);
				$('#price').val(data.r.price);
				$('#authcode').val(data.r.authcode);
				$('#endtime').val(data.r.endtime);
				$('#mod').val(data.r.mod);
				$('#act').val(data.r.act);
				$('#tag').val(data.r.tag);
				$('input:radio[name=search_open]').eq(data.r.search_open).attr('checked','checked');
				$('#search_name').val(data.r.search_name);
				$('#search_width').val(data.r.search_width);
				$('#search_tip').val(data.r.search_tip);
			}
         }
	});
	return false;
});
</script>
<?php include(ADMINTPL.'/footer.tpl.php');?>