<?php
if(!defined('INDEX')){
	exit('Access Denied');
}
define('VIEW_PAGE',1);
//幻灯片
$slides=dd_slides($duoduo,10);

//商城
include(DDROOT.'/comm/mall.class.php');
$mall_class=new mall($duoduo);
$num=11;
$paipai_arr=array();

$malls=$mall_class->index($num,$paipai_arr);
$chongzhi_url=$ddTaoapi->tdj_zujian(1,$dduser['id']);

//友情链接
$yqlj=dd_link($duoduo,30,0);

//合作伙伴
$hzhb=dd_link($duoduo,30,1);

$ajax_load_num=$dd_tpl_data['ajax_load_num'];

$bankuai=$duoduo->select_all('bankuai','id,title,code,bankuai_tpl,web_cid,yugao,yugao_time,huodong_time',"tuijian=1 and status=1 and del=0 ORDER BY sort=0 ASC,sort asc,id desc");
$t=array();
foreach($bankuai as $key=>$vo){
	if($key==0){
		if($vo['huodong_time']){
			$vo['huodong_etime']=strtotime(date('Y-m-d '.$vo['huodong_time'].":00:00",TIME))+24*3600;
		}
		$first_bankuai=$vo;
		$web_cid=$vo['web_cid'];
	}
	if(!in_array($vo['bankuai_tpl'],$t)){
		$css[]=TPLURL."/goods/".$vo['bankuai_tpl']."/css/list.css";
		$t[]=$vo['bankuai_tpl'];
	}
}
$web_cid=unserialize($web_cid);
if($web_cid){
	$where="id in(".implode(',',$web_cid).")";
}else{
	$where=" tag='goods' ";
}
if(!empty($web_cid)){
	$goods_type=$duoduo->select_all("type","id,title",$where."  order by sort=0 asc,sort asc,id desc");
}
$yugao_time=date('Y-m-d '.$first_bankuai['yugao_time'].":00");
if(strtotime($yugao_time)>TIME){
	$yugao_close=true;
}

$css[]=TPLURL."/inc/css/index.css";

