<?php //商城联盟接口
if(BIJIA==3){
    include(DDROOT.'/comm/yiqifa.config.php');
	$mall_api_set=$webset['yiqifaapi'];
	$mall_api_set['api']='yiqifa';
	$mall_api=$ddYiqifa;
	$sjidname='merchantId';
}
elseif(BIJIA==2){
    include(DDROOT.'/comm/59miao.config.php');
	$mall_api_set=$webset['wujiumiaoapi'];
	$mall_api_set['api']='wujiumiao';
	$mall_api=$dd59miao;
	$sjidname='wujiumiaoid';
}

$shield_merchantId=$mall_api_set['shield_merchantId'];
$shield_merchantId=explode(',',$shield_merchantId);
?>