<?php
if (!defined('INDEX')) {
	exit ('Access Denied');
}

$parameter=act_wap_list();
extract($parameter);
include(TPLPATH.'/inc/header_2.tpl.php');?>
<script>
var floorStep=2;
var ajaxTag=0;
$(function(){
	$(window).bind('scroll',function(){
		if($(window).scrollTop()+$(window).height()>=$(document).height()-400){
			if(ajaxTag==0){
				ajaxTag=1;
				jiazai(floorStep);
				floorStep++;
			}
		}
	});
	$('.shuju_load img.lazy').lazyload({
		threshold:20,
		failure_limit:50
	});
});

function index_tpl(){/*<li> <a dd-href="{$url}&url=" data-itemid="{$num_iid}" isconvert=1 class="click_url"> <span class="mu-tmb"><img data-original="{$img}" title="{$title}" class="lazy" src="<?=$dd_tpl_data['loading_img']?>" style="width:100px; height:100px; margin:0 auto;display: block;"> </span> <span style="max-height:3em; overflow:hidden; display:block; font-size:1em">{$title}</span>
        <span class="pricecolor1"><span>原价：￥{$reserve_price}</span></span>
        <span class="pricecolor2">现价：￥{$zk_final_price}<span>{$rebate_word}</span></span>
        <span class="pricecolor3">产地：{$provcity}</span>
      </a> </li>*/;}

function jiazai(floorStep){	
	$('.chakan_more').text('数据获取中……');
	var url='<?=wap_l(MOD,ACT)?>&q='+'<?=$q?>'+'&page='+floorStep;
	$.getJSON(url,function(data){
		ajaxTag=0;
		if(data.s=='1'){
			if(data.r=='' || data.r=='null' || data.r==null){
				alert('没有了');
				ajaxTag=1;
				$('.chakan_more').hidden();
			}else{
				for(i in data.r){
					row=data.r[i];
					var html=getTplObj(index_tpl,row);
					$('.shuju_load').append(html);
				}
				$('.chakan_more').text('点击更多');
				$('.shuju_load img.lazy').lazyload({
					threshold:20,
					failure_limit:50
				});
			}
		}
	});
}
</script>
<div class="listHeader">
  <p> <b><?=$q?></b><a href="javascript:;" onclick="history.back()" class="left">返回</a> <a href='<?=wap_l()?>' class="right">首页</a> </p>
</div>
<!--<dl class="sequence">
  <div style="width:140px; margin:auto;">
  <?php foreach($sort_arr as $k=>$v){?>
  <a href="<?=wap_l(MOD,ACT,array('q'=>$q,'sort'=>$k,'page'=>$page))?>" class="aright <?php if($k==$sort){?>cur<?php }?>"><?=$v?></a>
  <?php }?>
  </div>
</dl>-->
  <p class="line"></p>
<div class="mc radius">
	<ul class="mu-l2w shuju_load">
		 <?php foreach($shuju_data as $k=>$row){?>
		<li> <a dd-href="<?=$row['url']?>&url=" data-itemid="<?=$row['num_iid']?>" isconvert=1 class="click_url"> <span class="mu-tmb"><img data-original="<?=tb_img($row['img'],200)?>" title="<?=$row['title']?>" class="lazy" src="<?=$dd_tpl_data['loading_img']?>" style="width:100px; height:100px; margin:0 auto;display: block;"> </span> <span style="max-height:3em; overflow:hidden; display:block; font-size:1em"><?=$row['title']?></span>
        <span class="pricecolor1"><span style="color:#666">原价：<del>￥<?=$row['reserve_price']?></del></span></span>
        <span class="pricecolor2">现价：￥<?=$row['zk_final_price']?>  <span><?=$row['rebate_word']?></span> <!--<span style=" background:#09F;">手机专享</span>--></span>
        <span class="pricecolor3">产地：<?=$row['provcity']?></span>
      </a> </li>
      <?php }?>
       
        
			</ul>
</div>
<a class="chakan_more">下拉加载更多</a>
<?php include(TPLPATH.'/inc/tdj.tpl.php');?>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>