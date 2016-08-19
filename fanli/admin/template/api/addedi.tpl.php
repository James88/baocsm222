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
<div class="explain-col">请到相关网站注册应用，填写相关的key、secret即可。
  </div>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">名称：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>"/> <span class="zhushi"><a href="http://bbs.duoduo123.com/read-1-1-198028.html" target="_blank">设置教程</a></span></td>
  </tr>
  <tr>
    <td align="right"><?php if($row['code']=='qq'){?>APP ID<?php }else{?>key<?php }?>：</td>
    <td>&nbsp;<input name="key" type="text" id="key" value="<?=$row['key']?>"/></td>
  </tr>
  <tr>
    <td align="right"><?php if($row['code']=='qq'){?>KEY<?php }else{?>secret<?php }?>：</td>
    <td>&nbsp;<input name="secret" type="text" id="title" value="<?=$row['secret']?>" style="width:300px"/></td>
  </tr>
  <?php if($row['code']=='qq'){?>
  <tr>
    <td align="right">回调地址：</td>
    <td>&nbsp;<input name="back_url" type="text" id="back_url" value="<?=$row['back_url']?>" style="width:300px"/> <span class="zhushi"><?=SITEURL?> 必须和QQ申请时填写的完全一样</span></td>
  </tr>
  <?php }?>
  <tr>
    <td align="right">标示代码：</td>
    <td>&nbsp;<input name="code" type="text" id="code" value="<?=$row['code']?>" <?php if($row['code']!=''){?> readonly="readonly" <?php }?>/> <span class="zhushi">注意：填写后不可修改</span></td>
  </tr>
  <tr>
    <td align="right">状态：</td>
    <td>&nbsp;<?=html_radio($open_arr,$row['open'],'open')?></td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?>"/></td>
  </tr>
  <tr>
    <td align="right">代码验证：</td>
    <td>
    <table border="0">
  <tr>
    <td><textarea name="<?=$row['code']?>_meta" id="qq_meta" style="width:300px; height:100px"><?=$webset[$row['code'].'_meta']?></textarea></td>
    <td><img src="images/qq_open.png" width="409" height="114" alt="示例" /></td>
  </tr>
</table>

    </td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>