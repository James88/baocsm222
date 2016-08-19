<?php  //多多
if(!defined('INDEX')){
	exit('Access Denied');
}
$parameter=dd_act();
extract($parameter);
//淘宝商品
if($goods['laiyuan_type']==1||$goods['laiyuan_type']==2){
	if($webset['taodianjin_pid']==''){
		jump('http://item.taobao.com/item.html?id='.$goods['data_id']);
	}
	if(!isset($ddTaoapi)){
		$ddTaoapi=new ddTaoapi();
	}
	$tao_goods=$ddTaoapi->taobao_tbk_tdj_get($goods['data_id'],1,1);
	if($tao_goods['ds_title']==''){
		$duoduo->update('goods',array('endtime'=>time()),'id="'.$goods['id'].'"');
		error_html('商品已下架',-1,1);
	}
	$goods['sell']=$tao_goods['ds_sell']?$tao_goods['ds_sell']:$goods['sell'];
	$goods['nick']=$tao_goods['ds_nick']?$tao_goods['ds_nick']:$goods['nick'];
	$goods['shop_jump']='';
}
elseif($goods['laiyuan_type']==3){
	//京东商品
}
elseif($goods['laiyuan_type']==3){
	//拍拍商品
}
$tuijian_lanmu_title='推荐商品';
$tuijian_lanmu_goods=$goods_class->index_list(array('code'=>$goods['code']),5,1,"code='".$goods['code']."' and id!=".$goods['id']);
foreach($tuijian_lanmu_goods as $k=>$row){
	if($row['data_id']!=$goods['data_id']){
		$tuijian_lanmu_goods[$k]['view']=u('tao','view',array('iid'=>iid_encode($row['data_id'])));
	}
}
if(count($tuijian_lanmu_goods)>5){
	unset($tuijian_lanmu_goods[5]);
}

