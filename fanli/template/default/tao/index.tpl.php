<?php
//商城类型
$type_all=dd_get_cache('type');
$mall_type=$type_all['mall'];

extract($parameter);
$css[]=TPLURL."/inc/css/index.css";
$css[]=TPLURL.'/inc/css/mallindex.css';
include(TPLPATH.'/inc/header.tpl.php');
?>
<script>
$(function(){
	$('#offer-q').focusClear('mallIndexSearch');
})
</script>

<div style="width:998px;  margin:0 auto; margin-top:10px;">
 <div id="content" class="span-24" style="min-height:330px;border:#ccc 1px solid; width:998px;background:#FFF;"> 		    
	<div class="fan-box">
    	<div class="fl_box">
        	<div class="tao_choose">
            	<ul class="search-nav">
                    <li class="check-rebate active">
                    	<a c="tao">淘宝、天猫查返利</a>
                    </li>
                </ul>
                <em class="see-tips"></em>
            </div>
            <div class="box_big" style="position:relative; z-index:0;">
            	<div class="search-box" style="z-index:0; position:relative;">
                	<div class="tao-key">
                    	<form id="taobao_box" target="_blank" method="GET" action="index.php" onsubmit="return checkSubFrom('#offer-q');">
                        <input type="hidden" class="mod" name="mod" value="tao" /><input type="hidden" class="act" name="act" value="view" />
                        	<div class="search-fields">
                        		<input id="offer-q" class="tao-text" type="text" value="粘贴淘宝/天猫商品名称、关键字，如：雅诗兰黛 即时修护" moren="<?=$webset['search_key']['s8']?>" name="q">
                            </div>
                            <input class="tao-smt" type="submit" value="">
                        </form>
                    </div>
                </div>
                <a class="jc" id="jiaochengurl" target="_blank" href="<?=$dd_tpl_data['jiaocheng']['tao']?>"></a>
            </div>
        </div>
    </div>
    <div class="fan-steps">
    	<p class="title">
        	<img src="<?=TPLURL?>/inc/images/zj_nfl.png" />
        </p>
        <ul class="jdfanli" id="taojc">
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
        <div style="clear:both"></div>
        <br/>
        <img src="<?=TPLURL?>/inc/images/fuzhi.jpg" alt="复制商品名" style="width:980px" />
        <img src="<?=TPLURL?>/inc/images/xinwanfa.jpg" alt="淘宝返利新玩法" style="width:980px" />
    </div>
</div>


</div>
<?php include(TPLPATH.'/inc/footer.tpl.php');?>