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
include(ADMINTPL.'/tixian/ddshouquan.tpl.php');
$return_arr=include(DDROOT.'/data/tixian_return.php');
?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">会员：</td>
    <td>&nbsp;<?=$duoduo->select('user','ddusername','id="'.$row['uid'].'"')?></td>
  </tr>
  <tr>
    <td align="right">提现<?=$type_arr[$row['type']]?>：</td>
    <td>&nbsp;<?=(float)($row['money2']==0?$row['money']:$row['money2'])?></td>
  </tr>
  <tr>
    <td align="right"><?=$tool_arr[$row['tool']]?>：</td>
    <td>&nbsp;<?=$row['code']?></td>
  </tr>
  <tr>
    <td align="right">真实姓名：</td>
    <td>&nbsp;<?=$row['realname']?></td>
  </tr>
  <tr>
    <td align="right">提现时间：</td>
    <td>&nbsp;<?=date('Y-m-d H:i:s',$row['addtime'])?></td>
  </tr>
  <tr>
    <td align="right">提现IP：</td>
    <td>&nbsp;<?=$row['ip']?></td>
  </tr>
  <tr>
    <td align="right">手机：</td>
    <td>&nbsp;<?=$row['mobile']?></td>
  </tr>
  <tr>
    <td align="right">备注：</td>
    <td>&nbsp;<?=$row['remark']?></td>
  </tr>
  <?php if($row['api_return']!=''){?>
  <tr>
    <td align="right">集分宝代发反馈：</td>
    <td>&nbsp;<?=$row['api_return']?><?=is_numeric($row['api_return'])?'（流水号）':''?> &nbsp;&nbsp;&nbsp;<span class="zhushi"><?php if($row['wait']==1){?><a style=" text-decoration:underline" href="<?=u(MOD,ACT,array('do'=>'cancel','id'=>$id))?>">撤销平台集分宝发放</a><?php }?>&nbsp;&nbsp;&nbsp;<?php if(DLADMIN!=1){?><a href="http://bbs.duoduo123.com/read-htm-tid-145592.html" target="_blank">查看错误介绍</a><?php }?></span></td>
  </tr>
  <?php }?>
  <?php if($do=='no'){?>
  <tr>
    <td align="right">退回原因：</td>
    <td>&nbsp;<input type="text" name="why" id="why" style="width:400px" value="<?=$row['why']?$row['why']:$return_arr[0]?>" /></td>
  </tr>
  <tr>
    <td align="right">选择原因：</td>
    <td>&nbsp;<?=select($return_arr,0,'return_why')?></td>
  </tr>
  <?php }?>
  <tr>
    <td align="right">状态：</td>
    <td>&nbsp;<?=$status_arr[$row['status']]?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if($need_correct==1){?><span class="zhushi"><a href="<?=u(MOD,ACT,array('id'=>$id,'do'=>'correct'))?>">自动纠错</a></span> <span class="zhushi" id="jiucuosm" style="cursor:pointer">功能说明</span><?php }?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input <?php if($row['wait']==1 && $do=='no' && $row['api_return']!='支付宝黑名单'){?> disabled="disabled" title="平台提现审核，如需退回，请先撤销" <?php }?> type="submit" id="sub" class="sub" name="sub" value=" <?php if($do=='yes'){?>确 认 提 现<?php }else{?>退 回 提 现<?php }?> " />
    <span class="zhushi">自动发送状态：<?=$jfb_tip?></span>
    </td>
  </tr>
</table>
<input type="hidden" name="do" value="<?=$do?>" />
</form>
<script>
var returnWhy=new Array();
<?php foreach($return_arr as $k=>$v){?>
returnWhy[<?=$k?>]='<?=$v?>';
<?php }?>

$('#return_why').change(function(){
	$('#why').val(returnWhy[$(this).val()]);
});

<?php if($row['type']==1 && $webset['tixian']['ddpay']==1 && $do=='yes'){?>
var needJfb=<?=$row['money2']?>;
var haveJfb=<?=$open_jifenbao?>;
$(function(){
	if(needJfb>haveJfb){
		$('#sub').attr('disabled','disabled');
		$('#sub').attr('title','集分宝余额不足');
	}
})
<?php }?>

$(function(){
	$('#jiucuosm').jumpBox({  
		height:160,
		width:500,
		contain:'由于集分宝提现在数据传送中可能会发生丢失，所以会出现这条提现实际已经处理（会员的提现状态是未提现，并且有这条提现明细），但是提现状态没有变化的情况，此时点击自动纠错即可'
    });
})
</script>
<?php
if($row['status']!=0){echo script('$("#sub").attr("disabled","true");');}
?>
<?php include(ADMINTPL.'/footer.tpl.php');?>