<?php
if (!defined('INDEX')) {
	exit ('Access Denied');
}

$parameter=act_wap_view();
extract($parameter);
$summary="赚钱是一种能力，花钱是一种技术，我能力有限，技术却很高。幸好及时发现了".$webset['title']."，挣钱能力虽然没涨，但省钱能力猛增！！";
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
      <?php if($shuju_data['discount_price']>0){?>
      <p class="p2"><span class="span1">现价</span><span class="span2"><font>¥<?=$shuju_data['discount_price']?>元</font></span><?php if($row['price']>0){?>&nbsp;<span class="span1" style="margin-left:10px"> 原价</span><span class="span2"><s>¥<?=$shuju_data['price']?>元</s></span><?php }?></p>
      <?php }else{?>
      <p class="p2"><span class="span1">现价</span><span class="span2"><font>¥<?=$shuju_data['price']?>元</font></span></p>
      <?php }?>
      <p class="p2"><span class="span1">商家</span><span class="span2"><?=$shuju_data['laiyuan']?></span><!--<span class="span1" style="margin-left:10px"> 销量</span><span class="span2"><?=(float)$shuju_data['volume']?> 件</span>--></p>   
	  </dd>
      <?php }else{?>
      <dt>该商品暂无信息</dt>
      <?php }?>
      <div style=" width:<?=$dd_wap_class->is_weixin()==1?'260':'200'?>px; margin:auto">
         <a style="display:inline-block;" title="分享到新浪微博" href="http://service.weibo.com/share/mobile.php?title=<?=urlencode($summary)?>&pic=<?=urlencode($shuju_data['img'])?>&url=<?=urlencode($share_url)?>&summary=<?=urlencode($summary)?>"><img src="<?=TPLURL?>/inc/images/sina.png" width="100%" /></a>
		 <?php if($dd_wap_class->is_weixin()==1){?><a style="display:inline-block;" class="bds_weixin" onClick="document.getElementById('weixinshare').style.display='block'" title="分享到微信"><img src="<?=TPLURL?>/inc/images/weixin.png" width="100%" /></a><?php }?>
         <a style="display:inline-block;" title="分享到QQ空间" href="http://openmobile.qq.com/oauth2.0/m_jump?loginpage=loginindex.html&logintype=qzone&page=qzshare.html&summary=<?=urlencode($summary)?>&imageUrl=<?=urlencode($shuju_data['img'])?>&url=<?=urlencode($share_url)?>&title=<?=urlencode($summary)?>&callbackUrl=<?=urlencode($share_url)?>"><img src="<?=TPLURL?>/inc/images/qzone.png" width="100%" /></a>
         <a style="display:inline-block;" href="http://share.v.t.qq.com/index.php?c=share&a=index&title=<?=urlencode($summary)?>&pic=<?=urlencode($shuju_data['img'])?>&url=<?=urlencode($share_url)?>&summary=<?=urlencode($summary)?>"><img src="<?=TPLURL?>/inc/images/txweibo.png" width="100%" /></a>
         </div>
	  </dl>
      
 <p class="buy"> 
 <?php if($dd_wap_class->is_weixin()==1 && $shuju_data['laiyuan_type']<=2){?>
 <a onClick="document.getElementById('weixindiv').style.display='block'" class="left">去网站购买</a>
 <?php }else{?>
    <a href='<?=$shuju_data['wap_jump']?>' dd-href="index.php?mod=jump&act=index&a=tb&id=<?=$shuju_data['id']?>&url=" target="_blank" class="left click_url" data-itemid="<?=$shuju_data['data_id']?>" isconvert=1>去网站购买</a>
 <?php }?>
 
  <a href="javascript:;" onClick="history.back()" class="right">返回列表</a></p>
   <a href="javascript:;" class="data" style="cursor:text;"><span><font>提醒：</font><strong style="font-weight:normal; color:#EE2E5B; font-size:0.8em">如果跳网站手机APP可以正常返利！</strong></span></a>
  <p class="line"></p>
  </dd>
</dl>
</div>
</div>

</div>
</div>
<?php include(TPLPATH.'/inc/tdj.tpl.php');?>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>