$css[]=TPLURL."/inc/css/view.css";
$js[]="js/jQuery.autoIMG.js";
include(TPLPATH.'/inc/header.tpl.php');
?>
<script>
$(function(){
	var pic_url='<?=tb_img($goods['img'],310)?>';
	$('#goodspic').attr('src',pic_url);
	$(".shopright .shopitem_main_l").imgAutoSize(310,310);
	
	$('.my-like').click(function(){
		goodsShoucang($(this));
	});
	$('.tx_title .tx_saomiao').hover(function(){
		$(this).find('.tx_erweima').show();
	},function(){
		$(this).find('.tx_erweima').hide();
	})
});
</script>
<script language="javascript" type="text/javascript" src="http://static.bshare.cn/b/buttonLite.js"></script>
<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC1.js"></script>
<div class="mainbody">
  <div class="mainbody1000">
    <div class="shopright" style=" *margin-bottom:-10px;">
      <div class="biaozhun1" style="float:none;">
        <div class="bz_first" style="border-bottom:1px solid #ccc;">
          <h3 class="c_border erweima">
            <div class="shutiao c_bgcolor"></div><?=$goods['title']?>
          </h3>
        </div>
        <div class="shopitem_main" style="*padding-bottom:15px;">
          <div class="shopitem_main_l"> <a class="spimng click_url" dd-href="?mod=jump&act=s8&iid=<?=iid_encode($goods['data_id'])?>&url=" data-itemid="<?=$goods['data_id']?>" isconvert=1 target="_blank" href="<?=$goods['jump']?>" ><img id="goodspic" src="images/310.gif" alt="<?=$goods['title']?>" /></a>
          	<a class="y-like my-like" title="<?=$goods['is_shoucang']==1?'已收藏':'加入收藏'?>" data_id="<?=$goods['id']?$goods['id']:$goods['data_id']?>">
            	<span class="like-ico <?=$goods['is_shoucang']==1?'l-active':''?>"></span>
        	</a>
            <div class="tp_ab">
              <?php if($goods['price_man']>0){?>
              <div class="tp_bq tp_1 dd_cure"> <a target="_blank" href="<?=$goods['lq_url']?$goods['lq_url']:'javascript:void(0)'?>" > 
               <span class="span_1">满<?=$goods['price_man']?>元</span><br />
               <span>减<?=$goods['price_jian']?>元</span>
              </a> 
              </div>
              <?php }?>
              <?php if($goods['shouji_price']>0 && ($goods['discount_price']-$goods['shouji_price']>1)){?>
              <div class="tp_bq tp_2 erweima dd_cure" id="<?=$goods['id']?>&uid=<?=$dduser['id']?>" url="<?=$goods['url']?>" youhui="<?=$goods['shouji_price_cha']?>">
                <div class="inline" style="color:#fff;"> 
                  <span>手机买再省</span><br />
                  <b class="span_1"><?=$goods['shouji_price_cha']?>元</b></div>
              </div>
              <?php }?>
              <?php if($goods['is_fanli_ico']&&FANLI==1){?>
              <div class="tp_bq tp_3"> 
                <span>高额返利</span>
                </div>
              <?php }?>
            </div>
          </div>
          <div class="shopitem_main_r" style="position:relative;">
            <div class="shopitem_main_r_1"><img src="<?=TPLURL?>/inc/images/n_baozhang.png" ></div>
            <?php if($goods['discount_price']>0){?>
            <div class="shopitem_main_r_3" style="margin-top:10px"> <span id="price_name" style="font-family:宋体"><span class="tbcuxiao"><i><?=$bankuai_title?></i></span></span>：
              <span class="price" style=" font-size:22px">
              <?=$goods['discount_price']?>
              </span> 元
              <?php if(isset($goods['price']) && $goods['price']>0){?>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="yuanjia">原价：<span style="text-decoration:line-through">
              <?=$goods['price']?>
              </span> 元</span>
              <?php }?>
            </div>
            <?php }?>
            <?php if($goods['goods_attribute_arr']||FANLI==1){?>
            <div class="inblock hiddens shopitem_main_r_3" style="margin-top:10px">
              <?php foreach($goods['goods_attribute_arr'] as $vo){
                            if($vo['ico']==''){?>
              <span class="biaoqian" title="<?=$vo['beizhu']?>" <?=$vo['style']?>>
              <?=$vo['title']?>
              </span>
              <?php }else{?>
              <span class="biaoqian" title="<?=$vo['beizhu']?>"><img style="height:29px;" alt="<?=$vo['title']?>" src="<?=$vo['ico']?>"></span>
              <?php }
               }?>
              <?php if(FANLI==1){?><span class="biaoqian qingse" <?php if($goods['fanli']>0){?>title="购买后返<?=$goods['fanli'].$goods['unit']?>"<?php }?>><?php if($goods['fanli']==0){?>有返利<?php }else{?>买后返:<?=$goods['fanli']?><?php }?></span><?php }?>
            </div>
            <?php }?>
            <?php if($goods['sell']>0){?>
            <div class="shopitem_main_r_3" style="margin-top:10px">近期销量：<?=$goods['sell']?> 件 </div>
            <?php }?>
            <div class="shopitem_main_r_3" style="margin-top:10px">所属商城：<?=$goods['laiyuan']?></div>
            <?php if(FANLI==1){?>
            <div class="shopitem_main_r_5" style="margin-top:10px">温馨提示：虚拟商品如话费，游戏，机票等无返利哦！</div>
            <?php }?>
            <?php if($goods['is_starttime']){?>
            <div class="shopitem_main_r_4" style="margin-top:15px">
            	<div class="dingshi"><?=$goods['starttime_tag']?>开始抢购</div>
            </div>
             <?php }else{?>
            <div class="shopitem_main_r_4" style="margin-top:15px;"><a target="_blank" class="click_url" dd-href="?mod=jump&act=s8&iid=<?=iid_encode($goods['data_id'])?>&url=" data-itemid="<?=$goods['data_id']?>" isconvert=1 href="<?=$goods['jump']?>" ><img alt="立刻去购买" src="<?=TPLURL?>/inc/images/n_gomai.gif" /></a>
              <?php if($goods['laiyuan_type']<=2){?>
              <a target="_blank" href="<?=$goods['shop_jump']?>" class="click_url" dd-href="?mod=jump&act=s8&url=" data-sellerid="<?=$tao_goods['ds_user_id']?>" isconvert=1><img alt="逛逛掌柜店铺" src="<?=TPLURL?>/inc/images/gozhanggui.gif" /></a>
              <?php }?>
            </div>
           <?php }?>
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
    summary: "<?=str_replace('"','',compact_html(strip_tags($goods['content'])))?>",
    pic: "<?=preg_match('/^http/',$goods['img'])?$goods['img']:SITEURL.'/'.$goods['img']?>"
});
</script>
            </div>
          </div>
          <?php if($goods['is_starttime']){?>
          <div style="float:right; margin-right:25px; width:200px; padding:0 10px;">
          	<div class="tixing"></div>
            <div class="tx_gt">
            	<div class="tx_top">
                	<div class="tx_title">
                    	<div class="tx_bt" style="float:left;">QQ提醒:</div>
                        <div style="float:left; width:104px;">
                        <script type="text/javascript">
						var __qqClockShare = {
						   content: "亲你关注的<?=utf_substr($goods['title'],27)?>...将在5分钟后以<?=$goods['discount_price']?$goods['discount_price']:$goods['price']?>价格开抢，请及时做好抢购准备！点击",
						   time: "<?=date('Y-m-d H:i',strtotime($goods['starttime']))?>",
						   advance: 5,
						   url: "<?=$goods['_url']?>",
						   icon: "1_1"
						};
						document.write('<a href="http://qzs.qq.com/snsapp/app/bee/widget/open.htm#content=' + encodeURIComponent(__qqClockShare.content) +'&time=' + encodeURIComponent(__qqClockShare.time) +'&advance=' + __qqClockShare.advance +'&url=' + encodeURIComponent(__qqClockShare.url) + '" target="_blank"><img src="http://i.gtimg.cn/snsapp/app/bee/widget/img/' + __qqClockShare.icon + '.png" style="border:0px;"/></a>');
						
						</script>
                        </div>
                    </div>
                	<div class="tx_title" style="font-size:12px;">设置提醒后会以QQ消息形式提醒</div>
                </div>
                <?php if($dd_tpl_data['erweima']){?>
                <div class="tx_top">
                	<div class="tx_title">
                    	<div class="tx_bt">微信提醒:</div>
                        <div class="tx_saomiao">
                        	<div class="tx_erweima">
                            	<img src="<?=$dd_tpl_data['erweima']?>" />
                            </div>
                        </div>
                    </div>
                	<div class="tx_title" style="font-size:12px;">打开微信扫描下微信公众号定期推送消息</div>
                </div>
                <?php }?>
                <?php if($goods['phone_app_status']>0){?>
                <div class="tx_top">
                	<div class="tx_title">
                    	<div class="tx_bt">APP提醒:</div>
                        <a href="<?=SITEURL?>/index.php?mod=app&act=index" target="_blank"><div class="tx_down"></div></a>
                    </div>
                	<div class="tx_title" style="font-size:12px;">下载手机客户端，随时随地可查看</div>
                </div>
                <?php }?>
            </div>
          </div>
          <?php }else{?>
          <div style="float:right; margin-right:25px;">
            <?=AD(5)?>
          </div>
          <?php }?>
        </div>
      </div>
      <div class="" style="float:none; margin-top:10px; *margin-top:0px;">
        <div class="shopit_txt" style="width:1000px; margin-bottom:10px; margin-left:0px;">
          <ul style="width:1000px;" class="c_border">
            <li class="c_bgcolor"><a>
              <?=$tuijian_lanmu_title?>
              </a></li>
          </ul>
          <div class="shopit_txt_ms" style="background:#fff; padding-bottom:10px;">
            <div class="goods_list" style="margin-top:10px; margin-left:12px;">
              <?php foreach($tuijian_lanmu_goods as $row){?>
              <div class="goods ">
                <div class="goods_info">
                  <?php if($row['goods_attribute'][1]==2){?>
                  <?php }?>
                  <a href="<?=$row['url']?>" ><img alt="<?=$row['title']?>" src="<?=tb_img($row['img'],200)?>"></a>
                  <div class="goods_title">
                    <?=$row['title']?>
                  </div>
                  <div class="buy_info">
                    <div class="price_info">
                      <div class="price"> ￥<span>
                        <?=$row['discount_price']?>
                        </span> </div>
                      <div class="pays"> <span class="C_FF9997">原价￥
                        <?=$row['price']?>
                        </span> </div>
                    </div>
                    <a href="<?=$row['url']?>" >
                    <div class="buy_btn"> </div>
                    </a> </div>
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
<?php if($goods['shouji_price']>0 && ($goods['discount_price']-$goods['shouji_price']>1)){?>
<script>
$(function(){
	$(".erweima").jumpBox({  
		LightBox:'show',
		height:220,
		width:380,
		defaultContain:1,
		jsCode:'if(shoujiBuy($(this))==false){var jumpBoxStop=1;}'
	});
})
</script>
<?php }?>
<?php include(TPLPATH.'/inc/tdj.tpl.php');?>
<?php include(TPLPATH.'/goods/jumpbox.tpl.php');?>
<?php 
include(TPLPATH.'/inc/footer.tpl.php');
?>
