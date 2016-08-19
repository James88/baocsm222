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
$status_arr=array(0=>'已审核',1=>'拒绝');//2=>待审核
$type=$duoduo->select_all('type','*',"tag='goods'");
foreach($type as $k=>$vo){
	$cid_arr[$vo['id']]=$vo['title'];
}
include(ADMINTPL.'/header.tpl.php');
?>
<script>
$(function(){
	$('input[name="status"]').click(function(){
		if($(this).val()==1){
			$("#reason").addClass("newClass");
			$('.reason').show();
		}
		else{
			$("#reason").removeClass("required");
			$('.reason').hide();
		}
	});
	if($('input[name="status"]:checked').val()==1){
		$("#reason").addClass("newClass");
		$('.reason').show();
	}
	else{
		$('.reason').hide();
	}
});

</script>

<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">栏目：</td>
    <td>&nbsp;<?=select($cid_arr,$row['cid'],'cid')?></td>
  </tr>
  <tr>
    <td align="right">商品：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>" style="width:300px"/></td>
  </tr>
  <tr>
    <td align="right">晒单会员：</td>
    <td>&nbsp;<?=$duoduo->select('user','ddusername','id='.$row['uid'])?> <!--<span class="zhushi"><a href="<?=u(MOD,'del',array('uid'=>$row['uid']))?>">删除此会员的所有晒单</a></span>--></td>
  </tr>
  <tr>
    <td align="right">上传图片：</td>
    <td>&nbsp;<input name="userimg" type="text" id="userimg" value="<?=$row['userimg']?>" style="width:300px" /> <input class="sub" type="button" value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'userimg','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">可直接添加网络地址</span>&nbsp;<span class="showpic" pic="<?=tb_img($row["userimg"],200)?>">查看</span></td>
  </tr>
  <tr>
    <td align="right">商品图片：</td>
    <td>&nbsp;<input name="img" type="text" id="img" value="<?=$row['img']?>" style="width:300px" /> <input class="sub" type="button" value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'img','sid'=>session_id()))?>','upload','450','350')" />  <span class="zhushi">可直接添加网络地址</span>&nbsp;<span class="showpic" pic="<?=tb_img($row["img"],200)?>">查看</span></td>
  </tr>
  <tr>
    <td align="right">淘宝商品id：</td>
    <td>&nbsp;<input name="tao_id" type="text" id="tao_id" value="<?=$row['tao_id']?>"/></td>
  </tr>
  <tr>
    <td align="right">掌柜：</td>
    <td>&nbsp;<input name="nick" type="text" id="nick" value="<?=$row['nick']?>"/></td>
  </tr>
  <tr>
    <td align="right">价格：</td>
    <td>&nbsp;<input name="price" type="text" id="price" value="<?=$row['price']?>"/></td>
  </tr>
  <!--<tr>
    <td align="right">佣金：</td>
    <td>&nbsp;<input name="commission" type="text" id="commission" value="<?=$row['commission']?>"/></td>
  </tr>-->
  <tr>
    <td align="right">奖励积分：</td>
    <td>&nbsp;<input name="jifen" type="text" id="jifen" value="<?=$row['jifen']?>"/></td>
  </tr>
  <tr>
    <td align="right">标签：</td>
    <td>&nbsp;<input name="keywords" type="text" id="keywords" value="<?=$row['keywords']?>"/> <span class="zhushi">用空格隔开</span></td>
  </tr>
  <tr>
    <td align="right">红心：</td>
    <td>&nbsp;<input name="hart" type="text" id="hart" value="<?=$row['hart']?>"/></td>
  </tr>
  <tr>
    <td align="right">添加时间：</td>
    <td>&nbsp;<input name="addtime" type="text" id="addtime" value="<?=date('Y-m-d H:i:s',$row['addtime'])?>"/></td>
  </tr>
  <?php if($webset['baobei']['user_show']==1){?>
  <tr>
    <td align="right">审核：</td>
    <td>&nbsp;<?=html_radio($status_arr,$row['status'],'status')?></td>
  </tr>
  <?php }?>
  <tr class="reason"><!--仅点失败时出现。-->
    <td align="right">原因：</td>
   <td style="padding:5px 13px;"><textarea name="reason" id="reason" cols="40" rows="3" class="btn3" style="width:400px"><?=$row['reason']?></textarea></td>
  </tr>
  <tr>
    <td align="right">排序：</td>
    <td>&nbsp;<input name="sort" type="text" id="sort" value="<?=$row['sort']?>"/></td>
  </tr>
  <tr>
    <td align="right">内容：</td>
    <td>&nbsp;<textarea id="content" name="content"><?=$row['content']?></textarea></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>