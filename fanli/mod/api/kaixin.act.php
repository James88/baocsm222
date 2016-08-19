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

include( DDROOT.'/api/kaixin/kxClient.php' );
include( DDROOT.'/api/kaixin/kxHttpClient.php' );
$app = $duoduo->select('api', '`key`,secret,title,code,open', 'code="'.ACT.'"');
$do=$_GET['do']?$_GET['do']:'go';
$callback=u('api',$app['code'],array('do'=>'back'));
$key['client_id']=$app['key'];
$key['client_secret']=$app['secret'];
$key['redirect_uri']=$callback;

if($do=='go'){ //登陆新浪微薄
    $connection = new KXClient($key);
    $scope = 'create_records create_album user_photo friends_photo upload_photo';
    $aurl =$connection->getAuthorizeURL('code',$scope);
    header("Location:".$aurl);
}
elseif($do=='back'){  //回调
    if(array_key_exists('code', $_GET)){
		$code=$_GET['code'];
	    $connect = new KXClient($key);
	    $response = $connect->getAccessTokenFromCode($code);
	    if(isset($response->access_token)){
		    $access_token=$response->access_token;
		    $connection = new KXClient($key,$access_token);
		    $example2 = $connection->users_me();
		    $uid=$example2['response']->uid;
		    $name=$example2['response']->name;
			
			$webname=$name;
		    if($webname==''){$webname=ACT.rand(1000,9999);}
		    $webid=$uid;
		    $web=ACT;
	        $input=array('webname'=>$webname,'webid'=>$webid,'web'=>$web);
		    echo postform(u('api','do'),$input);
            dd_exit();
	    } 
    }
}
?>