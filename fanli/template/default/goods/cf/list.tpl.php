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
<div class="con_auto super-limit-area">
<div style="display:block;" class="goods_list_cf">
<!--这里必须定义一个goods_items-->
<div class="clearfix home-limit-box yahei goods_items">
<?php }?>
<?php if(!empty($goods_list)){?>
<?php foreach($goods_list as $row){?>
<div class="item-mod list-good">
               	<div>
               		<a href="<?=$row['url']?>" class="click_url" dd-href="?mod=jump&act=s8&iid=<?=iid_encode($row['data_id'])?>&url=" data-itemid="<?=$row['data_id']?>" isconvert=1 target="_blank"><?=dd_html_img($row['img'],$row['title'],320)?></a>
                	<a href="<?=$row['url']?>" class="click_url" dd-href="?mod=jump&act=s8&iid=<?=iid_encode($row['data_id'])?>&url=" data-itemid="<?=$row['data_id']?>" isconvert=1 target="_blank"><div class="title"><span class="red"><?=$row['zhe']?>折/</span><?=$row['title']?></div></a>
                </div>
                <div class="money desc">
                    <p class="price"> ¥<strong><?=$row['discount_price']?></strong><del>¥<?=$row['price']?></del></p>
                    <?php if(FANLI==1&&$row['fanli']){?>
                    <p class="fl clearfix" <?php if($row['fanli']>0){?>title="购买后返<?=$row['fanli'].$row['unit']?>"<?php }?>><strong>-<?=$row['fanli_je']?></strong><i class="i-gmhf">购买后返<span><?=(float)$row['fanli_bl']?>%</span></i></p>
                    <?php }?>
                </div>
                <a target="_blank" dd-href="?mod=jump&act=s8&iid=<?=iid_encode($row['data_id'])?>&url=" data-itemid="<?=$row['data_id']?>" isconvert=1 href="<?=$row['url']?>" class="click_url mod-btn <?php if($row['is_starttime']){?>jjstart<?php }else{ ?>ht<?php }?>"></a>
                <a class="y-like my-like xihuan" title="<?=$row['is_shoucang']==1?'已收藏':'加入收藏'?>" data_id="<?=$row['id']?$row['id']:$row['data_id']?>">
            <span class="like-ico <?=$row['is_shoucang']==1?'l-active':''?>"></span>
        </a>
            </div>
    
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
 </div>
    </div>
</div>
<?php include(TPLPATH.'/inc/tdj.tpl.php');?>
<?php }?>
