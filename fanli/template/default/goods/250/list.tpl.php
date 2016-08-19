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
?>
<div style="padding-top:10px;">
<div class="goods_list_250">
<!--这里必须定义一个goods_items-->
  <ul class="goods_items">
<?php }?>
<?php if(!empty($goods_list)){?>
<?php foreach($goods_list as $row){?>
    <li>
      <div class="list-good">
        <div class="left"> <a class="click_url" dd-href="?mod=jump&act=s8&iid=<?=iid_encode($row['data_id'])?>&url=" data-itemid="<?=$row['data_id']?>" isconvert=1 href="<?=$row['url']?>" target="_blank"><?=dd_html_img($row['img'],$row['title'],250)?>
        <?php if($row['is_top']){?><div class="n_top"></div><?php }?>
        <?php if($row['is_new']){?><div class="left_up"></div><?php }?>
        <?php if($row['is_starttime']){?>
        <div class="start_time" title="<?=date('Y-m-d H:i:s',strtotime($row['starttime']))?>开始"><?=$row['starttime_tag']?>开始</div>
        <?php }elseif($row['oversell']==1){?>
        <div class="yimaiguang"></div>
        <?php }elseif($row['is_endtime']){?>
        <div class="end_time"></div>
        <?php }?>
        </a>
          <div class="tp_ab">
            <?php if($row['price_man']>0){?><div class="tp_bq tp_1 dd_cure"> <a href="<?=$row['lq_url']?$row['lq_url']:'javascript:void(0)'?>" target="_blank"> <span class="span_1">满<?=$row['price_man']?>元</span><br /><span>减<?=$row['price_jian']?>元</span> </a> </div><?php }?>
            <?php if($row['shouji_price']>0 && ($row['discount_price']-$row['shouji_price']>1)){?>
            <div class="tp_bq tp_2 erweima dd_cure click_url" id="<?=$row['id']?>&uid=<?=$dduser['id']?>" dd-href="?mod=jump&act=s8&iid=<?=iid_encode($row['data_id'])?>&url=" data-itemid="<?=$row['data_id']?>" isconvert=1 url="<?=$row['url']?>" youhui="<?=$row['shouji_price_cha']?>">
                <div class="inline" style="color:#fff;">
                    <span>手机买再省</span><br />
                    <b class="span_1"><?=$row['shouji_price_cha']?>元</b>
                </div>
            </div>
            <?php }?>
            <?php if($row['is_fanli_ico']&&FANLI==1){?>
            <div class="tp_bq tp_3"> 
            <span>高额返利</span>
            </div>
            <?php }?>
          </div> 
        </div>
        <?php /*?><?php if($row['opca']){?>
        <div class="opca"></div>
		<?php }?><?php */?>
        <a href="<?=$row['url']?>" class="click_url" dd-href="?mod=jump&act=s8&iid=<?=iid_encode($row['data_id'])?>&url=" data-itemid="<?=$row['data_id']?>" isconvert=1 target="_blank">
        <div class="jy_title"><?=$row['title']?></div>
        </a>
        <div class="jy_nr">
          <div class="jy_price">
          	<div class="inblock">¥<span><?=number_format($row['discount_price'],1)?></span></div>
            <div class="inblock">
                <del><?=$row['price']?></del><span class="dazhe">(<?=$row['zhe']?>折)</span>
            </div>
            <div class="inblock" style="float:right;">
                <div class="jy_w_buy">
                    <?php if($row['laiyuan_type']==1){?><div title="<?=$row['laiyuan']?>" class="tb"><i></i><?=$row['laiyuan']?></div><?php }?>
                    <?php if($row['laiyuan_type']==2){?><div title="<?=$row['laiyuan']?>" class="tmall"><i></i><?=$row['laiyuan']?></div><?php }?>
                    <?php if($row['laiyuan_type']==3){?><div title="<?=$row['laiyuan']?>" class="jd"><i></i><?=$row['laiyuan']?></div><?php }?>
                    <?php if($row['laiyuan_type']==4){?><div title="<?=$row['laiyuan']?>" class="paipai"><i></i><?=$row['laiyuan']?></div><?php }?>
                </div>
            </div>
          </div>
          <div class="jy_del">
                <div class="inblock hiddens">
				<?php foreach($row['goods_attribute_arr'] as $vo){
                if($vo['ico']==''){?>
                <span class="biaoqian" title="<?=$vo['beizhu']?>" <?=$vo['style']?>><?=$vo['title']?></span>
                <?php }else{?>
                <span class="biaoqian" title="<?=$vo['beizhu']?>"><img alt="<?=$vo['title']?>" src="<?=$vo['ico']?>"></span>
                <?php }
                }?>
            <?php if(FANLI==1){?><span class="biaoqian qingse" <?php if($row['fanli']>0){?>title="购买后返<?=$row['fanli'].$row['unit']?>"<?php }?>><?php if($row['fanli']==0){?>有返利<?php }else{?>买后返:<?=$row['fanli']?><?php }?></span><?php }?>
                </div>
                <?php if($row['sell']){?>
                <div class="inblock" style="float:right;">
                    <div class="jy_w_buy">
                        <div class="yishou">已售<?=$row['sell']?></div>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
        <a class="y-like my-like" title="<?=$row['is_shoucang']==1?'已收藏':'加入收藏'?>" data_id="<?=$row['id']?$row['id']:$row['data_id']?>">
            <span class="like-ico <?=$row['is_shoucang']==1?'l-active':''?>"></span>
        </a>
        <div class="jy_fx">
                	<div class="bshare-custom" style="font-size:12px"><a id="bshare-shareto" class="bshare-more">分享：</a><a target="_blank" href="<?=$row['qzone_url']?>" title="分享到QQ空间" class="bshare-qzone">空间</a><a href="<?=$row['sina_url']?>" target="_blank" title="分享到新浪微博" class="bshare-sinaminiblog">新浪</a><a href="<?=$row['qqim_url']?>" target="_blank" title="分享到QQ好友" class="bshare-qqim">QQ</a><a href="<?=$row['qqmb_url']?>" target="_blank" title="分享到腾讯微博" class="bshare-qqmb">腾讯</a></div>
                </div>
      </div>
    </li>
    <?php }?> 
    <?php }elseif(defined('VIEW_PAGE')){?>
       	<div class="empty_data">
          <div class="empty_ico">&nbsp;</div>
          <div class="empty_word">抱歉，没有找到相关商品。</div>
		  <div style="clear:both"></div>
        </div>
        <?php }?>

<?php if(defined('VIEW_PAGE')||$_GET['page']<=1){
?>
</ul>
<div style="clear:both"></div>
</div></div>
<?php include(TPLPATH.'/inc/tdj.tpl.php');?>
<?php }?>