<?php
header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache");
ini_set("magic_quotes_runtime", 0);
defined('MAGIC_QUOTES_GPC') || define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');

include '../comm/dd.config.php';
include '../comm/uc_define.php';

if($webset['ucenter']['open']==0 || UC_KEY==''){
	exit('UC close!');
}

$get = array ();
$code = $_GET['code'];
$allow_arr=array('test', 'deleteuser', 'renameuser', 'gettag', 'synlogin', 'synlogout', 'updatepw', 'updatebadwords', 'updatehosts', 'updateapps', 'updateclient', 'updatecredit', 'getcredit', 'getcreditsettings', 'updatecreditsettings', 'addfeed');

parse_str(_authcode($code, 'DECODE', UC_KEY), $get);

if (MAGIC_QUOTES_GPC) {
	$get = _stripslashes($get);
}

$timestamp = $_SERVER['REQUEST_TIME'];
if ($timestamp - $get['time'] > 3600) {
	dd_exit('Authracation has expiried');
}
if (empty ($get)) {
	dd_exit ('Invalid Request');
}

$action = $get['action'];
$sj = date('Y-m-d H:i:s', $get['time']);
if ($action == "synlogin" && isset($get['username']) && $get['username'] != '') {
	$name = iconv("utf-8", "utf-8//IGNORE", $get['username']);
	$ucid = intval($get['uid']);
	$email = $ucid . '@bbs.com';
	
	$user=$duoduo->select('user','id,ddusername,ddpassword','ucid="'.$ucid.'"');
	$userlogininfo=unserialize(get_cookie('userlogininfo')); 
	$hcookieuid = $userlogininfo['uid']; 
	if($user['id']>0 && $user['id']!=$hcookieuid){
		user_login($user['id'],$user['ddpassword'],1200);
		$set_con_arr=array(array('f'=>'lastlogintime','v'=>$sj),array('f'=>'loginnum','e'=>'+','v'=>1));
		$duoduo->update('user', $set_con_arr, 'id="' . $user['id'].'"');
	}
	$duoduo->close();
	dd_exit();
}

if ($action == "synlogout" and $get['time'] != '' && (!isset($get['username']) || $get['username'] == '')) {
	set_cookie("userlogininfo",'',0);
	dd_exit();
}

if (in_array($action,$allow_arr)) {
	dd_exit (API_RETURN_SUCCEED);
} else {
	dd_exit (API_RETURN_FAILED);
}

echo 1;

function _authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;

	$key = md5($key ? $key : UC_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microTIME), - $ckey_length)) : '';

	$cryptkey = $keya . md5($keya . $keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry +TIME : 0) . substr(md5($string . $keyb), 0, 16) . $string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array ();
	for ($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for ($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for ($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a +1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if ($operation == 'DECODE') {
		if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - TIME > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc . str_replace('=', '', base64_encode($result));
	}

}

function _stripslashes($string) {
	if (is_array($string)) {
		foreach ($string as $key => $val) {
			$string[$key] = _stripslashes($val);
		}
	} else {
		$string = stripslashes($string);
	}
	return $string;
}