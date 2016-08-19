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

$md_access_arr=array('pc'=>'关闭','wap'=>'wap站'/*,'app'=>'app下载页'*/);

include(ADMINTPL.'/header.tpl.php');
?>

<script>
$(function(){
	<?=radio_guanlian('webclose')?>
});

</script>
<form action="index.php?mod=webset&act=set" style="font-size:12px" method="post" name="form1">
<table id="addeditable" align="center" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="110"  align="right">网站开关：</td>
   	<td>&nbsp; <?=html_radio(array('0'=>'开启','1'=>'关闭'),$webset['webclose'],'webclose')?></td>
  </tr>
  <tbody class="webclose_guanlian">
  <tr>
    <td align="right" >关闭时显示的信息：</td>
   	<td style="padding:5px 13px;"><textarea name="webclosemsg" cols="40" rows="3" class="btn3" style="width:400px"><?=$webset['webclosemsg']?></textarea></td>
  </tr>
  <tr>
    <td align="right" >关闭后允许访问IP：</td>
   	<td >&nbsp;<input type="text" style="width:400px;" name="webcloseallowip" value="<?=$webset['webcloseallowip']?>" /> <span class="zhushi">可多个，用英文逗号分开。我的IP：<?=get_client_ip()?></span></td>
  </tr>
  </tbody>
  <tr>
    <td align="right">网站名称：</td>
    <td>&nbsp;<input name="WEBNAME" type="text" value="<?=WEBNAME?>" class="btn3" style="width:400px" /> <span class="zhushi">建议不超过5个汉字</span>
  </td>
  </tr>
  <tr>
    <td align="right">网址（全）：</td>
    <td>&nbsp;<input name="URL" type="text" id="url" value="<?=URL?>" size="40" class="btn3" style="width:400px" /> <span class="zhushi">如 www.taobao.com 不带http:// 后面不带/ </span>
    </td>
  </tr>
  <tr>
    <td align="right">子目录：</td>
    <td>&nbsp;<input name="URL_MULU" type="text" id="url_mulu" value="<?=defined('URLMULU')?URLMULU:str_replace($_SERVER['HTTP_HOST'],'',URL);?>" size="40" class="btn3" style="width:400px" /> <span class="zhushi">填写二级子目录名称 如：/fan ，没有请留空</span>
    </td>
  </tr>
 <tr>
    <td align="right">管理员email：</td>
	<td>&nbsp;<input name="email" type="text" id="email" value="<?=$webset['email']?>"  class="btn3" style="width:150px" /></td>
  </tr>
	<tr>
       <td align="right">管理员qq：</td>
       <td>&nbsp;<input name="qq" type="text" id="qq" value="<?=$webset['qq']?>" class="btn3" style="width:150px" /></td>
    </tr>
  <tr>
    <td align="right">网页压缩输出：</td>
    <td>&nbsp;<?=html_radio(array('1'=>'开启','0'=>'关闭'),$webset['gzip'],'gzip')?><span class="zhushi">先关闭此项，检测您的主机是否默认支持此功能，如果没有，再选择开启。<a target="_blank" href="http://gzip.zzbaike.com/">检测网站</a></span>
  </td>
  </tr>
  <tr>
    <td align="right">访问跳转：</td>
    <td>&nbsp;<?=html_radio($md_access_arr,$webset['md_access']?$webset['md_access']:'pc','md_access')?> <span class="zhushi">当使用移动设备访问网站时，是否自动跳转。<?php if($webset['wap']['status']==0){?><a href="<?=u('mobile','wap_set')?>">您的wap当前是关闭状态，请先开启</a><?php }?></span></td>
  </tr>
  <tr>
    <td align="right">跳转方式：</td>
    <td>&nbsp;<?=html_radio(array(0=>'对应网站',1=>'本站详情'),WEBTYPE,'WEBTYPE')?> <span class="zhushi">商品列表页点击商品跳转的页面，选“本站”为跳转到本站的商品详情页，反之到对应网站。</span></td>
  </tr>
  <tr>
    <td height="50" align="right">底部版权：</td>
    <td height="50" style="padding:5px 13px;"><textarea name="banquan" id="content" style="width:680px;"><?=$webset['banquan']?></textarea></td>
  </tr>
    <tr>
    <td align="right">&nbsp;</td>
<td>&nbsp;
      <input name="siteid" type="hidden" id="siteid" value="<?=$webset['siteid']?>" style="width:150px" readonly/><input type="submit" class="myself" name="sub" value=" 保 存 设 置 " /> 
      </td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>