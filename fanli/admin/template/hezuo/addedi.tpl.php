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
$bankuai_data=$duoduo->select_all('bankuai','code,title',"1");
foreach($bankuai_data as $vo){
	$bankuai[$vo['code']]=$vo['title'];
}
include(ADMINTPL.'/header.tpl.php');
?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">会员名：</td>
    <td>&nbsp;<?=$duoduo->select('user','ddusername','id='.$row['uid'])?></td>
  </tr>
  <tr>
    <td width="115px" align="right">内容：</td>
    <td>&nbsp;<?=$row['content']?></td>
  </tr>
 <tr>
    <td width="115px" align="right">报名栏目：</td>
    <td>&nbsp;<?=$bankuai[$row['code']]?></td>
  </tr>
  <tr>
    <td align="right">添加商品：</td>
    <td>&nbsp;<a href="<?=$url?>">点击添加对应商品</a></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>