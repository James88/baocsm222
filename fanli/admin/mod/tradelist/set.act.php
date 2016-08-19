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

if(isset($_POST['sub']) && $_POST['sub']!=''){
	$taodianjin_pid=$_POST['taodianjin_pid'];
	$js=dd_get('http://a.alimama.cn/tkapi.js');
	$js=preg_replace('#tkapi:"(.*)",packages:#','tkapi:"'.SITEURL.'/data/",packages:',$js);
	mkdir(DDROOT.'/data/tkapi/');
	file_put_contents(DDROOT.'/data/tkapi/tkapi.js',$js);
	
	$js=dd_get('http://a.alimama.cn/tkapi/click.js');
	file_put_contents(DDROOT.'/data/tkapi/click.js',$js);
	
	$js=dd_get('http://a.alimama.cn/tkapi/mclick.js');
	file_put_contents(DDROOT.'/data/tkapi/mclick.js',$js);
		
	$js=dd_get('http://a.alimama.cn/tkapi/plugin.js');
	file_put_contents(DDROOT.'/data/tkapi/plugin.js',$js);
	
	$diff_arr=array('sub','from');
	$_POST=logout_key($_POST, $diff_arr);
	$_POST['TDJ_URL']=preg_replace('#/$#','',$_POST['TDJ_URL']);
	
	foreach($_POST as $k=>$v){
		if(is_array($v)){
			$post_arr = $duoduo->webset_part($k,$v);
			$v=$post_arr[$k];
		}
		$duoduo->set_webset($k,$v);
	}
	$duoduo->webset(); //配置缓存
	if($_GET['from_url']!=''){
		jump($_GET['from_url'],'保存成功');
	}
	else{
		jump(-1,'保存成功');
	}
}
else{
	if($_GET['checkApi']==1){
		$data=array('q'=>'男装','page_size'=>1,'page_no'=>1);
		
		include (DDROOT . '/comm/Taoapi.php');
		include (DDROOT . '/comm/ddTaoapi.class.php');
		$ddTaoapi = new ddTaoapi();
		$a=$ddTaoapi->taobao_tbk_item_get($data);
		if($a['s']==0){
			echo $a['r'];
		}
		else{
			echo 1;
		}
		exit;
	}

	$taodianjin_set=file_get_contents(DDROOT.'/comm/tdj_tpl.php');
	$taodianjin_set=str_replace('<?=$webset[\'taodianjin_pid\']?>',$webset['taodianjin_pid'],$taodianjin_set);
	$taodianjin_set=preg_replace('/appkey: "\d+",/','appkey: "",',$taodianjin_set);
	$taodianjin_set=str_replace('<?=$dduser[\'id\']?>','',$taodianjin_set);
	$taodianjin_set=str_replace('<?=SITEURL?>',SITEURL,$taodianjin_set);
	$taodianjin_set=str_replace('data/tkapi','../data/tkapi',$taodianjin_set);
}