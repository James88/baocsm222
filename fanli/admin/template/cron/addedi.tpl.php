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
include(DDROOT.'/comm/cron.class.php');
if($id==0){
	$row['fangshi']=1;
	$row['status']=1;
}
else{
	$next_time=cron_next_time($row);
	if($r['fangshi']==3){
		$next_time=is_kong();
	}
	if($row['jindu']==0){
		$jindu='完成';
	}
	else{
		$jindu='进行中';
	}
}

$caiji_id='';
$caiji=$duoduo->select_2_field('collect','id,title');
foreach($caiji as $k=>$v){
	$caiji_id=$k;
	break;
}

$sys_cron=array();
$plugin_cron=array();
$cron=glob(DDROOT.'/comm/cron/cron_*');
foreach($cron as $k=>$v){
	$v=str_replace(DDROOT.'/comm/cron/','',$v);
	$sys_cron[$k]=$v;
}

$cron=glob(DDROOT.'/plugin/*');
foreach($cron as $k=>$v){
	if(file_exists($v.'/cron')){
		$plugin_name=str_replace(DDROOT.'/plugin/','',$v);
		$_cron=glob($v.'/cron/cron_*');
		foreach($_cron as $_k=>$_v){
			$_v=str_replace($v.'/cron/','',$_v);
			$plugin_cron[$plugin_name]=$_v;
		}
	}
}

include(ADMINTPL.'/header.tpl.php');
?>
<style>
.plugin_name,.execute_time,.interval_time{ display:none}
.w5{ width:50px}
</style> 
<script>
Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

var sysCron={};
<?php foreach($sys_cron as $k=>$v){?>
sysCron[<?=$k?>]='<?=$v?>';
<?php }?>

var pluginCron={};
<?php foreach($plugin_cron as $k=>$v){?>
pluginCron['<?=$k?>']='<?=$v?>';
<?php }?>
$(function(){
	$('input[name="leixing"]').click(function(){
		leixing_radio();
	});
	leixing_radio($('input[name="leixing"]'));
	
	$('input[name="fangshi"]').click(function(){
		fangshi_radio();
	});
	fangshi_radio($('input[name="fangshi"]'));
	
	$('#xiaoshi').change(function(){
		var s=$('#xiaoshi').val();
		$('#execute_time').val(s);
	});
	
	$('#filename').change(function(){
		if($('input[name="leixing"]:checked').val()==1){
			for(var i in pluginCron){
				if($(this).val()==pluginCron[i]){
					$('#plugin_name').val(i);
				}
			}
		}
	});
	
	$('#caiji').change(function(){
		$('#dev').val($(this).val());
	});
})

function setSysCron(){
	var html='';
	var s='';
	for(var i in sysCron){
		if(sysCron[i]=='<?=$row['filename']?>'){
			s='selected="selected"';		
		}
		else{
			s='';
		}
		html+='<option '+s+' value="'+sysCron[i]+'">'+sysCron[i]+'</option>'
	}
	$('#filename').html(html);
	$('.plugin_name').hide();
}

function setCaijiCron(){
	var html='';
	var s='';
	html+='<option value="cron_caiji.php">cron_caiji.php</option>';
	$('#filename').html(html);
	$('.plugin_name').hide();
}

function setPluginCron(){
	var html='';
	var j=0;
	var s='';
	
	if(Object.size(pluginCron)==0){
		html+='<option '+s+' value="">没有插件计划任务脚本</option>';
		alert('没有插件计划任务脚本！');
	}
	else{
		for(var i in pluginCron){
			if(pluginCron[i]=='<?=$row['filename']?>'){
				s='selected="selected"';		
			}
			else{
				s='';
			}
			html+='<option '+s+' value="'+pluginCron[i]+'">'+i+'/'+pluginCron[i]+'</option>';
			<?php if($id==0){?>
			if(j==0){
				$('#plugin_name').val(i);
			}
			<?php }?>
			j++;
		}
	}
	$('#filename').html(html);
	$('.plugin_name').show();
}
	
