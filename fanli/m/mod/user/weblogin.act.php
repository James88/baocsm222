<?php  //多多
dd_session_start();

function get_url_contents($url){
	$c=fs('collect');
	if(function_exists('curl_exec')){
		$c->set_func='curl';
	}
	$c->get($url);
	$result=$c->val;
    return $result;
}

function get_user_from_web($web,$webid,$webname){
	global $duoduo;
	$webset=$duoduo->webset;
	if(strlen($webid)>20){
		$webid=substr($webid,0,20);
	}
	$row=$duoduo->select('apilogin as a,user as b', 'b.id,b.ddusername,b.ddpassword,b.ucid,a.webid,a.web,a.uid,a.id as apilogin_id', 'a.uid=b.id and a.webid="'.$webid.'" and a.web="'.$web.'"');
	if($row['id']>0){
		$set_con_arr=array(array('f'=>'lastlogintime','v'=>date('Y-m-d H:i:s')),array('f'=>'loginnum','e'=>'+','v'=>1));

		if($row['ddpassword']==''){
			$key_md5webid=md5(dd_crc32(DDKEY.$webid));
			$set_con_arr[]=array('f'=>'ddpassword','v'=>$key_md5webid,'e'=>'=');
			$row['ddpassword']=$key_md5webid;
		}
		$duoduo->update('user', $set_con_arr, 'id="' . $row['uid'].'"');
		user_login($row['uid'],$row['ddpassword']);
		if($_SESSION['wap_login_action']!=''){
			$action=$_SESSION['wap_login_action'];
		}
		else{
			$action=wap_l('user');
		}
		jump($action);
	}
	else{
		$email=$webid.'@'.$web.'.com';
		$id=(float)$duoduo->select('user','id','ddusername="'.$webname.'"');
		if($id>0){
			$webname=$webname.'1';
		}
		$id=(float)$duoduo->select('user','id','email="'.$email.'"');
		if($id>0){
			$email='1'.$email;
		}
		if($webset['user']['autoreg']==1){
			$_GET['username']=$webname;
			$_GET['email']=$email;
			$_GET['password']=dd_crc32(DDKEY.$webid); 
			$_GET['password_confirm']=$_GET['password']; 
			$_GET['web']=$web;
			$_GET['webname']=$webname;
			$_GET['webid']=$webid;
			$_POST=$_GET;
			
			$_POST = arr_diff($_POST, array ('a','do','action','code','state'));
			
			$data=$duoduo->register('wap');
			if($data['s']==0){
				wap_jump($data['r'],wap_l('user','login'));
			}
			else{
				if($_SESSION['wap_login_action']!=''){
					$action=$_SESSION['wap_login_action'];
				}
				else{
					$action=wap_l('user');
				}
				jump($action);
			}
		}
		else{
			$_SESSION['apireg']=TIME;
			$default_pwd = dd_crc32(DDKEY . $webid);
			$action=SITEURL.'/m/index.php?mod=user&act=register&webname='.urlencode($webname).'&web='.$web.'&webid='.urlencode($webid);
			header('Location: '.$action);
			exit;
		}
	}
}

if($_POST){
	$web=$_POST['web'];
	$webid=authcode($_POST['webid'],'DECODE',DDKEY);
	$webname=$_POST['webname'];
	get_user_from_web($web,$webid,$webname);
}

$web=$_GET['a'];
$do=$_GET['do']?$_GET['do']:'go';
$action=$_GET['action'];
if($action!=''){
	$_SESSION['wap_login_action']=urldecode($action);
}
$app = $duoduo->select('api', '*', 'code="'.$web.'"');
$callback=urlencode($app['back_url']);
if($web=='qq'){
	$url=u('api','do',array('code'=>'qq','do'=>'go','state'=>'qq_wap'));
	jump($url);
}
elseif($web=='sina'){
	$url=u('api','do',array('code'=>'sina','do'=>'go','state'=>'sina_wap'));
	jump($url);
}
elseif($web=='renren'){
	include( DDROOT.'/api/renren/RenRenOauth.class.php');
	$o = new RenRenOauth($app['key'],$app['secret'],urldecode($callback));
	if($do=='go'){
		$code_url = $o->getAuthorizeUrl( $callback );
   		header('Location:'.$code_url.'&display=touch');
	}
	else{
	    $keys = array();
	   	$code = $_GET['code'];
	    $token = $o->getAccessToken($code);
		$webname=$token['user']['name'];
		$webid=$token['user']['id'];
		
		if ($webid>0) {//使用后不能在修改下面参数否则出错
		    if($webname==''){$webname=ACT.rand(1000,9999);}
	        get_user_from_web($web,$webid,$webname);
        } else {
            dd_exit('会员信息获取失败');
        }
	}
}
elseif($web=='tb'){
	$url=u('api','do',array('code'=>'tb','do'=>'go','state'=>'tb_wap'));
	jump($url);
}