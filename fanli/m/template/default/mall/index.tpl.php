<?php
if (!defined('INDEX')) {
	exit ('Access Denied');
}

$parameter=act_wap_mall();
extract($parameter);
include(TPLPATH.'/inc/header_2.tpl.php');
?>
<script>
var floorStep=2;
var ajaxTag=0;
$(function(){
	$('.shuju_load img.lazy').lazyload({
		threshold:20,
		failure_limit:50
	});
});
</script>
<div class="listHeader">
  <p> <b>商城返利</b><a href="javascript:;" onclick="history.back()" class="left">返回</a> <a href='<?=wap_l()?>' class="right">首页</a> </p>
</div>
  <p class="line"></p>
<div class="shuju_load">
<?php foreach($shuju_data as $row){?>
<div class="mc radius">
	<ul class="mu-l2w">
        <li style="padding: 10px;border-top: none;overflow: hidden; line-height: 1.6em;"> <a target="_blank" href="<?=$row['jump']?>" style="display: block;overflow: hidden;lear: both;padding:.22em 0; color:#666"> <span style="float:left;margin-right:8px;"><img data-original="<?=$row['img']?>" title="<?=$row['title']?>" class="lazy" src="images/lazy.gif" width="120"  height="60"> </span><span style="line-height:4em; float:right; padding:0em 0.5em;"><?=$row['title']?> | 最高返 <span style="color:#F00;"><?=$row['fan']?></span></span></a> 
        </li>
  </ul>
</div>
<?php }?>
</div>
<!--<a class="chakan_more">下拉加载更多</a>-->
<?php include(TPLPATH.'/inc/footer.tpl.php');?>
