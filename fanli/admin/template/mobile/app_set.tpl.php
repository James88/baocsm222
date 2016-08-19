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

if((int)$webset['app']['open']==0){
	$webset['app']['open']=1;
}
$top_nav_name=array(array('url'=>u('mobile','wap_set'),'name'=>'wap设置'),array('url'=>u('mobile','app_set'),'name'=>'app设置'));
include(ADMINTPL.'/header.tpl.php');
?>
<style>
.appstatus_guanlian,.appsign_open_guanlian{ display:none}
</style>
<script>
function check_iphone_appstore(){
	if($('input[name="app[iphone_appstore]"]:checked').val()==1){
		var u=$('#iphone_file').val();
		if(u!='' && u.indexOf('https://itunes.apple.com')<0){
			alert('您当前选择了苹果商店模式，但是iphone地址错误，请修改');
		}
	}
}

$(function(){
	$('input[name="app[iphone_appstore]"]').click(function(){
		check_iphone_appstore();
	});
	check_iphone_appstore();
	
	$('#getddshouquan').jumpBox({  
	    title: '获取联盟id和数据传送密钥',
		titlebg:1,
		height:140,
		width:450,
		contain:'<div id="ddform">平台登陆密码：<input id="ddopenpwd" type="password" name="ddopenpwd" value="" /> <input type="submit" onclick="shouquan($(this))" value="登录获取" /></div><br/><div><a href="<?=DD_U_URL?>/?m=user&a=getpwd_email&name=<?=urlencode(DOMAIN)?>" target="_blank" style=" color:red; font-size:12px">找回密码</a></div>',
		LightBox:'show'
    });

	<?=radio_guanlian('app[status]')?>
	<?=radio_guanlian('app[sign_open]')?>
})

