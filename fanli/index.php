<?php
/**
 * ============================================================================
 * 版权所有 2008-2013 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('INDEX',1);
if(defined('WAP') || defined('APP')){
	include (dirname(__FILE__).'/comm/dd.config.php');
}
else{
	include (dirname(__FILE__).'/comm/dd.config.php');
}
include (DDROOT.'/comm/checkpostandget.php');
if($webset['webclose']==1){
	$a=explode(',',$webset['webcloseallowip']);
	if(!in_array(get_client_ip(),$a)){
		include(DDROOT.'/data/webclose.php');
		exit;
	}
}
spider_limit($webset['spider']);//蜘蛛限制

if((isset($_GET['browser']) && $_GET['browser']==1) || browser()!=''){ //判断浏览器，节省淘宝api
    define('BROWSER',1);
}
else{
    define('BROWSER',0);
}

if((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') || (isset($_GET['ajax']) && $_GET['ajax']==1) || (isset($_POST['ajax']) && $_POST['ajax']==1)){
	define('AJAX',1);
}
else{
	define('AJAX',0);
}

if($webset['gzip']==1){ //gzip输出
	ob_start('ob_gzip');
}

if(!defined('WAP')){
	define('WAP',0);
}
if(!defined('APP')){
	define('APP',0);
}

$is_wap=WAP;
$is_app=APP;

if(WAP==0 && APP==0){
	$define_domain_arr=dd_get_cache('domain');
	foreach($define_domain_arr as $row){
		if($row['close']==1){
			continue;
		}
		if(strpos($_SERVER['REQUEST_URI'],'.html')===false && $_GET['mod']!='' && $row['mod']==$_GET['mod'] && AJAX==0 && CUR_WEB!=$row['url'] && (int)$_GET['domain_ignore']==0){
			$get=$_GET;
			unset($get['mod']);
			if($get['act']=='index'){
				unset($get['act']);
			}
			if($row['code']!=''){
				if($_GET['code']==$row['code']){
					unset($get['code']);
					jump(HTTP.$row['url'].(empty($get)?'':'?'.http_build_query($get)));
				}
			}
			else{
				jump(HTTP.$row['url'].(empty($get)?'':'?'.http_build_query($get)));
			}
		}
		if(CUR_WEB==$row['url']){
			if($row['mod']=='wap'){
				$is_wap=1;
			}
			else if($_GET['mod']==''){
				$_GET['mod']=$row['mod'];
				if($row['code']!=''){
					$_GET['code']=$row['code'];
				}
			}
			break;
		}
	}
}

$mod=isset($_GET['mod'])?$_GET['mod']:'index'; //当前模块
$act=isset($_GET['act'])?$_GET['act']:'index'; //当前行为

if(!preg_match('/^[\w-_]+$/',$mod)){
	exit('error mod');
}

if(!preg_match('/^[\w-_]+$/',$act)){
	exit('error act');
}

define('MOD',$mod);
define('ACT',$act);

include (DDROOT . '/comm/Taoapi.php');
include (DDROOT . '/comm/ddTaoapi.class.php');
include (DDROOT . '/mod/inc/header.act.php');

if(isset($_GET['web']) && $_GET['web']==1){
	set_cookie('use_web',1,3600,0);
}

$wjt_mod_act_arr=dd_get_cache('wjt');
$alias_mod_act_arr=dd_get_cache('alias');

if(MOD=='tao' || MOD=='index' || MOD=='ajax' || MOD=='jump' || MOD=='shop' || MOD=='goods'){ //只在淘宝,ajax和首页模块下实例化淘宝api
    $ddTaoapi = new ddTaoapi();
	if(!empty($user)){
	    $ddTaoapi->dduser=$dduser;
	}
}

if($is_wap==1){
	$mod_dir='m/mod';
	$tpl_dir='m/template';
	$moban_name=WAP_MOBAN;
	include(DDROOT.'/m/comm/dd.config.php');
}
elseif($is_app==1){
	$mod_dir='app/mod';
	$tpl_dir='app/template';
	$moban_name=APP_MOBAN;
	include(DDROOT.'/app/comm/dd.config.php');
}
else{
	$mod_dir='mod';
	$tpl_dir='template';
	$moban_name=MOBAN;
}

$mod_name=mod_name($mod,$act);

if(MOD=='user' && $is_wap==0 && $is_app==0){ //user模块特别处理
	if($act=='login' || $act=='register' || $act=='getpassword' || $act=='jihuo'){
	    if($_COOKIE['userlogininfo']!=''){
            jump('index.php');
        }
	}
	else{
	    if($_COOKIE['userlogininfo']=='' && (ACT!='up_avatar' && ACT!='exit')){
            jump(u('user','login'),'您还没有登陆或登录超时');
        }
	}
}

if(WJT==1 && isset($_GET['q'])){
	if(is_url($_GET['q'])==0){
		$_GET['q']=gbk2utf8($_GET['q']);
	}
}

$page_tag=dd_get_cache('page_tag');
if(isset($page_tag[MOD.'/'.ACT])){
	define('PAGETAG',$page_tag[MOD.'/'.ACT]);
}
else{
	define('PAGETAG',MOD);
}

if(file_exists(DDROOT . '/'.$mod_dir.'/'.MOD.'/fun.class.php')){
	include(DDROOT . '/'.$mod_dir.'/'.MOD.'/fun.class.php'); //引入模块库
	$dd_mod_class_name='dd_'.MOD.'_class';
	if(class_exists($dd_mod_class_name)){
		$$dd_mod_class_name=new $dd_mod_class_name($duoduo); //实例化，明明规则为 dd_模块名_class 如 dd_user_class
	}
}

if(file_exists(DDROOT . '/'.$mod_dir.'/'.$mod_name.'.act.php')){
	include(DDROOT . '/'.$mod_dir.'/'.$mod_name.'.act.php'); //引入模块
}

if($is_wap==0){
	$dd_tpl_data=dd_get_cache('tpl/pc_'.MOBAN); //获取模板设置
	define('LOADING_IMG',$dd_tpl_data['loading_img']);
}

define('TPLPATH',DDROOT.'/'.$tpl_dir.'/'.$moban_name);
define('TPLURL',$tpl_dir.'/'.$moban_name);

$tpl_dir_name=DDROOT . '/'.$tpl_dir.'/' . $moban_name . '/' . $mod_name . '.tpl.php';
if (file_exists($tpl_dir_name)) {
	if ($is_wap==0 && isset ($webset['static'][MOD][ACT]) && $webset['static'][MOD][ACT] == 1) { //如果此模块有静态设置
		if(is_file(DDROOT.'/data/html/'.$mod_name . '.html')){ //如果存在此模块静态页
			$tpl_dir_name=DDROOT.'/data/html/'.$mod_name . '.html';
		}
	}
	include ($tpl_dir_name); //引入模板
	include(DDROOT.'/mod/cron/index.act.php'); //计划任务
}

$duoduo->close();
unset ($duoduo);
unset ($ddTaoapi);
unset ($webset);
?>