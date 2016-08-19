<?php
if(!defined('INDEX')){
	exit('Access Denied');
}
$parameter=dd_act();
extract($parameter);
$last_zdm=$duoduo->select('goods','id,title',"id<".$goods['id']." and code='".$goods['code']."' ORDER BY id DESC");
$next_zdm=$duoduo->select('goods','id,title',"id>".$goods['id']." and code='".$goods['code']."' ORDER BY id ASC");
//最火爆料
$huo_goods=$goods_class->top_goods($bankuai_code,5,'title,id,img,url,discount_price,price,code,ding','ding DESC,top DESC');
$css[]=TPLURL."/goods/".$bankuai_tpl."/css/zhide-css.css";
include(TPLPATH.'/inc/header.tpl.php');
?>
<script>
$(function(){
	$(".img").find("img.lazy").lazyload({
		threshold:20,
		failure_limit:50,
		effect : "fadeIn"
	});
	$(".huobao").find("img.lazy").lazyload({
		threshold:20,
		failure_limit:50,
		effect : "fadeIn"
	});
	$('.J-expend-trigger').click();
	
	$('.my-like').click(function(){
		goodsShoucang($(this));
	});
})
</script>
<script language="javascript" type="text/javascript" src="http://static.bshare.cn/b/buttonLite.js"></script>
<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC1.js"></script>
<div id="zhidemaiad"> </div>
    <div class="zdm-body yahei" id="zdm-body">
      <div class="zhidecontainer">
        <div id="J-zdm-article" class="zdm-article" data-pagename="index">
          <?php include(TPLPATH.'/goods/'.$bankuai_tpl.'/top.tpl.php')?>
          <div class="zdm-list">
          <div id="J_zdm_list">
              <div class="zdm-list-item J-item-wrap item-no-expired" data-id="<?=$goods['id']?>" style="position:relative">
                <h4 class="t"><a class="J-item-track nodelog click_url" target="_blank" href="<?=$goods['jump']?>" dd-href="?mod=jump&act=s8&iid=<?=iid_encode($goodsrow['data_id'])?>&url=" data-itemid="<?=$goods['data_id']?>" isconvert=1><?=$goods['title']?></a></h4>
                <div class="item-img">
                  <a href="<?=$goods['jump']?>" target="_blank" class="J-item-track img nodelog click_url" dd-href="?mod=jump&act=s8&iid=<?=iid_encode($goods['data_id'])?>&url=" data-itemid="<?=$goods['data_id']?>" isconvert=1><?=dd_html_img($goods['img'],$goods['title'],210)?></a>
                  <a href="<?=$goods['jump']?>" target="_blank" class="btn-zdm-goshop J-item-track nodelog click_url" dd-href="?mod=jump&act=s8&iid=<?=iid_encode($goodsrow['data_id'])?>&url=" data-itemid="<?=$goods['data_id']?>" isconvert=1>去购买</a>
                </div>
                <div class="item-info J-item-info">
                  <div class="item-time"><?=date('m-d H:i:s',strtotime($goods['starttime']))?> </div>
                  <?php if($goods['cid_title']){?><div class="item-type">分类：<a href="<?=u(MOD,'index',array('code'=>$goods['code'],'cid'=>$goods['cid']))?>" class="nine" ><?=$goods['cid_title']?></a> </div><?php }?>
                  <?php if($goods['ddusername']!=''){?><div class="item-user">推荐人：<?=$goods['ddusername']?></div><?php }?>
                  <?php if($goods['laiyuan']!=''){?><div class="item-type">所属：<a class="nine"><?=$goods['laiyuan']?></a></div><?php }?>
                  <div class="item-content J-item-content nodelog-detail" data-id="<?=$goods['id']?>" style="max-height:none">
                    <div class="item-content-inner J-item-content-inner"><?=$goods['content']?></div>
                  </div>
                </div>
                <div class="J-expend-wrap-before item-vote clearfix">
                  <em class="l item-vote-t">评价本文：</em>
                  <a href="javascript:void(0);" class="l item-vote-yes J-item-vote-yes vote" onclick="goodsVote($(this))" data-type="1"data-id="<?=$goods['id']?>"><?=$goods['ding']?></a>
                  <a href="javascript:void(0);" class="l item-vote-no J-item-vote-no vote" onclick="goodsVote($(this))" data-type="0"data-id="<?=$goods['id']?>"><?=$goods['cai']?></a>
                  <span class="l">大家在评论：</span>
                  <a href="javascript:void(0)" class="l item-view-comment J-expend-trigger" onclick="goodsComment($(this))" data-id="<?=$goods['id']?>"><?=$goods['pinglun']?></a>
                  <div class="bshare-custom" style=" width:320px; margin-top:7px; float:left; margin-left:10px;">
                            <a title="分享到" href="http://www.bshare.cn/share" id="bshare-shareto" class="bshare-more" style="font-weight:normal; color:#555;">分享到:</a>
 								<a title="分享到QQ空间" class="bshare-qzone">空间</a>
                                <a title="分享到新浪微博" class="bshare-sinaminiblog">新浪</a>
                                <a title="分享到QQ好友" class="bshare-qqim">QQ</a>
                                <a title="分享到腾讯微博" class="bshare-qqmb">腾讯</a> 
                               
                                 <a title="更多平台" class="bshare-more bshare-more-icon"></a>      
                            </div>
                            <script type="text/javascript" charset="utf-8">
