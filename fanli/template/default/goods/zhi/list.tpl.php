<?php
if(!defined('INDEX')){
	exit('Access Denied');
}
$pagesize=$dd_tpl_data['pagesize'];
include_once(DDROOT.'/mod/goods/public.act.php');
$bankuai_code=$bankuai_code?$bankuai_code:$_GET['code'];
$parameter=act_goods_list($bankuai_code,$_GET['do'],$ajax_load_num,$pagesize,$_GET['page'],$_GET['cid'],$goods_total);
extract($parameter);
if(defined('VIEW_PAGE')||$_GET['page']<=1){
//最火爆料
require_once(DDROOT.'/comm/goods.class.php');
$goods_class=new goods($duoduo);
$huo_goods=$goods_class->top_goods($bankuai_code,10,'title,id,img,url,discount_price,price,code,ding','ding DESC,top DESC'," and starttime>=".strtotime(date('Y-m-d 00:00:00',strtotime('-3 day'))));
include(TPLPATH.'/goods/zhi/js.tpl.php');
?>
<script>
function LazyLoad($t){
	$t=$t||$('.list-good');
	var $obj=$t.find("img.lazy");
	var $cobj=$t.find('.J-item-content-inner');
	$obj.lazyload({
		threshold:20,
		failure_limit:50,
		effect : "fadeIn"
	});
	
	$t.find('.my-like').click(function(){
		goodsShoucang($(this));
	});
	
	<?php if(MOD!='index'){?>
	$(".huobao").find("img.lazy").lazyload({
		threshold:20,
		failure_limit:50,
		effect : "fadeIn"
	})
	<?php }?>
	
	$cobj.each(function(){
		var $t=$(this).parent('.nodelog-detail');
		if($(this).height()>200){
			$t.next('.item-toggle').find('a').show();
		}
	});
}
</script>
<div class="yahei goods_list_zhi" id="zdm-body">
  <div class="zhidecontainer">
    <div id="J-zdm-article" class="zdm-article" data-pagename="index">
    <!--这里必须定义一个goods_items，滚动加载-->
      <div class="zdm-list zhidemai_goods_list goods_items"id="zhidemaiDiv">
        <?php }?>
        <?php if(!empty($goods_list)){?>
        <?php foreach($goods_list as $row){?>
        <!--这里必须定义一个list-good识别图片加载的-->
        <div id="J_zdm_list" class="list-good" style="position:relative">
          <div class="zdm-list-item J-item-wrap item-no-expired" data-id="2" id="post-2"><?php if($row['top']>0){?><i class='zhiding'>置顶</i><?php }elseif($row['is_new']){?><i class='zuixinfabu'>最新发布</i><?php }else{?><i class='lowest-network'>全网最低</i><?php }?><h4 class="t"><a class="J-item-track nodelog click_url" dd-href="?mod=jump&act=s8&iid=<?=iid_encode($row['data_id'])?>&url=" data-itemid="<?=$row['data_id']?>" isconvert=1 href="<?=$row['url']?>" target="_blank"><?=$row['title']?></a><?php if($row['discount_price']>0){?><span class="red t-sub">[<?=(float)$row['discount_price']?>元]</span><?php }?></h4>
            <div class="item-img"> <a href="<?=$row['url']?>" dd-href="?mod=jump&act=s8&iid=<?=iid_encode($row['data_id'])?>&url=" data-itemid="<?=$row['data_id']?>" isconvert=1 class="click_url J-item-track img nodelog" target="_blank"><?=dd_html_img($row['img'],$row['title'],200)?></a> <a href="<?=$row['url']?>" dd-href="?mod=jump&act=s8&iid=<?=iid_encode($row['data_id'])?>&url=" data-itemid="<?=$row['data_id']?>" isconvert=1 class="btn-zdm-goshop J-item-track nodelog click_url" target="_blank">去购买</a> </div>
            <div class="item-info J-item-info">
              <div class="item-time"><?=$row['addtime']?></div>
              <?php if($row['cid_title']){?>
              <div class="item-type">分类：<a href="<?=u(MOD,ACT,array('code'=>$_GET['code'],'cid'=>$row['cid']))?>" class="nine" target="_blank"><?=$row['cid_title']?></a> </div>
              <?php }?>
              <?php if($row['laiyuan']!=''){?>
              <div class="item-type">所属：<a class="nine" ><?=$row['laiyuan']?></a></div>
              <?php }?>
              <div class="item-content J-item-content nodelog-detail" data-id="2">
                <div class="item-content-inner J-item-content-inner">
                  <?=$row['content']?>
                </div>
              </div>
              <div class="item-toggle" data-status="0" onclick="goodsItemToggle($(this))"><a href="javascript:void(0);" class="blue J-item-toggle">展开全文 ∨</a></div>
            </div>
            <div class="J-expend-wrap-before item-vote clearfix"> <em class="l item-vote-t">评价本文：</em>
            	<a href="javascript:void(0);" class="l item-vote-yes J-item-vote-yes vote" onclick="goodsVote($(this))" data-type="1"data-id="<?=$row['id']?>"><?=$row['ding']?></a>
                <a href="javascript:void(0);" class="l item-vote-no J-item-vote-no vote" onclick="goodsVote($(this))" data-type="0"data-id="<?=$row['id']?>"><?=$row['cai']?></a>
                <span class="l">大家在评论：</span>
               	<a href="javascript:void(0)" class="l item-view-comment J-expend-trigger" onclick="goodsComment($(this))" data-id="<?=$row['id']?>"><?=$row['pinglun']?></a>
              <div class="shopitem_main_r_6" style="float:right; width:auto;  margin-left:10px; margin-top:3px;"> <span style="float:left; font-size:12px; line-height: 30px;">分享：</span>
                <div class="bshare-custom" style="font-size:12px; margin-top:8px;"><a target="_blank" href="<?=$row['qzone_url']?>" title="分享到QQ空间" class="bshare-qzone">空间</a><a href="<?=$row['sina_url']?>" target="_blank" title="分享到新浪微博" class="bshare-sinaminiblog">新浪</a><a href="<?=$row['qqim_url']?>" target="_blank" title="分享到QQ好友" class="bshare-qqim">QQ</a><a href="<?=$row['qqmb_url']?>" target="_blank" title="分享到腾讯微博" class="bshare-qqmb">腾讯</a></div>
              </div>
            </div>
            <div class="J-expend-wrap yahei zdm-expand-wrap" style=" display:none"> <i class="top-arrow"></i>
              <div class="yahei zdm-expand-comment"> </div>
            </div>
            <a class="y-like my-like" style="top:67px; right:20px;" title="<?=$row['is_shoucang']==1?'已收藏':'加入收藏'?>" data_id="<?=$row['id']?$row['id']:$row['data_id']?>">
                <span class="like-ico <?=$row['is_shoucang']==1?'l-active':''?>"></span>
            </a>
          </div>
        </div>
        <?php }?>
        <?php }elseif(defined('VIEW_PAGE')){?>
       	<div class="empty_data">
          <div class="empty_ico">&nbsp;</div>
          <div class="empty_word">抱歉，没有找到相关商品。</div>
		  <div style="clear:both"></div>
        </div>
        <?php }?>     
      <?php if(defined('VIEW_PAGE')||$_GET['page']<=1){?>
      </div>
    </div>
    <?php include(TPLPATH.'/goods/zhi/right.tpl.php');?>
    <div style="clear:both"></div>
  </div>
</div>
<?php include(TPLPATH.'/inc/tdj.tpl.php');?>
<?php }?>