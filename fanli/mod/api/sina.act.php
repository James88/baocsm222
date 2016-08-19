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
include( DDROOT.'/api/sina/saetv2.ex.class.php' );
include_once( DDROOT.'/api/sina/weibooauth.php' );
$app = $duoduo->select('api', '`key`,secret,title,code,open', 'code="'.ACT.'"');
$do=$_GET['do']?$_GET['do']:'go';
$callback=u('api',$app['code'],array('do'=>'back'));
$o = new SaeTOAuthV2($app['key'],$app['secret']);

if($do=='go'){ //登陆新浪微薄
    $code_url = $o->getAuthorizeURL( $callback );
	if($_GET['state']=='sina_wap'){
		$code_url.='&state=sina_wap&display=mobile';
	}
    header('Location:'.$code_url);
}
elseif($do=='back'){  //回调

	if (isset($_REQUEST['code'])) {
	    $keys = array();
	    $keys['code'] = $_REQUEST['code'];
	    $keys['redirect_uri'] = $callback;
	    try {
		    $token = $o->getAccessToken( 'code', $keys ) ;
	    } 
	    catch (OAuthException $e) {
			print_r($e);exit;
	    }
    }
	
	if ($token) {
	    $c = new SaeTClientV2($app['key'],$app['secret'] , $token['access_token'] );
        $uid_get = $c->get_uid();
        $uid = $uid_get['uid'];
        $user_message = $c->show_user_by_id($uid);//根据ID获取用户等基本信息
	
	    if ($user_message['id']>0) {//使用后不能在修改下面参数否则出错
		    $webname=$user_message['name'];
		    if($webname==''){$webname=ACT.rand(1000,9999);}
		    $webid=$user_message['id'];
		    $web=ACT;
	        $input=array('webname'=>$webname,'webid'=>$webid,'web'=>$web);
		    
			if($_GET['state']=='sina_wap'){
				echo postform(wap_l('user','weblogin'),$input);
			}
			else{
				echo postform(u('api','do'),$input);
			}
			
            dd_exit();
        } else {
            dd_exit('会员信息获取失败');
        }
    }
	
	
    $o = new WeiboOAuth($app['key'], $app['secret'], $_SESSION['keys']['oauth_token'], $_SESSION['keys']['oauth_token_secret']);
    $last_key = $o->getAccessToken($_REQUEST['oauth_verifier']);
    $_SESSION['last_key'] = $last_key;
    $c = new WeiboClient($app['key'], $app['secret'], $_SESSION['last_key']['oauth_token'], $_SESSION['last_key']['oauth_token_secret']);
    $ms = $c->verify_credentials(); // done
	if ($ms['id']>0 || !$ms['error_code']) {
		$webname=$ms['name'];
		if($webname==''){$webname=ACT.rand(1000,9999);}
		$webid=$ms['id'];
		$web=ACT;
		
		$input=array('webname'=>$webname,'webid'=>$webid,'web'=>$web);
		
		if($_GET['state']=='sina_wap'){
			echo postform(wap_l('user','weblogin'),$input);
		}
		else{
			echo postform(u('api','do'),$input);
		}
	}
}
?>