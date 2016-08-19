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
	$diff_arr=array('sub');
	$_POST=logout_key($_POST, $diff_arr);
	foreach($_POST as $k=>$row){
		if($k=='user' && ACT=='zhuce'){
			if(!isset($row['need_alipay'])){
				$row['need_alipay'] = 0;
			}
			if(!isset($row['need_qq'])){
				$row['need_qq'] = 0;
			}
			if(!isset($row['need_tbnick'])){
				$row['need_tbnick'] = 0;
			}
			if(!isset($row['need_tjr'])){
				$row['need_tjr'] = 0;
			}
			$ips=str_replace('.','\.',$row['limit_ip']);
			dd_set_cache('user_limit_ip',strtoarray($ips));
		}
		if($k=='tgbl'){
			$row=round($row/100,2);
		}
		if(is_array($row)){
			$post_arr = $duoduo->webset_part($k,$row);
			foreach($post_arr as $m=>$n){
				$duoduo->set_webset($m,$n);
			}
		}else{
			$duoduo->set_webset($k,$row);
		}
	}

	$duoduo->webset(); //配置缓存
	jump('-1','保存成功');
}
else{
	
}