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

function act_wap_msg(){
	global $duoduo,$dd_tpl_data;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	
	if($dduser['id']==0){
		jump(wap_l('user','login'));
	}
	
	$do=$_GET['do']?$_GET['do']:'list';
	$page=(int)$_GET['page'];
	$page=$page==0?1:$page;
	$page_size=20;
	$uid=$dduser['id'];
	
	if($do=='list'){
		$msg=$duoduo->select_all('msg','*','uid="'.$uid.'" order by id desc limit '.($page-1)*$page_size.','.$page_size);
		
		foreach($msg as $row){
			$id_arr[]=$row['id'];
		}
		$data=array('see'=>1);
		$duoduo->update('msg',$data,'id="'.implode(',',$id_arr).'"');
	}
	else{
		$content=$_GET['content'];
		$field_arr=array('title'=>'站内消息','content'=>$content,'addtime'=>date('Y-m-d H:i:s'),'see'=>0,'uid'=>0,'senduser'=>$uid);
		$duoduo->insert('msg', $field_arr);
		wap_jump(-1,'提交完成');
	}

	$total=count($msg);
	
	$title='站内信';
	$webtitle=$title.'-'.$dd_tpl_data['title'];
	
	unset($duoduo);
	unset($webset);
	unset($dduser);
	unset($dd_tpl_data);
	$parameter['shuju_data']=$msg;
	$parameter['do']=$do;
	$parameter['webtitle']=$webtitle;
	$parameter['title']=$title;
	$parameter['page']=$page;
	$parameter['page_size']=$page_size;
	$parameter['total']=$total;
	return $parameter;
}
?>