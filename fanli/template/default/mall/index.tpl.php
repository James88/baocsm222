<?php
//商城类型
$type_all=dd_get_cache('type');
$mall_type=$type_all['mall'];

$parameter=act_mall_index();
extract($parameter);
$css[]=TPLURL."/inc/css/index.css";
$css[]=TPLURL.'/inc/css/malllist.css';
$css[]=TPLURL.'/inc/css/mallindex.css';
include(TPLPATH.'/inc/header.tpl.php');
?>
<script>
var jiazai=0;
var $shangjia;
$(function(){
	$shangjia=$('.shangjia');
	$('#offer-q').focusClear('mallIndexSearch');
	$('.kuang01').focusClear('mallIndexSearch');

    liHover();
	
	var $lia=$('.search-nav').find('li').eq(0).find('a');
	$('#taobao_box .mod').val($lia.attr('mod'));
	$('#taobao_box .act').val($lia.attr('act'));
	$('#taobao_box .tao-text').val($lia.attr('word')).attr('moren',$lia.attr('moren'));
	$('#'+$lia.attr('c')+'jc').show();
	$('#jiaochengurl').attr('href',$lia.attr('jiaocheng'));
	
	$('.leimu .kuang01').keyup(function(){
	    var val=$(this).val();
		if(val!=''){
		    ajaxMall(val,100);
		}
	});
	
	$('.funumber li').click(function(){
		//if(jiazai==1){return false;}
		$('.fenlei2 li').removeClass('fontL');
		$('.funumber li').removeClass('current');
		$(this).addClass('current');
		var zimu=$(this).find('a').attr('zimu');
		ajaxMall(zimu,100);
	});
	
	$('.fenlei2 li').click(function(){
		//if(jiazai==1){return false;}
		$('.funumber li').removeClass('current');
		$('.fenlei2 li').removeClass('fontL');
		$(this).addClass('fontL');
		var cid=$(this).find('a').attr('cid');
		ajaxMall(cid,100);
	});
})

function liHover(){
	$('.zhanshi ul li').hover(function(){
	    $(this).css('position','relative');
		$(this).find('.fuxuanting').show();
	},function(){
	    $(this).css('position','static');
		$(this).find('.fuxuanting').hide();
	});
}

function ajaxMall(val,num){
	//if(val==''){return true;}
	if(!isNaN(val)){
		if(val==0) num=30;
		else num=100;
		data={cid:val,'num':num};
	}else{
		data={title:val,'num':num};
    }
	$('.zhanshi ul').html('<div style=" padding-top:50px; text-align:center">数据加载中。。。<br/><br/><img src="<?=TPLURL?>/inc/images/wait.gif" /></div>');
	jiazai=1;
    $.ajax({
	    url: '<?=u('ajax','malls')?>',
		data:data,
		dataType:'jsonp',
		jsonp:"callback",
		success: function(data){
			var jsonLi='';
			if(data!=''){
				jsonLi=getTplObj(mallHtml,data);
				var hang=parseInt(Math.ceil(data.length/6));
				if(hang<5){hang=5;}
				$shangjia.css('height',(hang*100+10)+'px');
			}
			if(jsonLi==''){
			    jsonLi='<div class="empty_data"><div class="empty_ico">&nbsp;</div><div class="empty_word">没有匹配商城</div><div style="clear:both"></div></div>';
			}
		    $('.zhanshi ul').html(jsonLi);
			liHover();
			jiazai=0;
         }
	});
}

