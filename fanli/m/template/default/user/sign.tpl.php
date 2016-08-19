<?php
if (!defined('INDEX')) {
	exit ('Access Denied');
}

$parameter=act_wap_sign();
extract($parameter);

include(TPLPATH.'/inc/header.tpl.php');
?>
<script>
$(function(){
	<?php foreach($dd_tpl_data['sign'] as $k=>$v){?>
		$('.jfblogo').eq(<?=$k?>).find('span').html('×'+String(<?=$v?>));
	<?php }?>
	
	$('.lq_on').each(function(i){
		if(i<<?=$dduser['signnum']?>){
			$(this).show();
		}
	});
});

function qiandao(){
	var url='<?=wap_l(MOD,ACT)?>&sub=1';
	$.ajax({
		url: url,
		dataType:'jsonp',
		jsonp:"callback",
		success: function(data){
			if(data.s==1){
				ddAlert(data.r,'<?=wap_l(MOD,'invite',array('rec'=>$dduser['id']))?>');
			}
			else{
				ddAlert(data.r,'<?=wap_l(MOD,'login',array('from'=>wap_l(MOD,'sign')))?>');
			}
		}
	});
}
</script>
</head>

<body>
<div class="bbac">
    <ul>
        <li>
            <div class="w50" onClick="qiandao()">
                <div>
                    <p class="jfblogo mt05"><img src="<?=TPLURL?>/inc/images/sign.png"><span>×1</span></p>
                    <p class="mt03">第一天</p>
                </div>
                <div class="lq_on">
                    <p>已领取</p>
                </div>
            </div>
        </li>
        <li>
            <div class="w50" onClick="qiandao()">
              <div>
                <p class="jfblogo mt05"><img src="<?=TPLURL?>/inc/images/sign.png"><span>×2</span></p>
                <p class="mt03">第二天</p>
              </div>
              <div class="lq_on">
                    <p>已领取</p>
                </div>
            </div>
        </li>
        <li>
            <div class="w50" onClick="qiandao()">
            <div>
                <p class="jfblogo mt05"><img src="<?=TPLURL?>/inc/images/sign.png"><span>×3</span></p>
                <p class="mt03">第三天</p>
                </div>
              <div class="lq_on">
                    <p>已领取</p>
                </div>
            </div>
        </li>
        <li>
            <div class="w50" onClick="qiandao()">
            <div>
                <p class="jfblogo mt05"><img src="<?=TPLURL?>/inc/images/sign.png"><span>×4</span></p>
                <p class="mt03">第四天</p>
                </div>
              <div class="lq_on">
                    <p>已领取</p>
                </div>
            </div>
        </li>
        <li>
            <div class="w50" onClick="qiandao()">
            <div>
                <p class="jfblogo mt05"><img src="<?=TPLURL?>/inc/images/sign.png"><span>×5</span></p>
                <p class="mt03">第五天</p>
                </div>
              <div class="lq_on">
                    <p>已领取</p>
                </div>
            </div>
        </li>
        <li>
            <div class="w50" onClick="qiandao()">
            <div>
                <p class="jfblogo mt05"><img src="<?=TPLURL?>/inc/images/sign.png"><span>×6</span></p>
                <p class="mt03">第六天</p>
                </div>
              <div class="lq_on">
                    <p>已领取</p>
                </div>
            </div>
        </li>
        <li>
            <div class="w50" onClick="qiandao()">
            <div>
                <p class="jfblogo mt05"><img src="<?=TPLURL?>/inc/images/sign.png"><span>×7</span></p>
                <p class="mt03">第七天</p>
                </div>
              <div class="lq_on">
                    <p>已领取</p>
                </div>
            </div>
        </li>
        <li>
            <div style="margin-top:1.1em">
            <p class="p_lq"><input class="lqbtn" type="submit" onClick="qiandao()" value="领取"></p>
            </div>
        </li>
        
        
        <div style="clear:both"></div>
    </ul>
</div>
<div class="guize">
	<p class="title">签到规则：</p>
    <p>1、<img src="<?=TPLURL?>/inc/images/jfb.png">&nbsp;兑换比例为100:1元，可在支付宝支付时抵现金。</p>
    <p>2、连续7天可得高倍签到奖励。</p>
    <p>3、领取的集分宝在您的会员中心里查看，可申请提取。</p>
    <p>4、签到奖励共奖1000万，先到先得哦。</p>
</div>
<div>&nbsp;</div>

</body>

<?php include(TPLPATH.'/inc/footer.tpl.php');?>