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
define('PLUGIN',1);

include ('comm/dd.config.php');
include (DDROOT.'/comm/checkpostandget.php');

if($webset['webclose']==1){
	$a=explode(',',$webset['webcloseallowip']);
	if(!in_array(get_client_ip(),$a)){
		include(DDROOT.'/data/webclose.php');
		exit;
	}
}

spider_limit($webset['spider']);//蜘蛛限制
if((isset($_GET['browser']) && $_GET['browser']==1) || browser()!=''){ //判断浏览器
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

include (DDROOT . '/comm/Taoapi.php');
include (DDROOT . '/comm/ddTaoapi.class.php');
include (DDROOT . '/mod/inc/header.act.php');

$alias_mod_act_arr=dd_get_cache('alias');

foreach($alias_mod_act_arr as $k=>$row){
	if($row[0]==$mod && $row[1]==$act ){
		$s=explode('/',$k);
		$mod=$s[0];
		$act=$s[1];
		break;
	}
}

$query=$_GET['plugin_query'];
if($query!=''){
	$query_arr=explode('-',$query);
	$_GET['mod']=$query_arr[0];
	$_GET['act']=$query_arr[1];
	$plugin_query=str_replace($query_arr[0].'-'.$query_arr[1],'',$query);
	define('PLUGIN_QUERY',$plugin_query);
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

define('TPLPATH',DDROOT.'/template/'.MOBAN);
define('TPLURL','template/'.MOBAN);

define('PLUGIN_TPLPATH',DDROOT.'/plugin/'.MOD.'/template/');
define('PLUGIN_TPLURL','plugin/'.MOD.'/template/');

$ddTaoapi = new ddTaoapi();
if(!empty($dduser)){
    $ddTaoapi->dduser=$dduser;
}

$mod_name=mod_name($mod,$act);

if(browser()!=''){ //判断浏览器，节省淘宝api
    define('BROWSER',1);
}
else{
    define('BROWSER',0);
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

$dd_tpl_data=dd_get_cache('tpl/pc_'.MOBAN); //获取模板设置
$moban_name=MOBAN;
define('LOADING_IMG',$dd_tpl_data['loading_img']);

$plugin_id=(int)$duoduo->select('plugin','id','code="'.MOD.'"');
if($plugin_id==0){
	error_html('应用不存在');
}

//引入插件处理文件
include(DDROOT.'/comm/plugin.class.php');

$plugin_config=dd_get_cache('plugin/'.MOD);
if(empty($plugin_config)){
	error_html('应用未开启');
}
elseif($plugin_config['status']!=1){
	error_html('应用已关闭');
}

if(file_exists(DDROOT . '/plugin/'.MOD.'/mod/fun.php')){
	include(DDROOT . '/plugin/'.MOD.'/mod/fun.php'); //引入插件公共函数库
}

$act_file=DDROOT.'/plugin/'.MOD.'/mod/'.ACT.'.act.php';
if(file_exists($act_file)){
	include($act_file); //引入插件模块
}

if(ACT!='ajax'){
	$tpl_file=DDROOT.'/plugin/'.MOD.'/template/'.ACT.'.tpl.php';
	if(file_exists($tpl_file)){
		include($tpl_file); //引入插件模板
		include(DDROOT.'/mod/cron/index.act.php'); //计划任务
	}
}
$duoduo->close();
unset ($duoduo);
unset ($ddTaoapi);
unset ($webset);
?>