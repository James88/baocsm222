<?php
if (!defined('INDEX')) {
	exit ('Access Denied');
}

?>
<script>
$(function(){
	<?php if($dd_tpl_data['app']==1){?>
	var close_tishi=getCookie('close_tishi');
	if(close_tishi!=1){
		$('.down_app').show();
	}
	<?php }?>
});
function close_tishi(){
	setCookie('close_tishi',1);
	$('.down_app').hide();
}

function s8Tijiao($t){
	<?php if($dd_wap_class->is_weixin()==1){?>
	document.getElementById('weixindiv').style.display='block';
	return false;
	<?php }else{?>
	var v=$t.find('.keyW').val();
	if(v==''){
		alert('请输入搜索内容');
		return false;
	}
	<?php }?>
}
</script>
<p class="line line2" style="margin-bottom:20px;" ></p>
<div class="seach">
<form action="" method="get" name="searchForm" onsubmit="return s8Tijiao($(this))"  target="_blank">
<input type="hidden" name="mod" value="tao" /><input type="hidden" name="act" value="search" />
	<input type="text" id="keywords2" name="q" class="keyW text" value="<?=$webset['search_key']['wap']?>" placeholder="输入您想要买的商品名称" style="color:#999;" />
	<input type="submit" class="button" value="" />
</form>
</div>
<div class="footer footer_b" style="border:none; margin-top:1em">
<p class="line"></p>
<p class="gwcLogin">
<a href="<?=SITEURL?>/?web=1" target="_blank">电脑版</a>
<?php if($dduser['id']>0){?>
<a href="<?=wap_l('user')?>" >会员中心</a>
<?php }else{?>
<a href="<?=wap_l('user')?>" >登录</a>
<?php }?>
<a href="<?=wap_l('help')?>">帮助中心</a>
<?php if(app_status()==1){?>
<a href="<?=u('app','phone')?>" target="_blank" class="a3"><span id="goods_number">new</span>下载app</a>
<?php }else{?>
<a href="<?=wap_l()?>">首页</a>
<?php }?>
</p>
	<p class="banquan"><span><?=$dd_tpl_data['banquan']?><?=$dd_tpl_data['tongji']?></span></p>
</div>
<?php if($dd_tpl_data['foot_open']==1){?>
<div class="yi-shangqiao yi-www" id="Shangqiao">
<ul class="yi-toolbar yi-bgcolor" style="background:<?=$dd_tpl_data['color']?>;">
  <li><a href="<?=wap_l('user')?>"><span class="yi-toolbar-tel"></span>会员中心</a></li>
  <li><a href="<?=wap_l()?>"><span class="yi-toolbar-index"></span>网站首页</a></li>
  <li><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?=$dd_tpl_data['qq']?>&amp;site=qq&amp;menu=yes"><span class="yi-toolbar-online"></span>在线沟通</a></li>
</ul></div>
<?php }?>
<div class="download-con"<?php if($dd_tpl_data['foot_open']==0){?> style="bottom:0"<?php }?> >
	<div class="down_app" style="display:none">
    	<div class="download-logo">
        	<img src="<?=$dd_tpl_data['tubiao']?>" width="100%" height="100%" />
        </div>
        <div class="alogo">
        	<p class="client-name"><?=$dd_tpl_data['tishi_words']?$dd_tpl_data['tishi_words']:'使用客户端拿返利更快捷方便'?></p>
        </div>
        <div class="open_now">
        	<a href="<?=u('app','phone')?>">
            	<span class="open_btn">立即打开</span>
            </a>
        </div>
        <div class="close-btn-con" onclick="close_tishi()">
        	<span class="close-btn-icon"><img src="<?=TPLURL?>/inc/images/index.png" width="12" height="12" /></span>
        </div>
    </div>
</div>
<div id="weixindiv" onClick="document.getElementById('weixindiv').style.display='';"><img src="<?=TPLURL?>/inc/images/<?=$dd_wap_class->device_type()?>g.png"></div>
<div id="weixinshare" onClick="document.getElementById('weixinshare').style.display='';"><img src="<?=TPLURL?>/inc/images/weixinshare.png"></div>
</body></html>