function leixing_radio(){
	var a=$('input[name="leixing"]:checked').val();
	
	if(a==2){
		$('.caiji').show();
	}
	else{
		$('.caiji').hide();
	}
	
	if(a==1){
		setPluginCron();
	}
	else if(a==0){
		setSysCron();
	}
	else if(a==1){
		setPluginCron();
	}
	else if(a==2){
		setCaijiCron();
	}
}

function fangshi_radio(){
	$('.execute_time,.interval_time,.random').hide();
	var v=$('input[name="fangshi"]:checked').val();
	<?php if($row['dd']==1){?>
	if(v!=1){
		$('.execute_time').show();
		$("input[name='fangshi'][value=1]").attr("checked",true); 
		alert('官方采集执行方式不可修改');
		return false;
	}
	<?php }?>
	if(v==1){
		$('.execute_time').show();
	}
	else if(v==2){
		$('.interval_time').show();
	}
	else if(v==3){
		$('.random').show();
	}
}
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>&code=<?=$code?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">状态：</td>
    <td>&nbsp;<?=html_radio($zhuangtai_arr,$row['status'],'status')?></td>
  </tr>
  <tr>
    <td align="right">名称：</td>
    <td>&nbsp;<input type="text" id="title" name="title" class="required" value="<?=$row['title']?>" /></td>
  </tr>
  <tr>
    <td align="right">类型：</td>
    <td>&nbsp;<?=html_radio($leixing_arr,$row['leixing'],'leixing')?> <label class="plugin_name">插件标识码：<input value="<?=$row['plugin_name']?>" style="width:70px" type="text" id="plugin_name" name="plugin_name"/></label></td>
  </tr>
  <tr>
    <td align="right">脚本：</td>
    <td>&nbsp;<select name="filename" id="filename" class="filename"></select> <span class="zhushi">设置本任务的执行程序文件名，系统计划任务位于comm/cron/，插件计划任务位于plugin/插件目录/cron/</span></td>
  </tr>
  <tr style="display:none" class="caiji">
    <td align="right">采集板块：</td>
    <td>&nbsp;<?=str_replace('name="bankuai"','',select($caiji,$row['dev'],'dev','',1))?></td>
  </tr>
  <tr>
    <td align="right">执行方式：</td>
    <td>&nbsp;<?=html_radio($fangshi_arr,$row['fangshi'],'fangshi')?> <label class="execute_time">每天的<?php if($row['dd']==0){?><select name="execute_time" id="xiaoshi"><?php for($i=0;$i<24;$i++){?><option <?php if($i==$row['execute_time']){?> selected="selected"<?php }?> value="<?=$i?>"><?=$i?>时</option><?php }?></select><?php }else{?> <?=get_cron_time($row['dev'])?> <span class="zhushi">官方采集时间随机不可修改，如需当天数据，请进板块列表人工采集。</span><?php }?></label> <!--<span class="execute_time">分钟</span><select id="fenzhong" class="execute_time"><?php for($i=0;$i<60;$i++){?><option value="<?=$i?>"><?=$i?>分</option><?php }?></select>-->  <label class="interval_time"><input type="text" class="w5" value="<?=$row['interval_time']?>" id="interval_time" name="interval_time"><span class="zhushi">单位分钟，如果需要间歇1小时，填写60，表示每隔多长时间执行一次任务</span></label> <label class="random"><input type="text" id="random" value="<?=$row['random']?>" name="random" class="w5"><span class="zhushi">基值是1000,1是千分之一的概率，以此类推</span></label></td>
  </tr>
  <!--<tr>
    <td align="right">开发参数：</td>
    <td>&nbsp;<input type="text" id="dev" name="dev" value="<?=$row['dev']?>" /> <span></span></td>
  </tr>-->
  <?php if($row['id']>0){?>
  <tr>
    <td align="right">上次执行时间：</td>
    <td>&nbsp;<?=is_kong($row['last_time'])?></td>
  </tr>
  <tr>
    <td align="right">下次执行时间：</td>
    <td>&nbsp;<?=$next_time?></td>
  </tr>
  <tr>
    <td align="right">任务进度：</td>
    <td>&nbsp;<?=$jindu?></td>
  </tr>
    <tr>
    <td align="right">反馈描述：</td>
    <td>&nbsp;<?=is_kong($row['msg'])?></td>
  </tr>
  <?php }?>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>