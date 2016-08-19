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

$admin_name=str_replace(DDROOT,'',ADMINROOT);
$admin_name=str_replace('/','',$admin_name);
//获取验证码
$alimama_class=fs('alimama');
$yzm=$alimama_class->getyzm($webset['alimama']['username'],$webset['alimama']['password']);
if(preg_match('/blank\.gif$/',$yzm)){$yzm='';}

$top_nav_name=array(array('url'=>u('tradelist','set'),'name'=>'淘宝设置'),array('url'=>u('plugin','alimama'),'name'=>'淘宝联盟设置'));
include(ADMINTPL.'/header.tpl.php');
?>
<script>
function buy($t){
	var username=$('#username').val();
	if(username==''){
		alert('淘宝帐号必填');
		return false;
	}
	else{
		jumpboxOpen('付款完成后，<a style=" font-size:16px" href="javascript:location.replace(location.href);">点击刷新页面</a>',100,300);
		$('#ddjumpboxdom .close').click(function(){
			jumpboxClose();
		});
	}
}
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">

    <div class="explain-col">
    <?php if(TAOTYPE==1){?>
    本功能针对无返利类api的站点可直接获取阿淘宝联盟订单
    <?php }else{?>
    本功能针对有返利类api的站点在完成购买后，需要去<a href="<?=u('plugin','list',array('get'=>1))?>">百宝箱</a>获取订单，并完成安装管理。
    <?php }?>
    &nbsp;<!--<a href="http://bbs.duoduo123.com/read-htm-tid-161697.html" target="_blank">功能详细说明</a>-->
    </div>
    <br/>

  <?php if($yun_alimama['buy']==0){?>
    <div class="explain-col">
    <?php if($curl_ok==1){?>
        <?php if($alimama_data['username']==''){?>
        请先保存淘宝帐号！
        <?php }else{?>
        你还没有购买阿里妈妈订单在线获取功能，<a onclick="return buy($(this))" href="<?=DD_YUN_URL?>/index.php?m=bbx&a=view&id=109&domain=<?=urlencode(DOMAIN)?>&url=<?=urlencode(SITEURL.'/'.$admin_name)?>&banben=<?=BANBEN?>&alimama=<?=urlencode($alimama_data['username'])?>" target="_blank">点击进行支付</a>
        <?php }?>
    <?php }else{?>
    您的服务器不支持curl，不能使用本功能，请联系空间商开启。
    <?php }?>
    </div>
    <br/>
  <? }else{?>
  	<div class="explain-col">
    <?php if($alimama_data['password']!=''){?>
    您已经可以使用在线抓取阿里妈妈订单的功能，<a href="javascript:void(0)" id="test">点击测试</a>（注意，测试代码默认抓取你今天的订单,<b style="color:#F00">验证码请在下面的验证码输入框里输入</b>）
    <?php }else{?>
    请设置淘宝联盟密码，完成保存。
    <?php }?>
    </div>
    <br/>
  <?php }?>

  <table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
    <tr>
      <td width="115" align="right">淘宝联盟账号：</td>
      <td>&nbsp;<input type="text" name="username" id="username" value="<?=$alimama_data['username']?>" />  <?php if($yun_alimama['buy']==1){?>&nbsp;应用授权时间【<?=date('Y-m-d H:i:s',$alimama_shouquan['r']['addtime'])?> 到 <?=date('Y-m-d H:i:s',$alimama_shouquan['r']['endtime'])?>】（表示应用插件的有效时间）<?php }?></td>
    </tr>
    <?php if($yun_alimama['buy']==1){?>
    <tr>
      <td align="right">淘宝联盟密码：</td>
      <td>&nbsp;<?=limit_input("password",$alimama_data['password'])?> 点击激活可修改</td>
    </tr>
    <?php if($yzm){?>
    <tr style="height:35px;">
      <td align="right">请输入验证码：</td>
      <td>
      <table border="0">
  <tr>
    <td><input type="text" name="yzm" id="yzm" style="width:60px;" value="" /></td>
    <td><img id="TPL_checkcode" src='<?=$yzm?>'  /></td>
    <td><span style="cursor:pointer; margin-right:10px;" onclick="document.getElementById('TPL_checkcode').src='<?=$yzm?>'">看不清</span></td>
  </tr>
</table>
       </td>
    </tr>
    <?php }?>
    <tr>
      <td align="right">开启自动订单采集：</td>
      <td>&nbsp;<?=html_radio($shifou_arr,$alimama_data['open'],'open')?>&nbsp;<span style="color:#FF6600">一旦发生错误，会自动关闭本插件。此选项，无返利类api和有返利类api的站点，都要开启</span></td>
    </tr>
    <?php $tbauth_arr=array('0'=>'淘宝账号','1'=>'阿里妈妈账号');?>
    <tr>
      <td align="right">账号类型：</td>
      <td>&nbsp;<?=html_radio($tbauth_arr,$alimama_data['zh_type'],'zh_type')?></td>
    </tr>
    <tr>
      <td align="right">关闭时的前台提示：</td>
      <td>&nbsp;<input type="text" name="close_tip" id="close_tip" value="<?=$alimama_data['close_tip']?>" /></td>
    </tr>
    <tr>
      <td align="right">上次错误信息：</td>
      <td>&nbsp;<input type="text" name="error_msg" id="error_msg" style="width:300px" value="<?=$alimama_data['error_msg']?$alimama_data['error_msg']:'无'?>" /></td>
    </tr>
    <tr>
      <td align="right">提醒：</td>
      <td>&nbsp;<b style="color:red">如果错误，万万不能连续多次（三次）保存设置，进行测试，一旦提示输入验证码你将被可能被限制一天，直到淘宝认为不需要你输入验证码</b></td>
    </tr>
    <?php }?>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;<input type="hidden" name="tbauth" value="<?=$zhengshu?>" /><input type="submit" name="sub" value=" 保 存 设 置 " /> &nbsp;保存后更新网站缓存（后台右上角）</td>
    </tr>
  </table>
