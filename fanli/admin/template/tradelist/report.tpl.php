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
<style>
<?php if($cookie_ok==0){?>
.login_guanlian{ display:none}
<?php }else{?>
.login_do{ display:none}
<?php }?>
</style>
<script>
window.alert = function(text,cb) {
	_alert(text,cb);
}

function reyzm(){
	$('#TPL_checkcode').attr('src','<?=$yzm_url?>&suiji='+Math.floor(Math.random()*10));
}

function login(){
	var v='';
	if($("#yzm").length>0){
		v=$("#yzm").val();
		if(v==''){
			alert('验证码不能为空');
			return false;
		}
	}
	
	$('#monidenglu').attr('disabled',true);
	$.getJSON('<?=u(MOD,ACT)?>&do=login&yzm='+v,function(data){
		$('#monidenglu').attr('disabled',false);
		if(data.s==0){
			alert(data.r);
			reyzm();
		}
		else if(data.s==2){
			$('#target').val(data.r.target);
			$('#param').val(data.r.param);
			$('.mobile_yzm').show();
		}
		else{
			alert('登录成功，可以在线获取订单');
			$('.login_guanlian').show();
			reyzm();
		}
	});
}

function mobileYz(){
	var v='';
	if($("#mobile_yzm").length>0){
		v=$("#mobile_yzm").val();
		if(v==''){
			alert('短信验证码不能为空');
			return false;
		}
	}
	
	var target=$('#target').val();
	var param=$('#param').val();
	var url='<?=u(MOD,ACT)?>';
	var data={'mobile_yzm':v,'target':target,'param':param};
	$('#shoujitijiao').attr('disabled',true);
	
	$.ajax( {    
		url:url,// 跳转到 action    
		data:{'mobile_yzm':v,'target':target,'param':param},    
		type:'post',    
		cache:false,    
		dataType:'json',    
		success:function(data) {    
			$('#shoujitijiao').attr('disabled',false);
			if(data.s==0){
				alert(data.r);
			}
			else{
				alert('验证成功，请点击模拟登录');
				$('.mobile_yzm').hide();
				reyzm();
				$('#yzm').val('');
			}   
		 },    
		 error : function() {      
			  alert("异常！");    
		 }    
	}); 
	/*$.getJSON(url,function(data){
		$('#shoujitijiao').attr('disabled',false);
		if(data.s==0){
			alert(data.r);
		}
		else{
			alert('验证成功，请点击模拟登录');
			$('.mobile_yzm').hide();
			reyzm();
			$('#yzm').val('');
		}
	});*/
}

$(function(){
	$("#test").click(function(){
		if($("#yzm").length>0){
			var v=$("#yzm").val();
			if(v==''){
				alert('验证码不能为空');
			}
			else{
				location.href="<?=u(MOD,ACT)?>&test=1&yzm="+v;
			}
		}
		else{
			location.href="<?=u(MOD,ACT)?>&test=1";
		}
	});
})
</script>
<div class="explain-col">
提示：请选择获取交易的时间段。时间只能选择最近3个月内。已经获取过的交易不会覆盖原有的数据，获取过程将自动忽略。<br />
时间必须精确到<?=TAOTYPE==1?'天':'秒'?>，并且开始时间小于结束时间，否则将无法获取成功！
</div>

<?php if(!is_dir(DDROOT.'/comm/cron')){
	  $alimama_plugin_id=(int)$duoduo->select('plugin','id','code="alimama"');
	  if($alimama_plugin_id>0){?>
      &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=u('plugin','alimama')?>">旧版淘宝联盟插件</a>
<?php }}?>

