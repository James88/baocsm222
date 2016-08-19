<?php
$index_url=u('index','index');
$help_url=u('help','index');
	
$css[]=TPLURL."/inc/css/flbz.css";
include(TPLPATH.'/inc/header.tpl.php');
?>

<div style="background:url(<?=TPLURL?>/inc/images/help/diban.jpg) repeat-x; width:100%">
	<div class="top_bbg">
    	<div class="wenzi">
            <p class="first">淘宝返利<span>新</span>玩法</p>
            <p class="two">因淘宝规则调整，2014年7月1日起，将不再支持使用商品链接查返利。 <span>请您使用商品标题搜索，再去购物拿返利。</span>如：骆驼男装 短袖……</p>
            <p class="two">粘贴商品标题到网站，查询后将跳转到淘宝/天猫，找到你想买的商品并购买，确认收货后记得回网站拿返利哦。</p>
        </div>
    </div>
    </div>
<div class="mid_bbg">
    <div style="clear:both"></div>
    <div class="zjnr_bgg">
    	<div class="con">
        	<h3><span style="margin-right:15px; font-size:36px;">第1步</span>复制商品标题查询进入淘宝</h3>
            <img src="<?=TPLURL?>/inc/images/help/step_1.jpg" />
            <img src="<?=TPLURL?>/inc/images/help/step_2.jpg" />
        </div>
    </div>
    <div style="clear:both"></div>
    <div class="zjnr_bgg">
    	<div class="con">
        	<h3><span style="margin-right:15px; font-size:36px;">第2步</span>找到并购买商品</h3>
            <img src="<?=TPLURL?>/inc/images/help/step_3.jpg" />
            <img src="<?=TPLURL?>/inc/images/help/step_4.jpg" />
        </div>
    </div>
    <div style="clear:both"></div>
    <div class="zjnr_bgg" style="padding-bottom:20px;">
    	<div class="con">
        	<h3><span style="margin-right:15px; font-size:36px;">第3步</span>确认收货后回网站拿返利</h3>
            <img src="<?=TPLURL?>/inc/images/help/step_5.jpg" />
        </div>
    </div>
    <div style="clear:both"></div>
    <div style="background:none; width:1000px; float:left;">
    	<div class="con">
            <a class="shishi" href="<?=$index_url?>" target="_blank"></a>
            <a class="right" href="<?=$help_url?>" target="_blank"></a>
        </div>
    </div>
    <div style="clear:both"></div>
    <div style="background:none; width:1000px; float:left; margin-bottom:20px;">
    	<div class="wenda">常见疑问解答</div>
        <div class="wendas">
            <dl>
            	<dt>
                    <em>Q：</em> 通过关键词或商品名称去搜索可以返利吗？
                </dt>
                <dd>
                    <em>A：</em> 可以的，根据新规则，不能在本网站查返利了，但只要搜索去淘宝下单购买 都有返利的。
                </dd>
            </dl>
            <dl>
                <dt>
                    <em>Q：</em> 搜索商品名称后如何找我想买的商品？
                </dt>
                <dd>
                    <em>A：</em> 搜索商品跳转到淘宝后根据您找的淘宝商品旺旺名称确定是否为您找的商品。如果找不到 说明此商品无返利。
                </dd>
            </dl>
            <dl>
                <dt>
                    <em>Q：</em> 有什么简易方法能快速拿返利吗？
                </dt>
                <dd>
                    <em>A：</em> 建议收藏我们网站，每次去淘宝购物前先到我们网站搜索去淘宝找商品，只要通过本站去淘宝搜索购物都有返利，这样不用找到商品复制商品名称到我们网站来搜索拿返利了。
                </dd>
            </dl>
            <dl>
                <dt>
                    <em>Q：</em> 商家宝贝打折优惠时，可以返利吗？返利是怎么算的
                </dt>
                <dd>
                    <em>A：</em> 商家宝贝有打折优惠时，可以在成交价的基础上获得返利，享受折上折待遇。
                </dd>
            </dl>
            <dl>
                <dt>
                    <em>Q：</em> 聚划算有返利吗？
                </dt>
                <dd>
                    <em>A：</em> 聚划算没有返利了。
                </dd>
            </dl>
            <dl class="last">
                <dt>
                    <em>Q：</em> 货到付款是否可以得到返利？
                </dt>
                <dd>
                    <em>A：</em> 货到付款暂时无法得到返利，建议使用网上支付。
                </dd>
            </dl>
            <a class="btn-tbg-more" target="_blank" href="<?=$index_url?>">
				<img width="183" height="48" alt="查看更多解答" src="<?=TPLURL?>/inc/images/help/jieda_btn.jpg">
			</a>
        </div>
    </div>
    <div style="clear:both"></div>
</div>
<?php
include(TPLPATH.'/inc/footer.tpl.php');
?>
