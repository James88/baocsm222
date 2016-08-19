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
//$top_nav_name=array(array('url'=>u('mobile','wap_set'),'name'=>'wap设置'),array('url'=>u('mobile','weixin'),'name'=>'微信设置'));
include(ADMINTPL.'/header.tpl.php');
?>
<style>
.wapstatus_guanlian,.wapsign_open_guanlian,.wapapp_guanlian{ display:none}
.yanse div{ width:15px; height:15px; cursor:pointer; border:#999 1px solid; padding:2px}
</style>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>&do=<?=$do?>&plugin_id=<?=$plugin_id?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd"  bgcolor="#FFFFFF">
  
  <tr>
    <td width="115px" align="right">状态：</td>
    <td>&nbsp;<?=html_radio($zhuangtai_arr,$webset['wap']['status'],'wap[status]')?> <span class="zhushi"><a target="_blank" href="<?=wap_l()?>">查看wap首页</a>（注意，pc查看wap，使用非IE内核浏览器）</span></td>
  </tr>
  <tbody class="wapstatus_guanlian">
    <tr>
    <td align="right">无线网站名称：</td>
    <td>&nbsp;<input name="wap[title]" value="<?=$webset['wap']['title']?>"/></td>
  </tr>
  <tr>
    <td align="right">统计代码：</td>
    <td>&nbsp;<input name="wap[tongji]" value="<?=htmlspecialchars($webset['wap']['tongji'])?>" /> <span class="zhushi"> <a href="http://bbs.duoduo123.com/read-1-1-175903.html" target="_blank">设置教程</a></span></td>
  </tr>
  <tr>
    <td align="right">手机号码：</td>
    <td>&nbsp;<input name="wap[haoma]" value="<?=$webset['wap']['haoma']?>"/></td>
  </tr>
  <tr>
    <td align="right">qq号码：</td>
    <td>&nbsp;<input name="wap[qq]" value="<?=$webset['wap']['qq']?>"/></td>
  </tr>
  <tr>
    <td align="right">提示APP下载：</td>
    <td>&nbsp;<?=html_radio($zhuangtai_arr,$webset['wap']['app'],'wap[app]')?> <?php if($phone_app_endtime<SJ){?>您还没购买手机app，请购买后开启。<a href="http://yun.duoduo123.com/index.php?m=bbx&a=view&id=69">购买</a><?php }?> <span class="zhushi"> 开启后底部会提示app下载弹窗</span></td>
  </tr>
  <tr class="wapapp_guanlian">
    <td align="right">提示APP下载标语：</td>
    <td>&nbsp;<input name="wap[tishi_words]" id="tishi_words" style="width:400px" value="<?=$webset['wap']['tishi_words']?$webset['wap']['tishi_words']:'使用客户端拿返利更快捷方便'?>" /></td>
  </tr>
  <tr class="wapapp_guanlian">
    <td align="right">提示APP下载图标：</td>
    <td>&nbsp;<input name="wap[tubiao]" id="tubiao" value="<?=$webset['wap']['tubiao']?>" /> <input class="sub" type="button" value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'tubiao','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">建议大小：140px*140px</span></td>
  </tr>
  <tr>
    <td align="right">第三方登录：</td>
    <td>&nbsp;<?php  foreach($apilogin_arr as $row){?><label><input type="checkbox" <?php if($webset['wap']['apilogin'][$row['code']]==1){?>checked<?php }?> name="wap[apilogin][<?=$row['code']?>]" value="1"/><?=$row['name']?></label><?php }?> <span class="zhushi">（此功能需要以web端为基础，所以请确保您的网站端是可用的）</span>
    </td>
  </tr>
  <tr>
    <td align="right">连续签到：</td>
    <td>&nbsp;<?=html_radio($zhuangtai_arr,$webset['wap']['sign_open'],'wap[sign_open]')?></td>
  </tr>
  <tr class="wapsign_open_guanlian">
    <td align="right">奖励设置：</td>
    <td>&nbsp;<?php for($i=0;$i<7;$i++){?>第<?=($i+1)?>天：<input type="text" style=" width:30px" name="wap[sign][<?=$i?>]" value="<?=$webset['wap']['sign'][$i]?$webset['wap']['sign'][$i]:0?>" />&nbsp;<?php }?> （<?=TBMONEY?>）</td>
  </tr>
  <tr>
    <td align="right">分享的图片：</td>
    <td>&nbsp;<input name="wap[share_img]" id="share_img" value="<?=$webset['wap']['share_img']?>"/>  <input class="sub" type="button" value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('uploadtext'=>'share_img','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">邀请好友页面分享默认图片，不加默认logo。</span></td>
  </tr>
  <tr>
    <td align="right">分享的内容：</td>
    <td>&nbsp;<textarea name="wap[share_desc]" id="share_desc" cols="60" rows="5"><?=$webset['wap']['share_desc']?$webset['wap']['share_desc']:'我正在看[ '.WEBNAME.'-可以购物返利的网站]，分享给你，一起看吧！'?></textarea><span class="zhushi">邀请好友分享内容</span></td>
  </tr>
  <tr>
    <td align="right">帮助中心：</td>
    <td style="padding-left:5px; padding-bottom:3px">&nbsp;<textarea name="wap[help]" id="content" style="width:480px; margin-left:5px;"><?=$webset['wap']['help']?></textarea></td>
  </tr>
  </tbody>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;<input type="submit" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<script>
$(function(){
	<?=radio_guanlian('wap[status]')?>
	<?=radio_guanlian('wap[sign_open]')?>
	<?=radio_guanlian('wap[app]')?>
})
</script>

<?php include(ADMINTPL.'/footer.tpl.php');?>