<?php
/**
 * ============================================================================
 * 版权所有 多多网络，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}

$tao_goods=dd_get_cache('tao_goods','array');

function get_tao_goods_tag($tao_goods,$num_iid){
	foreach($tao_goods as $tag=>$row){
		foreach($row as $k=>$arr){
			if($arr['num_iid']==$num_iid){
				$a['tag']=$tag;
				$a['k']=$k;
				return $a;
			}
		}
	}
}

if(!empty($_POST)){
	$a=str_replace("'",'"',$_POST['a']);
	$a=json_decode($a,1);
	if(!empty($a)){
		foreach($a as $row){
			$row['fxje']=fenduan($row['commission'],$webset['fxbl'],0);
			$c=get_tao_goods_tag($tao_goods,$row['num_iid']);
			$b[$c['tag']][$c['k']]=$row;
			ksort($b[$c['tag']]);
		}
		dd_set_cache('tao_goods',$b,'array');
	}
	dd_exit('更新完毕');
}

//更新缓存
function del_session($dir) {
	if (!file_exists($dir)) {
		return false;
	} 
	if (!preg_match('#/data/temp/session/'.date('Ymd').'$#', $dir)) {
		if($dh = opendir($dir)){
			while ($file = readdir($dh)) {
				if ($file != "." && $file != "..") {
					$fullpath = $dir . "/" . $file;
					if (!is_dir($fullpath)) {
						unlink($fullpath);
					} else {
						del_session($fullpath);
					}
				}
			}
		closedir($dh);
		}
		if(judge_empty_dir($dir)==1){
			rmdir($dir);
			return true;
		}
		else {
			return false;
		} 
	}
}

/*$duoduo->set_webset('tao_report_time',TIME,0);
$duoduo->set_webset('paipai_report_time',TIME,0);
$duoduo->set_webset('tuan_goods_time',TIME,0);*/

$duoduo->webset();
define('UPDATECACHE',1);
include(ADMINROOT.'/mod/public/mod.update.php');
del_session(DDROOT.'/data/temp/session');

deldir(DDROOT.'/data/html');
deldir(DDROOT.'/upload/trade_'.md5(DDKEY));

$a=glob(DDROOT.'/data/css/*');
foreach($a as $v){
	unlink($v);
	//$b=str_replace(DDROOT.'/data/css/','',$v);
//	if(preg_match('/^index_index.*/',$b)){
//		if($webset['static']['index']['index'] != 1){
//			unlink($v);
//		}
//	}
//	else{
//		unlink($v);
//	}
}

$a=glob(DDROOT.'/data/js/*');
foreach($a as $v){
	unlink($v);
	//$b=str_replace(DDROOT.'/data/js/','',$v);
//	if(preg_match('/^index_index.*/',$b)){
//		if($webset['static']['index']['index'] != 1){
//			unlink($v);
//		}
//	}
//	else{
//		unlink($v);
//	}
}

set_cookie('liebiao','',0,0);

if (isset ($webset['static']['index']['index']) && $webset['static']['index']['index'] == 1 && $webset['webclose']!=1) {
	unlink(DDROOT.'/data/html/index.html');
	unlink(DDROOT.'/index.html');
	$c=file_get_contents(SITEURL.'/index.php?browser=1');
	if($c!=''){
		create_file(DDROOT.'/data/html/index.html',$c);
	}
}
else{
	if(file_exists(DDROOT.'/data/html/index.html')){
		unlink(DDROOT.'/data/html/index.html');
	}
}


$del_buy_log_day=date("Ymd",strtotime("-".BUY_LOG_DAY." day"));
$duoduo->delete('buy_log','day<"'.$del_buy_log_day.'"');

$attack_dir=DDROOT.'/data/temp/attack';
deldir($attack_dir);
MkdirAll($attack_dir);

function bankuai_cache(){
	global $duoduo;
	$a=$duoduo->select_all('bankuai','*','1 order by sort=0 ASC,tuijian desc,sort asc');
	foreach($a as $row){
		$bankuai[$row['code']]=$row;
	}
	dd_set_cache('bankuai',$bankuai);
}
bankuai_cache();

function cron_cache(){
	global $duoduo;
	$cron=$duoduo->select_all('cron','*');
	foreach($cron as $row){
		if(strpos($row['dev'],'a:')===0){
			$row['dev']=unserialize($row['dev']);
		}
		$_cron[$row['id']]=$row;
	}
	dd_set_cache('cron',$_cron);
}
cron_cache();

function domian_cache(){
	global $duoduo;
	$domain=$duoduo->select_all('domain','*');
	foreach($domain as $row){
		$a[$row['url']]=array('url'=>$row['url'],'mod'=>$row['mod'],'code'=>$row['code'],'close'=>$row['close']);
	}
	dd_set_cache('domain',$a);
}
domian_cache();

taopid_cache();

if($_GET['jump']==1){
	jump('../index.php');
}

PutInfo('更新缓存完毕！',-1);
?>