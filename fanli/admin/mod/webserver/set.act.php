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

if(!defined('ADMIN')){
	exit('Access Denied');
}

if(isset($_GET['backstage']) && $_GET['backstage']=='test'){
	$admin_name=str_replace(DDROOT,'',ADMINROOT);
	$admin_name=str_replace('/','',$admin_name);
	$url=SITEURL.'/data/backstage.php?a='.TODAY;
	only_send($url);
	sleep(3);
	$a=file_get_contents(DDROOT.'/data/backstage.txt');
	if($a==TODAY){
		jump(-1,'后台执行可用');
	}
	else{
		jump(-1,'后台执行不可用');
	}
}

if(isset($_POST['sub']) && $_POST['sub']!=''){
	$collect=$_POST['collect'];
	asort($collect);
	$collect=array_reverse($collect);
	dd_set_cache('collect',$collect);
	$duoduo->set_webset('BACKSTAGE',$_POST['backstage']);
	$duoduo->webset();
}

if(isset($_GET['ddjson'])){
	$_POST['sub']=1;
	$_POST['DDJSON']=$_GET['ddjson'];
}

include(ADMINROOT.'/mod/public/set.act.php');
$url = 'http://www.baidu.com'; //测试url
$output = '';

$file = array (
	'data/',
	'data/bdata/',
	'data/json/',
	'data/json/webset.php',
	'data/json/bankuai.php',
	'data/json/domain.php',
	'data/temp/',
	'data/spider/',
	'data/title/',
	'data/cache/Log/',
	'data/cache/tempUpload/',
	'upload/',
	'upload/avatar/',
	'upload/ddjt/',
	'data/banben.php',
	'plugin/'
);

//curl
if (function_exists('curl_exec')) {
    $curl_status='存在';
}
else{
    $curl_status='不存在';
}

//file_get_contents
if (function_exists('file_get_contents')) {
	$file_get_contents_status='存在';
}
else{
    $file_get_contents_status='不存在';
}

//fsockopen
if (function_exists('fsockopen') || function_exists('pfsockopen')) {
   $fsockopen_status='存在';
}
else{
    $fsockopen_status='不存在';
}

function test_fsockopen($url){
	 if (SendGET($url) != '') {
	    return 'fsockopen ok';
    }
	else{
	    return 'fsockopen not work';
	}
}

if (function_exists('pfsockopen')) {
    $pfsockopen_status='存在';
}
else{
    $pfsockopen_status='不存在';
}

if (extension_loaded('json')) {
    $json_encode_status='存在';
}
else{
    $json_encode_status='不存在';
}

if (extension_loaded('openssl')) {
    $ssl_status='存在';
}
else{
    $ssl_status='不存在';
}

function test_curl($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch);
	if ($output != '') {
		return 'curl ok';
	}
	else{
	    return 'curl not work';
	}
}

function test_file_get_contents($url){
	$output=file_get_contents($url);
    if ($output != '') {
		return 'file_get_contents ok';
	}
	else{
	    return 'file_get_contents not work';
	}
}

function openfile($url) {
	$output = '';
	if (file($url)) {
		$str = file($url);
		$count = count($str);
		for ($i = 0; $i < $count; $i++) {
			$output .= $str[$i];
		}
		return $output;
	} else {
		return;
	}
}


function SendGET($_url){
  $url = parse_url($_url);
  $contents = '';
  $url_port = $url['port']==''?80:$url['port'];
  $fp = fsockopen($url['host'],$url_port);
  if($fp){
    $_request = $url['path'].($url['query']==''?'':'?'.$url['query']).($url['fragment']==''?'':'#'.$url['fragment']);
    fputs($fp,'GET '.(($_request=='')?'/':$_request)." HTTP/1.0\r\n");
    fputs($fp,"Host: ".$url['host']."\n");
    fputs($fp,"Content-type: application/x-www-form-urlencoded\n");
    fputs($fp,"Connection: close\n\n");
    $line = fgets($fp,1024);
    if($line=='') return;
    else{
      $results = '';
      $contents = '';
      $inheader = 1;
      while(!feof($fp)){
        $line = fgets($fp,2048);
        if($inheader&&($line == "\n" || $line == "\r\n")){
          $inheader = 0;
        }elseif(!$inheader){
          $contents .= $line;
        }
      }
      fclose($fp);
    }
  }
  return $contents;
}
?>