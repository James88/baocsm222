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

if($id>0){
	if($row['senduser']>0){
	    $senduser=$duoduo->select('user','ddusername','id="'.$row['senduser'].'"');
	}
    else{
	    $senduser='网站客服';
	}
	if($row['uid']>0){
	    $receiveuser=$duoduo->select('user','ddusername','id="'.$row['uid'].'"');
	}
    else{
	    $receiveuser='网站客服';
	}
?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form2">
<input type="hidden" name="mod" value="<?=MOD?>" />
<input type="hidden" name="act" value="<?=ACT?>" />
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd"  class="msg">
  <tr>
    <td width="100" align="right"><?=$senduser?>：</td>
    <td>&nbsp;<span class="msgmain"><?=$row['content']?></span> <span class="zhushi">（<?=$row['addtime']?>）</span>
    </td>
  </tr>
   <tr>
    <td align="right">回复内容：</td>
    <td>&nbsp;<textarea style="width:300px; height:100px" name="content"></textarea></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="username" value="<?=$senduser?>" /><input type="hidden" name="sid" value="<?=$id?>" /><input type="submit" class="sub" name="sub"  value=" 回 复 " /></td>
  </tr>
  <?php foreach($msg_re as $v){ $v['admin']=$v['admin']?$v['admin']:'网站客服';?>
  <tr>
    <td width="100" align="right"><?=$v['uid']==0?$msg_senduser:$v['admin']?>：</td>
    <td>&nbsp;<span class="msgmain"><?=$v['content']?></span> <span class="zhushi">（<?=$v['addtime']?>）</span>
    </td>
  </tr>
  <?php }?>
 
</table>
</form>
<?php }else{?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">会员：</td>
    <td>&nbsp;<input name="username" type="text" style="width:400px" value="<?=$name?>" /> <span class="zhushi">用“|”隔开会员名可群发。不填写将发送全站会员</span></td>
  </tr>
  <tr>
    <td align="right">内容：</td>
    <td>&nbsp;<textarea style="width:400px; height:200px" name="content"></textarea></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="" /><input type="hidden" name="sid" value="<?=$sid?>" /><input type="submit" class="sub" name="sub" value=" 发 送 " /></td>
  </tr>
</table>
</form>
<?php }?>
<?php include(ADMINTPL.'/footer.tpl.php');?>