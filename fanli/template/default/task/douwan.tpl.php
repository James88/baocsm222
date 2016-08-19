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

if(!defined('INDEX')){
	exit('Access Denied');
}

include(TPLPATH.'/inc/header.tpl.php');

?>
<style>
html { overflow-x:hidden; }
</style>
<script>
$(function(){
	if(typeof getCookie('userlogininfo')=='undefined'){
		$('#tiplogin-beijing').show();
	}
});
  	function ScrollImgLeft(){
		var speed=30
		var scroll_begin = document.getElementById("scroll_begin");
		var scroll_end = document.getElementById("scroll_end");
		var scroll_div = document.getElementById("scroll_div");		
			
		if(scroll_begin.offsetWidth < scroll_div.offsetWidth){
				
      	return false;	
    	}else{
		  scroll_end.innerHTML=scroll_begin.innerHTML;
		  function Marquee(){
			if(scroll_end.offsetWidth-scroll_div.scrollLeft<=0)
			  scroll_div.scrollLeft-=scroll_begin.offsetWidth
			else
			  scroll_div.scrollLeft++
		  }
		  var MyMar=setInterval(Marquee,speed)
		  scroll_div.onmouseover=function() {clearInterval(MyMar)}
		  scroll_div.onmouseout=function() {MyMar=setInterval(Marquee,speed)}
				
		}
			
	  }
	function Autohide(){
		$('#ajax_goods_loading').hide();
	}
	setTimeout('Autohide()',3000);
</script>
<link rel="stylesheet" href="<?=TPLURL?>/inc/css/douwan/offer_css.css" />
<div class="mainbody" style="height:1600px; width:1020px; overflow-x:hidden; position:relative;">
    <div class="wrap-task">
        <div class="ad-banner">
           <div class="l aside">
           <div class="ad_ban"><a <?php if($offer['url']!=''){?>href="<?=$offer['url']?>"<?php }?> target="_blank"><img src="<?=$offer['img']?>" width="1000" height="195" alt="<?=$offer['title']?>"/></a></div>
            <div class="status">
                <div style="float:left; width:213px; height:55px; margin:10px;">
                    <img src="<?=a($user['id'],'middle')?>" width="48" height="48" style="background:#FFF; border:1px solid #CCC; padding:3px; float:left;" alt="<?=$user['name']?>"/>
                    <div class="user-msg six">
                        <span style="float:left;">欢迎您</span>
                        <a href="<?=u('user','index')?>" style="float:right;">[会员中心]</a>
                    </div>
                    <div class="user-msg six">
                        <?=$dduser['name']?$dduser['name']:'游客'?>
                    </div>
                 </div>
                <div class="fanli-msg" style="float:left;">
                    <p>我的余额：<?=(float)$dduser['money']?>&nbsp;&nbsp;元</p>
                    <p>已获任务奖励：<?=(float)$total?>&nbsp;&nbsp;元</p>
                </div>
            </div>
        </div>
        </div>
        <div class="others">
                <p class="six" style="float:left;">他们正在玩游戏拿返利</p>
                    <div class="scroll_div" id="scroll_div">
                    <?php if(!empty($info)){?>
                    <div id="scroll_begin">
                    <?php foreach($info as $r){?>
                    	<?=utf_substr($r['ddusername'],2).'***'?>完成<em><?=$r['programname']?></em>获得<span><?=(float)$r['point']?></span>元任务奖励&nbsp;&nbsp;    
                     <?php }?>
                     </div>
                      <?php }else{?>
                      <div id="scroll_begin">&nbsp;&nbsp;暂时没有数据哦！赶紧行动吧！</div>
                      <?php }?>
                      <div id="scroll_end"></div>
                    </div>
                <script type="text/javascript">
                  ScrollImgLeft();
                </script>
            </div>
        <div class="r main" style="width:1020px;">
            <div id="ajax_goods_loading" style="background:#999; color:#000;filter:alpha(Opacity=30);width:1000px; height:1350px;padding:15px 0;margin:auto;text-align:center; z-index:555; position:absolute; font-size:16px; font-weight:bolder"><img src="<?=TPLURL?>/inc/images/ajax_loader.gif" style="margin-bottom:-2px" />&nbsp;&nbsp;正在拼命加载中</div>
            <div class="iframe">
               <iframe src="<?=DD_U_URL?>/Public/html/v83/douwan.html?uid=<?=$memberid?>&uname=<?=urlencode($dduser['name'])?>" style='width:1020px;height:1290px;' scrolling="no" frameborder='no' border='0'></iframe>
            </div>
            <a id="tiplogin-beijing" style="display:none; " href="<?=u('user','login')?>" ><div style="width: 1020px; height: 100%; top:0; position: absolute; left: 50%; margin-left: -510px;filter:alpha(opacity=10);-moz-opacity:0.1;-khtml-opacity: 0.1;opacity: 0.1; background-color:#fff;">&nbsp;</div></a>
        </div>
    </div>
</div>
<!--新的U站插件版本20140225-->
<?php include(TPLPATH.'/inc/footer.tpl.php');?>