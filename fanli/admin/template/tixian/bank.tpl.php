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

if(isset($_POST['sub'])){
	$bank=$_POST['bank'];
	foreach($bank as $k=>$row){
		if($row['name']==''){
			unset($bank[$k]);
		}
	}
	ksort($bank);
	dd_set_cache('bank',$bank);
	jump(-1,'完成');
}
else{
	$top_nav_name=array(array('url'=>u(MOD,'set'),'name'=>'提现设置'),array('url'=>u(MOD,'bank'),'name'=>'银行设置'));
	include(ADMINTPL.'/header.tpl.php');
	$bank=dd_get_cache('bank');
}
?>

<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">

<?php if($webset['tixian']['need_bank']!=1){?>
<div class="explain-col">对不起，您的提现可选字段"银行"未选择。<a href="<?=u('tixian','set')?>">立刻选择提现可选字段“银行”</a>
  </div>
<br />
<?php }else{?>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
<?php foreach($bank as $k=>$row){?>
  <tr>
    <td width="115px" align="right">银行：</td>
    <td>&nbsp;<input type="text" name="bank[<?=$k?>][name]" value="<?=$row['name']?>" /> &nbsp;<button class="bank_del sub">删除</button></td>
  </tr>
<?php }?>
  <tr id="last_tr">
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="submit" id="sub" class="sub" name="sub" value="确 认" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="添加" id="bank_add" /></td>
  </tr>
</table>
</form>
<script>
k=<?=$k?$k:0?>;
$(function(){
	$('#bank_add').click(function(){
		k++;
		$('#last_tr').before('<tr><td width="115px" align="right">银行：</td><td>&nbsp;<input type="text" name="bank['+k+'][name]" value="" /> &nbsp;<button class="bank_del sub">删除</button></td></tr>');
	});	
	$('.bank_del').live('click',function(){
		var tr=$(this).parent('td').parent('tr');
		tr.remove();
	});
})
</script>
<?php }?>
<?php include(ADMINTPL.'/footer.tpl.php');?>