<?php 
/**
 * ============================================================================
 * 版权所有 2008-2012 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}

include(ADMINTPL.'/header.tpl.php');
if(!defined('TAODATATPL')){
	define('TAODATATPL',1);
}
?>
<style>
.tdjsm ol li{ line-height:30px}
</style>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115" align="right">淘点金代码：</td>
    <td><div style="float:left">&nbsp;<textarea id="taodianjin"  cols="60" rows="23"><?=$webset['taodianjin_pid']?$taodianjin_set:''?></textarea></div>
    <div style="float:left; padding-top:30px;" class="tdjsm">
    <ol>
    <li>首次开通淘点金代码，大约需要1小时生效！（<a href="http://www.alimama.com" target="_blank">前往阿里妈妈</a>）</li>
    <li style="color:#F00">淘点金代码必须在你申请淘点金的域名下才可使用</li>
    <li><a data-type="1" biz-sellerid="263817957" data-tmpl="140x190" data-tmplid="3" data-rd="1" data-style="1" data-border="1" target="_blank" href="#">淘点金测试</a>（鼠标放在文字上，会出现一个带有“韩都衣舍”logo的浮动层，如果你没出现，说明你的淘点金代码是错误的，点击浮动层到达淘宝有pid，说明你的淘点金代码生效了。<a href="http://bbs.duoduo123.com/read-htm-tid-168561.html" target="_blank">查看详细说明</a>）</li>
    <li>程序会提取你的阿里妈妈pid并且格式化代码，如果你需要修改淘点金代码，文件在comm/tdj_tpl.php</li>
    <li><a href="http://bbs.duoduo123.com/read-htm-tid-168865.html" target="_blank">淘点金代码本地化</a></li>
    </ol>
    </div></td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="hidden" name="TAODATATPL" value="1" /><input type="submit" name="sub" value=" 保 存 设 置 " /> &nbsp;&nbsp;&nbsp;<a href="http://bbs.duoduo123.com/read-htm-tid-159578.html" style="color:#F00; font-weight:bold; font-size:14px" target="_blank">淘点金代码获取教程</a>
     <input type="hidden" name="taodianjin_pid" id="taodianjin_pid" />
     </td>
  </tr>
</table>
</form>
<script>
$(document).ready(function(){
  $("#taodianjin").focus();
}); 

$("#taodianjin").blur(function(){
	var patrn=/mm_[0-9]+_[0-9]+_[0-9]+/ig; 
	var pid=patrn.exec($("#taodianjin").val());
	$("#taodianjin_pid").val(pid);
});
</script>
<?=$taodianjin_set?>
<?php include(ADMINTPL.'/footer.tpl.php');?>