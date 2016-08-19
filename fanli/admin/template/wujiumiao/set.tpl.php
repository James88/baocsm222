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
    <td>&nbsp;<?=html_radio(array('0'=>'关闭','1'=>'开启'),$webset['wujiumiaoapi']['open'],'wujiumiaoapi[open]')?> <a target="_blank" href="http://bbs.duoduo123.com/read-htm-tid-125897-ds-1.html">说明教程</a></td>
  </tr>
  <tr>
    <td width="115" align="right">59秒key：</td>
    <td>&nbsp;<input id="" name="wujiumiaoapi[key]" value="<?=$webset['wujiumiaoapi']['key']?>" /></td>
  </tr>
  <tr>
    <td align="right">59秒secret：</td>
    <td>&nbsp;<input id="" type="test" name="wujiumiaoapi[secret]" value="<?=$webset['wujiumiaoapi']['secret']?>" /></td>
  </tr>
  <tr>
    <td align="right">商品个数：</td>
    <td>&nbsp;<input style=" width:50px"  name="wujiumiaoapi[pagesize]" value="<?=$webset['wujiumiaoapi']['pagesize']?>" /> 最多40</td>
  </tr>
  <tr>
    <td align="right">缓存时间：</td>
    <td>&nbsp;<input style="width:30px" name="wujiumiaoapi[cache_time]" value="<?=$webset['wujiumiaoapi']['cache_time']?>" />&nbsp;<span style="color:#FF6600">单位(小时)，设为为0即为不缓存，目录为data/temp/wujiumiaoapi。</span> <input type="button" value="删除缓存" onclick="javascript:openpic('../<?=u('cache','del',array('admin'=>'1','do'=>'wujiumiao'))?>','upload','450','350')" /></td>
  </tr>
  <tr>
    <td align="right">禁用商城id：</td>
    <td>&nbsp;<input style="width:500px" name="wujiumiaoapi[shield_merchantId]" value="<?=$webset['wujiumiaoapi']['shield_merchantId']?>" /> &nbsp;用英文逗号隔开</td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="hidden" name="wujiumiaoapi[del_cache_time]" value="<?=$webset['wujiumiaoapi']['del_cache_time']?>" /><input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>