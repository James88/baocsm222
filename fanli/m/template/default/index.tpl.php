<?php
if (!defined('INDEX')) {
	exit ('Access Denied');
}

$parameter=act_wap_index(4);
extract($parameter);
?>
<?php include(TPLPATH.'/inc/header.tpl.php');?>
<div class="body">
<?php if(!empty($slides)){?>
<div class="lbt">
	<div style="overflow: hidden;" id="wrapper">
    <div style="transition-property: transform; transform-origin: 0px 0px 0px; transform: translate(-300px, 0px) scale(1) translateZ(0px);" id="scroller">
            <ul id="thelist">
            <?php foreach($slides as $row){?>
            <li><a href="<?=$row['url']?>" <?php if($row['waibu_url']==1){?> target="_blank"<?php }?>><img src="<?=$row['img']?>" height="150" width="300"></a></li>
            <?php }?>
            </ul>
        </div>
    <div>
            <ol id="indicator">
            <?php for($i=0;$i<$slide_num;$i++){?>
            <li <?php if($i==0){?>class="on"<?php }?> style="width:<?=round(300/$slide_num)?>px;"></li>
            <?php }?>
            </ol>
        </div>
    </div>
</div>
<?php }?>
	<p class="menu">
		<a href="<?=wap_l('tao')?>"><span class="span1 span15"></span><span class="span2">宝贝返利</span></a>
		<a href="<?=wap_l('mall')?>"><span class="span1 span16"></span><span class="span2">商城返利</span></a>
		<a href="<?=wap_l('user')?>"><span class="span1 span17"></span><span class="span2">会员中心</span></a>
        <?php if($dd_tpl_data['sign_open']==1){?>
		<a href="<?=wap_l('user','sign')?>"><span class="span1 span14"></span><span class="span2">签到有奖</span></a>
        <?php }else{?>
        <a href="<?=wap_l('help')?>"><span class="span1 span14"></span><span class="span2">帮助中心</span></a>
        <?php }?>
	</p>
	<p class="menu" style=" padding-top:0px">
    <?php foreach($bankuai_wap as $row){?>
        <a href="<?=$row['url']?>"><span style="background:url(<?=$row['img']?>) 0px 0px; background-size:60px 60px" class="span1"></span><span class="span2"><?=$row['title']?></span></a>
        <?php }?>
    </p>
	
    
	<p class="nvyong_m">
        <a href="<?=wap_l('tao','list',array('q'=>'数码'))?>"><font style="background:#ff6600;color:#fff">数码</font></a>
        <a href="<?=wap_l('tao','list',array('q'=>'热卖'))?>">热卖</a>
        <a href="<?=wap_l('tao','list',array('q'=>'男装'))?>"><font style="background:#3366ff;color:#fff">男装</font></a>
        <a href="<?=wap_l('tao','list',array('q'=>'女装'))?>"><font color="#FF6600">女装</font></a>
        <a href="<?=wap_l('tao','list',array('q'=>'卫衣'))?>"><font color="#ff3366">卫衣</font></a>
        <a href="<?=wap_l('tao','list',array('q'=>'打底衫'))?>"><font style="background:#009933;color:#fff">打底衫</font></a>
        <a href="<?=wap_l('tao','list',array('q'=>'美妆'))?>"><font color="#ff6600">美妆</font></a>
        <a href="<?=wap_l('tao','list',array('q'=>'户外'))?>"><font style="background:#cc0033;color:#fff;font-weight:bold;">户外</font></a>
        </p>     
</div>
<script type="text/javascript">
var myScroll;
function loaded() {
	myScroll = new iScroll('wrapper', {
		snap: true,
		momentum: false,
		hScrollbar: false,
		onScrollEnd: function () {
			document.querySelector('#indicator > li.on').className = '';
			document.querySelector('#indicator > li:nth-child(' + (this.currPageX+1) + ')').className = 'on';
	}
    });
}
document.addEventListener('DOMContentLoaded', loaded, false);
setInterval(function(){  
    if(myScroll.currPageX==<?=$slide_num-1?>){
        myScroll.scrollToPage(0, 0);
    }else{
        myScroll.scrollToPage('next', 0);}
},5000);
</script>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>