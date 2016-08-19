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

//include(ADMINROOT.'/mod/public/part_set.act.php');
include(ADMINTPL.'/header.tpl.php');

?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td align="right" width="115px">淘宝缓存时间：</td>
    <td>&nbsp;<input style="width:30px" name="taoapi[cache_time]" value="<?=(int)$webset['taoapi']['cache_time']?>" />&nbsp;<span class="zhushi">单位(小时)，设为为0即为不缓存，目录为data/temp/taoapi。</span><input type="button" value="删除缓存" onclick="javascript:openpic('../<?=u('cron','run',array('jiaoben'=>'cron_deltaocache'))?>','upload','450','350')" /></td>
  </tr>
  <tr>
    <td align="right">临时缓存：</td>
    <td>&nbsp;<span class="zhushi">目录为data/temp/session。</span> <input type="button" value="删除缓存" onclick="javascript:openpic('../<?=u('cron','run',array('jiaoben'=>'cron_delsessioncache'))?>','upload','450','350')" /></td>
  </tr>
  <tr>
    <td align="right">数据库缓存：</td>
    <td>&nbsp;<span class="zhushi">目录为data/temp/sql。</span> <input type="button" value="删除缓存" onclick="javascript:openpic('../<?=u('cron','run',array('jiaoben'=>'cron_delsqlcache'))?>','upload','450','350')" /></td>
  </tr>
  <tr>
    <td align="right">远程抓取缓存：</td>
    <td>&nbsp;<span class="zhushi">目录为data/temp/url。</span> <input type="button" value="删除缓存" onclick="javascript:openpic('../<?=u('cron','run',array('jiaoben'=>'cron_delurlcache'))?>','upload','450','350')" /></td>
  </tr>
  <tr>
    <td align="right">清除所有缓存：</td>
    <td>&nbsp;<span class="zhushi">目录为data/temp。</span> <input type="button" value="删除缓存" onclick="javascript:openpic('../<?=u('cron','run',array('jiaoben'=>'cron_delallcache'))?>','upload','450','350')" /></td>
  </tr>
  <tr>
    <td align="right">生成静态页：</td>
    <td>&nbsp;<label><input <?php if($webset['static']['index']['index']==1){?> checked="checked"<?php }?> name="static[index][index]" type="checkbox" value="1"/> 首页</label>&nbsp;<span class="zhushi">（暂时只支持首页）</span></td>
  </tr>
  <tr>
    <td align="right">网站缓存：</td>
    <td>&nbsp;<input type="button" value="更新缓存" onclick="javascript:openpic('<?=u('fun','cache')?>','upload','450','350')" /></td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>