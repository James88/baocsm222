<?php
$parameter=act_baobei_view();
extract($parameter);
$css[]=TPLURL.'/inc/css/baobei.css';
$css[]=TPLURL.'/goods/315/css/list.css';
$css[]=TPLURL.'/inc/css/shai_n.css';
$css[]='css/qqFace.css';

$js[]=TPLURL.'/inc/js/jquery.infinitescroll.js';
$js[]=TPLURL.'/inc/js/jquery.masonry.js';
include(TPLPATH.'/inc/header.tpl.php');
$num=$webset['baobei']['comment_word_num'];
$comment_tip='亲，登陆后才可评论哦！';
?>
<script language="javascript" type="text/javascript" src="http://static.bshare.cn/b/buttonLite.js"></script>
<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC1.js"></script>
<script type="text/javascript" src="js/scrollpagination.js"></script>
<script type="text/javascript">
$(function(){
	$('img.lazy').lazyload({
		threshold:20,
		failure_limit:50,
		effect : "fadeIn"
	});
})
</script>
<script type="text/javascript">
function comment_html(){/*<div class="n_hnr">
            <div class="items clearfix">
              <div class="items-l"> <a href="{$user_url}" target="_blank"><img class="items-face" src="{$user_img}"></a> </div>
              <div class="items-r l">
                <div><span class="name"><a href="{$user_url}" target="_blank">{$ddusername}</a></span><span class="l time"><i>{$_addtime}</i></span></div>
                <div><span class="detail">{$_comment}</span></div>
              </div>
            </div>
          </div>*/;}
function items_masonry(){ 
	$('.item_list img').load(function(){ 
		$('.infinite_scroll').masonry({ 
			itemsSelector: '.masonry_brick',
			columnWidth:243,
			gutterWidth:12						
		});		
	});
	$('.infinite_scroll').masonry({ 
		itemsSelector: '.masonry_brick',
		columnWidth:243,
		gutterWidth:12								
	});	
}
$(function(){
	function items_callback(){ 
		items_masonry();	
	}
	items_callback();  
});

