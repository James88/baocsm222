<?php
include(DDROOT.'/comm/yiqifa.class.php');
include(DDROOT.'/comm/ddYiqifa.class.php');
$ddYiqifa=new ddyiqifa();
$ddYiqifa->key=$webset['yiqifaapi']['key'];
$ddYiqifa->secret=$webset['yiqifaapi']['secret'];
$ddYiqifa->uid=$webset['yiqifa']['uid'];
$ddYiqifa->wid=$webset['yiqifa']['wzid'];
$ddYiqifa->e=$dduser['id'];
$ddYiqifa->cache_open=$webset['yiqifaapi']['cache_time']>0?1:0;
$ddYiqifa->cache_time=$webset['yiqifaapi']['cache_time'];
$ddYiqifa->cache_root=DDROOT.'/data/temp/yiqifaapi';
$ddYiqifa->hotword=$webset['hotword'][0];
?>