function mallHtml() {/*<li>
<div class="pailie"><a href="{$view}"><img alt="{$title}" src="{$img}"/></a>
  <p>
  <?php if(FANLI==1){?>
  最高返<span id="fontk">{$fan}</span>
  <?php }else{?>
						{$title}
						<?php }?>
  </p></div>
  <div class="fuxuanting" style="height:125px; border:1px solid #dfdfdf; background:#fff;">
                        <div class="fuxt01"><div class="fuxt01b"><img alt="{$title}" src="{$img}" /></div><div class="fuxt01a">
						<?php if(FANLI==1){?>
						返 <span>{$fan}</span>
						<?php }else{?>
						{$title}
						<?php }?>
						</div></div>
                        <div class="fuxt02">
                          <ul>
                            <li><a href="{$view}"><img alt="返利详情" src="<?=TPLURL?>/inc/images/fx01.png" /></a></li>
                            <li><a target="_blank" href="{$view_jump}"><img alt="直接购买" src="<?=TPLURL?>/inc/images/fx02.png" /></a></li>
                          </ul>
                        </div>
                        <div class="fuxt03" style="border:0 none; background:#fff;">{$des}...</div>
                    </div>
</li>*/;}
</script>
<div style="width:998px;  margin:0 auto; margin-top:10px;">
<?php if(FANLI==1){?>
 <div id="content" class="span-24" style="min-height:330px;border:#ccc 1px solid; width:998px;background:#FFF;"> 		    
	<div class="fan-box">
    	<div class="fl_box">
        	<div class="tao_choose">
            	<ul class="search-nav">
                    <li class="check-rebate active">
                    	<a c="mall" mod="inc" act="check" jiaocheng="<?=$dd_tpl_data['jiaocheng']['mall']?>" moren="<?=$webset['search_key']['mall']?>" word="粘贴京东、当当等商城名">京东、当当等查返利</a>
                    </li>
                </ul>
                <em class="see-tips"></em>
            </div>
            <div class="box_big" style="position:relative; z-index:0;">
            	<div class="search-box" style="z-index:0; position:relative;">
                	<div class="tao-key">
                    	<form id="taobao_box" target="_blank" method="GET" action="index.php" onsubmit="return checkSubFrom('#offer-q');">
                        <input type="hidden" class="mod" name="mod" value="" /><input type="hidden" class="act" name="act" value="" /><input type="hidden" name="do" value="mall" />
                        	<div class="search-fields">
                        		<input id="offer-q" class="tao-text" type="text" value="" name="q" moren="">
                            </div>
                            <input class="tao-smt" type="submit" value="">
                        </form>
                    </div>
                </div>
                <a class="jc" id="jiaochengurl" target="_blank" href=""></a>
            </div>
        </div>
    </div>
    <div class="fan-steps">
    	<p class="title">
        	<img src="<?=TPLURL?>/inc/images/zj_nfl.png" />
        </p>
        <ul class="jdfanli" id="taojc" style="display:none;">
        	<li class="f-step">
            	<span class="tycss left95">复制商品关键词查返利</span>
            	<p>
                	复制淘宝商品关键词，在此查询返利，
                    <br>
                    网站最高可返70%。
                </p>
            </li>
            <li class="s-step">
            	<span class="tycss left105">去淘宝下单购买宝贝</span>
            	<p>
                	跳转到"淘宝搜索页面"后，若查到商
                    <br>
                    品则此商品有返利，可点击完成下单。
                </p>
            </li>
            <li class="t-step">
            	<span class="tycss left105">返利及时到帐</span>
            	<p>
                	确认收货后，回到网站会员中心查
                    <br>
                    看您的返利订单。
                </p>
            </li>
        </ul>
        <ul class="jdfanli" id="malljc" style="display:none;">
        	<li class="f-step">
            	<span class="tycss left95">复制京东等商品网址查返利</span>
            	<p>
                	复制京东等商品网址查返利，
                    <br>
                    网站最高可返50%。
                </p>
            </li>
            <li class="s-step">
            	<span class="tycss left105">去对应商城下单购买宝贝</span>
            	<p>跳转到对应商城购买商品</p>
            </li>
            <li class="t-step">
            	<span class="tycss left105">返利及时到帐</span>
            	<p>下单完成后，隔30分钟回到网站会员中心<br>查看返利订单详情。</p>
            </li>
        </ul>
        
        <ul class="jdfanli" id="zhanneijc" style="display:none;">
        	<li class="f-step">
            	<span class="tycss left95">搜索热门关键词</span>
            	<p>
                	搜索“女装，热卖”等关键词查询<br>返利，网站最高可返50%。
                </p>
            </li>
            <li class="s-step">
            	<span class="tycss left105">去淘宝下单购买宝贝</span>
            	<p>跳转到“爱淘宝”进行商品购买</p>
            </li>
            <li class="t-step">
            	<span class="tycss left105">返利及时到帐</span>
            	<p>
                	确认收货后，回到网站会员中心查
                    <br>
                    看您的返利订单。
                </p>
            </li>
        </ul>
        
    </div>
</div>
<?=AD(2)?>
<?php }?>
<div class="mainleft" style="float:none;">
<div class="leimu biaozhun1" style="width:998px; height:auto; float:none;">
<div class="leimutop c_border" style="width:auto;">
<div class="biaoti3  bz_first"><h3><div class="shutiao c_bgcolor"></div>全部商家 <span style="font-size:12px; font-weight:normal">(共<?=$total?>家)</span></h3> </div>
<div class="search23" style="margin:6px; padding:1px; width:230px;">
<form action="index.php" method="get" target="_blank">
<div id="searchtu2">
<input class="kuang01" type="text" name="q" value="<?=$webset['search_key']['mall']?>" />
<input type="hidden" name="mod" value="inc" />
<input type="hidden" name="act" value="check" />
<input type="hidden" name="do" value="mall" />
</div>
<input name="" type="image" value="搜索" src="<?=TPLURL?>/inc/images/sea_ss.png" style=" width:52px; height:25px" alt="submit"/>
</form>
</div>

