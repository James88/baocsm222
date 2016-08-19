<?php
if(!defined('INDEX')){
	exit('Access Denied');
}

$css[]=TPLURL."/inc/css/view.css";
$js[]="js/jQuery.autoIMG.js";
include(TPLPATH.'/inc/header.tpl.php');
?>
<script language="javascript" type="text/javascript" src="http://static.bshare.cn/b/buttonLite.js"></script>
<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC1.js"></script>
<script>
$(function(){
	var pic_url='<?=tb_img($goods['img'],310)?>';
	$('#goodspic').attr('src',pic_url);
	$(".shopright .shopitem_main_l").imgAutoSize(310,310);
	
	$('.my-like').click(function(){
		goodsShoucang($(this));
	});
});
</script>
<div class="mainbody">
	<div class="mainbody1000">
      <div class="shopright" style=" *margin-bottom:-10px;">
      <div class="biaozhun1" style="float:none;">
      <div class="bz_first"> <h3 class="c_border"><div class="shutiao c_bgcolor"></div><?=$goods['title']?><?php if(TAOTYPE==2){?>&nbsp;&nbsp;<span style="font-size:12px; font-family:宋体">【<a style="color:#F60;" href="<?=u('tao','list',array('cid'=>0,'q'=>$goods['title']))?>" target="_blank">查看同款商品</a>】</span><?php }?></h3></div>
      
      <div class="shopitem_main" style="*padding-bottom:15px;">
                    <div class="shopitem_main_l">
                    <a class="y-like my-like" title="<?=$goods['is_shoucang']==1?'已收藏':'加入收藏'?>" data_id="<?=$goods['iid']?>">
            	<span class="like-ico <?=$goods['is_shoucang']==1?'l-active':''?>"></span>
        	</a>
                    	<a class="spimng click_url" dd-href="?mod=jump&act=s8&iid=<?=iid_encode($goods['iid'])?>&url=" data-itemid="<?=$goods['iid']?>" isconvert=1 href="<?=$goods['jump']?>" target="_blank"><img id="goodspic" src="images/310.gif" alt="<?=$goods['title']?>" /></a>
                        <div class="tp_ab">
                            <?php if($goods['price_man']>0){?><div class="tp_bq tp_1"> <a href="<?=$goods['lq_url']?>" target="_blank"> <span>减<?=$goods['price_jian']?>元</span><br /><span class="span_1">满<?=$goods['price_man']?>元</span> </a> </div><?php }?>
							<?php if($goods['shouji_price']>0){?>
                            <div class="tp_bq tp_2">
                              <div class="inline" style="color:#fff;"> <span class="span_1"><?=$goods['price']-$goods['shouji_price']?>元</span><br />
                                <span>手机买再省</span> </div>
                            </div>
                            <?php }?>
                            <?php if($goods['is_fanli_ico']){?>
                            <div class="tp_bq tp_3"> <span class="span_1"><?=$goods['fanli']?></span><br />
                              <span>高返利</span> </div>
                            <?php }?>
                      	</div>
                    </div>
                    <div class="shopitem_main_r" style="position:relative;">
                    	<div class="shopitem_main_r_1"><img src="images/baozhang.gif" ></div>

                        <div class="shopitem_main_r_3" style="margin-top:10px"><span id="price_name" style="font-family:宋体"><?=$price_name?></span>：<span class="price" style="font-weight:bold"><?=$goods['price']?></span> 元<?php if(isset($goods['yuanjia']) && $goods['yuanjia']>0){?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="yuanjia">原价：<span style="text-decoration:line-through"><?=$goods['yuanjia']?></span> 元</span><?php }?></div>
                        
                        <?php if(FANLI==1){?>
                        <div class="shopitem_main_r_3" style="margin-top:10px"><?php if($has_fanli*$allow_fanli==0){?><span id="zuigaofan">温馨提示：</span> <img src="<?=TPLURL?>/inc/images/rebate_txt_no.png" alt="无返利" title="该商品无返利"><?php }else{?>
                        <!--<span id="zuigaofan">商品返利：</span> -->
                        <p class="rate-text" title="根据淘宝最新规则，查询返利时将不再显示具体返利<?=TBMONEY?>，但返利仍会正常发放，具体<?=TBMONEY?>以到账时为准">商品返利：</p> 
                        <!--<span style="color:#060">实际返利以成交价为准</span>-->
						<?php }?></div>
                        <?php }?>
                        <?php  if(count($goods['goods_attribute_arr'])>0){?>
                        <div class="inblock hiddens shopitem_main_r_3">
							<?php foreach($goods['goods_attribute_arr'] as $vo){
                            if($vo['ico']==''){?>
                            <span class="biaoqian" title="<?=$vo['beizhu']?>" <?=$vo['style']?>><?=$vo['title']?></span>
                            <?php }else{?>
                            <span class="biaoqian" title="<?=$vo['beizhu']?>"><img alt="<?=$vo['title']?>" src="<?=$vo['ico']?>"></span>
                            <?php }
                            }?>
                       <?php if(FANLI==1){?> <?php if($goods['fanli']>0){?><span class="biaoqian qingse"><?php if($goods['fanli_ico']==0){?>有返利<?php }else{?>买后返:<?=$goods['fanli']?><?php }?></span><?php }?> <?php }?>
                            </div>
                        <?php }?>
                        <div class="shopitem_main_r_3" style="margin-top:10px">近期销量： <?=$goods['volume']?> 件 </div>
                        <div class="shopitem_main_r_3" style="margin-top:10px">掌柜名称： <?=$goods['nick']?> </div>
                        <?php if(FANLI==1){?>
                        <div class="shopitem_main_r_5" style="margin-top:10px">温馨提示：虚拟商品如话费，游戏，机票等无返利哦！</div>
                        <?php }?>
                        <div class="shopitem_main_r_4" style="margin-top:15px">

                        <a href="<?=$goods['jump']?>" class="click_url" dd-href="?mod=jump&act=s8&iid=<?=iid_encode($goods['iid'])?>&url=" data-itemid="<?=$goods['iid']?>" isconvert=1 target="_blank"><img alt="立刻去购买" src="<?=TPLURL?>/inc/images/gomai.gif" /></a> 
                        <!--<a href="<?=$shop['jump']?>" target="_blank"><img alt="逛逛掌柜店铺" src="<?=TPLURL?>/inc/images/gozhanggui.gif" /></a>-->
                        </div>
                        <div class="shopitem_main_r_6">
                            <div class="bshare-custom" style="margin-top:7px; float:left; margin-left:10px;">
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
								summary: "<?=str_replace('"','',compact_html(strip_tags($goods['title'])))?>",
								pic: "<?=preg_match('/^http/',$goods['img'])?$goods['img']:SITEURL.'/'.$goods['img']?>"
							});
							</script>
                        </div>
                        <?php if($zhuanxiang==1){?>
                        <div title="使用手机扫描二维码购买，优惠<?=$shouji_youhui?>元" style="width:90px; height:90px;  position:absolute; top:90px; left:273px;">
                        <div style="margin-bottom:5px">手机省<b style="font-family: Arial; color:#F60; font-size:16px"><?=$shouji_youhui?></b>元</div>
                        <img src="<?=$qrcode?>" style="width:95%; height:95%; display:block" alt="二维码"  alt="使用手机扫描二维码购买，优惠<?=$goods['discount_price']-$goods['shouji_price']?>元"/>
                        </div>
                        <?php }?>
                    </div>
                    <div style="float:right; margin-right:25px;">
                    	<?=AD(7)?>
                    </div>
                </div>
      
      </div>
      <div class="" style="float:none; margin-top:10px; *margin-top:0px;">
      <div class="shopit_txt" style="width:1000px; margin-bottom:10px; margin-left:0px;">
        <ul style="width:1000px;" class="c_border">
        <li class="c_bgcolor"><a><?=$tuijian_lanmu_title?></a></li>
        </ul>
    <div class="shopit_txt_ms" style="background:#fff; padding-bottom:10px;">
        <div class="goods_list" style="margin-top:10px; margin-left:12px;">
        <?php foreach($tuijian_lanmu_goods as $row){?>
        <div class="goods ">
            <div class="goods_info">
                <a href="<?=$row['url']?>" target="_blank"><img alt="<?=$row['title']?>" src="<?=tb_img($row['img'],200)?>"></a>
                <div class="goods_title"><?=$row['title']?></div>
                <div class="buy_info">
                    <div class="price_info">
                        <div class="price">
                            ￥<span><?=$row['discount_price']?></span>
                        </div>
                        <div class="pays">
                            <span class="C_FF9997">原价￥<?=$row['price']?></span>
                        </div>
                    </div>
                    <a href="<?=$row['view']?>" target="_blank">
                    <div class="buy_btn">
                    </div>
                    </a>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
    </div>
</div>
</div>
       	
            </div>
            <?=AD(108)?>
        </div> 
	</div>
<div class="clear"></div>
<?php include(TPLPATH.'/inc/tdj.tpl.php');?>
<?php 
include(TPLPATH.'/inc/footer.tpl.php');
?>