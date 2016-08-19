<?php
include(DDROOT.'/comm/59miao.class.php');
$dd59miao=new wujiumiao();
$dd59miao->appkey=$webset['wujiumiaoapi']['key'];
$dd59miao->appSecret=$webset['wujiumiaoapi']['secret'];
$dd59miao->cache_time=$webset['wujiumiaoapi']['cache_time'];
$dd59miao->cache_root=DDROOT.'/data/temp/wujiumiaoapi';
$dd59miao->hotword=$webset['hotword'][0];
?>