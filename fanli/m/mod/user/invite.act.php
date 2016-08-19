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

function act_wap_user_invite(){
	global $duoduo,$dd_tpl_data;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	
	if($dduser['id']==0){
		jump(wap_l('user','login'));
	}
	
	if($_GET['sub']==1){
		$page=$_GET['page']?$_GET['page']:1;
		$page_size = 5;
		$frmnum=($page-1)*$page_size;
		$list=$duoduo->select_all('user','id,ddusername,regtime','tjr="'.$dduser['id'].'" order by id desc limit '.$frmnum.','.$page_size);
		foreach($list as $k=>$v){
			$list[$k]['tgyj']=(float)$duoduo->select('tgyj','money','uid="'.$v['id'].'" and tjrid="'.$dduser['id'].'"');	
			$list[$k]['ddusername']=utf_substr($list[$k]['ddusername'],2).'***';	
		}
		$a=dd_json_encode(array('s'=>1,'r'=>$list));
		exit($a);
	}
	
	$title='邀请好友';
	$webtitle=$title.'-'.$dd_tpl_data['title'];
	
	$share_img=$dd_tpl_data['share_img']?$dd_tpl_data['share_img']:$dd_tpl_data['logo'];
	if(strpos($share_img,'http')===false){
		$share_img=SITEURL.'/'.$share_img;
	}
	$share_desc=$dd_tpl_data['share_desc']?$dd_tpl_data['share_desc']:'我正在看[ '.$dd_tpl_data['title'].'-可以购物返利的网站]，分享给你，一起看吧！';
	
	$parameter['webtitle']=$webtitle;
	$parameter['share_img']=urlencode($share_img);
	$parameter['share_desc']=urlencode($share_desc);
	$parameter['rec_url']=urlencode(wap_l().'/?rec='.ddStrCode($dduser['id'],DDKEY));
	
	unset($duoduo);
	unset($webset);
	unset($dduser);
	unset($dd_tpl_data);
	return $parameter;
}
?>