$css[]=TPLURL."/inc/css/malllist.css";
include(TPLPATH.'/inc/header.tpl.php');
?>
<script src="js/jquery.KinSlideshow-1.2.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/scrollpagination.js"></script>
<script>
$(function(){
	fixDiv('#ddlanmu .ddlanmu_c',0);
	countDown('.count_down');
});
</script>
<div class="mainbody">
  <div class="mainbody1000">
    <?php if(!empty($slides)){?>
    <div id="KinSlideshow" style="margin-top:10px; height:90px; overflow:hidden; background:url(<?=$slides[0]['img']?>)">
      <?php foreach($slides as $row){?>
      <a href="<?=$row['url']?>" target="_blank"><img src="<?=$row['img']?>" alt="<?=$row['title']?>" width="1000" height="90" /></a>
      <?php }?>
    </div>
    <?php }?>
    <div class="w1000">
      <div class="home_left home-shop">
        <div class="clearfix" style="height:198px;border:1px solid #dfdfdf;background:#FFF; position:relative;">
          <ul style="margin-left:8px;margin-top:15px">
            <?php foreach($malls as $row){?>
            <li style="float:left;width:113px;padding-top:8px;text-align:center;color:#999;height:68px;margin:0 11px 7px 0; z-index:999;"> <a href="<?=$row['view']?>" target="_blank"> <img class="img_1" alt="<?=$row['title']?>" src="<?=$row['img']?>" style="width:105px; display:block;margin:5px auto;"></a>
              <?php if(FANLI==1){?>
              最高返
              <?=$row['fan']?>
              <?php }else{?>
              <?=$row['title']?>
              <?php }?>
              <div class="fuxuanting" style="height:125px; border:1px solid #dfdfdf; background:#fff;">
                <div class="fuxt01">
                  <div class="fuxt01b"><img alt="<?=$row['title']?>" src="<?=$row['img']?>" /></div>
                  <?php if(FANLI==1){?>
                  <div class="fuxt01a">返 <span>
                    <?=$row['fan']?>
                    </span></div>
                  <?php }?>
                </div>
                <div class="fuxt02">
                  <ul>
                    <li><a target="_blank" href="<?=$row['view']?>"><img alt="查看详情" src="<?=TPLURL?>/inc/images/fx01.png" /></a></li>
                    <li><a target="_blank" href="<?=$row['view_jump']?>"><img alt="直接购买" src="<?=TPLURL?>/inc/images/fx02.png" /></a></li>
                  </ul>
                </div>
                <div class="fuxt03" style="border:0 none; background:#fff;">
                  <?=utf_substr($row['des'],46)?>
                  ...</div>
              </div>
            </li>
            <?php }?>
          </ul>
          <a class="arrow-shop-list simsun" href="<?=u('mall','index')?>" target="_blank">></a> </div>
      </div>
      <div class="chongzhi" style="position:relative">
        <?php if($chongzhi_url!=''){?>
        <iframe frameborder="0" style="height:200px; width:210px" src="<?=$chongzhi_url?>"></iframe>
        <?php }else{?>
        <div style="text-align:center; line-height:200px; font-size:16px; font-weight:bold"></div>
        <?php }?>
        <div id="index-chongzhi-tiplogin-beijing" style="position:absolute; top:0px; left:0px; width:212px; height:200px; display:none"><a href="<?=u('user','login')?>" style="display:block; width:100%; height:200px;">&nbsp;</a></div>
      </div>
      <div style="clear:both"></div>
      <?=AD(1)?>
      <div style="clear:both; height:5px">&nbsp;</div>
      <div id="ddlanmu">
        <div class="ddlanmu_c">
          <ul class="home-tab clearfix">
            <?php foreach($bankuai as $key=>$vo){?>
            <li <?php if($vo['code']==$_GET['code']||$key==0){?>class="current"<?php }?> code="<?=$vo['code']?>"><span code="<?=$vo['code']?>" class="home-tab-super c_border"><strong class="c_fcolor">
              <?=$vo['title']?>
              </strong></span></li>
            <?php }?>
          </ul>
          <div class="jy_tl">
            <div class="jy_auto">
              <?php if($goods_type||$first_bankuai['yugao']==1){?>
              <div class="jy_nav" id="<?=$first_bankuai['code']?>_nav"> 
              <?php if($goods_type){?>
              <div class="up_fenlei">
            	<a class="cur c_border" href="<?=u('goods','index',array('code'=>$first_bankuai['code']))?>">全部</a>
                <?php foreach($goods_type as $vo){?>
                <a target="_blank" href="<?=u('goods','index',array('code'=>$first_bankuai['code'],'cid'=>$vo['id']))?>">
                <?=$vo['title']?>
                </a>
                <?php }?>
                </div>
                <?php }?>
                <?php if($first_bankuai['huodong_time']&&date('H')<$first_bankuai['huodong_time']){?>
                <div class="upnew">
                	<i></i>
                    每天<span><?=$first_bankuai['huodong_time']?></span>点上新     距上新还有<span><?=$first_bankuai['huodong_time']-date('H')?></span>小时
                </div>
                <?php }elseif($first_bankuai['huodong_time']){?>
                <div class="upnew">
                	<i></i>
                    <div style="float:left;">本场剩余</div><div class="count_down"><span class="count_down_h">0</span>时<span class="count_down_m">0</span>分<span class="count_down_s">0</span>秒<input type="hidden" class="stime" value="<?=TIME?>"><input type="hidden" class="etime" value="<?=$first_bankuai['huodong_etime']?>"></div></div>
                <?php }?>
                <?php if($first_bankuai['yugao']==1){?>
                <div style="float:right; width:85px; margin-right:10px;">
                	<a class="cur c_border" <?php if($yugao_close){?>onClick="alert('对不起，亲！<?=$first_bankuai['yugao_time']?>后公布预告商品。');"<?php }else{?>href="<?=u('goods','index',array('code'=>$first_bankuai['code'],'do'=>'yugao'))?>"<?php }?>>明日精选</a>
                </div>
                <?php }?>
              </div>
              <?php }?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="index-goods">
      <?php 
	foreach($bankuai as $key=>$vo){
?>
      <div id="<?=$vo['code']?>Div" class="ddgoods goods_list" <?php if($key==0){?>show="1" style=" display:block"<?php }else{?>show="0"<?php }?>>
        <?php if($key==0){
	$bankuai_tpl=$vo['bankuai_tpl'];
	$bankuai_code=$vo['code'];
 	include(TPLPATH."/goods/".$bankuai_tpl."/list.tpl.php");
}
?>
      </div>
      <?php }?>
      <div style="clear:both"></div>
      <div id="ajax_goods_loading" style="margin-bottom:10px"><img src="<?=TPLURL?>/inc/images/white-ajax-loader.gif" style="margin-bottom:-2px" alt="加载商品" />&nbsp;&nbsp;正在加载商品</div>
      <?php include(TPLPATH.'/goods/jumpbox.tpl.php');?>
    </div>
    <div class="links">
      <div class="links01">
        <div style=" width:70px; float:left; padding-left:10px"><b>友情链接:</b></div>
        <ul style="float:left; width:875px">
          <?php foreach($yqlj as $row){?>
          <li><a href="<?=$row['url']?>" target="_blank">
            <?=$row['title']?>
            </a></li>
          <?php }?>
        </ul>
      </div>
      <div class="linksline"> <img alt="间隔线" src="<?=TPLURL?>/inc/images/line02.gif" style="width:900px; height:10px" /></div>
      <div class="links02">
        <div style=" width:70px; float:left; padding-left:10px">
          <h3>合作伙伴:</h3>
        </div>
        <ul style="float:left; width:875px">
          <?php foreach($hzhb as $row){?>
          <li><a href="<?=$row['url']?>" target="_blank"><img alt="<?=$row['title']?>" style="width:95px; height:33px" src="<?=$row['img']?>" /></a></li>
          <?php }?>
        </ul>
      </div>
    </div>
  </div>
