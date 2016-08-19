<?php
if(!defined('INDEX')){
	exit('Access Denied');
}
$parameter=act_goods_index($dd_tpl_data['ajax_load_num']);
extract($parameter);
$bankuai_tpl=$bankuai_tpl?$bankuai_tpl:$dd_tpl_data['bankuai_tpl'];
$yugao_time=date('Y-m-d '.$bankuai['yugao_time'].":00");
if(strtotime($yugao_time)>TIME){
	$yugao_close=true;
}
if($bankuai['huodong_time']){
	$bankuai['huodong_etime']=strtotime(date('Y-m-d '.$bankuai['huodong_time'].":00:00",TIME))+24*3600;
}

$phone_app_status=$app_status;
$css[]=TPLURL."/goods/".$bankuai_tpl."/css/list.css";
include(TPLPATH.'/inc/header.tpl.php');
?>
<script type="text/javascript" src="js/scrollpagination.js"></script>
<?php if($bankuai['bg_color']!='' && $bankuai['bg_color']!='none'){?>
<style>body {background:<?=$bankuai['bg_color']?>;}</style>
<?php }?>
<?php if(empty($bankuai_code)||$bankuai['fenlei']==1||$bankuai['yugao']==1){?>
<div id="ddlanmu" style=" width:100%">
  <div class="jy_tl">
    <div class="jy_auto">
      <div class="jy_nav">   
        <div class="up_fenlei">
        <?php 
		if(($bankuai['fenlei']==1 || $_GET['code']=='')&&$goods_type){
		$url_canshu=array("code"=>$bankuai_code);
		if($_GET['do']!=''){
			$url_canshu['cid']=0;
			$url_canshu['do']=$_GET['do'];
		}
		?>
        <a href="<?=u('goods','index',$url_canshu)?>" <?php if(empty($_GET['cid'])){?>class="cur c_border"<?php }?>>全部</a>
          <?php foreach($goods_type as $vo){?>
          <a href="<?=$vo['url']?>" <?php if($_GET['cid']==$vo['id']){?>class="cur c_border"<?php }?>>
          <?=$vo['title']?>
          </a>
          <?php }?>
          <?php }?>
        </div>
        <?php if($_GET['code']!=''){?>
        <?php if($_GET['do']!='yugao'){?>
        <?php if($bankuai['huodong_time']&&date('H')<$bankuai['huodong_time']){?>
        <div class="upnew"><i></i>每天<span><?=$bankuai['huodong_time']?></span>点上新     距上新还有<span><?=$bankuai['huodong_time']-date('H')?></span>小时</div>
         <?php }elseif($bankuai['huodong_time']){?>
        <div class="upnew"><i></i><div style="float:left;">本场剩余</div><div class="count_down"><span class="count_down_h">0</span>时<span class="count_down_m">0</span>分<span class="count_down_s">0</span>秒<input type="hidden" class="stime" value="<?=TIME?>"><input type="hidden" class="etime" value="<?=$bankuai['huodong_etime']?>"></div></div>
         <?php }}?>
         <?php if($bankuai['yugao']==1){?>
         <div style="float:right; width:110px; margin-right:10px;">
         <?php if($_GET['do']=='yugao'){?>
         <a class="cur c_border" href="<?=l('goods','index',array('code'=>$_GET['code']))?>">返回上线商品</a>
         <?php }else{?>
         <a class="cur c_border" <?php if($yugao_close){?>onClick="alert('对不起，亲！<?=$bankuai['yugao_time']?>后公布预告商品。');"<?php }else{?>href="<?=u('goods','index',array('code'=>$bankuai['code'],'do'=>'yugao'))?>"<?php }?>>明日精选</a>
         <?php }?>
         </div>
		 <?php }}?>
      </div>
    </div>
  </div>
</div>
<?php }?>
<?php 
$ad_close=(int)$_COOKIE[$bankuai['code'].'adClose'];
if($bankuai['banner_img']!=''){?>
<div id="<?=$bankuai['code']?>ad" class="yunad" style="text-align:center; height:auto; position:relative; <?php if($ad_close==1){?>height:0<?php }?>">
  <div id="ad_a" class="banner_bg" style=" <?php if($ad_close==1){?>display:none<?php }?>;<?php if(($bankuai['banner_color']!='' && $bankuai['banner_color']!='none')){?>background-color:<?=$bankuai['banner_color']?>;<?php }?>"> <img src="<?=$bankuai['banner_img']?>" />
    <div style="position:absolute; right:5px; top:5px; cursor:pointer" onclick="closeAd($(this))"><img title="关闭" src="<?=TPLURL?>/inc/images/ad_close.png" /></div>
  </div>
  <div id="ad_b" <?php if($ad_close!=1){?>style="display:none"<?php }?>>
    <div h="auto" style="position:absolute;right:5px; top:5px; cursor:pointer;" title="打开" onclick="openAd($(this))"><img title="打开" src="<?=TPLURL?>/inc/images/ad_open.png" /></div>
  </div>
</div>
<?php }?>

<div style=" height:0px; overflow:hidden">&nbsp;</div>
<div class="goods_list" style="min-height:400px">
  <?php include(TPLPATH."/goods/".$bankuai_tpl."/list.tpl.php");?>
</div>
<div style="clear:both;"></div>
<div id="ajax_goods_loading" style="margin-bottom:10px"><img src="<?=TPLURL?>/inc/images/white-ajax-loader.gif" style="margin-bottom:-2px" alt="加载商品" />&nbsp;&nbsp;正在加载商品</div>
<div class="megas512" style="padding:10px; display:none">
  <?php if($goods_total==1){?>
  <?=pageft($total,$pagesize*(1+$ajax_load_num),u(MOD,ACT,$url_arr),WJT)?>
  <?php }?>
</div>
<?php include(TPLPATH.'/goods/jumpbox.tpl.php');?>
<?php
$a=$url_arr;
$a['do']=trim($_GET['do']);
unset($a['code']);
$contentData=json_encode($a);
?>
<script type="text/javascript">
scrollPaginationPage=(<?=$ajax_load_num?>-1)*<?=($page-1)?>+1;
$(function(){
	LazyLoad($('.list-good'));
	<?php if($ajax_stop!=1 && $ajax_load_num>0){?>
	ajaxLoad('.goods_list .goods_items','.megas512',<?=$ajax_load_num?>,'<?=CURURL.'/?mod=goods&act=data&code='.$_GET['code']?>',<?=$contentData?>,500,LazyLoad);
	<?php }else{?>
	$('.megas512').show();
	<?php }?>
	fixDiv('#ddlanmu',0);
})
countDown('.count_down');
</script>
<?php 
include(TPLPATH."/inc/footer.tpl.php");
?>