bShare.addEntry({
    title: "<?=$goods['title']?>",
    url: "<?=$goods['_url']?>",
    summary: "<?=str_replace('"','',compact_html(strip_tags($goods['content'])))?>",
    pic: "<?=preg_match('/^http/',$goods['img'])?$goods['img']:SITEURL.'/'.$goods['img']?>"
});
</script>
                </div>             
                <div class="J-expend-wrap yahei zdm-expand-wrap" style=" display:none">
  <i class="top-arrow"></i>
  <div class="yahei zdm-expand-comment">
  </div>
</div>

<a class="y-like my-like" style="top:67px; right:20px;" title="<?=$goods['is_shoucang']==1?'已收藏':'加入收藏'?>" data_id="<?=$goods['id']?$goods['id']:$goods['data_id']?>">
            	<span class="like-ico <?=$goods['is_shoucang']==1?'l-active':''?>"></span>
        	</a>
              </div>
            </div>
          </div>
          <div id="baoliao_con" style="margin-top:10px;">
	<div id="nav-below" class="baoliao_blo single_navi">
		<div class="nav-previous">
			<span class="meta-nav">上一篇：</span><?php if($last_zdm['title']){?><a href="<?=u('goods','view',array('id'=>$last_zdm['id']))?>"><?=$last_zdm['title']?><?php }else{?>没有了<?php }?></a>
		</div>
		<div class="nav-next">
			<span class="meta-nav">下一篇：</span><?php if($next_zdm['title']){?><a href="<?=u('goods','view',array('id'=>$next_zdm['id']))?>"><?=$next_zdm['title']?><?php }else{?>没有了<?php }?></a>
		</div>
	</div>
	<div class="baoliao_blo">
		<div class="single_declare">
			<strong>声明：</strong><?=WEBNAME?>（<span><?=SITEURL?></span>）是一家中立的，致力于帮助广大网友在网购时能买到性价比更高商品的分享平台，每天为网友们提供丰富、准确、新鲜的网上商品、特价资讯等信息。本站信息大部分来自于网友爆料，如果您发现了优质的商品或好的价格，不妨爆料给我们吧（谢绝任何商业爆料）！
		</div>
	</div>
</div>

        </div>
        <?php include(TPLPATH.'/goods/zhi/right.tpl.php')?>    
        </div>
    </div>
<?php include(TPLPATH.'/inc/tdj.tpl.php');?>
<?php 
include(TPLPATH.'/goods/zhi/js.tpl.php');
include(TPLPATH.'/inc/footer.tpl.php');
?>