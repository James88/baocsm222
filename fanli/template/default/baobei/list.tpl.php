<?php
$parameter=act_baobei_list();
extract($parameter);
$goods_total=1;
$ajax_load_num=$dd_tpl_data['ajax_load_num'];

define('VIEW_PAGE',1);

$css[]=TPLURL.'/inc/css/shai_l.css';
$css[]=TPLURL.'/inc/css/list_g.css';
$css[]='css/qqFace.css';

$js[]=TPLURL.'/inc/js/jquery.infinitescroll.js';
$js[]=TPLURL.'/inc/js/jquery.masonry.js';
include(TPLPATH.'/inc/header.tpl.php');
?>
<script type="text/javascript" src="js/scrollpagination.js"></script>
<?php include(TPLPATH.'/baobei/topcat.tpl.php');?>
<div class="goods_l">
<div class="w1000" style="width:1000px; margin:0 auto">

<?=AD(11)?>
<div class="demo clearfix" style="margin-top:0">
<?php include(TPLPATH.'/baobei/baobei.tpl.php');?>
</div>
<div style="clear:both;"></div>
<div id="ajax_goods_loading" style="margin-bottom:10px"><img src="<?=TPLURL?>/inc/images/white-ajax-loader.gif" style="margin-bottom:-2px" alt="加载商品" />&nbsp;&nbsp;正在加载商品</div>
<div class="megas512" style="padding:10px; display:none"><?php if($goods_total==1){?><?=pageft($total,$pagesize*(1+$ajax_load_num),u(MOD,ACT,$url_arr),WJT)?><?php }?></div>
</div>
</div>
<?php
$a=$url_arr;
$contentData=json_encode($a);
?>
<script type="text/javascript">
function LazyLoad($t){
	if(typeof $t=='undefined'){
		var a=0;
	}
	else{
		var a=1;
	}
	
	$t=$t||$('.infinite_scroll');
	var $obj=$t.find("img.lazy");
	$obj.lazyload({
		threshold:20,
		failure_limit:50,
		effect : "fadeIn"
	});
	
	if(a==0){
		$('.masonry_brick img').load(function(){
			$('.infinite_scroll').masonry({ 
				itemSelector: '.masonry_brick',
				columnWidth:240,
				gutterWidth:13						
			});		
		});
		$('.infinite_scroll').masonry({ 
			itemSelector: '.masonry_brick',
			columnWidth:240,
			gutterWidth:13							
		});
	}
	else{
		$('.masonry_brick img').load(function(){
			$('.infinite_scroll').masonry('reload');
		});
		$('.infinite_scroll').masonry('reload');
	}
}

scrollPaginationPage=(<?=$ajax_load_num?>-1)*<?=($page-1)?>+1;
$(function(){
	fixDiv('#ddlanmu',0);
	LazyLoad();
	<?php if($ajax_load_num>0){?>
	ajaxLoad('.infinite_scroll','.megas512',<?=$ajax_load_num?>,'<?=CURURL.'/?mod='.MOD.'&act=baobei'?>',<?=$contentData?>,500,LazyLoad);
	<?php }?>
})
</script>
<?php
include(TPLPATH.'/inc/footer.tpl.php');
?>