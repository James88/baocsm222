<!DOCTYPE html PUBliC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="author" content="duoduo_v8.3(<?=BANBEN?>)" />
<?php if($webset['qq_meta']!=''){echo $webset['qq_meta']."\r\n";}?>
<?php if(is_file(DDROOT.'/data/title/'.$mod.'_'.$act.'.title.php')){?>
<?php include(DDROOT.'/data/title/'.$mod.'_'.$act.'.title.php');?>
<?php }else{?>
<title>商家中心-<?=WEBNAME?></title>
<meta name="keywords" content="商家中心-<?=WEBNAME?>" />
<meta name="description" content="商家中心-<?=WEBNAME?>" />
<?php }?>
<?php include(TPLPATH.'/inc/js.config.tpl.php')?>
<base href="<?=SITEURL?>/" />
<?php
$css[]="css/kefu.css";
$css[]=TPLURL."/inc/css/baoming.css";
$css[]=TPLURL."/inc/css/goos.css";
$css[]=TPLURL."/inc/css/hf.css";
$css[]=TPLURL."/inc/css/common.css";
$css[]="data/plugin/default/color.css";
echo css($css);
unset($css);

$js['a']='js/jquery.js';
$js[]='js/fun.js';
$js[]=TPLURL.'/inc/js/fun.js';
echo js($js);
unset($js);
?>
<?php if($dd_have_tdj==1){include(DDROOT.'/comm/tdj_tpl.php');}?>
</head>
<body>
<div class="container dddefault">
  <div class="top">
    <div class="top1000">
      <div class="topleft" style="display:none">
        <div class="topleftA">您好，欢迎来到<?=WEBNAME?>！  请<a href="<?=u('user','login')?>">登录</a> / <a href="<?=u('user','register')?>">免费注册</a> <?php if($app_show==1){?>或使用<?php }?></div>
        <?php if($app_show==1){?>
        <div class=loginWays onmouseover=showLogin() onmouseout=showLogin()>
          <SPAN id=weibo_login class=firstWay>
            <A style="CURSOR: pointer" href="<?=u('api',$apps[0]['code'],array('do'=>'go'))?>"><img style="width:16px; height:16px" alt="用<?=$apps[0]['code']?>号登录" src="<?=TPLURL?>/inc/images/login/<?=$apps[0]['code']?>_1.gif"><?=$apps[0]['title']?>登陆</A><SPAN class=icon-down></SPAN>
          </SPAN>
        <div style="DISPLAY: none" id=menu_weibo_login class=pw_menu>
        <ul class=menuList>
          <?php foreach($apps as $k=>$row){?>
          <li><A href="<?=u('api','do',array('code'=>$row['code'],'do'=>'go'))?>"><img style="width:16px; height:16px" alt='使用<?=$row['title']?>帐号登录' src="<?=TPLURL?>/inc/images/login/<?=$row['code']?>_1.gif" /><?=$row['title']?>帐户登录</A></li>
          <?php }?>
        </ul>
      </div>
    </div>
    <?php }?>
  </div>
<script>
function topHtml() {/*<div class="topleftA" style="padding-top:10px;">
	<a href="<?=u('user')?>">{$name}</a> 
	<a href="<?=u('user','msg')?>">{$msgsrc}</a>&nbsp;&nbsp;|&nbsp;&nbsp;余额：<a href="<?=u('user','mingxi')?>">￥{$money}</a>
	&nbsp;&nbsp;<?=TBMONEY?>：<a href="<?=u('user','mingxi')?>">{$jifenbao}</a> 
	<?=TBMONEYUNIT?>&nbsp;&nbsp;|&nbsp;&nbsp;
</div>
<div class=loginWays1 onmouseover=showHide('menu_usernav') onmouseout=showHide('menu_usernav')>
          <SPAN>
            我的账户<img src="<?=TPLURL?>/inc/images/downarrow.gif" alt="箭头" />
          </SPAN>
          <div id=menu_usernav>
            <div class="wode">我的账户<img src="<?=TPLURL?>/inc/images/toparrow.gif" alt="箭头" /></div>
            <ul>
              <li><A href="<?=u('user','tradelist')?>">我的订单管理</A></li>
              <li><A href="<?=u('user','mingxi')?>">我的账户明细</A></li>
			  <?php if($webset['user']['shoutu']==1){?>
              <li><A href="<?=u('user','shoutu')?>">我的徒弟奖励</A></li>
			  <?php }?>
              <li><A href="<?=u('user','info')?>">我的账户设置</A></li>
            </ul>
          </div>
        </div>
		<div class"fl" style=" margin-top:10px">|&nbsp;&nbsp;&nbsp;<a href="<?=u('user','exit',array('t'=>TIME))?>">退出</a></div>*/;}

$.ajax({
	url: '<?=l('ajax','userinfo')?>',
	dataType:'jsonp',
	jsonp:"callback",
	success: function(data){
		if(data.s==1){
			topHtml=getTplObj(topHtml,data.user);
			$('.container .topleft').html(topHtml).show();
		}
		else{
			$('.container .topleft').show();
		}
	}
});
</script>
  <div class="topright"> 
    <ul>
      <li> <a href="javascript:;" onClick="AddFavorite('<?=SITEURL?>','<?=WEBNAME?>')">收藏本站</a> </li>  
      <li> <a href="comm/shortcut.php">快捷桌面 </a></li>  
      <li> <a href="<?=u('help','index')?>">网站帮助</a>   </li>
      <?php if($app_status==1){?>
      <li> <a href="<?=u('app','index')?>" target="_blank" style="*line-height:15px;">手机APP </a></li>
      <?php }?>
      <li id="fonta"> <a style="color:#F00" href="<?=u('hezuo','index')?>">商家中心</a>   </li>  
    </ul>
  </div>
</div>
</div>
<div class="bm_wrap">
    <div class="baoming_wrap" style="background:#fff;"> 
          <div class="grid1000 " >
              <div class="baoming_nav" >	
                    <div class=" col_l baoming_logo">
                        <div class="col_l bm_logo" >
                        	<a href="<?=SITEURL?>"><img src="<?=$dd_tpl_data['logo']?>" alt="<?=WEBNAME?>" style="height:70px; max-width:230px"/></a>
                        </div>
                        <div class="col_l bm_txt"> 
                       	 <h3 class="u-h3">商家报名中心</h3>
                        </div>
                    </div>
                    <div class="apply-menu col_r">
                        <ul>
                            <li <?php if(ACT=='index'){?>class="title-current"<?php }?>><a class="theee" href="<?=u('hezuo','index')?>">首页</a></li>
                            <li <?php if(ACT=='xuzhi'){?>class="title-current"<?php }?>><a class="theee" href="<?=u('hezuo','xuzhi')?>">报名须知</a></li>
                            <li <?php if(ACT=='list'){?>class="title-current"<?php }?>><a class="theee" href="<?=u('hezuo','list')?>">我的报名</a></li>
                        </ul>
                    </div>
              </div>
          </div>
    </div>
    <div class="clearfix" style="height:0px;"></div>
    <?php if(ACT=='index' || ACT=='xuzhi'){?>
    <img class="a_img" src="<?=$webset['shangjia']['banner']?>"/>
      <?php }?>
    <div class="bmbody_wrap">	
    	<div class="grid1000 " >
       	 <h2 class="u-h2">报名流程:</h2>
           <div class="bm_gc">
           </div>