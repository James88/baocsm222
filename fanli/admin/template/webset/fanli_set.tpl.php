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
if($_GET['jiance']==1){
	  $page = !($_GET['page'])?'1':intval($_GET['page']);
	  $pagesize=1000;
	  $frmnum=($page-1)*$pagesize;
	  $a = $duoduo->select_all('user','id,tbnick','(tbnick is null or tbnick ="")  order by id asc limit '.$frmnum.','.$pagesize);
	  if(empty($a)){
		  jump(u(MOD,ACT),'检测完毕');
	  }
	  
	  foreach($a as $k=>$r){
		  if($r['tbnick']!==''){
			 continue;
		  }
		  $trade_id = $duoduo->select('tradelist','trade_id_former','uid='.$r['id']);
		  if($trade_id!=''){
			  $duoduo->trade_uid($r['id'],$trade_id);
			  $field_arr=array('tbnick'=>$trade_id);
			  $duoduo -> update('user', $field_arr, 'id=' . $r['id']);
		  }
	  }
	  
	  $page++;
	  PutInfo('检测修复中。。。<br/><br/><img src="../images/wait2.gif" />',u(MOD,ACT,array('jiance'=>1,'page'=>$page)));
}
include(ADMINTPL.'/header.tpl.php');

if(!defined('TAOTYPE')){
	define(TAOTYPE,1);
}
if(!defined('TAODATATPL')){
	define('TAODATATPL',1);
}

?>
<style>
<?php if(TAOTYPE==1){?>
.taoi-api-mod{ display:none}
<?php }else{?>
#auto_fanli{ display:none}
<?php }?>
</style>
<script>
$(function(){
	if(parseInt($('input[name="FANLI"]:checked').val())==1){
		$('#gt').show();
	}else{
		 $('#gt').hide();
	}
	
	 $('input[name="FANLI"]').click(function(){
        if($(this).val()==1){
		   $('#gt').show();
		}
		else if($(this).val()==0){
		   $('#gt').hide();
		}
	});
	 
	$('input[name="taoapi[freeze]"]').click(function(){
		if(parseInt($(this).val())==2){
			$('#djxz').show();
			$('#djsj').show();
		}
		else{
			$('#djxz').hide();
			$('#djsj').hide();
		}
	});

	if(parseInt($('input[name="taoapi[freeze]"]:checked').val())==2){
		$('#djxz').show();
		$('#djsj').show();
	}
	
	if(parseInt($('input[name="JIFENBAO"]:checked').val())==2){
		$('#jfbzdy').show();
	}
	
	$('input[name="JIFENBAO"]').click(function(){
		if(parseInt($(this).val())==2){
			$('#jfbzdy').show();
		}
		else{
			$('#jfbzdy').hide();
			$('#tb_money_name').val('集分宝');
			$('#tb_money_unit').val('个');
			$('#tb_money_bili').val('100');
			$('input[name="TBMONEYTYPE"]:eq(0)').attr("checked",'checked');
		}
	});
	
	if(parseInt($('input[name="taoapi[m2j]"]:checked').val())==1){
		$('.taoapim2j_close').show();
	}
	
	$('input[name="taoapi[m2j]"]').click(function(){
		if(parseInt($(this).val())==1){
			$('.taoapim2j_close').show();
		}
		else{
			$('.taoapim2j_close').hide();
		}
	});
	
	$('input[name="taoapi[auto_fanli]"]').click(function(){
		if(parseInt($(this).val())==1){
			$('.tb_auto_fanli').show();
		}
		else{
			$('.tb_auto_fanli').hide();
		}
	});
	
	if(parseInt($('input[name="TAOTYPE"]:checked').val())==2){
		$('#key').show();
		$('#secret').show();
	}
	
	$('#xiadan_shijiancha').click(function(){
		var a=$(this).attr('checked');
		if(a!='checked'){
			$('#xiadan_shijiancha_val').attr('disabled',true).val(0);
		}
		else{
			$('#xiadan_shijiancha_val').attr('disabled',false).select();
		}
	});

	var a=$('#xiadan_shijiancha').attr('checked');
	if(a=='checked'){
		$('#xiadan_shijiancha_val').attr('disabled',false);
	}
	
	$('#title_per').click(function(){
		var a=$(this).attr('checked');
		if(a!='checked'){
			$('#title_per_val').attr('disabled',true).val(0);
		}
		else{
			$('#title_per_val').attr('disabled',false).select();
		}
	});

	var a=$('#title_per').attr('checked');
	if(a=='checked'){
		$('#title_per_val').attr('disabled',false);
	}
})

