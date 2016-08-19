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
include(DDROOT.'/comm/jssdk.php');
echo '<script src="http://a.tbcdn.cn/apps/top/x/sdk.js?appkey='.$webset['taoapi']['jssdk_key'].'"></script>';
echo '<script src="../js/base64.js"></script>';
echo '<script src="../js/md5.js"></script>';
echo '<script src="../js/jssdk.js"></script>';
if($webset['static']['index']['index'] == 1 || is_file(DDROOT.'/index.html')){
	$dis=1;
}
?>
<div class="explain-col">
<iframe src="<?=DUODUO_URL?>/huodong.html"  frameborder="0" marginheight="0" marginwidth="0" border="0" scrolling="No" height="30" width="100%"></iframe>
  </div>
<br />
<script>
function doClickUrl(url){
	$('#click_url').val(url);
}

function get_click_url_f(){
	parame=new Array();
	parame['url']='http://1111.tmall.com/';
	parame['call_user_fun']='addInput';
	taobaoTaobaokeWidgetUrlConvert(parame);
	return false;
}
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">顶端大幅广告：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$webset['huodong']['top_ad'],'huodong[top_ad]')?></td>
  </tr>
  <tr>
    <td align="right">首页幻灯片：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$webset['huodong']['index_slides'],'huodong[index_slides]')?> 幻灯片设置为淘宝双十一宣传素材  
      <input type="button" value="获取链接" onclick="get_click_url_f()" class="b" /> 
      <input type="text" name="huodong[click_url]" style="width:300px" value="<?=$webset['huodong']['click_url']?>" id="click_url"/></td>
  </tr>
  <tr>
    <td align="right">首页淘宝热卖：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$webset['huodong']['index_tao_hot'],'huodong[index_tao_hot]')?> 替换为双十一商品</td>
  </tr>
  <tr>
    <td align="right"></td>
    <td>&nbsp;<input id="sub" type="submit" name="sub" class="sub" value=" 提 交 " /></td>
  </tr>
  <tr>
    <td align="right"></td>
    <td>提醒：如果关闭首页静态，网站访问慢，请关闭拍拍返利即可。<a href="index.php?mod=paipai_order&amp;act=set">关闭</a></td>
  </tr>
</table>
</form>
<script>
<?php if($dis==1){?>
$('#sub').attr('disabled','disabled').after(' 关闭<a href="<?=u('template','set')?>" style="text-decoration:underline">首页静态</a>，清除网站缓存（删除根目录index.html），才可提交');
<?php }?>
</script>
<?php include(ADMINTPL.'/footer.tpl.php');?>