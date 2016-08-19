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

if($_GET['set_type']==1){
	$page=$_GET['page']?$_GET['page']:1;
	$pagesize=1000;
	$fromnum=($page-1)*$pagesize;
	$user_list=$duoduo->select_all('user','id,level,type','1 order by id desc limit '.$fromnum.','.$pagesize);
	if(empty($user_list)){
		PutInfo('完成<br/><br/><img src="../images/wait2.gif" />',u(MOD,ACT),1);
	}
	foreach($user_list as $r){
		$type=0;
		foreach($webset['level'] as $k=>$v){
			if($r['level']>=$v['level']){
				$type=$k;
			}
		}
		$u_data=array();
		$u_data['type']=$type;
		if($type!=$r['type']){
			$duoduo->update('user',$u_data,'id="'.$r['id'].'"');
		}
	}
	$url=u(MOD,ACT,array('set_type'=>1)).'&page='.($page+1);
	PutInfo('第'.$page.'页升级完成<br/><br/><img src="../images/wait2.gif" />',$url,1);
}

if(isset($_POST['sub']) && $_POST['sub']!=''){
	$diff_arr=array('sub','from','level_name','level_dengji');
	$_POST=logout_key($_POST, $diff_arr);
	foreach($_POST as $k=>$v){
		if(is_array($v) && $k!='level'){
			$post_arr = $duoduo->webset_part($k,$v);
			$v=$post_arr[$k];
		}
		$duoduo->set_webset($k,$v);
	}
	
	$ips=str_replace('.','\.',$_POST['user']['limit_ip']);
	dd_set_cache('user_limit_ip',strtoarray($ips));
	
	$duoduo->webset(); //配置缓存
	jump(-1,'保存成功');
}
