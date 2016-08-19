<?php
error_reporting(0);
define('DDROOT', str_replace(DIRECTORY_SEPARATOR,'/',dirname(dirname(__FILE__))));
include(DDROOT.'/comm/lib.php');
include(DDROOT.'/comm/checkpostandget.php');
$webset=dd_get_cache('webset');
$pid=$webset['taoapi']['taobao_chongzhi_pid'];
$uid=(int)$_GET['uid'];

if(strpos($pid,'mm')!==false){
	$pid=$pid;
}
else{
	$pid='mm_'.$pid;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>充值</title>
    <meta charset="gbk"/>
    <meta name="data-spm" content="1" />
 <!--频道页面js 相关 -->
<script type='text/javascript'> 
	// php
    var taoke_channel_referer_id = '<?=$pid?>';
	 // 钻石展位
	var alimama_referpid='<?=$pid?>';
</script>
<script type='text/javascript'> 
    tbk_pid='<?=$pid?>';
    tbk_type='5';
    var tbk_pathname = window.location.pathname;
	tbk_pathname=tbk_pathname.substring(tbk_pathname.lastIndexOf("/")+1,tbk_pathname.lastIndexOf(".php"));
    tbk_id="ch_"+tbk_pathname;
    tbk_pre = document.referrer;
</script>
<script type="text/javascript" src="http://z.alimama.com/tbk_inf.js"></script><script> 
var uid = '<?=$uid?>',taokeUrl = 'http://www.alimama.com/',pid = '<?=$pid?>';
</script>    <script type="text/javascript">
        //面值是否有radio选项
        var __isDenominationElse = true;
        //是否有用户历史记录
        var __isHistory = true;
    </script>
    <link rel="stylesheet" href="http://a.tbcdn.cn/apps/med/other/tbk/chongzhi.css?20121119.css" type="text/css" />
    <script type="text/javascript" src="http://a.tbcdn.cn/s/kissy/1.2.0/kissy-min.js" charset="utf-8"></script>
    <script type="text/javascript" src="http://a.tbcdn.cn/apps/med/other/tbk/convenience/lvxing/moment.js" charset="utf-8"></script><meta http-equiv="Content-Type" content="text/html; charset=gb2312"></head>
<body data-spm="135976"><script type="text/javascript"> 
(function (d) {
var t=d.createElement("script");t.type="text/javascript";t.async=true;t.id="tb-beacon-aplus";
t.setAttribute("exparams","category=&userid=&aplus");
t.src=("https:"==d.location.protocol?"https://s":"http://a")+".tbcdn.cn/s/aplus_v2.js";
d.getElementsByTagName("head")[0].appendChild(t);
})(document);
</script>
 
<div class="tk210x200" id="J_ChongZhiContainer" style="height:198px; border:0">
    <div class="switchable">
                    <a href="http://s.click.taobao.com/t?pid=<?=$pid?>&e=zGU34CA7K%2BPkqB05%2Bm7rfGKas1PIKp0U37pZuBoqR26DdsswrDgHSrCNjO54g48d5VlMunlYrUiLsBvRJ9P9YHtxJAWSpSjB8D7b4%2B3hxm7iWgMrFoI%3D" class=" logo" target="_blank" style=" display:block; width:0px; height:0px"><img src="http://img02.taobaocdn.com/tps/i2/T1kOyqXfRUXXXXXXXX-56-28.png" height="0" width="0"></a>
        <ul class="nav ks-switchable-nav">            <li class="ks-switchable-trigger current">
                <a href="http://s8.taobao.com/search?pid=<?=$pid?>&mode=63&refpos=&cat=50004958&scat=y&catName=%D2%C6%B6%AF%2F%C1%AA%CD%A8%2F%B5%E7%D0%C5%B3%E4%D6%B5%D6%D0%D0%C4" target="_blank" class="nav-other" style="border-left:none">手机充值</a>
                <s class="arrow-top"></s>
            </li>
            <li class="ks-switchable-trigger">
                <a href="http://s8.taobao.com/search?pid=<?=$pid?>&mode=63&refpos=&cat=99&commend=all&s=0&sort=commend&n=40&olu=yes&yp4p_page=0&viewIndex=1" target="_blank" class="nav-other">游戏快充</a>
                <s class="arrow-top"></s>
            </li>            <li class="ks-switchable-trigger">
                        <a href="http://s.click.taobao.com/t?pid=<?=$pid?>&e=zGU34CA7K%2BPkqB05%2Bm7rfGKas1PIKp0U37pZuBoqR26DdsswrDgHSrCNjO54g48d5VlMunlYrUiLsBvRJ9P9YHtxJAWSpSjB8D7b4%2B3hxm7iWgMrFoI%3D" target="_blank" class="nav-other">淘宝旅行</a>
                <s class="arrow-top"></s>
            </li>        </ul>
    </div>
    <div class="ks-switchable-content">        <div class="ks-switchable-panel">
            <form id="J_TelForm" method="post">
                <div class="tel-section3">
                    <label class="tel-section-title" for="J_TelInput">手机号:</label>
                    <div class="text-wrap">
                        <div class="wrapper">
                            <input class="text-filed" maxlength="11" type="text" name="" id="J_TelInput">
                        </div>
                    </div>
                </div>
                <div class="tel-section3" style="display:block;">
                    <label class="tel-section-title">归属地:</label>
                    <div class="text-wrap">
                        <span id="J_ZoneAndSP_def" class="tel-section-dft">运营商、地区</span>
                        <span id="J_ZoneAndSP_show" class="tel-section-price" style="float:left;display:none;"><span id="J_TelInfoCfm"></span></span>
                    </div>
                </div>
                <div class="tel-section3">
                    <label class="tel-section-title">面　值:</label>
                    <div class="text-wrap">
                    <input type="radio" name="denom-r" class="denom-r" id="denom-100" checked value="100" data-id="30679" /><label for="denom-100">100元</label>
                        <input type="radio" name="denom-r" class="denom-r" id="denom-50" value="50" data-id="30678" /><label for="denom-50">50元</label>
                        <input type="radio" name="denom-r" class="denom-r" id="denom-30" value="30" data-id="30688" /><label for="denom-50">30元</label>
                        <select style="display:none" id="J_Dnomination" class="tel-section-select3" name=""></select>
                    </div>
                </div>
                <div class="tel-section3">
                    <span class="tel-section-title">售　价:</span>
                    <div class="text-wrap">
                    <span id="J_TelPrice" class="tel-section-price">1元-1000元</span>
                       </div>
                </div>
                <div class="tel-buy tp-btn">
                    <a href='#' target="_blank" id="J_TelSubmitBtn" class=" tel-submit" hidefocus="true" >点此充值</a>
                </div>
            </form>
        </div>        <div style="display:none" class="ks-switchable-panel">            <div class="tel-section3">
                <div class="text-wrap2">
                    <input type="radio" checked="" id="card" name="game">
                    <label hidefocus="true" for="card" class="tel-section-game-label">点卡</label>
                    <input type="radio" id="gold" name="game">
                    <label hidefocus="true" for="gold" class="tel-section-game-label">QQ</label>
                    <input type="radio" id="game" name="game">
                    <label hidefocus="true" for="game" class=" tel-section-game-label">网游物品</label>
                </div>
            </div>
            <div class="tel-section3">
                <label  id="J_labelType" class="tel-section-title">游戏:</label>
                 <div class="text-wrap">
                    <select  id="J_selectType" class="tel-section-select2" name="">
                    </select>
                </div>
            </div>
            <div class="tel-section3">
                <label  id="J_labelPrice" class="tel-section-title">面值:</label>
                <div class="text-wrap">
                    <select  id="J_selectPrice" class="tel-section-select2" name=""></select>
                </div>
            </div>
            <div id="J_price_container" class="tel-section3">
                <span class="tel-section-title">售价:</span>
                <div class="text-wrap">
                    <span id="J_youxiPrice" class="tel-section-price" style="float:left;margin-right:10px">暂缺</span>
                </div>
            </div>
            <div class="tel-buy tp-btn">
                <a href='#' target="_blank" id="J_youxiSubmitBtn" class=" tel-submit" hidefocus="true" >点此充值</a>
                
            </div>
        </div>        <div style="display:none" class="ks-switchable-panel" id="J_lvxingForms">            <div class="tel-section3">
                <ul class="menubar ks-switchable-nav">
                    <li class="ks-lvxing-trigger">
                        <a href="#" class="li-current">国内机票</a>
                    </li>
                    <li class="ks-lvxing-trigger">
                        <a href="#">国际机票</a>
                    </li>
                    <li class="ks-lvxing-trigger">
                        <a href="#">酒店</a>
                    </li>
 
                    <li class="ks-lvxing-trigger">
                        <a href="#" ></a>
                    </li>
                </ul>
            </div>
 
            <div class="ks-lvxing-panel">
                <div class="tel-section3">
                    <label class="tel-section-title2">出发:</label>
                    <div class="text-wrap3">
                        <select class="tel-section-select2" id="neDepCity">
                            <option value="">-请选择-</option>
                            <option value="AKU">A阿克苏</option>
                            <option value="AAT">A阿勒泰</option>
                            <option value="AKA">A安康</option>
                            <option value="AQG">A安庆</option>
 
                            <option value="AOG">A鞍山</option>
                            <option value="AVA">A安顺</option>
 
                            <option value="BJS">B北京</option>
                            <option value="BSD">B保山</option>
                            <option value="BAV">B包头</option>
                            <option value="BHY">B北海</option>
 
                            <option value="BFU">B蚌埠</option>
                            <option value="CKG">C重庆</option>
 
                            <option value="CTU">C成都</option>
                            <option value="CSX">C长沙</option>
                            <option value="CGQ">C长春</option>
                            <option value="CGD">C常德</option>
 
                            <option value="CIF">C赤峰</option>
                            <option value="CHG">C朝阳</option>
 
                            <option value="CIH">C长治</option>
                            <option value="CZX">C常州</option>
                            <option value="CNI">C长海</option>
                            <option value="DLC">D大连</option>
 
                            <option value="DDG">D丹东</option>
                            <option value="DNH">D敦煌</option>
 
                            <option value="DLU">D大理</option>
                            <option value="DIG">D迪庆</option>
                            <option value="DAX">D达县</option>
                            <option value="DAT">D大同</option>
 
                            <option value="DOY">D东营</option>
                            <option value="ENH">E恩施</option>
 
                            <option value="DSN">E鄂尔多斯</option>
                            <option value="FOC">F福州</option>
                            <option value="FYN">F富蕴</option>
                            <option value="FUG">F阜阳</option>
 
                            <option value="FUO">F佛山</option>
                            <option value="CAN">G广州</option>
 
                            <option value="KWL">G桂林</option>
                            <option value="KWE">G贵阳</option>
                            <option value="KOW">G赣州</option>
                            <option value="GOQ">G格尔木</option>
 
                            <option value="GHN">G广汉</option>
                            <option value="GYS">G广元</option>
 
                            <option value="HGH">H杭州</option>
                            <option value="HRB">H哈尔滨</option>
                            <option value="HFE">H合肥</option>
                            <option value="HET">H呼和浩特</option>
 
                            <option value="HAK">H海口</option>
                            <option value="TXN">H黄山</option>
 
                            <option value="HLD">H海拉尔</option>
                            <option value="HEK">H黑河</option>
                            <option value="HMI">H哈密</option>
                            <option value="HTN">H和田</option>
 
                            <option value="HYN">H黄岩</option>
                            <option value="HNY">H衡阳</option>
 
                            <option value="HZG">H汉中</option>
                            <option value="JIL">J吉林</option>
                            <option value="TNA">J济南</option>
                            <option value="JZH">J九寨沟</option>

 
                            <option value="KNC">J吉安</option>
                            <option value="JNG">J济宁</option>
 
                            <option value="JMU">J佳木斯</option>
                            <option value="JGN">J嘉峪关</option>
                            <option value="JDZ">J景德镇</option>
                            <option value="JHG">J景洪</option>
 
                            <option value="JJN">J晋江</option>
                            <option value="JNZ">J锦州</option>
 
                            <option value="CHW">J酒泉</option>
                            <option value="JIU">J九江</option>
                            <option value="JGS">J井冈山</option>
                            <option value="KMG">K昆明</option>
 
                            <option value="KRY">K克拉玛依</option>
                            <option value="KHG">K喀什</option>
 
                            <option value="KRL">K库尔勒</option>
                            <option value="KCA">K库车</option>
                            <option value="LHW">L兰州</option>
                            <option value="LXA">L拉萨</option>
 
                            <option value="LYG">L连云港</option>
                            <option value="LJG">L丽江</option>
 
                            <option value="LYI">L临沂</option>
                            <option value="LZH">L柳州</option>
                            <option value="LYA">L洛阳</option>
                            <option value="LNJ">L临沧</option>
 
                            <option value="LZO">L泸州</option>
                            <option value="LCX">L连城</option>
 
                            <option value="LUM">M芒市</option>
                            <option value="MXZ">M梅县</option>
                            <option value="NZH">M满洲里</option>
                            <option value="MIG">M绵阳</option>
 
                            <option value="MDG">M牡丹江</option>
                            <option value="NKG">N南京</option>
 
                            <option value="KHN">N南昌</option>
                            <option value="NGB">N宁波</option>
                            <option value="NAO">N南充</option>
                            <option value="WUS">N南平</option>
 
                            <option value="NNG">N南宁</option>
                            <option value="NTG">N南通</option>
 
                            <option value="NNY">N南阳</option>
                            <option value="PZI">P攀枝花</option>
                            <option value="TAO">Q青岛</option>
                            <option value="NDG">Q齐齐哈尔</option>
 
                            <option value="SHP">Q秦皇岛</option>
                            <option value="IQM">Q且末</option>
 
                            <option value="IQN">Q庆阳</option>
                            <option value="JJN">Q泉州</option>
                            <option value="JUZ">Q衢州</option>
                            <option value="SHA">S上海</option>
 
                            <option value="SZX">S深圳</option>
                            <option value="SHE">S沈阳</option>
 
                            <option value="SJW">S石家庄</option>
                            <option value="SZV">S苏州</option>
                            <option value="SYX">S三亚</option>
                            <option value="SWA">S汕头</option>
 
                            <option value="SHS">S沙市</option>
                            <option value="SYM">S思茅</option>
 
                            <option value="TYN">T太原</option>
                            <option value="TSN">T天津</option>
                            <option value="TCG">T塔城</option>
                            <option value="TNH">T通化</option>
 
                            <option value="TGO">T通辽</option>
                            <option value="TEN">T铜仁</option>
 
                            <option value="WUH">W武汉</option>
                            <option value="WNZ">W温州</option>
                            <option value="URC">W乌鲁木齐</option>
                            <option value="WUX">W无锡</option>
 
                            <option value="WXN">W万州</option>
                            <option value="WEF">W潍坊</option>
 
                            <option value="WEH">W威海</option>
                            <option value="HLH">W乌兰浩特</option>
                            <option value="WUZ">W乌海</option>
                            <option value="WUS">W武夷山</option>
 
                            <option value="WUZ">W梧州</option>
                            <option value="WNH">W文山</option>
 
                            <option value="XIY">X西安</option>
                            <option value="XMN">X厦门</option>
                            <option value="DIG">X香格里拉</option>
                            <option value="XNN">X西宁</option>
 
                            <option value="XUZ">X徐州</option>
                            <option value="JHG">X西双版纳</option>
 
                            <option value="XFN">X襄樊</option>
                            <option value="XIC">X西昌</option>
                            <option value="XIL">X锡林浩特</option>
                            <option value="ACX">X兴义</option>
 
                            <option value="XNT">X邢台</option>
                            <option value="INC">Y银川</option>
 
                            <option value="ENY">Y延安</option>
                            <option value="YNJ">Y延吉</option>
                            <option value="YNT">Y烟台</option>
                            <option value="YNZ">Y盐城</option>
 
                            <option value="YBP">Y宜宾</option>
                            <option value="YIH">Y宜昌</option>
 
                            <option value="YIN">Y伊宁</option>
                            <option value="YIW">Y义乌</option>
                            <option value="UYN">Y榆林</option>
                            <option value="YCU">Y运城</option>
 
                            <option value="LLF">Y永州</option>
                            <option value="CGO">Z郑州</option>
 
                            <option value="ZUH">Z珠海</option>
                            <option value="ZAT">Z昭通</option>
                            <option value="DYG">Z张家界</option>
                            <option value="ZHA">Z湛江</option>
 
                            <option value="HSN">Z舟山</option>
                            <option value="ZYI">Z遵义</option>
 
                            <option value="HJJ">Z芷江</option>
                        </select>
                    </div>
                </div>
                <div class="tel-section3">
                    <label class="tel-section-title2">到达:</label>
                    <div class="text-wrap3">
                        <select class="tel-section-select2" id="neArrCity" style="color: #C60;">
                            <option value="">-请选择-</option>
                            <option value="AKU">A阿克苏</option>
                            <option value="AAT">A阿勒泰</option>
                            <option value="AKA">A安康</option>
                            <option value="AQG">A安庆</option>
 
                            <option value="AOG">A鞍山</option>
                            <option value="AVA">A安顺</option>
 
                            <option value="BJS">B北京</option>
                            <option value="BSD">B保山</option>
                            <option value="BAV">B包头</option>
                            <option value="BHY">B北海</option>
 
                            <option value="BFU">B蚌埠</option>
                            <option value="CKG">C重庆</option>
 
                            <option value="CTU">C成都</option>
                            <option value="CSX">C长沙</option>
                            <option value="CGQ">C长春</option>
                            <option value="CGD">C常德</option>
 
                            <option value="CIF">C赤峰</option>
                            <option value="CHG">C朝阳</option>
 
                            <option value="CIH">C长治</option>
                            <option value="CZX">C常州</option>
                            <option value="CNI">C长海</option>
                            <option value="DLC">D大连</option>
 
                            <option value="DDG">D丹东</option>
                            <option value="DNH">D敦煌</option>
 
                            <option value="DLU">D大理</option>
                            <option value="DIG">D迪庆</option>
                            <option value="DAX">D达县</option>
                            <option value="DAT">D大同</option>
 
                            <option value="DOY">D东营</option>
                            <option value="ENH">E恩施</option>
 
                            <option value="DSN">E鄂尔多斯</option>
                            <option value="FOC">F福州</option>
                            <option value="FYN">F富蕴</option>
                            <option value="FUG">F阜阳</option>
 
                            <option value="FUO">F佛山</option>
                            <option value="CAN">G广州</option>
 
                            <option value="KWL">G桂林</option>
                            <option value="KWE">G贵阳</option>
                            <option value="KOW">G赣州</option>
                            <option value="GOQ">G格尔木</option>
 
                            <option value="GHN">G广汉</option>
                            <option value="GYS">G广元</option>
 
                            <option value="HGH">H杭州</option>
                            <option value="HRB">H哈尔滨</option>
                            <option value="HFE">H合肥</option>
                            <option value="HET">H呼和浩特</option>
 
                            <option value="HAK">H海口</option>
                            <option value="TXN">H黄山</option>
 
                            <option value="HLD">H海拉尔</option>
                            <option value="HEK">H黑河</option>
                            <option value="HMI">H哈密</option>
                            <option value="HTN">H和田</option>
 
                            <option value="HYN">H黄岩</option>
                            <option value="HNY">H衡阳</option>
 
                            <option value="HZG">H汉中</option>
                            <option value="JIL">J吉林</option>
                            <option value="TNA">J济南</option>
                            <option value="JZH">J九寨沟</option>
 
                            <option value="KNC">J吉安</option>
                            <option value="JNG">J济宁</option>
 
                            <option value="JMU">J佳木斯</option>
                            <option value="JGN">J嘉峪关</option>
                            <option value="JDZ">J景德镇</option>
                            <option value="JHG">J景洪</option>
 
                            <option value="JJN">J晋江</option>
                            <option value="JNZ">J锦州</option>
 
                            <option value="CHW">J酒泉</option>
                            <option value="JIU">J九江</option>
                            <option value="JGS">J井冈山</option>
                            <option value="KMG">K昆明</option>
 
                            <option value="KRY">K克拉玛依</option>
                            <option value="KHG">K喀什</option>
 
                            <option value="KRL">K库尔勒</option>
                            <option value="KCA">K库车</option>
                            <option value="LHW">L兰州</option>
                            <option value="LXA">L拉萨</option>
 
                            <option value="LYG">L连云港</option>
                            <option value="LJG">L丽江</option>
 
                            <option value="LYI">L临沂</option>
                            <option value="LZH">L柳州</option>
                            <option value="LYA">L洛阳</option>
                            <option value="LNJ">L临沧</option>
 
                            <option value="LZO">L泸州</option>
                            <option value="LCX">L连城</option>
 
                            <option value="LUM">M芒市</option>
                            <option value="MXZ">M梅县</option>
                            <option value="NZH">M满洲里</option>
                            <option value="MIG">M绵阳</option>
 
                            <option value="MDG">M牡丹江</option>
                            <option value="NKG">N南京</option>
 
                            <option value="KHN">N南昌</option>
                            <option value="NGB">N宁波</option>
                            <option value="NAO">N南充</option>
                            <option value="WUS">N南平</option>
 
                            <option value="NNG">N南宁</option>
                            <option value="NTG">N南通</option>
 
                            <option value="NNY">N南阳</option>
                            <option value="PZI">P攀枝花</option>
                            <option value="TAO">Q青岛</option>
                            <option value="NDG">Q齐齐哈尔</option>
 
                            <option value="SHP">Q秦皇岛</option>
                            <option value="IQM">Q且末</option>
 
                            <option value="IQN">Q庆阳</option>
                            <option value="JJN">Q泉州</option>
                            <option value="JUZ">Q衢州</option>
                            <option value="SHA">S上海</option>
 
                            <option value="SZX">S深圳</option>
                            <option value="SHE">S沈阳</option>
 
                            <option value="SJW">S石家庄</option>
                            <option value="SZV">S苏州</option>
                            <option value="SYX">S三亚</option>
                            <option value="SWA">S汕头</option>
 
                            <option value="SHS">S沙市</option>
                            <option value="SYM">S思茅</option>
 
                            <option value="TYN">T太原</option>
                            <option value="TSN">T天津</option>
                            <option value="TCG">T塔城</option>
                            <option value="TNH">T通化</option>
 
                            <option value="TGO">T通辽</option>
                            <option value="TEN">T铜仁</option>
 
                            <option value="WUH">W武汉</option>
                            <option value="WNZ">W温州</option>
                            <option value="URC">W乌鲁木齐</option>
                            <option value="WUX">W无锡</option>
 
                            <option value="WXN">W万州</option>
                            <option value="WEF">W潍坊</option>
 
                            <option value="WEH">W威海</option>
                            <option value="HLH">W乌兰浩特</option>
                            <option value="WUZ">W乌海</option>
                            <option value="WUS">W武夷山</option>
 
                            <option value="WUZ">W梧州</option>
                            <option value="WNH">W文山</option>
 
                            <option value="XIY">X西安</option>
                            <option value="XMN">X厦门</option>
                            <option value="DIG">X香格里拉</option>
                            <option value="XNN">X西宁</option>
 
                            <option value="XUZ">X徐州</option>
                            <option value="JHG">X西双版纳</option>
 
                            <option value="XFN">X襄樊</option>
                            <option value="XIC">X西昌</option>
                            <option value="XIL">X锡林浩特</option>
                            <option value="ACX">X兴义</option>
 
                            <option value="XNT">X邢台</option>
                            <option value="INC">Y银川</option>
 
                            <option value="ENY">Y延安</option>
                            <option value="YNJ">Y延吉</option>
                            <option value="YNT">Y烟台</option>
                            <option value="YNZ">Y盐城</option>
 
                            <option value="YBP">Y宜宾</option>
                            <option value="YIH">Y宜昌</option>
 
                            <option value="YIN">Y伊宁</option>
                            <option value="YIW">Y义乌</option>
                            <option value="UYN">Y榆林</option>
                            <option value="YCU">Y运城</option>
 
                            <option value="LLF">Y永州</option>
                            <option value="CGO">Z郑州</option>
 
                            <option value="ZUH">Z珠海</option>
                            <option value="ZAT">Z昭通</option>
                            <option value="DYG">Z张家界</option>
                            <option value="ZHA">Z湛江</option>
 
                            <option value="HSN">Z舟山</option>
                            <option value="ZYI">Z遵义</option>
 
                            <option value="HJJ">Z芷江</option>
                        </select>
                    </div>
                </div>
                <div class="tel-section3">
                    <span class="tel-section-title2 tp-tit">出发:</span>
                    <div class="text-wrap3">
                        <select class="tel-section-select6" id="J_ds_y_gn"></select>
                        <span>-</span>
                        <select class="tel-section-select7" id="J_ds_m_gn"></select>
                        <span>-</span>
                        <select class="tel-section-select7" id="J_ds_d_gn"></select>
                    </div>
                </div>
                <div class="tel-buy tp-btn">
                    <a class="tel-discount" id="J_gn_submit" href="#" target="_blank">查看折扣价</a>   
                </div>
            </div>
 
            <div class="ks-lvxing-panel" style="display:none;">
                <div class="tel-section3">
                    <label class="tel-section-title2">出发:</label>
                    <div class="text-wrap3">
                        <select class="tel-section-select2" id="ieDepCity">
                            <option value="">-请选择-</option>
                            <option value="AKU">A阿克苏</option>
                            <option value="AAT">A阿勒泰</option>
                            <option value="AKA">A安康</option>
                            <option value="AQG">A安庆</option>
 
                            <option value="AOG">A鞍山</option>
                            <option value="AVA">A安顺</option>
 
                            <option value="BJ">B北京</option>
                            <option value="BSD">B保山</option>
                            <option value="BAV">B包头</option>
                            <option value="BHY">B北海</option>
 
                            <option value="BFU">B蚌埠</option>
                            <option value="CKG">C重庆</option>
 
                            <option value="CTU">C成都</option>
                            <option value="CSX">C长沙</option>
                            <option value="CGQ">C长春</option>
                            <option value="CGD">C常德</option>
 
                            <option value="CIF">C赤峰</option>
                            <option value="CHG">C朝阳</option>
 
                            <option value="CIH">C长治</option>
                            <option value="CZX">C常州</option>
                            <option value="CNI">C长海</option>
                            <option value="DLC">D大连</option>
 
                            <option value="DDG">D丹东</option>
                            <option value="DNH">D敦煌</option>
 
                            <option value="DLU">D大理</option>
                            <option value="DIG">D迪庆</option>
                            <option value="DAX">D达县</option>
                            <option value="DAT">D大同</option>
 
                            <option value="DOY">D东营</option>
                            <option value="ENH">E恩施</option>
 
                            <option value="DSN">E鄂尔多斯</option>
                            <option value="FOC">F福州</option>
                            <option value="FYN">F富蕴</option>
                            <option value="FUG">F阜阳</option>
 
                            <option value="FUO">F佛山</option>
                            <option value="CAN">G广州</option>
 
                            <option value="KWL">G桂林</option>
                            <option value="KWE">G贵阳</option>
                            <option value="KOW">G赣州</option>
                            <option value="GOQ">G格尔木</option>
 
                            <option value="GHN">G广汉</option>
                            <option value="GYS">G广元</option>
 
                            <option value="HGH">H杭州</option>
                            <option value="HRB">H哈尔滨</option>
                            <option value="HFE">H合肥</option>
                            <option value="HET">H呼和浩特</option>
 
                            <option value="HAK">H海口</option>
                            <option value="TXN">H黄山</option>
 
                            <option value="HLD">H海拉尔</option>
                            <option value="HEK">H黑河</option>
                            <option value="HMI">H哈密</option>
                            <option value="HTN">H和田</option>
 
                            <option value="HYN">H黄岩</option>
                            <option value="HNY">H衡阳</option>
 
                            <option value="HZG">H汉中</option>
                            <option value="JIL">J吉林</option>
                            <option value="TNA">J济南</option>
                            <option value="JZH">J九寨沟</option>
 
                            <option value="KNC">J吉安</option>
                            <option value="JNG">J济宁</option>
 
                            <option value="JMU">J佳木斯</option>
                            <option value="JGN">J嘉峪关</option>
                            <option value="JDZ">J景德镇</option>
                            <option value="JHG">J景洪</option>
 
                            <option value="JJN">J晋江</option>
                            <option value="JNZ">J锦州</option>
 
                            <option value="CHW">J酒泉</option>
                            <option value="JIU">J九江</option>
                            <option value="JGS">J井冈山</option>
                            <option value="KMG">K昆明</option>
 
                            <option value="KRY">K克拉玛依</option>
                            <option value="KHG">K喀什</option>
 
                            <option value="KRL">K库尔勒</option>
                            <option value="KCA">K库车</option>
                            <option value="LHW">L兰州</option>
                            <option value="LXA">L拉萨</option>
 
                            <option value="LYG">L连云港</option>
                            <option value="LJG">L丽江</option>
 
                            <option value="LYI">L临沂</option>
                            <option value="LZH">L柳州</option>
                            <option value="LYA">L洛阳</option>
                            <option value="LNJ">L临沧</option>
 
                            <option value="LZO">L泸州</option>
                            <option value="LCX">L连城</option>
 
                            <option value="LUM">M芒市</option>
                            <option value="MXZ">M梅县</option>
                            <option value="NZH">M满洲里</option>
                            <option value="MIG">M绵阳</option>
 
                            <option value="MDG">M牡丹江</option>
                            <option value="NKG">N南京</option>
 
                            <option value="KHN">N南昌</option>
                            <option value="NGB">N宁波</option>
                            <option value="NAO">N南充</option>
                            <option value="WUS">N南平</option>
 
                            <option value="NNG">N南宁</option>
                            <option value="NTG">N南通</option>
 
                            <option value="NNY">N南阳</option>
                            <option value="PZI">P攀枝花</option>
                            <option value="TAO">Q青岛</option>
                            <option value="NDG">Q齐齐哈尔</option>
 
                            <option value="SHP">Q秦皇岛</option>
                            <option value="IQM">Q且末</option>
 
                            <option value="IQN">Q庆阳</option>
                            <option value="JJN">Q泉州</option>
                            <option value="JUZ">Q衢州</option>
                            <option value="SH">S上海</option>
 
                            <option value="SZX">S深圳</option>
                            <option value="SHE">S沈阳</option>
 
                            <option value="SJW">S石家庄</option>
                            <option value="SZV">S苏州</option>
                            <option value="SYX">S三亚</option>
                            <option value="SWA">S汕头</option>
 
                            <option value="SHS">S沙市</option>
                            <option value="SYM">S思茅</option>
 
                            <option value="TYN">T太原</option>
                            <option value="TSN">T天津</option>
                            <option value="TCG">T塔城</option>
                            <option value="TNH">T通化</option>
 
                            <option value="TGO">T通辽</option>
                            <option value="TEN">T铜仁</option>
 
                            <option value="WUH">W武汉</option>
                            <option value="WNZ">W温州</option>
                            <option value="URC">W乌鲁木齐</option>
                            <option value="WUX">W无锡</option>
 
                            <option value="WXN">W万州</option>
                            <option value="WEF">W潍坊</option>
 
                            <option value="WEH">W威海</option>
                            <option value="HLH">W乌兰浩特</option>
                            <option value="WUZ">W乌海</option>
                            <option value="WUS">W武夷山</option>
 
                            <option value="WUZ">W梧州</option>
                            <option value="WNH">W文山</option>
 
                            <option value="XIY">X西安</option>
                            <option value="XMN">X厦门</option>
                            <option value="DIG">X香格里拉</option>
                            <option value="XNN">X西宁</option>
 
                            <option value="XUZ">X徐州</option>
                            <option value="JHG">X西双版纳</option>
 
                            <option value="XFN">X襄樊</option>
                            <option value="XIC">X西昌</option>
                            <option value="XIL">X锡林浩特</option>
                            <option value="ACX">X兴义</option>
 
                            <option value="XNT">X邢台</option>
                            <option value="INC">Y银川</option>
 
                            <option value="ENY">Y延安</option>
                            <option value="YNJ">Y延吉</option>
                            <option value="YNT">Y烟台</option>
                            <option value="YNZ">Y盐城</option>
 
                            <option value="YBP">Y宜宾</option>
                            <option value="YIH">Y宜昌</option>
 
                            <option value="YIN">Y伊宁</option>
                            <option value="YIW">Y义乌</option>
                            <option value="UYN">Y榆林</option>
                            <option value="YCU">Y运城</option>
 
                            <option value="LLF">Y永州</option>
                            <option value="CGO">Z郑州</option>
 
                            <option value="ZUH">Z珠海</option>
                            <option value="ZAT">Z昭通</option>
                            <option value="DYG">Z张家界</option>
                            <option value="ZHA">Z湛江</option>
 
                            <option value="HSN">Z舟山</option>
                            <option value="ZYI">Z遵义</option>
 
                            <option value="HJJ">Z芷江</option>
                        </select>
                    </div>
                </div>
                <div class="tel-section3">
                    <label class="tel-section-title2">到达:</label>
                    <div class="text-wrap3">
                        <select class="tel-section-select2" id="ieArrCity" style="color: #09F;">
                            <option value="">-请选择-</option>
                            <option value="MFM">A澳门</option>
                            <option value="PAR">B巴黎</option>
 
                            <option value="TYO">D东京</option>
                            <option value="OSA">D大阪</option>
                            <option value="FRA">F法兰克福</option>
                            <option value="KUL">J吉隆坡</option>
                            <option value="LON">L伦敦</option>
                            <option value="LAX">L洛杉矶</option>
 
                            <option value="BKK">M曼谷</option>
                            <option value="NGO">M名古屋</option>
                            <option value="MEL">M墨尔本</option>
                            <option value="MUC">M慕尼黑</option>
                            <option value="NYC">N纽约</option>
                            <option value="SEL">S首尔</option>
 
                            <option value="TPE">T台北</option>
                            <option value="SIN">X新加坡</option>
                            <option value="HKG">X香港</option>
                            <option value="SYD">X悉尼</option>
                        </select>
                    </div>
                </div>
                <div class="tel-section3">
                    <span class="tel-section-title2 tp-tit">出发:</span>
                    <div class="text-wrap3">
                        <select class="tel-section-select6" id="J_ds_y_gj"></select>
                        <span>-</span>
                        <select class="tel-section-select7" id="J_ds_m_gj"></select>
                        <span>-</span>
                        <select class="tel-section-select7" id="J_ds_d_gj"></select>
                    </div>
                </div>
                <div class="tel-buy tp-btn">
                    <a class="tel-discount" id="J_gj_submit" target="_blank">查看折扣价</a>
                    
                </div>
            </div>
 
            <div class="ks-lvxing-panel" style="display:none;">
                <form target="_blank" id="J_HotelSearchForm" class="tp-main" action="http://kezhan.trip.taobao.com/hotel_list.htm" name="innerSearch" method="get">
                    <input type="hidden" name="action" value="hotel_list_action">
                    <input type="hidden" name="event_submit_do_search" value="submit">
                    <input type="hidden" id="J_CityCode" name="_fmd.h._0.cit" value="">
                    <input type="hidden" id="J_CountryCode" name="_fmd.h._0.co" value="">
                    <input type="hidden" id="J_Source" name="source" value="">
                    <input type="hidden" id="th:destCityCode" name="_fmho.h._0.de" value="">
                    <input type="hidden" name="payFilter" id="payFilter" value="">
                    <input type="hidden" name="sortBy" id="sortBy" value="">
                    <input type="hidden" id="breakFast" name="breakFast" value="">
                    <input type="hidden" id="wideBand" name="wideBand" value="">
                    <input type="hidden" name="_fmd.h._0.cu" id="currentPage" value="1">
 

                    <div class="tel-section3">
                        <label class="tel-section-title2">入住:</label>
                        <div class="text-wrap3">
                            <select name="_fmho.h._0.d" class="tel-section-select2" id="J_HotelDestination">
                                <option value="">-请选择-</option>
                                <option value="820000">A澳门</option>
                                <option value="110100">B北京市</option>
                                <option value="150200">B包头市</option>
                                <option value="450500">B北海市</option>
                                <option value="510100">C成都市</option>
                                <option value="500100">C重庆市</option>
                                <option value="130800">C承德市</option>
                                <option value="430100">C长沙市</option>
                                <option value="220100">C长春市</option>
                                <option value="140200">D大同市</option>
                                <option value="210200">D大连市</option>
                                <option value="210600">D丹东市</option>
                                <option value="230600">D大庆市</option>
                                <option value="371400">D德州市</option>
                                <option value="441900">D东莞市</option>
                                <option value="150600">E鄂尔多斯市</option>
                                <option value="350100">F福州市</option>
                                <option value="440600">F佛山市</option>
                                <option value="360700">G赣州市</option>
                                <option value="440100">G广州市</option>
                                <option value="450300">G桂林市</option>
                                <option value="520100">G贵阳市</option>
                                <option value="150700">H呼伦贝尔市</option>
                                <option value="150100">H呼和浩特市</option>
                                <option value="230100">H哈尔滨市</option>
                                <option value="211400">H葫芦岛市</option>
                                <option value="460100">H海口市</option>
                                <option value="330100">H杭州市</option>
                                <option value="340100">H合肥市</option>
                                <option value="341000">H黄山市</option>
                                <option value="420200">H黄石市</option>
                                <option value="421100">H黄冈市</option>
                                <option value="441300">H惠州市</option>
                                <option value="441600">H河源市</option>
                                <option value="652200">H哈密地区</option>
                                <option value="210700">J锦州市</option>
                                <option value="220200">J吉林市</option>
                                <option value="230800">J佳木斯市</option>
                                <option value="330400">J嘉兴市</option>
                                <option value="360400">J九江市</option>
                                <option value="360200">J景德镇市</option>
                                <option value="370100">J济南市</option>
                                <option value="421000">J荆州市</option>
                                <option value="440700">J江门市</option>
                                <option value="620200">J嘉峪关市</option>
                                <option value="410200">K开封市</option>
                                <option value="530100">K昆明市</option>
                                <option value="320700">L连云港市</option>
                                <option value="530700">L丽江市</option>
                                <option value="540100">L拉萨市</option>
                                <option value="542600">L林芝地区</option>
                                <option value="620100">L兰州市</option>
                                <option value="410300">L洛阳市</option>
                                <option value="231000">M牡丹江市</option>
                                <option value="340500">M马鞍山市</option>
                                <option value="320100">N南京市</option>
                                <option value="330200">N宁波市</option>
                                <option value="450100">N南宁市</option>
                                <option value="360100">N南昌市</option>
                                <option value="130300">Q秦皇岛市</option>
                                <option value="370200">Q青岛市</option>
                                <option value="469002">Q琼海市</option>
                                <option value="441800">Q清远市</option>
                                <option value="310100">S上海市</option>
                                <option value="130100">S石家庄市</option>
                                <option value="320500">S苏州市</option>
                                <option value="210100">S沈阳市</option>
                                <option value="361100">S上饶市</option>
                                <option value="411200">S三门峡市</option>
                                <option value="440300">S深圳市</option>
                                <option value="460200">S三亚市</option>
                                <option value="440500">S汕头市</option>
                                <option value="120100">T天津市</option>
                                <option value="370900">T泰安市</option>
                                <option value="130200">T唐山市</option>
                                <option value="140100">T太原市</option>
                                <option value="710100">T台北市</option>
                                <option value="652100">T吐鲁番地区</option>
                                <option value="320200">W无锡市</option>
                                <option value="330300">W温州市</option>
                                <option value="371000">W威海市</option>
                                <option value="420100">W武汉市</option>
                                <option value="450400">W梧州市</option>
                                <option value="469005">W文昌市</option>
                                <option value="650100">W乌鲁木齐市</option>
                                <option value="810000">X香港</option>
                                <option value="350200">X厦门市</option>
                                <option value="433100">X湘西土家族苗族自治州</option>
                                <option value="630100">X西宁市</option>
                                <option value="610100">X西安市</option>
                                <option value="610400">X咸阳市</option>
                                <option value="610600">Y延安市</option>
                                <option value="321000">Y扬州市</option>
                                <option value="370600">Y烟台市</option>
                                <option value="360600">Y鹰潭市</option>
                                <option value="420500">Y宜昌市</option>
                                <option value="530400">Y玉溪市</option>
                                <option value="640100">Y银川市</option>
                                <option value="321100">Z镇江市</option>
                                <option value="410100">Z郑州市</option>
                                <option value="430200">Z株洲市</option>
                                <option value="430800">Z张家界市</option>
                                <option value="440400">Z珠海市</option>
                                <option value="441200">Z肇庆市</option>
                            </select>
                            <input id="neDepCityName" name="_fmh.fl._0.s" type="hidden" value=""/>
                        </div>
                    </div>
                    <div class="tel-section3">
                        <span class="tel-section-title2 tp-tit">入住:</span>
                        <div class="text-wrap3 tp-opt">
                            <select class="tel-section-select6" id="J_ds_y_jdi"></select>
                            <span>-</span>
                            <select class="tel-section-select7" id="J_ds_m_jdi"></select>
                            <span>-</span>
                            <select class="tel-section-select7" id="J_ds_d_jdi"></select>
                        </div>
                        <input type="hidden" id="J_hotelInDate" value="" name="_fmd.h._0.ch">
                    </div>
                    <div class="tel-section3">
                        <span class="tel-section-title2 tp-tit">离开:</span>
                        <div class="text-wrap3 tp-opt">
                            <select class="tel-section-select6" id="J_ds_y_jdo"></select>
                            <span>-</span>
                            <select class="tel-section-select7" id="J_ds_m_jdo"></select>
                            <span>-</span>
                            <select class="tel-section-select7" id="J_ds_d_jdo"></select>
                        </div>
                        <input type="hidden" id="J_hotelOutDate" value="" name="_fmd.h._0.che">
                    </div>
                    <div class="tel-buy tp-btn">
                        <a class="tel-discount" id="J_jd_submit">查看折扣价</a>
                        
                   </div>
                </form>
            </div>
 
            <div class="ks-lvxing-panel" style="display:none;">
                <form id="J_TravelSearchForm1" target="_blank" class="tp-main" action="http://z.alimama.com/tksEss.php" method="get">
                    <input name="pid" type="hidden" value="<?=$pid?>">
                    <input name="cat" type="hidden" value="50018968">
                    <div class="tel-section2">
                        <div class="text-search">
                        <label class="">搜门票:</label>
                           <input class="text-filed"  id="J_TravelDestination" type="text" name="q" placeholder="请输入目的地名称">
                        </div>
                    </div>
                    <div class="tel-section2">
                        <span class="tel-section-title">热门服务:</span>
                        <span class="text-wrap">
                            
                                                               <a target="_blank" href="http://search8.taobao.com/search?spm=1.135976.162600.6&pid=<?=$pid?>&q=%BF%A8%C8%AF&mode=63&rt=1323681688769" class="text-hotlink">卡券</a>
                                                               <a target="_blank" href="http://search8.taobao.com/search?spm=1.135976.162600.7&pid=<?=$pid?>&q=%C7%A9%D6%A4&mode=63&rt=1323681715675" class="text-hotlink">签证</a>
                                                               <a target="_blank" href="http://search8.taobao.com/search?spm=1.135976.162600.8&pid=<?=$pid?>&q=%D7%E2%B3%B5&mode=63&rt=1323681736675" class="text-hotlink">租车</a>
                                                               <a target="_blank" href="http://search8.taobao.com/search?spm=1.135976.162600.9&pid=<?=$pid?>&q=%D3%CA%C2%D6&mode=63&rt=1323681752301" class="text-hotlink">邮轮</a>
                                                               <a target="_blank" href="http://search8.taobao.com/search?spm=1.135976.162600.10&pid=<?=$pid?>&q=%C2%C3%D3%CE%B6%C8%BC%D9&mode=63&rt=1323681962835" class="text-hotlink">旅游度假</a>
                                                           
                        </span>
                    </div>
                    <div class="tel-section2">
                        <span class="tel-section-title">热门城市:</span>
                        <span class="text-wrap">
                            
                                                                <a target="_blank" href="http://search8.taobao.com/search?spm=1.135976.162600.11&pid=<?=$pid?>&q=%CF%E3%B8%DB&mode=63&rt=1323680955228" class="text-hotlink">香港</a>
                                                                <a target="_blank" href="http://search8.taobao.com/search?spm=1.135976.162600.12&pid=<?=$pid?>&q=%C8%FD%D1%C7&mode=63&rt=1323680973025" class="text-hotlink">三亚</a>
                                                                <a target="_blank" href="http://search8.taobao.com/search?spm=1.135976.162600.13&pid=<?=$pid?>&q=%C0%F6%BD%AD&mode=63&rt=1323681059261" class="text-hotlink">丽江</a>
                                                                <a target="_blank" href="http://search8.taobao.com/search?spm=1.135976.162600.14&pid=<?=$pid?>&q=%B9%F0%C1%D6&mode=63&rt=1323683620559" class="text-hotlink">桂林</a>
                                                                <a target="_blank" href="http://search8.taobao.com/search?spm=1.135976.162600.15&pid=<?=$pid?>&q=%BE%C5%D5%AF%B9%B5&mode=63&rt=1323681132855" class="text-hotlink">九寨沟</a>
                                                            
                        </span>
                    </div>
                    <div class="tel-buy tp-btn">
                        <a class="tel-discount" id="J_lx_submit">查看折扣价</a>
                        
                    </div>
                </form>
            </div>        </div>
    </div>
</div>
</body>
<script type="text/javascript"> 
KISSY.config({
    map:[
        [/(.+convenience\/.+)-min.js(\?[^?]+)?$/, "$1.js$2"]
    ],
    packages:[
        {
            name:"convenience",
            tag:"20120702",
            path:"http://a.tbcdn.cn/apps/med/other/tbk/",
            charset:"utf-8"
        }
    ]
});
KISSY.use("convenience/lvxing/lvxing",function(S,LX){
    new LX();
});
 
KISSY.use("switchable,sizzle", function(S) {
    var Tabs = S.Tabs;
    S.ready(function(S) {
        var $ = S.all;
        var tabs = new Tabs('#J_ChongZhiContainer', {
            activeTriggerCls : 'current',
            markupType : 1,
            switchTo : 0
        });        var tabs2 = new Tabs('#J_lvxingForms', {
            triggerCls : 'ks-lvxing-trigger',
            activeTriggerCls : 'current',
            panelCls : 'ks-lvxing-panel',
            markupType : 1,
            switchTo : 0
        });
 
        tabs2.on('beforeSwitch', function(ev) {
            var index = ev.toIndex;
            var els = $(".menubar li a");
            els.each(function(el,i){
                if(i==index){
                    el.addClass("li-current");
                }
                else{
                    el.removeClass("li-current");
                }
            });
        });    });
});
</script><script src="http://www.taobao.com/go/act/mmbd/phonecard.php"></script>
<script src="http://a.tbcdn.cn/apps/med/other/tbk/history.js" charset="utf-8"></script>
<script src="http://a.tbcdn.cn/apps/med/other/tbk/shouji.js?t=20130709.js" charset="utf-8"></script><script src="http://www.taobao.com/go/act/mmbd/qqcard.php"></script>
<script src="http://www.taobao.com/go/act/mmbd/gamecard.php"></script>
<script src="http://www.taobao.com/go/act/mmbd/hotgame.php"></script>
<script src="http://a.tbcdn.cn/apps/med/other/tbk/youxi.js" charset="utf-8"></script><script src="http://a.alimama.cn/spmact/spmact.js"></script>
</html>