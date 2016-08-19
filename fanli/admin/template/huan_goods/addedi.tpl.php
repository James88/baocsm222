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
<script>
$(function(){
<?=radio_guanlian('auto')?>
})
</script>
<style>
#array{ width:500px}
</style>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">标题：</td>
    <td>&nbsp;<input name="title" type="text" class="required" id="title" value="<?=$row['title']?$row['title']:$relate_row['title']?>" style="width:300px" /> <span class="zhushi"><a href="http://bbs.duoduo123.com/read-1-1-198006.html" target="_blank">添加教程</a></span></td>
  </tr>
  <tr>
    <td align="right">类别：</td>
    <td>&nbsp;<select name="cid"><?php getCategorySelect($row['cid']?$row['cid']:$_GET['cid']);?></select> <span class="zhushi"><a href="index.php?mod=huan_goods_type&act=list">添加</a></span></td>
  </tr>
  <tr>
    <td align="right">图片：</td>
    <td>&nbsp;<input name="img" type="text" id="img" value="<?=$row['img']?$row['img']:$relate_row['img']?>" style="width:300px" /> <input class="sub" type="button" value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'img','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">可直接添加网络地址</span></td>
  </tr>
  <tr>
    <td align="right"><?=TBMONEY?>：</td>
    <td>&nbsp;<input name="jifenbao" type="text" id="jifenbao" value="<?=$row['jifenbao']?>" /> <span class="zhushi">设为0此项不参与兑换</span></td>
  </tr>
  <tr>
    <td align="right">积分：</td>
    <td>&nbsp;<input name="jifen" type="text" id="jifen" value="<?=$row['jifen']?>" /> <span class="zhushi">设为0此项不参与兑换</span></td>
  </tr>
  <tr>
    <td align="right">数量：</td>
    <td>&nbsp;<input name="num" type="text" id="num" value="<?=$row['num']?>" /></td>
  </tr>
  <tr>
    <td align="right">开始时间：</td>
    <td>&nbsp;<input class="timeinput" name="sdate" type="text" id="sdate" value="<?=$row['sdate']?$row['sdate']:$relate_row['sdate']?>" /></td>
  </tr>
  <tr>
    <td align="right">结束时间：</td>
    <td>&nbsp;<input class="timeinput" name="edate" type="text" id="edate" value="<?=$row['edate']?$row['edate']:$relate_row['edate']?>" /></td>
  </tr>
  <tr>
    <td align="right">显示/隐藏：</td>
    <td>&nbsp;<?=html_radio($status,$row['hide'],'hide')?></td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?$row['sort']:0?>"  /> <span class="zhushi">数字越小越靠前，1为最小值</span></td>
  </tr>
  <tr>
    <td align="right">自动发货：</td>
    <td>&nbsp;<?=html_radio(array(0=>'否',1=>'是'),$row['auto'],'auto')?> <span class="zhushi">适用于领取代码模式，会员兑换后自动发送站内信</span></td>
  </tr>
  <tr class="auto_guanlian">
    <td align="right">领取代码：</td>
    <td><table border="0">
  <tr>
    <td><textarea style="width:400px; height:150px" name="array"><?=$row['array']?></textarea></td>
    <td>&nbsp; <span class="zhushi">填写后会员兑换申请以站内信形式获得代码，多个代码可用空格，回车或者逗号隔开。</span></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td align="right">兑换限制：</td>
    <td>&nbsp;<input name="limit" type="text" id="limit" value="<?=$row['limit']?$row['limit']:0?>"  /> <span class="zhushi">每个会员每天最多兑换此商品的个数，0表示不限制</span></td>
  </tr>
  <tr>
    <td align="right">介绍：</td>
    <td>&nbsp;<textarea id="content" name="content"><?=$row['content']?$row['content']:$relate_row['content']?></textarea></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="hidden" name="relateid" value="<?=$_GET['relateid']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>