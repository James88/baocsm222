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
?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" align="center" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">开启搜索：</td>
    <td>&nbsp;<?=html_radio(array('0'=>'关闭','1'=>'开启'),$webset['yiqifaapi']['open'],'yiqifaapi[open]')?> <a target="_blank" href="http://bbs.duoduo123.com/read-htm-tid-86464-ds-1.html">说明教程</a></td>
  </tr>
  <tr>
    <td width="115px" align="right">亿起发key：</td>
    <td>&nbsp;<input id="" name="yiqifaapi[key]" value="<?=$webset['yiqifaapi']['key']?>" /></td>
  </tr>
  <tr>
    <td align="right">亿起发secret：</td>
    <td>&nbsp;<input id="" type="test" name="yiqifaapi[secret]" value="<?=$webset['yiqifaapi']['secret']?>" /></td>
  </tr>
  <tr>
    <td align="right">商品个数：</td>
    <td>&nbsp;<input style=" width:50px"  name="yiqifaapi[pagesize]" value="<?=$webset['yiqifaapi']['pagesize']?>" /></td>
  </tr>
  <tr>
    <td align="right">缓存时间：</td>
    <td>&nbsp;<input style="width:30px" name="yiqifaapi[cache_time]" value="<?=$webset['yiqifaapi']['cache_time']?>" />&nbsp;<span style="color:#FF6600">单位(小时)，设为为0即为不缓存，目录为data/temp/yiqifaapi。</span> <input type="button" value="删除缓存" onclick="javascript:openpic('../<?=u('cache','del',array('admin'=>'1','do'=>'yiqifa'))?>','upload','450','350')" /></td>
  </tr>
  <tr>
    <td align="right">禁用商城id：</td>
    <td>&nbsp;<input style="width:500px" name="yiqifaapi[shield_merchantId]" value="<?=$webset['yiqifaapi']['shield_merchantId']?>" /> &nbsp;用逗号隔开</td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>