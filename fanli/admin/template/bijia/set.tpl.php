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
$top_nav_name=get_lm($need_zhlm);

$bijia_arr=array('关闭','综合平台');
if($need_zhlm==1){
	$bijia_arr=array(0=>'关闭',2=>'59秒开放平台',3=>'亿起发开放平台');
}

$bijia=BIJIA;
if($bijia==1){$bijia=0;}

include(ADMINTPL.'/header.tpl.php');
?>
<script>

$(function(){
    $('input[name=BIJIA]').click(function(){
		var v=$(this).val();
		$('.from_table').hide();
        if(v==1){
			$('#zonghe').show();
		}
		else if(v==3){
			$('#yiqifa').show();
		}
		else if(v==2){
			$('#wujiu').show();
		}
	});
	
	var v=parseInt($('input[name="BIJIA"]:checked').val());
	if(v==1){
		$('#zonghe').show();
	}
	else if(v==3){
		$('#yiqifa').show();
	}
	else if(v==2){
		$('#wujiu').show();
	}
})
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" align="center" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">全网搜索：</td>
    <td>&nbsp;<?=html_radio($bijia_arr,$bijia,'BIJIA')?></td>
  </tr>
  <tbody class="from_table" id="zonghe">
  <tr>
    <td width="115" align="right">综合平台：</td>
    <td>&nbsp;<span class="zhushi">综合平台无需设置，开启就可使用</span></td>
  </tr>
  </tbody>
  <tbody class="from_table" id="wujiu">
  <tr>
    <td width="115" align="right">59秒key：</td>
    <td>&nbsp;<input id="" name="wujiumiaoapi[key]" value="<?=$webset['wujiumiaoapi']['key']?>" /> <?php if(DLADMIN!=1){?><span class="zhushi"><a target="_blank" href="http://bbs.duoduo123.com/read-htm-tid-125897-ds-1.html">说明教程</a></span><?PHP }?></td>
  </tr>
  <tr>
    <td align="right">59秒secret：</td>
    <td>&nbsp;<input id="" type="text" name="wujiumiaoapi[secret]" value="<?=$webset['wujiumiaoapi']['secret']?>" /></td>
  </tr>
  <tr>
    <td align="right">商品个数：</td>
    <td>&nbsp;<input style=" width:50px"  name="wujiumiaoapi[pagesize]" value="<?=$webset['wujiumiaoapi']['pagesize']?>" /> 最多40</td>
  </tr>
  <tr>
    <td align="right">禁用商城id：</td>
    <td>&nbsp;<input style="width:500px" name="wujiumiaoapi[shield_merchantId]" value="<?=$webset['wujiumiaoapi']['shield_merchantId']?>" /> &nbsp;<span class="zhushi">用英文逗号隔开</span></td>
  </tr>
  </tbody>
  
  <tbody class="from_table" id="yiqifa">
  <tr>
    <td width="115px" align="right">亿起发key：</td>
    <td>&nbsp;<input id="" name="yiqifaapi[key]" value="<?=$webset['yiqifaapi']['key']?>" /> <?php if(DLADMIN!=1){?><span class="zhushi"><a target="_blank" href="http://bbs.duoduo123.com/read-htm-tid-86464-ds-1.html">说明教程</a></span><?php }?></td>
  </tr>
  <tr>
    <td align="right">亿起发secret：</td>
    <td>&nbsp;<input id="" type="text" name="yiqifaapi[secret]" value="<?=$webset['yiqifaapi']['secret']?>" /></td>
  </tr>
  <tr>
    <td align="right">商品个数：</td>
    <td>&nbsp;<input style=" width:50px"  name="yiqifaapi[pagesize]" value="<?=$webset['yiqifaapi']['pagesize']?>" /></td>
  </tr>
  <tr>
    <td align="right">禁用商城id：</td>
    <td>&nbsp;<input style="width:500px" name="yiqifaapi[shield_merchantId]" value="<?=$webset['yiqifaapi']['shield_merchantId']?>" /> &nbsp;<span class="zhushi">用逗号隔开</span></td>
  </tr>
  </tbody>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="hidden" name="yiqifaapi[open]" value="0"/><input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>