<?php if(TAOTYPE==2){?>
<form method="get" action="../index.php" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">获取方式：</td>
    <td>&nbsp;淘宝API接口 <?php if($last_time){?><span class="zhushi">上次执行时间：<?=$last_time?></span><?php } ?> </td>
  </tr>
  <tr>
    <td width="115px" align="right">时间范围：</td>

    <td>&nbsp;<input name="sdatetime" type="text" id="sdatetime" value="<?=date('Y-m-d')." 00:00:00"?> " /> 到 <input name="edatetime" type="text" id="edatetime" value="<?=date('Y-m-d H:i:s')?>" /></td>
  </tr>
  <tr>
    <td width="115px" align="right">操作：</td>

    <td>&nbsp;<input type="submit" class="sub" name="daoru" value="获取交易记录" /> </td>
  </tr>
  <!--<tr>
    <td align="right"></td>
    <td>&nbsp;<span class="bigtext"><a href="<?=u('tradelist','import')?>" style="text-decoration:underline"><img src="images/ico-darrow.png" width="10" height="11" border="0" /> 如果您无法成功获取数据，点击这里试试手动导入数据！</a></span></td>
  </tr>-->
</table>
<input type="hidden" name="mod" value="cron" />
<input type="hidden" name="act" value="run" />
<input type="hidden" name="jiaoben" value="cron_tradelist" />
<input type="hidden" name="admin" value="<?=authcode(1,'ENCODE')?>" />
</form>
<?php }else{?>

<?php if($curl_ok==0){?>
<br/>
<div class="explain-col">服务器curl模块不可用，联系空间商开启</div>
<?php }?>

<form method="get" action="../index.php">
  <table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
      <tr>
      <td width="115px" align="right">使用教程：</td>
      <td><span class="zhushi">&nbsp;<a href="http://bbs.duoduo123.com/read-1-1-198008.html" target="_blank">教程传送门</a></span></td>
     </tr>
     <tr>
      <td width="115px" align="right">订单导入：</td>
      <td>&nbsp;请人工导入订单。<a href="<?=u(MOD,'import')?>" class="link3">[人工导入]</a> <span class="zhushi">或者可以通过下面在线登陆获取订单，建议使用人工导入</span></td>
    </tr>
    <?php if($webset['taoapi']['tbname']=='' || $webset['taoapi']['tbpwd']==''){?>
	<tr>
		<td align="right">提示：</td>
		<td>&nbsp;对不起，您还没有设置阿里妈妈联盟账号或者密码！ <a href="<?=u('tradelist','tbname',array('from_url'=>u(MOD,ACT)))?>" style="color:red">[设置]</a> </td>
	</tr>
    <?php }else{?>
    <tr>
		<td align="right">联盟账号：</td>
		<td>&nbsp;<?=$webset['taoapi']['tbname']?> <a href="<?=u('tradelist','tbname',array('from_url'=>u(MOD,ACT)))?>" style="color:red">[更改]</a> </td>
	</tr>
    <tr>
    <td align="right">获取方式：</td>
    <td>&nbsp;阿里妈妈在线登录获取 <span class="zhushi login_guanlian"><a href="javascript:void(0)" id="test">点击测试</a>（注意，测试代码默认抓取今天的订单）</span> <b style="color:red">（如果在线登录提示滑块登录，是淘宝帐号被限制目前无法解决请使用人工手动导入）</b></td>
    </tr>
    <?php if($yzm_url){?>
    <tr style="height:35px;">
      <td align="right">请输入验证码：</td>
      <td>
		<table border="0">
		  <tr>
			<td>&nbsp;<input type="text" name="yzm" id="yzm" style="width:80px;" class="required" value="" /></td>
			<td><img id="TPL_checkcode" src='<?=$yzm_url?>' onclick="reyzm()"  /></td>
			<td><span style="cursor:pointer; margin-right:10px;" onclick="reyzm()">看不清</span></td>
		  </tr>
		</table>
       </td>
    </tr>
    <?php }?>
    <tr class="mobile_yzm" style="display:none">
      <td align="right">短信验证码：</td>
      <td>&nbsp;<input type="text" id="mobile_yzm" name="mobile_yzm" /><input type="hidden" id="param" /><input type="hidden" id="target" /> <input id="shoujitijiao" type="button" onclick="mobileYz()" value="提交" /></td>
    </tr>
    
    <tr class="login_do">
      <td align="right">&nbsp;</td>
      <td>&nbsp;<input class="sub" id="monidenglu" type="button" onclick="login()" value="在线登录" /></td>
    </tr>
    
    <tbody class="login_guanlian">
    <tr>
      <td align="right">时间范围：</td>
      <td>&nbsp;<input name="sday" type="text" id="sdate" size="10" value="<?=date('Y-m-d')?>" /> 到 <input name="eday" type="text" id="edate" size="10" value="<?=date('Y-m-d')?>" /></td>
    </tr>
    <tr>
      <td align="right">订单时间：</td>
	  <td>&nbsp;<label><input checked="checked" name="paystatus" type="radio" value="0"> 创建时间</label>&nbsp;&nbsp;<label><input name="paystatus" type="radio" value="3"> 结算时间</label>&nbsp;&nbsp;</td>
    </tr>
    <tr>
      <td align="right">处理条数：</td>
      <td>&nbsp;<input name="pagesize" type="text" value="300" style="width:60px"/> <span class="zhushi">导入数据后，每次处理订单的数量，站长可根据自己的服务器性能调节</span></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;<input type="submit" class="sub" name="daoru" value="获取交易记录" /> </td>
    </tr>
    <?php }?>
    </tbody>
  </table>
<input type="hidden" name="mod" value="cron" />
<input type="hidden" name="act" value="run" />
<input type="hidden" name="jiaoben" value="cron_tradelist" />
<input type="hidden" name="admin" value="<?=authcode(1,'ENCODE')?>" />
<input type="hidden" name="admindir" value="<?=ADMINDIR?>" />
</form>
<?php }?>
<?php include(ADMINTPL.'/footer.tpl.php');?>