</form>
<?php if($yun_alimama['buy']==1 && TAOTYPE==1){$paystatus_arr=array('0'=>'创建时间','3'=>'结算时间');?>
<br/>
<form method="get" action="../index.php">
  <table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
    <?php if($yzm){?>
    <tr style="height:35px;">
      <td align="right">请输入验证码：</td>
      <td>
      <table border="0">
  <tr>
    <td> <input type="text" name="yzm" id="yzm2" style="width:60px;" value="" /></td>
    <td><img id="TPL_checkcode2" src='<?=$yzm?>' onclick="reyzm2()"  /></td>
    <td><span style="cursor:pointer; margin-right:10px;" onclick="reyzm2()">看不清</span></td>
  </tr>
</table>
       </td>
    </tr>
    <?php }?>
    <tr>
      <td width="115px" align="right">时间范围：</td>
      <td>&nbsp;<input name="sday" type="text" id="sday" size="10" maxlength="8" value="<?=date('Ymd')?>" /> 到 <input name="eday" type="text" id="eday" size="10" maxlength="8" value="<?=date('Ymd')?>" /></td>
    </tr>
    <tr>
      <td align="right">订单时间：</td>
      <td>&nbsp;<?=html_radio($paystatus_arr,0,'paystatus')?></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;<input type="submit" class="sub" name="daoru" value="获取交易记录" /> 根据时间人工获取订单（获取前请先点上面的点击测试，正常后再获取交易记录）</td>
    </tr>
  </table>
<input type="hidden" name="mod" value="tao" />
<input type="hidden" name="act" value="report" />
<input type="hidden" name="show" value="<?=authcode(1,'ENCODE')?>" />
</form>
<?php }?>
<?php if($alimama_data['password']!=''){?>
<script>
$("#test").click(function(){
	location.href="<?=u(MOD,ACT,array('test'=>1))?>&yzm="+$("#yzm").val();
});
</script>
<?php }?>
<?php include(ADMINTPL.'/footer.tpl.php');?>