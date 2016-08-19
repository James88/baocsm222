<?php
if (!defined('INDEX')) {
	exit ('Access Denied');
}

$parameter=act_wap_view();
extract($parameter);

$share_title=urlencode($shuju_data['title']);
$share_img=urlencode($shuju_data['img']);
$share_url=urlencode($share_url);
$share_desc=urlencode('赚钱是一种能力，花钱是一种技术，我能力有限，技术却很高。幸好及时发现了'.$webset['title'].'，挣钱能力虽然没涨，但省钱能力猛增！！');

include(TPLPATH.'/inc/header_2.tpl.php');
?>
<div class="listHeader">
  <p> <b>商品详情</b><a href="javascript:;" onClick="history.back()" class="left">返回</a> <a href='<?=wap_l()?>' class="right">首页</a> </p>
  </div>
<div class="goodsBody">
<dl class="goods ">
<?php if($shuju_data['title']!=''){?>
    <dt><img src="<?=tb_img($shuju_data['img'],320)?>" width='320' style="display:block" height='320' alt='<?=$shuju_data['title']?>' /></a></dt>
    <dd>
      <p class="p1"><?=$shuju_data['title']?></p><!--最多18个字-->
      <p class="p2"><span class="span1">返利</span><span class="span2" style="color:#060"><?=$shuju_data['rebate_word']?></span></p>
      <?php if($shuju_data['promotion_price']>0){?>
      <p class="p2"><span class="span1">现价</span><span class="span2"><font>¥<?=$shuju_data['promotion_price']?>元</font></span>&nbsp;<span class="span1" style="margin-left:10px"> 原价</span><span class="span2"><s>¥<?=$shuju_data['price']?>元</s></span></p>
      <?php }else{?>
      <p class="p2"><span class="span1">现价</span><span class="span2"><font>¥<?=$shuju_data['price']?>元</font></span></p>
      <?php }?>
      <p class="p2"><span class="span1">卖家</span><span class="span2"><?=$shuju_data['nick']?></span><!--<span class="span1" style="margin-left:10px"> 销量</span><span class="span2"><?=(float)$shuju_data['volume']?> 件</span>--></p>   
	  </dd>
      <?php }else{?>
      <dt>该商品暂无返利</dt>
      <?php }?>
      <div style=" width:<?=$dd_wap_class->is_weixin()==1?'260':'200'?>px; margin:auto">
         <a style="display:inline-block;" title="分享到新浪微博" href="http://service.weibo.com/share/mobile.php?title=<?=$share_title?>&pic=<?=$share_img?>&url=<?=$share_url?>&summary=<?=$share_desc?>"><img src="<?=TPLURL?>/inc/images/sina.png" width="100%" /></a>
		 <?php if($dd_wap_class->is_weixin()==1){?><a style="display:inline-block;" class="bds_weixin" onClick="document.getElementById('weixinshare').style.display='block'" title="分享到微信"><img src="<?=TPLURL?>/inc/images/weixin.png" width="100%" /></a><?php }?>
         <a style="display:inline-block;" title="分享到QQ空间" href="http://openmobile.qq.com/oauth2.0/m_jump?loginpage=loginindex.html&logintype=qzone&page=qzshare.html&summary=<?=$share_desc?>&imageUrl=<?=$share_img?>&url=<?=$share_url?>&title=<?=$shuju_title?>&callbackUrl=<?=$share_url?>"><img src="<?=TPLURL?>/inc/images/qzone.png" width="100%" /></a>
         <a style="display:inline-block;" href="http://share.v.t.qq.com/index.php?c=share&a=index&title=<?=$shuju_title?>&pic=<?=$shuju_img?>&url=<?=$share_url?>&summary=<?=$share_desc?>"><img src="<?=TPLURL?>/inc/images/txweibo.png" width="100%" /></a>
         </div>
	  </dl>
      
 <p class="buy"> 
 <?php if($dd_wap_class->is_weixin()==1){?>
 <a onClick="document.getElementById('weixindiv').style.display='block'" class="left">去淘宝购买</a>
 <?php }else{?>
    <a href='' data-itemid="<?=$shuju_data['num_iid']?>" isconvert=1 dd-href="index.php?mod=jump&act=index&a=tb&iid=<?=$shuju_data['num_iid']?>&url=" target="_blank"class="left click_url">去淘宝购买</a>
 <?php }?>
 
  <a href="javascript:;" onClick="history.back()" class="right">返回列表</a></p>
   <a href="javascript:;" class="data" style="cursor:text;"><span><font>提醒：</font><strong style="font-weight:normal; color:#EE2E5B; font-size:0.8em">如果跳淘宝手机APP可以正常返利！</strong></span></a>
  <p class="line"></p>
  
  <?php if(!empty($shuju_data['comment']['rateList'])){?>
  <div class="mc radius">
	<ul class="mu-l2w">他们正在说：
    <?php foreach($shuju_data['comment']['rateList'] as $row){?>
    	<li style="padding: 5px 10px;border-top: none;overflow: hidden;line-height: 1.6em;">
        <span class="pricecolor" style="display: block;margin-top:10px; font-size:1em;line-height: 1.6em;"><?=$row['displayUserNick']?>：<span style=" color:#999"><?=$row['rateContent']?></span></span>
        </li>
    <?php }?>
			</ul>
</div>
<?php }?>
  </dd>
</dl>
</div>
</div>

</div>
</div>
<?php include(TPLPATH.'/inc/tdj.tpl.php');?>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>