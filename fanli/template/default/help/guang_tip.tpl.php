<?php
if(!defined('INDEX')){
	exit('Access Denied');
}
if(ACT=='guang_tip'){
	$css[]=TPLURL."/inc/css/flbz.css";
	include(TPLPATH.'/inc/header.tpl.php');
}

$bankuai=dd_get_cache('bankuai');
?>
<div class="biaozhun5" style="width:1000px; margin:10px auto 0; background:#fff;">
<div class="bz_first">
    <h3 class="c_border">
    <div class="shutiao c_border"></div>
    	 搜索提醒
    </h3>
</div>
<div class="mid_bg" style="width:950px; height:432px;">
    <div class="zj_btn">
        <p>
        <?php if(ACT!='guang_tip'){?>
        亲！您搜错了！
        <?php }else{?>
        亲！欢迎您来看看！
        <?php }?>
        </p>
        <p>去我们网站看看，有很多性价比的商品，一样可以购物返利。</p>
    </div>
    <div style="clear:both"></div>
    <div class="anniu">
    	<ul>
        <?php foreach($bankuai as $row){?>
        	<li><a class="one" target="_blank" href="<?=u('goods',$row['code'])?>">去<?=$row['title']?></a></li>
        	<?php }?>
        </ul>
    </div>
    <div style="clear:both"></div>
    <!--<a class="fl_btn1" href=""></a>-->
</div>
</div>
<?php
if(ACT=='guang_tip'){
	include(TPLPATH.'/inc/footer.tpl.php');
}
?>