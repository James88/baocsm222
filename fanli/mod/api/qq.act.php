<?php
/**
 * ============================================================================
 * 版权所有 多多科技，保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('INDEX')){
	exit('Access Denied');
}

dd_session_start();

function get_url_contents($url)
{
	$c=fs('collect');
	if(function_exists('curl_exec')){
		$c->set_func='curl';
	}
	$c->get($url);
	$result=$c->val;
    return $result;
}

function qq_callback()
{
    //debug
    //print_r($_REQUEST);
    //print_r($_SESSION);

    if(1) //$_REQUEST['state'] == $_SESSION['state']
    {
        $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
            . "client_id=" . $_SESSION["appid"]. "&redirect_uri=" . urlencode($_SESSION["callback"])
            . "&client_secret=" . $_SESSION["appkey"]. "&code=" . $_REQUEST["code"];

        $response = get_url_contents($token_url);
        if (strpos($response, "callback") !== false)
        {
            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
            $msg = json_decode($response);
            if (isset($msg->error))
            {
                echo "<h3>error:</h3>" . $msg->error;
                echo "<h3>msg  :</h3>" . $msg->error_description;
                dd_exit();
            }
        }

        $params = array();
        parse_str($response, $params);

        //debug
        //print_r($params);

        //set access token to session
        $_SESSION["access_token"] = $params["access_token"];

    }
    else 
    {
        echo("The state does not match. You may be a victim of CSRF.");
    }
}

function qq_get_openid()
{
    $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=" 
        . $_SESSION['access_token'];

    $str  = get_url_contents($graph_url);
    if (strpos($str, "callback") !== false)
    {
        $lpos = strpos($str, "(");
        $rpos = strrpos($str, ")");
        $str  = substr($str, $lpos + 1, $rpos - $lpos -1);
    }

    $user = json_decode($str);
    if (isset($user->error))
    {
        echo "<h3>error:</h3>" . $user->error;
        echo "<h3>msg  :</h3>" . $user->error_description;
        dd_exit();
    }

    //debug
    //echo("Hello " . $user->openid);

    //set openid to session
    $_SESSION["openid"] = $user->openid;
}

function qq_get_user_info()
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

$app = $duoduo->select('api', '*', 'code="'.ACT.'"');
$do=$_GET['do']?$_GET['do']:'go';
$_SESSION["appid"] = $app['key']; 
$_SESSION["appkey"] = $app['secret']; 
$_SESSION["callback"] = $app['back_url'];//u('api',$app['code'],array('do'=>'back'));
$_SESSION["scope"] = "get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_one_blog,add_weibo";

if($do=='go'){ //登陆QQ
	if($_GET['state']==''){
		$_SESSION['state'] = 'qq_'.md5(uniqid(rand(), TRUE));
		$tmp='';
	}
	else{
		$_SESSION['state'] = $_GET['state'];
		$tmp='&display=mobile';
	}
    $login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=".$_SESSION["appid"]."&redirect_uri=".urlencode($_SESSION["callback"]). "&state=" . $_SESSION['state']. "&scope=".$_SESSION["scope"].$tmp;
    header("Location:$login_url");
}
elseif($do=='back'){  //回调
    //QQ登录成功后的回调地址,主要保存access token
    qq_callback();
    //获取用户标示id
    qq_get_openid();
	//获取用户信息
	$arr = qq_get_user_info();
	//头像
	if($arr['figureurl_qq_2']){
		$_SESSION["avatar"]=$arr['figureurl_qq_2'];
	}
	$name=$arr['nickname'];
    if($name==''){$name='qq'.rand(1000,9999);} //个别情况名字会为空
    $urlname=str_replace('%E2%80%AD','',urlencode($name)); //个别名字会带有特殊的空格符
	$name=urldecode($urlname);
	
	if ($name!='' && $_SESSION["openid"]!='') {
		$webname=$name;
		$webid=$_SESSION["openid"];
		$web=ACT;
		$input=array('webname'=>$webname,'webid'=>$webid,'web'=>$web);
		if($_GET['state']=='qq_wap'){
			echo postform(wap_l('user','weblogin'),$input);
		}
		else{
			echo postform(u('api','do'),$input);
		}
	}
}
?>