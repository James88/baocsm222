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
include(ADMINROOT.'/mod/public/part_set.act.php');
include(ADMINTPL.'/header.tpl.php');
?>
<script>
$(function(){
    $('input[name="user[shoutu]"]').click(function(){
        if($(this).val()==1){
		    $('.shoutu').show();
		}
		else if($(this).val()==0){
		   $('.shoutu').hide();
		}
	});
	
	if(parseInt($('input[name="user[shoutu]"]:checked').val())==1){
		$('.shoutu').show();
	}
})
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" align="center" border=1 cellpadding=0 cellspacing=0
bordercolor="#dddddd">
    <tr>
        <td align="right" width="115">邀请好友机制：</td>
        <td>&nbsp;<?=html_radio($zhuangtai_arr,$webset['user']['shoutu'],'user[shoutu]')?><span class="zhushi">关闭后只是前台不显示对应文字和页面，不影响推广的机制</span></td>
    </tr>
    <tr id="s1" class="shoutu" style="display:none">
        <td align="right" >邀请人佣金比率：</td>
        <td>&nbsp;<input name="tgbl" type="text" id="tgbl" value="<?php echo $webset['tgbl']*100;?>" class="required" num="y" style="width:50px" /> % <span class="zhushi">（填写0-100）如 10% 表示给会员返利的10%，支付给发出邀请会员的部分</span></td>
    </tr>
    <tr id="s2" class="shoutu" style="display:none">
        <td align="right" >邀请人佣金峰值：</td>
        <td>&nbsp;<input name="tgfz" type="text" id="tgfz" value="<?php echo $webset['tgfz'];?>" class="required" num="y" style="width:50px" />元 <span class="zhushi">邀请人获得的好友佣金大于此数值后，邀请人将不再通过该好友获取邀请佣金</span>
        </td>
    </tr>
    <tr id="s3" class="shoutu" style="display:none">
        <td align="right" >一次现金奖励：</td>
        <td>&nbsp;<input name="tixian[hytxjl]" style=" width:50px;" id="hytxjl" value="<?=$webset['tixian']['hytxjl']?$webset['tixian']['hytxjl']:0?>" class="required" num="y" /> 元 <span class="zhushi">好友第一次提现时给邀请人一次性奖励。</span></td>
    </tr>
    <tr class="shoutu" style="display:none">
		<td align="right">邀请地址：</td>
		<td>&nbsp; <input name="tgurl" type="text" id="tgurl" value="<?=$webset['tgurl']?>" class="btn3" style="width:400px" /><span class="zhushi"> 例：http://<?php echo URL;?>/index.php?</span></td>
	</tr>
    <tr >
        <td align="right">&nbsp;</td>
        <td>&nbsp;<input type="submit" class="myself" name="sub" value=" 保 存 设 置 " /></td>
    </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>