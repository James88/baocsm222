<?php
/**
 * ============================================================================
 * 版权所有 2008-2012 多多网络，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
if(TAOTYPE==2){
    $app_key = $webset['taoapi']['jssdk_key'];/*填写appkey */
    $secret=$webset['taoapi']['jssdk_secret'];/*填入Appsecret'*/
    $jssdk_time=TIME."000";
    $message = $secret.'app_key'.$app_key.'timestamp'.$jssdk_time.$secret;
    $jssdk_sign=strtoupper(dd_hash_hmac("md5",$message,$secret));
}
?>
<?php if(TAOTYPE==1){?>
<script>
TAO_TYPE=1;
JSSDK_TIME=0;
JSSDK_SIGN='';
</script>
<script src="<?=DD_YUN_URL.'/view.php?time='.TIME?>"></script>
<?php }elseif(TAOTYPE==2){?>
<script>
TAO_TYPE=2;
JSSDK_TIME='<?=$jssdk_time?>';
JSSDK_SIGN='<?=$jssdk_sign?>';
</script>
<?php }?>
<script>
GETAGAINTIME=3000; //二次加载时间

MONEYBL=<?=TBMONEYBL?>;
DATA_TYPE=<?=TBMONEYTYPE?>;

CACHEURL='http://<?=$_SERVER['HTTP_HOST'].URLMULU?>/data/temp/taoapi';
SHOPOPEN=<?=(int)$webset['shop']['open']?>;
SHOPSLEVEL=<?=(int)$webset['shop']['slevel']?>;
SHOPELEVEL=<?=(int)$webset['shop']['elevel']?>;
CACHETIME=<?=(int)$webset['taoapi']['cache_time']?>;
ERRORLOG=<?=(int)$webset['taoapi']['errorlog']?>;
CHECKCODE='<?=urlencode(authcode($_SERVER['REQUEST_TIME'],'ENCODE'))?>';

<?php
foreach($webset['fxbl'] as $k=>$v){
	$webset['fxbl'][$k.'a']=$v;
	unset($webset['fxbl'][$k]);
}
php2js_object($webset['fxbl'],'fxblArr');
?>
</script>