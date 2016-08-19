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
$top_nav_name=array(array('url'=>u('seo','list'),'name'=>'SEO设置'),array('url'=>u('sitemap','list'),'name'=>'网站地图'),array('url'=>u('seo','arr'),'name'=>'伪静态设置'),array('url'=>u('seo','set'),'name'=>'加密设置'));
include(ADMINTPL.'/header.tpl.php');
$alias_mod_act_arr=dd_get_cache('alias');
?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td align="right" width="115">url加密字符：</td>
    <td>&nbsp; <input name="URLENCRYPT" value="<?=URLENCRYPT?>"/> <span class="zhushi">为空表示不加密(设置后建议不要修改，适用于淘宝模块的view页面)</span></td>
  </tr>
  <tr>
    <td align="right">图片加密开关：</td>
    <td>&nbsp;
      <label>
       <?=html_radio(array('1'=>'开启','0'=>'关闭'),PICJM,'PICJM')?>
     </label><span class="zhushi">图片加密会增加图片收录，同时损耗系统资源。</span>
    </td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="hidden" name="arr_name" value="alias" /><input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>