num=<?=$num?>;
commentTip='<?=$comment_tip?>';
username='<?=$dduser['name']?>';
var page = 2;
$(function(){
	$('#click_more').click(function(){
		$('#click_more').html('正在获取评论。。');
		 $.ajax({
			  url: "<?=u('ajax','get_comments')?>",
			  data:{page:page,id:<?=$id?>},
			  dataType:'jsonp',
			  jsonp:"callback",
			  success: function(data){
				  if(data.s==0){
					  alert('获取失败,请刷新页面');
					  $('#click_more').hide();
				  }
				  else if(data.s==1){ 
					  commentHtml=getTplObj(comment_html,data.r);
					  $('.n_huifu').append(commentHtml);
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
	<?php if($dduser['id']==0){?>
	$('#<?=$comment_id?>').attr('title','登陆后才可评价宝贝');
	<?php }elseif($dduser['level']<$webset['baobei']['share_level']){?>
	$('#<?=$comment_id?>').attr('disabled',true).attr('title','等级达到<?=$webset['baobei']['share_level']?>才可评价宝贝');
	<?php }?>

	$('#noComment').click(function(){
		if(confirm('登陆才能评论，马上登陆？')){
			window.location='<?=u('user','login')?>&from='+encodeURIComponent(location.href);
		}						   
	});
	$('#noLevelComment').click(function(){
	    alert(errorArr[21]);
		helpWindows('每次成功购物级别都可增加<b>1</b>，亲加油吧！','<?=WEBNAME?>小助手');
	});
	$('#noLevelComment').click(function(){
		alert(errorArr[21]);
	});
	$('#StartComment').click(function(){
		var comment=$('#comment').val();
		if(comment==commentTip || comment==''){
		    alert(errorArr[27]);
		}
		else{
			$(this).attr('disabled','disabled');
		    $.ajax({
	            url: "<?=u('ajax','save_share_comment')?>",
		        data:{comment:comment,id:<?=$id?>},
		        dataType:'jsonp',
				jsonp:"callback",
		        success: function(data){
			        if(data.s==0){
						$(this).attr('disabled',false);
			            alert(errorArr[data.id]);
						if(data.id==73){
						    helpWindows('亲，您最多评论三次！','<?=WEBNAME?>小助手');
						}
			        }
			        else if(data.s==1){
			            alert('提交成功');
					    location.replace(location.href);//closeShare();
			        }
		         }
	        });
		}
	});
})
</script>
<div style="width:1000px; margin:auto; margin-top:10px;">
  <div style="width:757px; float:left;">
    <div class="shai_n_l" style="background:#fff;">
      <div class="img_l"> <img src="<?=tb_img($baobei['userimg'],400)?>" alt="<?=$baobei['title']?>" title="<?=$baobei['title']?>"/> </div>
       </div>
    <div class="shai_n_l" style="border-top:0 none; padding-bottom:20px; height:auto;background:#fff;">
      <div class="detail_pp">
        <textarea class="in_text" onfocus="if(this.value=='<?=$comment_tip?>')this.value=''" id="comment"><?=$dduser['id']?'':$comment_tip?></textarea>
        <input class="in_btn c_bgcolor" type="button" id="<?=$comment_id?>" value="发表评论">
        <div style="clear:both;"></div>
      </div>
      <div class="sdwrap">
        <div class="n_huifu">
          <?php if($comment_total>0){?>
          <?php foreach($comment_arr as $v){?>
          <div class="n_hnr">
            <div class="items clearfix">
              <div class="items-l"> <a href="<?=$v['user_url']?>" target="_blank"><img class="items-face" src="<?=$v['user_img']?>"></a> </div>
              <div class="items-r l">
                <div><span class="name"><a href="<?=$v['user_url']?>" target="_blank"><?=utf_substr($v['ddusername'],2).'***'?></a></span><span class="l time"><i><?=$v['_addtime']?></i></span></div>
                <div><span class="detail"><?=$v['_comment']?></span></div>
              </div>
            </div>
          </div>
          <?php }?>
          
          <?php }else{?>
          <div style="text-align:center; font-size:16px; color:#b5b5b5;">暂无评论</div>
		 <?php }?>
        </div>
        <?php if($comment_total>10){?>
          	<div id="click_more">点击加载更多</div>
          <?php }?>
      </div>
      <!--<div class="fy_page"> <a href="#"><span class="yifanye">上一页</span></a> <a href="#"><span>1</span></a> <a href="#"><span class="yifanye">2</span></a> <a href="#"><span class="yifanye">下一页</span></a> </div>-->
    </div>
    <div class="shai_like"> <span><i class="caini hot_buy">猜你喜欢</i><!--热门标签:<a href="#">铅笔裤</a><a href="#">斜挎包</a><a href="#">松糕鞋</a><a href="#">平底鞋</a><a href="#">甜美</a><a href="#">发箍</a>--></span>
      <div class="demo clearfix">
        <div class="item_list infinite_scroll">
          <?php foreach($orther_baobei as $v){?>
          <div class="item masonry_brick">
            <div class="item_t">
              <div class="img tb_img"> <a href="<?=$v['url']?>" target="_blank"><?=dd_html_img($v['userimg'],$v['title'],'200')?></a> <span class="price">￥<?=$v['price']?><?php if($v['fxje']>0  && FANLI==1){?><span style="margin-left:15px;" title="返了<?=$v['fxje'].TBMONEY?>">返了<?=$v['fxje']?></span><?php }?></span>
              </div>
              <div class="title"> <a href="<?=$v['user_url']?>" target="_blank"> <img src="<?=$v['user_img']?>" width="50" height="50" /> </a> <span><a href="<?=$v['url']?>" target="_blank"><?=$v['title']?></a></span> </div>
            </div>
            <div class="item_b" style="border-bottom:1px solid #eaeaea;"><?=utf_substr($v['content'],144)?></div>
            <div class="item_b clearfix">
              <div class="items_likes fl"> <a onclick="like(<?=$v['id']?>,'x_<?=$v['id']?>')" class="like_btn"></a> <em class="bold" id="x_<?=$v['id']?>"><?=$v['hart']?></em> </div>
            </div>
          </div>
          <?php }?>
        </div>
      </div>
      <a href="<?=u('baobei','user',array('uid'=>$user['id']))?>" target="_blank">
      <div class="chakan_more">看看TA更多晒单>></div>
      </a> </div>
  </div>
  <div class="shai_n_r">
    <div class="pad15">
      <div class="qimg"><a target="_blank" href="<?=$baobei['jump']?>"><?=dd_html_img($baobei['img'],$baobei['title'],'200')?></a></div>
      <div class="shop_name"> <span>店铺：<?=$baobei['shop_title']?></span></div>
      <div class="view_name"> <span><a target="_blank" href="<?=$baobei['jump']?>"><?=$baobei['title']?></a></span> </div>
      <div class="n_price"> <span style="margin-right:15px;">¥<?=(float)$baobei['price']?></span><?php if($baobei['fxje']>0 && FANLI==1){?>返了<span style="font-size:12px;" title="返了<?=$baobei['fxje'].TBMONEY?>"><?=$baobei['fxje']?></span><?=TBMONEY?><?php }?></div>
      <a target="_blank" href="<?=$baobei['jump']?>"><div class="qukankan"></div></a>
      <div style="clear:both;"></div>
    </div>
    <div style="border-top:1px dashed #ccc; margin-top:12px;"></div>
    <div class="pad15" style="margin:10px;">
      <div class="items clearfix">
        <div class="item_pl"> <a href="<?=u('baobei','user',array('uid'=>$baobei['uid']))?>" target="_blank"><img class="items-face" src="<?=$baobei['user_img']?>"></a> </div>
        <div class="items-r">
          <div> <span><a href="<?=u('baobei','user',array('uid'=>$baobei['uid']))?>" target="_blank"><?=utf_substr($baobei['ddusername'],2).'***'?></a></span><span style="float:right; color:#bababe;"><?=$baobei['_addtime']?></span> </div>
        </div>
      </div>
      <div class="items-r-pl" style="max-height:59px; overflow:hidden;"> <span><?=utf_substr($baobei['content'],144)?></span> </div>
      <div class="item_b clearfix" style="background:#fff; padding:10px 0px;">
        <div class="items_likes fl"> <a class="like_btn" onclick="like(<?=$baobei['id']?>,'x_<?=$baobei['id']?>')"></a> <em class="bold" id="x_<?=$baobei['id']?>"><?=$baobei['hart']?></em> </div>
        <div>
        <div class="bshare-custom" style="line-height:20px !important;">
                            <a title="分享到" href="http://www.bshare.cn/share" id="bshare-shareto" class="bshare-more" style="font-weight:normal; color:#555;">分享到:</a>
 								<a title="分享到QQ空间" class="bshare-qzone"></a>
                                <a title="分享到新浪微博" class="bshare-sinaminiblog"></a>
                                <a title="分享到QQ好友" class="bshare-qqim"></a>
                                <a title="分享到腾讯微博" class="bshare-qqmb"></a> 
                               
                                 <a title="更多平台" class="bshare-more bshare-more-icon"></a>      
                            </div>
                            <script type="text/javascript" charset="utf-8">
							bShare.addEntry({
								title: "<?=$baobei['title']?>",
								url: "<?=$baobei['_url']?>",
								summary: "<?=str_replace('"','',compact_html(strip_tags($baobei['content'])))?>",
								pic: "<?=preg_match('/^http/',$baobei['userimg'])?$baobei['userimg']:SITEURL.'/'.$baobei['img']?>"
							});
							</script>
      </div>
      </div>
      
    </div>
    <div style="border-top:1px dashed #ccc; margin-top:12px;"></div>
    <div class="qitasp"> TA的其他的照片
      <?php foreach($user_baobei as $v){?>
      <div class="sp_img"> <a href="<?=$v['url']?>"  target="_blank"> <?=dd_html_img($v['userimg'],$v['title'],240)?> </a>
        <div class="s_title"> <a href="<?=$v['url']?>"  target="_blank"><span><?=$v['title']?></span></a> </div>
        <div class="s_price"> <span>¥<?=$v['price']?></span><!--<del>50.00</del>--><?php if($v['fxje']>0 && FANLI==1){?><span style="float:right;" title="返了<?=$v['fxje'].TBMONEY?>">返了<?=$v['fxje']?></span><?php }?> </div>
      </div>
      <?php }?>
    </div>
  </div>
  <div style="clear:both;"></div>
</div>
<div class="hot_buy">其他热卖商品</div>
<div class="goods_list_315">
  <ul class="goods_items" scrollpagination="enabled">
  	<?php foreach($remai as $v){?>
    <li>
      <div class="list-good">
        <div class="left"> <a target="_blank" href="<?=$v['jump']?>"><?=dd_html_img($v['img'],$v['title'],300)?></a>
          <!--<div class="tp_ab">
            <div class="tp_bq tp_3"> <span>高返利</span><br>
              <b class="span_1">7元</b> </div>
          </div>-->
          <div class="n_top"></div>
        </div>
        <a target="_blank" href="<?=$v['jump']?>">
        <div class="jy_title"><?=$v['title']?></div>
        </a>
        <div class="jy_nr">
          <div class="jy_price">
            <div class="inblock"> ¥<span><?=$v['discount_price']?></span> </div>
            <div class="inblock"> <del><?=$v['price']?></del><?php if($v['discount_price']<$v['price']){?><span class="dazhe">(<?=$v['zhe']?>折)</span><?php }?> </div>
            <div style="float:right;" class="inblock">
              <div class="jy_w_buy">
                    <?php if($v['laiyuan_type']==1){?><div title="淘宝" class="tb"><i></i><?=$v['laiyuan']?></div><?php }?>
                    <?php if($v['laiyuan_type']==2){?><div title="天猫" class="tmall"><i></i><?=$v['laiyuan']?></div><?php }?>
                    <?php if($v['laiyuan_type']==3){?><div title="商城" class="jd"><i></i><?=$v['laiyuan']?></div><?php }?>
                    <?php if($v['laiyuan_type']==4){?><div title="拍拍" class="paipai"><i></i><?=$v['laiyuan']?></div><?php }?>
                </div>
            </div>
          </div>
          <div class="jy_del">
            <div class="inblock hiddens">
				<?php foreach($v['goods_attribute_arr'] as $vo){
                if($vo['ico']==''){?>
                <span class="biaoqian" title="<?=$vo['beizhu']?>" <?=$vo['style']?>><?=$vo['title']?></span>
                <?php }else{?>
                <span class="biaoqian" title="<?=$vo['beizhu']?>"><img alt="<?=$vo['title']?>" src="<?=$vo['ico']?>"></span>
                <?php }
                }?>
            <?php if(FANLI==1){?><span class="biaoqian qingse" <?php if($v['fanli']>0){?>title="<?=$v['fanli'].$v['unit']?>"<?php }?>><?php if($v['fanli']==0){?>有返利<?php }else{?>买后返:<?=$v['fanli']?><?php }?></span><?php }?>
                </div>
            <div style="float:right;" class="inblock">
              <div class="jy_w_buy">
                <div class="yishou">已售<?=$v['sell']?></div>
              </div>
            </div>
          </div>
        </div>
        <div class="jy_fx">
          <div class="bshare-custom" style="float:left;">
                            <a title="分享到" href="http://www.bshare.cn/share" id="bshare-shareto" class="bshare-more" style="font-weight:normal; color:#555;">分享到:</a>
 								<a title="分享到QQ空间" class="bshare-qzone">空间</a>
                                <a title="分享到新浪微博" class="bshare-sinaminiblog">新浪</a>
                                <a title="分享到QQ好友" class="bshare-qqim">QQ好友</a>
                                <a title="分享到腾讯微博" class="bshare-qqmb">腾讯</a> 
                                 <a title="更多平台" class="bshare-more bshare-more-icon"></a>      
                            </div>
                            <script type="text/javascript" charset="utf-8">
							bShare.addEntry({
								title: "<?=$v['title']?>",
								url: "<?=$v['_url']?>",
								summary: "<?=str_replace('"','',compact_html(strip_tags($v['title'])))?>",
								pic: "<?=preg_match('/^http/',$v['img'])?$v['img']:SITEURL.'/'.$v['img']?>"
							});
							</script>
        </div>
      </div>
    </li>
    <?php }?>
  </ul>
  <div style="clear:both"></div>
</div>
<?php
include(TPLPATH.'/inc/footer.tpl.php');
?>