</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115" align="right">返利模式：</td>
    <td>&nbsp;<?=html_radio(array(1=>'开启',0=>'关闭'),FANLI,'FANLI')?> <span class="zhushi">关闭后，导购模式运营网站。文章教程及SEO请及时修改。</span></td>
  </tr>
  <tbody id="gt">
  <tr>
    <td align="right">淘宝返利形式：</td>
    <td>&nbsp;<?=html_radio(array(1=>'集分宝',2=>'自定义'),JIFENBAO,'JIFENBAO')?>&nbsp; <span class="zhushi">包括淘宝/天猫，推荐集分宝，可自动发放。注：不允许返“现金”。,<a href="http://<?=URL?>/index.php?mod=tao&act=jifenbao" target="_blank">什么是集分宝？</a></span></td>
  </tr>
  <tr id="jfbzdy" style="display:none">
    <td align="right">淘宝返利自定义：</td>
    <td>&nbsp;名称：<input type="text" id="tb_money_name" name="TBMONEY" value="<?=TBMONEY?>" style="width:50px;" />&nbsp;单位：<input type="text" id="tb_money_unit" name="TBMONEYUNIT" value="<?=TBMONEYUNIT?>" style="width:30px;" />&nbsp;比例：<input style="width:30px" type="text" id="tb_money_bili" name="TBMONEYBL" value="<?=TBMONEYBL?>" /> <?=TBMONEY?>与人民币的比例为<?=TBMONEYBL?>:1 &nbsp; 数据格式：<?=html_radio(array(1=>'整数',2=>'小数（两位有效数字）'),TBMONEYTYPE,'TBMONEYTYPE')?>	    </td>
  </tr>
  <tr>
    <td align="right">金额转<?=TBMONEY?>：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$webset['taoapi']['m2j'],'taoapi[m2j]')?>&nbsp; <span class="taoapi[m2j]_close" style="display:none">手续费：<input class="required" num='y' style="width:50px;" type="text" name="JFB_FEE" value="<?=JFB_FEE?>" /> <span class="zhushi">例子：0.07，不需要会员支付手续费写0，不能为空！</span></span></td>
  </tr>
  <tr class="taoapim2j_close" style="display:none">
    <td align="right">转换手续费：</td>
    <td>&nbsp;<input class="required" num='y' style="width:50px;" type="text" name="JFB_FEE" value="<?=JFB_FEE?>" /> <span class="zhushi">例子：0.07，不需要会员支付手续费写0，不能为空！</span></td>
  </tr>
  <tr>
    <td align="right">淘宝找回订单审核：</td>
    <td>&nbsp;<?=html_radio(array(0=>'自动',1=>'人工'),$webset['taoapi']['trade_check'],'taoapi[trade_check]')?> <span class="zhushi">为了安全建议开启 人工</span></td>
  </tr>
  <tr id="auto_fanli">
    <td align="right">淘宝自动跟单条件：</td>
    <td>&nbsp;<label>浏览记录<input name="taoapi[auto_fanli]" type="checkbox" value="1" <?php if($webset['taoapi']['auto_fanli']==1){?> checked="checked"<?php }?>/></label>
    <label title="浏览记录中商品名或者商品iid的匹配度">精确匹配<input id="title_per" type="checkbox" name="taoapi[auto_fanli_plan][equal]" value="1"<?php if($webset['taoapi']['auto_fanli_plan']['equal']==1){?> checked="checked"<?php }?> /></label> <input id="title_per_val" type="text" name="taoapi[auto_fanli_plan][per]" value="<?=(float)$webset['taoapi']['auto_fanli_plan']['per']?>"<?php if($taoapi['auto_fanli_plan']['per']==0){?> disabled="disabled"<?php }?>  style="width:30px"/>百分比
    <label title="浏览记录的时间和淘宝下单的时间差">下单时间差<input id="xiadan_shijiancha" type="checkbox" <?php if($webset['taoapi']['auto_fanli_plan']['time']>0){?> checked="checked"<?php }?> /></label> <input id="xiadan_shijiancha_val" type="text" name="taoapi[auto_fanli_plan][time]" value="<?=(int)$webset['taoapi']['auto_fanli_plan']['time']?>"<?php if($taoapi['auto_fanli_plan']['time']==0){?> disabled="disabled"<?php }?>  style="width:30px"/>小时（必须是整数）
    <label>订单后四位<input name="taoapi[auto_fanli_plan][trade_uid]" type="checkbox" value="1" <?php if($webset['taoapi']['auto_fanli_plan']['trade_uid']==1){?> checked="checked"<?php }?>/></label>   <span class="zhushi"><a href="http://bbs.duoduo123.com/read-1-1-198038.html" target="_blank">详细说明</a></span>
    </td>
  </tr>
  <tr>
    <td align="right">淘宝冻结返利：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',/*1=>'按结算日解冻(当月返利会处在待结算状态)',*/2=>'开启'),$webset['taoapi']['freeze'],'taoapi[freeze]')?>&nbsp;</td>
  </tr>
  <tr id="djsj" style="display:none">
    <td align="right">冻结返利开始时间：</td>
    <td>&nbsp;<input type="text" name="taoapi[freeze_sday]" id="sdatetime" value="<?=$webset['taoapi']['freeze_sday']?$webset['taoapi']['freeze_sday']:date('Y-m-d H:i:s',TIME)?>" /> <span class="zhushi">冻结<?=TAO_FREEZE_DAY?>天设置的开始时间，要大于站内所有会员的提现时间</span></td>
  </tr>
  <tr id="djxz" style="display:none">
    <td align="right">冻结返利限制：</td>
    <td>&nbsp;<?php for($i=0;$i<4;$i++){?><?=$webset['level'][$i]['title']?>:<input style="width:50px" name="taoapi[freeze_limit_user][<?=$i?>]" value="<?=$webset['taoapi']['freeze_limit_user'][$i]?>" /><?php }?> <span class="zhushi"><?=TBMONEY?>大于等于此数值会冻结返利</span></td>
  </tr> 
  <?php if(TAOTYPE==1){?>
  <tr>
    <td align="right">淘宝补贴：</td>
    <td>&nbsp;<?=html_radio(array(0=>'不补贴会员',1=>'补贴会员'),$webset['taoapi']['butie'],'taoapi[butie]')?>&nbsp; <span class="zhushi">许多订单会给站长佣金外的额外补贴，此项设置这部分补贴是否分配给会员</span>
  </tr>
  <?php }?>
    <tr>
      <td align="right">淘宝返现比率：</td>
    <td>&nbsp;
    <?php foreach($webset['fxbl'] as $k=>$v){?>
    <?=$webset['level'][$k]['title']?>：<input name="fxbl[]" type="text" id="fxbl" value="<?php echo $v*100;?>" size="10"  class="required" num="y" style="width:50px" />&nbsp;%&nbsp;&nbsp;
    <?php }?> <span class="zhushi"><a href="<?=u('user','set')?>">修改等级名称</a></span>
    </td>
    </tr>
    <tr>
      <td align="right">商城返现比率：</td>
    <td>&nbsp;
    <?php foreach($webset['mallfxbl'] as $k=>$v){?>
    <?=$webset['level'][$k]['title']?$webset['level'][$k]['title']:'普通会员'?>：<input name="mallfxbl[]" type="text" id="mallfxbl" value="<?php echo $v*100;?>" size="10"  class="required" num="y" style="width:50px" />&nbsp;%&nbsp;&nbsp;
    <?php }?>
    </td>
    </tr>
    <tr>
      <td align="right">拍拍返现比率：</td>
    <td>&nbsp;
    <?php foreach($webset['paipaifxbl'] as $k=>$v){?>
    <?=$webset['level'][$k]['title']?$webset['level'][$k]['title']:'普通会员'?>：<input name="paipaifxbl[]" type="text" id="paipaifxbl" value="<?php echo $v*100;?>" size="10"  class="required" num="y" style="width:50px" />&nbsp;%&nbsp;&nbsp;
    <?php }?>
    </td>
    </tr>
    <tr>
      <td align="right">返积分比例：</td>
      <td>&nbsp;<input name="jifenbl" type="text" id="jifenbl" value="<?php echo $webset['jifenbl']*100;?>"  class="required" num="y" style="width:50px" />% <span class="zhushi">返利同时赠送一定比例的积分，按照实际给会员的返利计算，取整。例如比例为1000%，返利0.1元，积分就是1</span></td>
    </tr>
    </tbody>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /> <span class="zhushi"><a href="http://bbs.duoduo123.com/read-1-1-198038.html" target="_blank">设置说明</a></span></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>