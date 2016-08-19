<?php
$parameter=act_mall_view(6,8);
extract($parameter);

$css[]=TPLURL."/inc/css/mall_view.css";
$css[]=TPLURL."/goods/250/css/list.css";
include(TPLPATH.'/inc/header.tpl.php');
?>
<script>
var page = 1;
function comment_html(){/*<div class="detail_pl">
                <div class="l"> <a><img src="{$src}" /></a> </div>
                <div class="l">
                  <p class="hyname">{$ddusername}</p>
                  <p>{$content}</p>
                  <p class="time">{$addtime}</p>
                </div>
              </div>*/;}
$(function(){
	$('#click_more').click(function(){
		$('#click_more').html('正在获取评论。。');
		 $.ajax({
			  url: "<?=u('ajax','get_mall_comments')?>",
			  data:{page:page,pagesize:10,id:<?=$mall['id']?>},
			  dataType:'jsonp',
			  jsonp:"callback",
			  success: function(data){
				  if(data.s==0){
					  alert('获取失败,请刷新页面');
					  $('#click_more').hide();
				  }
				  else if(data.s==1){ 
					  commentHtml=getTplObj(comment_html,data.r);
					  $('#mall_content').append(commentHtml);
					  if(data.next==0){
					  	$('#click_more').hide();
					  }else{
					  	$('#click_more').html('点击加载更多');
					  }
				  }
			   }
		  });
		 page++;
	});
	
	LazyLoad();
})
function mallItemToggle($t){
	var a=$t.attr('data-status');
	if(a==0){
		$t.find('a').html('收起全文 ∧');
		var $p=$t.prev('.nodelog-detail');
		$p.css('max-height','none');
		$t.attr('data-status',1);
	}
	else{
		$t.find('a').html('展开全文 ∨');
		var $p=$t.prev('.nodelog-detail');
		$p.css('max-height','230px');
		$t.attr('data-status',0);
	}
}
</script>
<div class="m_v">
  <div class="m_v-banner" style="background:url(<?=$mall['banner']?$mall['banner']:TPLURL.'/inc/images/bg-top.jpg'?>) no-repeat;background-position:top center;">
    <div class="m_v_container">
      <div class="logo-panel"> 
      	<a href="<?=$jump?>" class="logo-box" target=_blank> <img src="<?=$mall['img']?>" /> </a>
         <?php if(FANLI==1){?><?php if($webset['jiaocheng']['mall']!=''){?><div class="fav-status"> <a href="<?=$webset['jiaocheng']['mall']?>" target="_blank">返利教程</a> </div><?php }?><?php }?>
        <div class="wuguan"><span><img src="<?=TPLURL?>/inc/images/<?=$mall['ico']?>.png" /></span><?php if($mall['renzheng']==1){?><span><img src="<?=TPLURL?>/inc/images/renzheng.png" /></span><?php }?></div>
      <?php if($dd_tpl_data['jiaocheng']['cookie']!=''){?><div style="margin-top:10px"><a href="<?=$dd_tpl_data['jiaocheng']['cookie']?>" target="_blank">怎样清除cookie</a></div><?php }?>
      </div>
      <div class="desc-wrap">
        <div class="desc-inner">
          <div class="desc-cont"><?=$mall['des']?></div>
        </div>
      </div>
      <div class="fanli-info">
        <?php if(FANLI==1){?><div class="money fanli-numb"> <span class="range">最高</span> <span class="prefix">返利</span> <span class="amount"><?=$mall['fan']?></span> <span class="units"></span> <span class="nofanli"></span> </div><?php }?>
        <a target="_blank" class="btn-go-shop" href="<?=$jump?>"><?php if(FANLI==1){?>返利模式购买<?php }else{?>进入商城<?php }?></a> </div>
        
    </div>
  </div>
  <div class="ad_sm"><?=AD(6)?> </div>
  <div class="shop-detail-wrap">
    <div class="m_v_container">
      <div class="detail-info-wrap">
        <h3 class="t c_border"><div class="shutiao c_bgcolor"></div><?=$mall['title']?></h3>
        <div class="detail-info-box">
          <div class="detail-info-nr nodelog-detail item-content" data-id="1">
          	<div id="zhenshi_content" style="padding:10px 0;">
             <?=$mall['content']?>
         </div>
          </div>
          <div onclick="mallItemToggle($(this))" data-status="0" class="item-toggle" style="display:none"><a href="javascript:void(0);" class="detail-info-a">展开全文 ∨</a></div>
          <script>
          var pp=document.getElementById("zhenshi_content").offsetHeight;
		  if(pp>=230){
		  	$('.item-toggle').css('display','block');
		  }
          </script>
          </div>
      </div>
    </div>
  </div>
  
  <div class="shop-detail-wrap">
    <div class="m_v_container">
      <div class="detail-info-wrap">
        <div class="detail_pp c_border2">
            <input class="in_text" type="text" id="comment" value="" />
            <input class="in_btn c_bgcolor" type="button" value="发表评论" <?php if($dduser['name']==''){?> onclick="alert('登陆后才能评论！');window.location='<?=u('user','login')?>&url='+encodeURIComponent(window.location.href)" <?php }else{?>onclick="saveComment()"<?php }?>/>
            <div style="clear:both;"></div>
          <div class="nodelog-detail item-content" data-id="2" id="mall_content">
          <div id="zhenshi_comment" style="overflow:hidden">
          <?php foreach($mall_comment as $arr){?>
              <div class="detail_pl">
                <div class="l"> <a><img src="<?=a($arr['id'])?>" /></a> </div>
                <div class="l">
                  <p class="hyname"><?=utf_substr($arr['ddusername'],2).'***'?></p>
                  <p><?=$arr['content']?></p>
                  <p class="time"><?=date('Y-m-d H:i:s',$arr['addtime'])?></p>
                </div>
              </div>
          <?php }?>
          </div>
          </div>
          <?php if($mall_comment_total>3){?>
          	<div id="click_more" class="c_bgcolor">点击加载更多</div>
          <?php }?>
      </div>
    </div>
  </div>
  
  <?php if(!empty($goods)){?>
  <div class="shop-detail-wrap">
    <div class="m_v_container">
      <div class="detail_tt">本商城热卖商品</div>
      <div class="goods_list_250 list-good">
        <ul class="goods_items">
        <?php foreach($goods as $row){?>
          <li>
<div class="list-good">
<div class="left">
<a href="<?=$row['url']?>" target="_blank"><?=dd_html_img($row['img'],$row['title'],310)?></a>
<?php if($row['is_new']){?><div class="left_up"></div><?php }?>
<?php if($row['is_starttime']){?>
<div class="start_time" title="<?=date('Y-m-d H:i:s',strtotime($row['starttime']))?>开始"><?=$row['starttime_tag']?>开始</div>
<?php }elseif($row['oversell']==1){?>
<div class="yimaiguang"></div>
<?php }elseif($row['is_endtime']){?>
<div class="end_time" title="于<?=$row['endtime']?>结束"></div>
<?php }?>
<div class="tp_ab">
	<?php if($row['price_man']>0){?>
	<div class="tp_bq tp_1">
        <a href="<?=$row['lq_url']?$row['lq_url']:'javascript:void(0)'?>" target="_blank"> <span class="span_1">满<?=$row['price_man']?>元</span><br /><span>减<?=$row['price_jian']?>元</span> </a>
    </div>
    <?php }?>
    <?php if($row['shouji_price']>0 && $row['shouji_price']<$row['discount_price']){?>
    <div class="tp_bq tp_2 erweima"  id="<?=$row['id']?>&uid=<?=$dduser['id']?>" url="<?=$row['url']?>" youhui="<?=$row['discount_price']-$row['shouji_price']?>">
    	<div class="inline" style="color:#fff;">
            <span>手机买再省</span><br />
            <b class="span_1"><?=$row['discount_price']-$row['shouji_price']?>元</b>
        </div>
    </div>
    <?php }?>
    <?php if($row['is_fanli_ico']){?>
    <div class="tp_bq tp_3">
        <span>高额返利</span>
    </div>
    <?php }?>
</div>
<?php if($row['top']>0){?><div class="n_top"></div><?php }?>
</div>
<?php if($row['opca']){?>
<div class="opca"></div>
<?php }?>
<a href="<?=$row['url']?>" target="_blank"><div class="jy_title"><?=$row['title']?></div></a>
<div class="jy_nr">
<div class="jy_price">
	<div class="inblock">
		¥<span><?=number_format($row['discount_price'],1)?></span>
    </div>
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
         
        </ul>
      </div>
    </div>
  </div>
  <?php }?>
  
  <div class="shop-detail-wrap">
    <div class="m_v_container">
      <div class="detail_tt">您可能喜欢的商城</div>
      <div class="gxq_pp">
      	<ul>
        	<?php foreach($malls as $row){?>
        	<li>
            	<a style="float:left;" title="<?=$row['title']?>" target="_blank" href="<?=u('mall','view',array('id'=>$row['id']))?>"><img alt="<?=$row['title']?>" src="<?=$row['img']?>" /></a>
                <?php if(FANLI==1){?><span>最高返利<?=$row['fan']?></span><?php }else{?><span><?=$row['title']?></span><?php }?>
            </li>
            <?php }?>
        </ul>
      </div>
    </div>
  </div>
</div>
</div>
<script>
function cpmmentTpl(){/*<div class="detail_pl">
                <div class="l"> <a><img src="{$avatar}" /></a> </div>
                <div class="l">
                  <p class="hyname">{$ddusername}</p>
                  <p>{$content}</p>
                  <p class="time">{$addtime}</p>
                </div>
              </div>*/;}

function saveComment(){
    var fen=parseInt($('#qualityScore').val());
	var comment=$('#comment').val();
	var mallId=<?=$id?>;
	htmlFen='';
	$.ajax({
		url: '<?=u('ajax','mall_comment')?>',
		data:{'mall_id':mallId,'fen':fen,'comment':comment},
		dataType:'jsonp',
		jsonp:"callback",
		success: function(data){//alert(data);
			if(data.s==0){
			    alert(errorArr[data.id]);
				if(data.id==73){
				    helpWindows('亲，您最多评论三次！','<?=$webset['webnick']?>小助手');
				}
			}
			else if(data.s==1){
				//alert('评论成功');
			    //location.replace(location.href);
				$('#comment').val('');
				var html=getTplObj(cpmmentTpl,data.r);
				$('#zhenshi_comment').prepend(html);
			}
		}
	});
}
</script>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>