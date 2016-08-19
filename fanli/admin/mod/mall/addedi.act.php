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
if(isset($_GET['mall_field'])){
	$duoduo->set_webset('mall_field',$_GET['mall_field']);
	$duoduo->webset();//跟新下缓存
	exit();
}
if($_GET['mall_url']!=''){
	$url=DD_U_URL."/?g=Home&m=DdApi&a=dd_mall_info&mall_url=".urlencode($_GET['mall_url']);
	$return=dd_get_json($url);
	$a=$return['r'];
	if($a['edate']){
		$a['edate']=date('Y-m-d',$a['edate']);
	}
	echo json_encode($a);
	exit;
}
if($_POST['sub']!=''){
	del_magic_quotes_gpc($_POST,1);
	$username = $_POST['username'];
	unset($_POST['username']);
	if($username!=''){
		$uid=$duoduo->select('user','id','ddusername="'.$username.'"');
		if($uid>0){
			$_POST['uid'] = $uid;
		}else{
			jump(-1,'会员不存在！');
		}
	}
    $id=empty($_POST['id'])?0:(int)$_POST['id'];
	unset($_POST['id']);
	unset($_POST['sub']);
	unset($_POST['add_type']);
	unset($_POST['mall_url_s']);
	unset($_POST['mall_url']);
	unset($_POST['mall_field']);
	unset($_POST['update_jizhi']);
	$_POST['edate']=dd_strtotime($_POST['edate']);
	if(isset($_POST['sort']) && ($_POST['sort']=='' || $_POST['sort']==0)){$_POST['sort']=DEFAULT_SORT;}
	$_POST['domain']=get_domain($_POST['url']);
	$_POST['host']=get_host($_POST['url']);
	trim_arr($_POST);
	if($_POST['lm']==50){
		$_POST['pindao_url']=$_POST['url'];
		$mallid=(int)$duoduo->select(get_mall_table_name(),'id','pindao_url="'.$_POST['pindao_url'].'"');
	}elseif($_POST['lm']==9){
		if(empty($_POST['tbnick'])){
			jump(-1,'请填写淘宝账号');
		}
		$mallid=(int)$duoduo->select(get_mall_table_name(),'id','tbnick="'.$_POST['tbnick'].'"');
	}else{
		$chong_mall_url=include(DDROOT.'/data/chong_mall_url.php');
		foreach($chong_mall_url as $vo){
			if($vo['type']==1){
				if(strpos($url,$vo['host'])!==false){
					$mallid=(int)$duoduo->select(get_mall_table_name(),'id','url like "%'.$vo['host'].'%"');
				}
			}
			elseif($vo['type']==0){
				if(strpos($url,get_domain($vo['host']))!==false){
					$mallid=(int)$duoduo->select(get_mall_table_name(),'id','url like "%'.$vo['host'].'%"');
				}
			}
			if($mallid){
				break;
			}
		}
		
		if(empty($mallid)){
			
			if($_POST['lm']==9){
				$mallid=(int)$duoduo->select(get_mall_table_name(),'id','url="'.$_POST['url'].'"');
			}else{
				$mallid=(int)$duoduo->select(get_mall_table_name(),'id','domain="'.$_POST['domain'].'"');
			}
		}
	}
	if($id==0){
		if($mallid>0){
			jump(-1,'该商城已存在');
		}
		
		if(!isset($_POST['addtime']) || $_POST['addtime']==''){
			$_POST['addtime']=TIME;
		}
		$id=$duoduo->insert(get_mall_table_name(),$_POST);
		$word='保存';
	}
	else{
		if($mallid>0 && $mallid!=$id){
			jump(-1,'该商城已存在');
		}
		if(array_key_exists('addtime',$_POST)){
		    unset($_POST['addtime']);
		}
		$duoduo->update(get_mall_table_name(),$_POST,'id="'.$id.'"');
		echo mysql_error();
		$word='修改';
	}
	del_ddcache('','sql/'.MOD);
	jump(-2,$word.'成功');
}
else{
	$url=DD_U_URL."/index.php?g=Home&m=DdApi&a=dd_mall_list&key=".md5(DDYUNKEY).'&url='.urlencode(SITEURL)."&from=duoduo&field=url";
	$a=dd_get_json($url);
	if(isset($a['s']) && $a['s']==0){
		jump(-1,$a['r']);
	}
	$mall_list=$a['r'];
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
    if($id==0){
	    $row=array();
	}
	else{
	    $row=$duoduo->select(get_mall_table_name(),'*','id="'.$id.'"');
		if(isset($row['edate']) && $row['edate']!=''){$row['edate']=dd_date($row['edate'],2);}
		if($row['uid']>0){$row['username']=$duoduo->select('user','ddusername','id="'.$row['uid'].'"');}
	}
}
?>