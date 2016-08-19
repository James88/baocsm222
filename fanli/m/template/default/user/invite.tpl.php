<?php
if (!defined('INDEX')) {
	exit ('Access Denied');
}

$parameter=act_wap_user_invite();
extract($parameter);
include(TPLPATH.'/inc/header_2.tpl.php');
?>
<script>
var floorStep=1;
var ajaxTag=0;
$(function(){
	$(window).bind('scroll',function(){
		if($(window).scrollTop()+$(window).height()>=$(document).height()-400){
			if(ajaxTag==0){
				ajaxTag=1;
				jiazai(floorStep);
				floorStep++;
			}
		}
	});
});

function index_tpl(){/*<tr>
                	<td>{$ddusername}</td>
                	<td>{$regtime}</td>
                	<td>{$tgyj} 元</td>
                </tr>*/;}

function jiazai(floorStep){	
	$('.chakan_more').text('数据获取中……');
	var url='<?=wap_l(MOD,ACT)?>&sub=1&page='+floorStep;
	$.ajax({
		url: url,
		dataType:'jsonp',
		jsonp:"callback",
		success: function(data){
			ajaxTag=0;
			if(data.s=='1'){
				if(data.r=='' || data.r=='null' || data.r==null){
					setCookie('inviteajax',1,300);
					//alert('没有了');
					ajaxTag=1;
					if(floorStep==1){
						$('.no_data').show();
					}else{
						$('.no_data').html('已全部加载！');
						$('.no_data').show();
					}
					$('.chakan_more').hide();
				}else{
					for(i in data.r){
						row=data.r[i];
						var html=getTplObj(index_tpl,row);
						$('.shuju_load').append(html);
					}
					$('.chakan_more').text('点击更多');
				}
			}
		}
	});
	return false;
}
</script>
<link href="<?=TPLURL?>/inc/css/invite.css?v=1" rel="stylesheet" type="text/css" />
<div class="listHeader">
  <p> <b>邀请好友</b> <a href="javascript:;" onclick="history.back()" class="left">返回</a> <a href='<?=wap_l()?>' class="right">首页</a>  </p>
</div>
<div class="juzhong">
	<div class="top">
    	<img src="<?=TPLURL?>/inc/images/header_bner.jpg" width="100%" />
        <p class="up">每成功邀请一个好友，最高可获得<span><?=$webset['tgfz']?></span>元奖励</p>
        <p class="down">既能帮好友省钱，也能获取额外奖励！马上开始行动吧！</p>
    </div>
    <div class="mb_mid">
    	<p class="title">1、分享给好友</p>
        <p>点击下方任意按钮，分享即可！</p>
        <p>分享给QQ好友或者QQ空间，更容易邀请到好友哦~</p>
        <div class="fenxiang">
        	<ul>
                 <li>
                    <a title="分享到新浪微博" href="http://service.weibo.com/share/mobile.php?title=<?=$share_desc?>&pic=<?=$share_img?>&url=<?=$rec_url?>"><img src="<?=TPLURL?>/inc/images/sina.png" width="100%" /></a>
                    <p>新浪微博</p>
                </li>
                <?php if($dd_wap_class->is_weixin()==1){?>
            	<li>
                	<a class="bds_weixin" onClick="document.getElementById('weixinshare').style.display='block'" title="分享到微信"><img src="<?=TPLURL?>/inc/images/weixin.png" width="100%" /></a>
                    <p>微信</p>
                </li>
                <?php }?>
            	<li>
                	<a title="分享到QQ空间" href="http://openmobile.qq.com/oauth2.0/m_jump?loginpage=loginindex.html&logintype=qzone&page=qzshare.html&quit=&site=<?=$rec_url?>&summary=<?=$share_desc?>&imageUrl=<?=$share_img?>&url=<?=$rec_url?>&title=<?=$share_desc?>&callbackUrl=<?=$rec_url?>"><img src="<?=TPLURL?>/inc/images/qzone.png" width="100%" /></a>
                    <p>QQ空间</p>
                </li>
            	<li>
                	<a href="http://share.v.t.qq.com/index.php?c=share&a=index&title=<?=$share_desc?>&pic=<?=$share_img?>&url=<?=$rec_url?>"><img src="<?=TPLURL?>/inc/images/txweibo.png" width="100%" /></a>
                    <p>腾讯微博</p>
                </li>
            </ul>
        </div>
        <div style="clear:both"></div>
    </div>
    <div class="mb_down">
    	<p class="title">2、发送链接给好友</p>
        <p>复制您的专属邀请链接，发送给好友，好友通过该链接注册即可！</p>
        <p>
        	<div class="whitebg">
            	<input type="text" class="fuzhi" value="<?=urldecode($rec_url)?>" />
            </div>
        </p>
    </div>
    <div class="mb_down">
    	<p class="title">3、其他注意事项</p>
        <p>1、记得注册之后多多教教好友怎么用哦！获得更高奖励机会更高！</p>
        <p>2、不要为了获得小小的邀请奖励而失掉了自己的诚信，我们会人工核查，对于查实的<span>作弊行为</span>，我们将收回该帐号全部的邀请奖励，严重者将冻结所有收入并永久封号；</p>
        <p class="f00">*作弊行为：包括但不限于使用相同的电脑、相同的IP地址在同一天内注册多个帐号，以骗取邀请奖励的行为。</p>
    </div>
    <div class="mb_footer">
    	<p class="title">4、好友列表</p>
        <div class="topban">
        	<table width="100%" class="shuju_load">
            	<tr style="background:#f8f7f7;" >
                	<td>好友昵称</td>
                	<td>邀请时间</td>
                	<td>你获得的奖励</td>
                </tr>
            </table>
            <p style="text-align:center; margin-top:1em; line-height:1.2em; display:none" class="no_data">暂无好友！</p>
        </div>
    </div>
</div>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>