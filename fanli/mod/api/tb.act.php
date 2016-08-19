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

function dcurl($url, $postFields = null){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FAILONERROR, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	if (is_array($postFields) && 0 < count($postFields)){
		$postBodyString = "";
		foreach ($postFields as $k => $v){
			$postBodyString .= "$k=" . urlencode($v) . "&"; 
		}
		unset($k, $v);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);  
 		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0); 
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString,0,-1));
	}
	$reponse = curl_exec($ch);
	if (curl_errno($ch)){
		throw new Exception(curl_error($ch),0);
	}
	else{
		$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if (200 !== $httpStatusCode){
			throw new Exception($reponse,$httpStatusCode);
		}
	}
	curl_close($ch);
	return $reponse;
}

$app = $duoduo->select('api', '`key`,secret,title,code,open', 'code="'.ACT.'"');
$do=$_GET['do']?$_GET['do']:'go';
if($do=='go'){ //登陆
    $urls = 'https://oauth.taobao.com/authorize?response_type=code&client_id='.$app['key'].'&redirect_uri=http%3A%2F%2F'.URL.'%2Findex.php%3Fmod%3Dapi%26act%3Dtb%26do%3Dback';
	if($_GET['state']=='tb_wap'){
		$urls.='&state=tb_wap&view=wap';
	}
	else{
		$urls.='&view=web';
	}
    header("Location:".$urls);
}
elseif($do=='back'){  //回调
    $code=$_GET['code'];
	if($code==''){
		if(isset($_GET['error'])){
			if($_GET['error_description']=='authorize reject'){
				jump(u('index','index'));
			}
			exit($_GET['error_description']);
		}
		exit('miss code');
	}
	$postfields= array('grant_type' => 'authorization_code','client_id'  => $app['key'],'client_secret' => $app['secret'],'code'=> $code,'redirect_uri' => SITEURL);
	 
	$url = 'https://oauth.taobao.com/token?'.http_build_query($postfields);
 
	$token = json_decode(dd_get($url,'post'),1);
	
	if(empty($token)){
		if(function_exists('curl_exec')){
			$a=dcurl($url,$postfields);
			$token = json_decode($a,1);
			if(empty($token)){
				exit('函数不支持！');
			}
		}
		else{
			exit('函数不支持');
		}
	}
	
	if(isset($token['error'])){
		exit($token['error_description']);
	}
	
	if(!isset($token['taobao_user_nick'])){
		print_r($token);exit;
	}
	
	$nick_taobao=urldecode($token['taobao_user_nick']);
	$webid=dd_crc32($nick_taobao);
	
	$row=$duoduo->select('apilogin','id,uid,webid','webname="'.$nick_taobao.'" and web="tb"');
	if($row['id']>0){
		if($row['webid']!=$webid){
			$data=array('webid'=>$webid);
			$duoduo->update('apilogin',$data,'id="'.$row['id'].'"');
		}
	}

	$webname=$nick_taobao;
	if($webname==''){$webname=ACT.rand(1000,9999);}
	$webid=$webid;
	$web=ACT;
		
	$input=array('webname'=>$webname,'webid'=>$webid,'web'=>$web);
	
	if($_GET['state']=='tb_wap'){
		echo postform(wap_l('user','weblogin'),$input);
	}
	else{
		echo postform(u('api','do'),$input);
	}
	
	/*$url='https://oauth.taobao.com/token?grant_type=authorization_code&code='.$code.'&client_id='.$app['key'].'&client_secret='.$app['secret'].'&redirect_uri=http%3A%2F%2F'.URL.'%2Findex.php%3Fmod%3Dapi%26act%3Dtb%26do%3Dback&scope=item%2Cpromotion%2Cusergrade&view=web&state=1';
	$collect=new collect;
	$collect->get($url,'post');
	$s=$collect->val;
	$row=json_decode($s,1);
	if($row['error']!=''){
	    exit($row['error_description']);
	}
	$id_taobao=$row['taobao_user_id'];
	$nick_taobao=$row['taobao_user_nick'];
	if ($id_taobao>0 || $nick_taobao!='') {
		$webname=$nick_taobao;
		if($webname==''){$webname=ACT.rand(1000,9999);}
		$webid=$id_taobao;
		$web=ACT;
		
		$input=array('webname'=>$webname,'webid'=>$webid,'web'=>$web);
		echo postform(u('api','do'),$input);
	}*/
}
?>