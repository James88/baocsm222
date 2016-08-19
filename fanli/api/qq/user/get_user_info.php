<?php
require_once("../comm/config.php");
require_once("../comm/utils.php");

function get_user_info()
{
    $get_user_info = "https://graph.qq.com/user/get_user_info?"
        . "access_token=" . $_SESSION['access_token']
        . "&oauth_consumer_key=" . $_SESSION["appid"]
        . "&openid=" . $_SESSION["openid"]
        . "&format=json";

    $info = get_url_contents($get_user_info);
    $arr = json_decode($info, true);

    return $arr;
}

//获取用户基本资料
$arr = get_user_info();
//print_r($arr);

$name=$arr['nickname'];
if($name==''){$name='qq'.rand(1000,9999);}
$urlname=str_replace('%E2%80%AD','',urlencode($name));

$param=array('action'=>"http://".URL."/user/register_api.php",'orther_web_id'=>$_SESSION['openid'],'orther_web_name'=>urldecode($urlname),'orther_web'=>'QQ空间');
echo form($param);

?>