function shouquan($t){
	var ddopenpwd=$('#ddopenpwd').val();
	if(ddopenpwd==''){
		alert('登录密码不能为空');
		$('#ddopenpwd').focus();
		return false;
	}
	
	$t.attr('disabled','true');
	var url='<?=u(MOD,ACT)?>&ddopenpwd='+encodeURIComponent(ddopenpwd);
	$.getJSON(url,function(data){
		if(data.s==1){
			$('#did').val(data.r.site_id);
			$('#dkey').val(data.r.key);
			jumpboxClose();
		}
		else{
			alert('密码错误');
			$t.attr('disabled',false);
		}
	});
}
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>&do=<?=$do?>&plugin_id=<?=$plugin_id?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">状态：</td>
    <td>&nbsp;<?=html_radio($zhuangtai_arr,$webset['app']['status'],'app[status]')?></td>
  </tr>
  <tbody class="appstatus_guanlian">
  <tr><td colspan="2" style="padding-left:5px; font-weight:bold; background:#e3e3e3;">基本设置：</td></tr>
  <tr>
    <td align="right">提示升级：</td>
    <td>&nbsp;<?=html_radio(array(1=>'提示升级',2=>'强制升级'),$webset['app']['open'],'app[open]')?></td>
  </tr>
  <tr>
    <td align="right">升级内容：</td>
    <td style="padding-top:3px">&nbsp;<textarea style="width:180px; height:90px" name="app[update_content]"><?=$webset['app']['update_content']?></textarea></td>
  </tr>
  <tr>
    <td align="right">应用名称：</td>
    <td>&nbsp;<input name="app[appname]" value="<?=$webset['app']['appname']?>"/></td>
  </tr>
  <tr>
    <td align="right">应用图标：</td>
    <td>&nbsp;<input name="app[applogo]" id="applogo" value="<?=$webset['app']['applogo']?>" style="width:300px"/>  <input class="sub" type="button" value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('do'=>'httpurl','uploadtext'=>'applogo','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">下载等页面的图标，可直接添加网络地址</span></td>
  </tr>
  <tr>
    <td align="right">苹果版本号：</td>
    <td>&nbsp;<input name="app[android_version]" value="<?=$webset['app']['android_version']?$webset['app']['android_version']:$webset['app']['version']?>" style="width:300px"/>  <span class="zhushi">以安装包的说明文档内版本为准</span></td>
  </tr>
  <tr>
    <td align="right">安卓版本号：</td>
    <td>&nbsp;<input name="app[ios_version]" value="<?=$webset['app']['ios_version']?$webset['app']['ios_version']:$webset['app']['version']?>" style="width:300px"/> <span class="zhushi">以安装包的说明文档内版本为准</span></td>
  </tr>
  <input name="app[version]" type="hidden" value="<?=$webset['app']['version']?>" style="width:300px"/>
  <input name="app[iphone_appstore_url]" type="hidden" id="iphone_appstore_url" value="<?=$webset['app']['iphone_appstore_url']?>" style="width:300px"/>
  <tr>
    <td align="right">应用ID：</td>
    <td>&nbsp;<input name="app[appid]" value="<?=$webset['app']['appid']?>" style="width:80px"/> <span class="zhushi">以安装包的说明文档内版本为准</span></td>
  </tr>
  <tr>
    <td align="right">苹果商店审核：</td>
    <td>&nbsp;<?=html_radio($shifou_arr,$webset['app']['iphone_appstore'],'app[iphone_appstore]')?>   <span class="zhushi">通过苹果商店审核选择是，默认都是否</span></td>
  </tr>
  <tr>
    <td align="right">iphone下载地址：</td>
    <td>&nbsp;<input id="iphone_file" name="app[iphone_file]" onblur="check_iphone_appstore()" value="<?=$webset['app']['iphone_file']?>" style="width:300px"/>  <span class="zhushi">通过苹果商店填写苹果商店地址，没有通过写网络地址</span></td>
  </tr>
  <tr>
    <td align="right">android下载地址：</td>
    <td>&nbsp;<input name="app[android_file]" value="<?=$webset['app']['android_file']?>" style="width:300px"/> <span class="zhushi">直接添加网络地</span></td>
  </tr>
  <tr>
    <td align="right">二维码：</td>
    <td>&nbsp;<input name="app[erweima]" id="erweima" value="<?=$webset['app']['erweima']?>" style="width:300px"/>   <input class="sub" type="button" value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('do'=>'httpurl','uploadtext'=>'erweima','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">可直接添加网络地址  扫描地址：<?=p('phone_app','phone')?> <!--<br/><br/> 【注意，系统会自动生成二维码，默认为空即可，如果您需要特别设置，可在这里上传二维码图片】--></span></td>
  </tr>
  <tr>
    <td align="right">在线制作二维码：</td>
    <td>&nbsp;<a href="http://www.liantu.com/" target="_blank">http://www.liantu.com/</a></td>
  </tr>
  <tr>
    <td align="right">手机号码：</td>
    <td>&nbsp;<input name="wap[haoma]" value="<?=$webset['wap']['haoma']?>"/></td>
  </tr>
  <tr>
    <td align="right">qq号码：</td>
    <td>&nbsp;<input name="wap[qq]" value="<?=$webset['wap']['qq']?>"/></td>
  </tr>
  <tr><td colspan="2" style="padding-left:5px; font-weight:bold; background:#e3e3e3">内容设置：</td></tr>
  <tr>
    <td align="right">应用logo：</td>
    <td>&nbsp;<input name="app[logo]" id="logo" value="<?=$webset['app']['logo']?>" style="width:300px"/>  <input class="sub" type="button" value="上传图片" onclick="javascript:openpic('<?=u('fun','upload',array('do'=>'httpurl','uploadtext'=>'logo','sid'=>session_id()))?>','upload','450','350')" /> <span class="zhushi">可直接添加网络地址   150*70像素</span></td>
  </tr>
  <tr>
    <td align="right">手机网页广告语：</td>
    <td>&nbsp;<input name="app[addword]" value="<?=$webset['app']['addword']?>" style="width:300px"/></td>
  </tr>
  <tr>
    <td align="right">关于应用：</td>
    <td>&nbsp;<textarea name="app[about]" id="content" style="width:800px"><?=$webset['app']['about']?></textarea></td>
  </tr>
  <tr>
    <td align="right">新手帮助：</td>
    <td>&nbsp;<textarea name="app[help]" id="content" style="width:800px"><?=$webset['app']['help']?></textarea></td>
  </tr>
  <tr><td colspan="2" style="padding-left:5px; font-weight:bold; background:#e3e3e3">功能设置：</td></tr>
  <tr>
    <td align="right">强制登录：</td>
    <td>&nbsp;<?=html_radio($zhuangtai_arr,$webset['app']['force_login'],'app[force_login]')?> <span class="zhushi">去第三方购物前，是否强制会员登录（如果选择不否，系统也会提示会员登录，只是会员可以点击取消）</span></td>
  </tr>
  <?php
  if($webset['app']['moshi']==''){$webset['app']['moshi']=1;}
  ?>
  <!--
  <tr class="s8_guanlian">
    <td align="right">S8 PID：</td>
    <td>&nbsp;<input name="app[s8_pid]" id="s8_pid" style="width:200px" value="<?=$webset['app']['s8_pid']?>" /> 格式：mm_16600009_4228266_22442931</td>
  </tr>-->
  <tr>
    <td align="right">购物模式：</td>
    <td>&nbsp;<?=html_radio(array(1=>'标准模式',2=>'简易模式'),$webset['app']['moshi'],'app[moshi]')?> <span class="zhushi">针对淘宝购物，简易模式在商品列表页直接跳转</span></td>
  </tr>
  <tr>
    <td align="right">手机号码注册：</td>
    <td>&nbsp;<?=html_radio($zhuangtai_arr,$webset['app']['mobile_reg'],'app[mobile_reg]')?> <span class="zhushi">手机号码注册，网站需要购买短信方可使用</span></td>
  </tr>
  <tr>
    <td align="right">第三方登录：</td>
    <td>&nbsp;<?php  foreach($apilogin_arr as $row){?><labal><input type="checkbox" <?php if($webset['app']['apilogin'][$row['code']]==1){?>checked<?php }?> name="app[apilogin][<?=$row['code']?>]" value="1"/><?=$row['name']?></labal><?php }?> <span class="zhushi">（手机客户端第三方登录需要以web端为基础，所以请确保您的网站端是可用的）</span>
    </td>
  </tr>
  <tr>
    <td align="right">连续签到：</td>
    <td>&nbsp;<?=html_radio($zhuangtai_arr,$webset['app']['sign_open'],'app[sign_open]')?></td>
  </tr>
  <tr class="appsign_open_guanlian">
    <td align="right">签到奖励：</td>
    <td>&nbsp;<?php for($i=0;$i<7;$i++){?>第<?=($i+1)?>天：<input type="text" style=" width:30px" name="app[sign][<?=$i?>]" value="<?=$webset['app']['sign'][$i]?$webset['app']['sign'][$i]:0?>" />&nbsp;<?php }?> （集分宝）</td>
  </tr>
  </tbody>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;<input type="submit" name="sub" value=" 保 存 " /> <span class="zhushi">特别说明：由于app的缓存机制，所有的网站后台更改后，app不会马上做出相应修改，缓存时间大于1小时，站长需关闭app从新打开查看更改效果。</span></td>
  </tr>
</table>
</form>
<script>
helloIndex=<?=(int)$hello_index?>;
slidesIndex=<?=(int)$slides_index?>;
indexCatIndex=<?=(int)$index_cat_index?>;
$(function(){
	$('#add_slides').click(function(){
		slidesIndex++;
		$('.slides:last').after('<tr class="slides"><td align="right">幻灯片'+(slidesIndex+1)+'：</td><td>&nbsp;商品id或关键词：<input name="app[slides]['+slidesIndex+'][iid]" value=""/>&nbsp;&nbsp;图片：<input name="app[slides]['+slidesIndex+'][img]" value="" id="img_slides'+slidesIndex+'" style="width:300px"/> <input class="sub" type="button" value="上传图片" onclick="javascript:openpic(\'index.php?mod=fun&act=upload&do=httpurl&uploadtext=img_slides'+slidesIndex+'\',\'upload\',450,350)" /> <span class="del_slides" style="cursor:pointer">删除</span></td></tr>');
	});	
	
	$('.del_slides').live('click',function(){
		$(this).parents('.slides').remove();
		slidesIndex--;
	});
	
	$('#add_hello').click(function(){
		helloIndex++;
		$('.hello:last').after('<tr class="hello"><td align="right">首次启动图片'+(helloIndex+1)+'：</td><td>&nbsp;<input name="hello['+helloIndex+']" value="" id="img_hello'+helloIndex+'" style="width:300px"/> <input class="sub" type="button" value="上传图片" onclick="javascript:openpic(\'index.php?mod=fun&act=upload&do=httpurl&uploadtext=img_hello'+helloIndex+'\',\'upload\',450,350)" /> <span class="del_hello" style="cursor:pointer">删除</span></td></tr>');
	});	
	
	$('.del_hello').live('click',function(){
		$(this).parents('.hello').remove();
		helloIndex--;
	});
	
	/*$('.delcat').live('click',function(){
		$(this).parents('.slides').remove();
		slidesIndex--;
	});
	
	$('#add_index_cat').click(function(){
		indexCatIndex++;
		$('.index_cat:last').after('<tr class="index_cat"><td align="right">首页栏目'+(indexCatIndex+1)+'：</td><td>&nbsp;名称：<input style="width:70px" name="index_cat['+indexCatIndex+'][name]" value=""/> 搜索词：<input style="width:70px" name="index_cat['+indexCatIndex+'][q]" value=""/> 图片：<input name="index_cat['+indexCatIndex+'][img]" value="" id="img_index_cat_'+indexCatIndex+'" style="width:300px"/> <input class="sub" type="button" value="上传图片"  onclick="javascript:openpic(\'index.php?mod=fun&act=upload&do=httpurl&uploadtext=img_index_cat'+indexCatIndex+'\',\'upload\',450,350)" /></td></tr>');
	});	
	
	$('.del_index_cat').live('click',function(){
		$(this).parents('.index_cat').remove();
		indexCatIndex--;
	});*/
	
	$('.shuoming').jumpBox({  
		height:130,
		width:280,
		contain:$('#urlsm').html()
    });
})
</script>
<div style="display:none" id="urlsm">
<div style="padding-top:10px; line-height:25px">
连接形式分为3种，淘宝商品id，淘宝商品关键词还有网址，如果网址的形式是淘宝商品，系统会自动取出其中的商品id
</div></div>
<?php include(ADMINTPL.'/footer.tpl.php');?>