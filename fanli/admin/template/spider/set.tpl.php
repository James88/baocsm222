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
$spider_limit_arr=array(0=>'关闭',1=>'开启');
?>
<script>
$(function(){
	<?=radio_guanlian('seo[spider_limit]')?>
});
</script>
<div class="explain-col"> 填写数字，100表示100%限制，20表示20%限制，无需限制填写0！</div>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
  <tr>
    <td width="150px" align="right">屏蔽蜘蛛：</td>
    <td>&nbsp;<?=html_radio($spider_limit_arr,$webset['seo']['spider_limit'],'seo[spider_limit]')?></td>
  </tr>
  <tbody class="seospider_limit_guanlian">
  <tr>
    <td align="right">搜搜(sosospider)：</td>
    <td>&nbsp;<input name="spider[sosospider]" value="<?=$webset['spider']['sosospider']?>" style="width:30px"/> </td>
  </tr>
  <tr>
    <td align="right">百度(baiduspider)：</td>
    <td>&nbsp;<input name="spider[baiduspider]" value="<?=$webset['spider']['baiduspider']?>" style="width:30px"/></td>
  </tr>
  <tr>
    <td align="right">雅虎(yahoo)：</td>
    <td>&nbsp;<input name="spider[yahoo]" value="<?=$webset['spider']['yahoo']?>" style="width:30px"/></td>
  </tr>
  <tr>
    <td align="right">必应(bingbot)：</td>
    <td>&nbsp;<input name="spider[bingbot]" value="<?=$webset['spider']['bingbot']?>" style="width:30px"/></td>
  </tr>
  <tr>
    <td align="right">谷歌(googlebot)：</td>
    <td>&nbsp;<input name="spider[googlebot]" value="<?=$webset['spider']['googlebot']?>" style="width:30px"/></td>
  </tr>
  <tr>
    <td align="right">alexa(ia_archiver)：</td>
    <td>&nbsp;<input name="spider[ia_archiver]" value="<?=$webset['spider']['ia_archiver']?>" style="width:30px"/></td>
  </tr>
  <tr>
    <td align="right">有道(youdaobot)：</td>
    <td>&nbsp;<input name="spider[youdaobot]" value="<?=$webset['spider']['youdaobot']?>" style="width:30px"/></td>
  </tr>
  <tr>
    <td align="right">搜狐(sohu)：</td>
    <td>&nbsp;<input name="spider[sohu]" value="<?=$webset['spider']['sohu']?>" style="width:30px"/></td>
  </tr>
  <tr>
    <td align="right">msn(msnbot)：</td>
    <td>&nbsp;<input name="spider[msnbot]" value="<?=$webset['spider']['msnbot']?>" style="width:30px"/></td>
  </tr>
  <tr>
    <td align="right">雅虎(slurp)：</td>
    <td>&nbsp;<input name="spider[slurp]" value="<?=$webset['spider']['slurp']?>" style="width:30px"/></td>
  </tr>
  <tr>
    <td align="right">搜狗(sogou)：</td>
    <td>&nbsp;<input name="spider[sogou]" value="<?=$webset['spider']['sogou']?>" style="width:30px"/></td>
  </tr>
  <tr>
    <td align="right">奇虎(QihooBot)：</td>
    <td>&nbsp;<input name="spider[QihooBot]" value="<?=$webset['spider']['QihooBot']?>" style="width:30px"/></td>
  </tr>
  <tr>
    <td align="right">一搜(YisouSpider)：</td>
    <td>&nbsp;<input name="spider[YisouSpider]" value="<?=$webset['spider']['YisouSpider']?$webset['spider']['YisouSpider']:100?>" style="width:30px"/></td>
  </tr>
  </tbody>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </form>
</table>

<?php include(ADMINTPL.'/footer.tpl.php');?>