</div>
<?php
$a=$url_arr;
$a['code']=trim($_GET['code']);
$contentData=json_encode($a);
?>
<script>
var scrollPaginationPage=1;
var ajaxLoadNum=<?=$ajax_load_num?>;
var lanmuChangeStop=0;
var ajaxGet=0;
<?php
foreach($bankuai as $k=>$v){
	$indexAjaxCodeObj[$v['code']]=1;
}
?>
var indexAjaxCodeObj=<?=dd_json_encode($indexAjaxCodeObj)?>;
$(function(){
	if(typeof getCookie('userlogininfo')=='undefined'){
		$('#index-chongzhi-tiplogin-beijing,#index-chongzhi-tiplogin-wenzi').show();
	}
	$("#KinSlideshow").KinSlideshow({
		isHasTitleFont:false,
		isHasTitleBar:false,
		moveStyle:'up',
		btn:{btn_fontHoverColor:"#FFFFFF"}
	});
	$('.clearfix ul li').hover(function(){
		$(this).css('position','relative');
		$(this).find('.fuxuanting').show();
	},function(){
		$(this).css('position','static');
		$(this).find('.fuxuanting').hide();
	});
	
	indexAjaxLoad('<?=$first_bankuai['code']?>');
	var $homeTabLi=$('.home-tab li');
	$homeTabLi.click(function(){
		if(lanmuChangeStop==1){
			return false;
		}		
		scroller('ddlanmu',500,50);
		$homeTabLi.removeClass('current');
		$(this).addClass('current');
		var code=$(this).attr('code');
		//分类选择显示
		$(".jy_nav").hide();
		$("#"+code+"_nav").show();
		var $indexGoods=$('#index-goods');
		$indexGoods.find('.ddgoods').hide();
		$indexGoods.find('#'+code+'Div').show();
		var show=$indexGoods.find('#'+code+'Div').attr('show');
		$('#ajax_goods_loading').html('<img src="<?=TPLURL?>/inc/images/white-ajax-loader.gif" style="margin-bottom:-2px" alt="加载商品" />&nbsp;&nbsp;正在加载商品').hide();
		if(show==0){
			$indexGoods.find('#'+code+'Div div ul').html('<div id="ajax_goods_loading" style=" display:block"><img src="<?=TPLURL?>/inc/images/white-ajax-loader.gif" style="margin-bottom:-2px" alt="加载商品" />&nbsp;&nbsp;正在加载商品</div>');
			$indexGoods.find('#'+code+'Div').attr('show',1);
			/*setTimeout(function(){
				changelanmu(code);
			},500);*/
			
			lanmuChangeStop=1;
			ajaxGet=1;
			changelanmu(code);
		}
	});
	fixDiv('#ddlanmu .ddlanmu_c',0);
});

function indexAjaxLoad(code){
	LazyLoad($('#'+code+'Div'));
	for(var i in indexAjaxCodeObj){
		if(i!=code){
			$('#'+i+'Div .goods_items').stopScrollPagination();
		}
	}
	ajaxLoad('#'+code+'Div .goods_items','',ajaxLoadNum,CURURL+u('goods','data'),{"code":code},500,LazyLoad);
}

function changelanmu(code,first){
	var arr=new Array()
	arr['code']=code;
	arr['page']=1;
	scrollPaginationPage=1;
	var url=CURURL+u('goods','data',arr);
	$.get(url,function(data){
		$('#'+code+'Div').html(data);
		indexAjaxLoad(code);
		lanmuChangeStop=0;
		ajaxGet=0;
	});
	//分类
	var arr=new Array()
	arr['code']=code;
	var url=CURURL+u('ajax','goods_type',arr);
	$.get(url,function(data){
		$(".jy_nav").hide();
		$(".jy_auto").append(data);
	});
} 
</script>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>
