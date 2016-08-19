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
<div class="explain-col">此功能仅在伪静态下可用。<br />设置后如被搜索引擎收录，不可轻易更改，在data/rewrite下会生成对应的伪静态文件（注意要刷新ftp），根据主机选择可用。</div>
<script>
$(function(){
	<?=radio_guanlian('WJT')?>
});

</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  
  	<tr>
    <td align="right" width="150">伪静态开关：</td>
    <td>&nbsp;
      <label>
       <?=html_radio(array('1'=>'开启','0'=>'关闭'),WJT,'WJT')?>
       </label>
     <span class="zhushi"> 请确认您的主机支持伪静态，否则不要开启。</span>
    </td>
  </tr>
  <tr>
    <td align="right">图片伪静态开关：</td>
    <td>&nbsp;
      <label>
       <?=html_radio(array('1'=>'开启','0'=>'关闭'),PICWJT,'PICWJT')?>
     </label><span class="zhushi">图片伪静态会耗费系统资源，虚拟主机禁止开启，服务器用户按需开启。</span>
    </td>
  </tr>
  	<tr class="WJT_guanlian">
    <td  align="right" >标识：</td>
    <td><div style="width:90px; float:left; margin-left:10px">自定义目录</div> <div style="width:80px;float:left">自定义文件名</div></td>
    </tr>
    <?php foreach($alias_mod_act_arr as $k=>$row){?>
    <tr class="WJT_guanlian">
    <td  align="right"><?=$k?>：</td>
    <td>&nbsp;<input style="width:80px" type="text" name="<?=$k?>[0]" value="<?=$row[0]?>" /><input style="width:80px" type="text" name="<?=$k?>[1]" value="<?=$row[1]?>" /></td>
    </tr>
	<?php }?>
     <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="hidden" name="arr_name" value="alias" /><input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>