</div>

<div class="kong01" style="border-top:1px solid #ccc;">
<div class="funumber" style="margin:auto; padding-top:10px">
<ul>
<?php foreach($zimu as $v){?>

<li <?php if($q==$v){?> class="current" <?php }?>><a style="font-size:14px; cursor:pointer" zimu="<?=$v?>"><?=strtoupper($v)?></a></li>
<?php }?>
</ul></div>
</div>
<div class="shangjia" style="width:auto; height:510px;">
<div class="fenlei2" style="margin:0;">
<ul>

<li class="fontL"><a style="cursor:pointer" cid="0">最热商城</a></li>
<?php $i=0; foreach($mall_type as $id=>$title){$i++;?>
<li ><a style="cursor:pointer" cid="<?=$id?>"><?=$title?></a></li>
<?php if($i==13) break; }?>
</ul>
</div> 

<div class="zhanshi"  style="width:900px;">
<ul style="width:900px; float:left;">
<?php foreach($malls as $row){?>
<li>
<div class="pailie"><a href="<?=$row['view']?>"><img alt="<?=$row['title']?>" src="<?=$row['img']?>"/></a>
  <?php if(FANLI==1){?><p>最高返<span id="fontk"><?=$row['fan']?></span></p><?php }else{?><p><?=$row['title']?></p><?php }?></div>
  <div class="fuxuanting" style="height:125px; border:1px solid #dfdfdf; background:#fff;">
                        <div class="fuxt01"><div class="fuxt01b"><img alt="<?=$row['title']?>" src="<?=$row['img']?>" /></div><?php if(FANLI==1){?><div class="fuxt01a">返 <span><?=$row['fan']?></span></div><?php }?></div>
                        <div class="fuxt02">
                          <ul>
                            <li><a href="<?=$row['view']?>"><img alt="返利详情" src="<?=TPLURL?>/inc/images/fx01.png" /></a></li>
                            <li><a target="_blank" href="<?=$row['view_jump']?>"><img alt="直接购买" src="<?=TPLURL?>/inc/images/fx02.png" /></a></li>
                          </ul>
                        </div>
                        <div class="fuxt03" style="border:0 none; background:#fff;"><?=utf_substr($row['des'],46)?>...</div>
                    </div>
</li>
<?php }?>
  </ul>
  
 </div>

</div>
</div>
</div>

</div>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>