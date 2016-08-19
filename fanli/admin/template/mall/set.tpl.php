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
/*if($_GET['update_lm']==1){
	$duoduo->update('mall',array('lm'=>8),1,0);
	jump(-1,'更新完成！');
}*/
if($_GET['ddyunpwd']!=''){
	$webnick=defined('WEBNAME')?WEBNAME:'';
	$url=DD_U_URL.'/?m=DdApi&a=getweb&url='.urlencode(URL).'&pwd='.md5(md5($_GET['ddyunpwd'])).'&webname='.urlencode($webnick).'&updatesite=1';
	$a=dd_get($url);
	echo $a;
	exit;
}

$ddyunkey=defined('DDYUNKEY')?DDYUNKEY:'';
$url=DD_U_URL.'/?g=Home&m=DdApi&a=getweb&key='.$ddyunkey.'&url='.urlencode(URL).'&webname='.urlencode($webnick);
$a=dd_get_json($url);

if($a['s']==1){
	$row=$a['r'];
}else{
	$row = array();
}

$step=(int)$_GET['step'];

$top_nav_name=get_lm($need_zhlm);

include(ADMINTPL.'/header.tpl.php');
?>
<script>
$(function(){
	$('#getddshouquan').jumpBox({  
	    title:'用于获取云库数据及联盟数据推送。',
		titlebg:1,
		height:140,
		width:450,
		contain:'<div id="ddform">登录密码：<input id="ddyunpwd" type="password" name="ddyunpwd" value="" /> <input type="submit" onclick="shouquan($(this))" value="点击获取" /></div><br><a style="float:right"" href="<?=DD_U_URL?>/index.php?m=user&a=reg&name=<?=urlencode(URL)?>&forward=<?=urlencode(SITEURL.ADMINDIR.'/'.u(MOD,ACT))?>">没有？点击去注册&gt;&gt;</a>',
		LightBox:'show'
    });
})

function shouquan($t){
	var ddyunpwd=$('#ddyunpwd').val();
	if(ddyunpwd==''){
		alert('登录密码不能为空');
		$('#ddopenpwd').focus();
		return false;
	}
	$t.attr('disabled','true');
	var url='<?=u(MOD,ACT)?>&ddyunpwd='+encodeURIComponent(ddyunpwd);
	$.getJSON(url,function(data){
		if(data.s==1){
			$('#alipay').val(data.r.alipay);
			$('#realname').val(data.r.realname);
			$('#DDYUNKEY').val(data.r.key);
			$('#siteid').val(data.r.site_id);
			jumpboxClose();
		}
		else{
			alert('密码错误或者还未注册多多云平台');
			$t.attr('disabled',false);
		}
	});
}
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" align="center" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">通信密钥：</td>
    <td>&nbsp;<input class="required" name="DDYUNKEY" type="text" id="DDYUNKEY" value="<?=$ddyunkey?>"  <?php if($ddyunkey!=''){?>readonly="readonly" <?php }?>/> <button class="sub" id="getddshouquan">获取</button> <span class="zhushi">请勿泄露 &nbsp;&nbsp;&nbsp;</span>
    </td>
  </tr>
   <input name="siteid" type="hidden" id="siteid" value="<?=$webset['siteid']?>" style="width:150px" readonly="readonly"/>
  <tr>
    <td align="right">综合联盟优势：</td>
    <td>&nbsp;<span class="zhushi">综合联盟无需过多设置，可一键获取500家商城信息，方便快捷 <a href="index.php?mod=mall&act=addedi">获取</a></span></td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /> <span class="zhushi"><a href="http://bbs.duoduo123.com/read-1-1-198027.html" target="_blank">设置教程</a></span></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>