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
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
	<tr>
    <td width="115" height="35" align="right">第一步：</td>
    <td>&nbsp;<a target="_blank" style="text-decoration:underline" href="https://oauth.taobao.com/authorize?response_type=token&client_id=<?=$webset['taoapi']['jssdk_key']?>">点击获取淘宝授权</a><span style="color:#FF6600">&nbsp;　请使用网站填写的“淘宝账号”登陆获取　<a href="index.php?mod=tradelist&act=set">查看</a></span></td>
  </tr>
  <tr>
    <td height="35" align="right">第二步：</td>
    <td><table width="" border="0">
  <tr>
    <td>&nbsp;session：</td>
    <td>&nbsp;<input style=" width:400px;"  name="taobao_session[value]" value="<?=$webset['taobao_session']['value']?>" /> 必须填写</td>
  </tr>
  <tr>
    <td>&nbsp;refresh_token：</td>
    <td>&nbsp;<input style=" width:400px;"  name="taobao_session[refresh_token]" value="<?=$webset['taobao_session']['refresh_token']?>" /> 必须填写</td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td height="35" align="right">第三步：</td>
    <td>&nbsp;<input type="hidden" name="taobao_session[day]" value="<?=$webset['taobao_session']['day']?>" /><input type="submit" name="sub" value=" 保 存 设 置 " /> </td>
  </tr>
  <tr>
    <td height="35" align="right">第四步（可选）：</td>
    <td><span style="color:#FF6600">&nbsp;检测主机是否支持openssl组件，可将淘宝授权延长到30天</span> <a style="text-decoration:underline" href="<?=u(MOD,ACT,array('test_ssl'=>1))?>">点击检测</a></td>
  </tr>
  <tr>
    <td height="35" align="right">第五步（可选）：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'自动'),$webset['taobao_session']['auto'],'taobao_session[auto]')?>&nbsp;<span style="color:#FF6600">如果可用则开启，不可用则关闭。点上面“保存设置”即可</span></td>
  </tr>
  <tr style="color:#666">
     <td align="right">&nbsp;常见错误：</td>
     <td style="padding-left:10px; padding-top:15px; padding-bottom:15px">
     <p>1、获取失败？答：检测jssdk appkey的地址是否为首页。<a href="index.php?mod=tradelist&act=set"></a>或是否多了空个或其他字符。</p>
     <p>2、主机不支持怎么办？答：可不必理会，一天获取一次即可。或联系空间商处理。</p>
     </td>
  </tr>
  <tr style="color:#666">
     <td align="right">&nbsp;说明：</td>
     <td style="padding-left:10px; padding-top:15px; padding-bottom:15px">
     <p>1、填写您的淘宝账号（此号需要是您appkey列表中第一个key的创建者）<a href="index.php?mod=tradelist&act=set">设置</a></p>
     <p>2、获取成功后，按照图示将淘宝session填写到第二步内。</p>
     <p><img src="images/taobao_session.png" style="border:#CCC 1px solid" /></p>
     </td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>