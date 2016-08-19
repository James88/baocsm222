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
/**
* @name 用户分享宝贝
* @copyright duoduo123.com
* @example 示例user_baobei();
* @param $page 每页多少
* @param $pagesize 每页显示多少
* @param $field 字段
* @return $parameter 结果集合
*/
function act_user_fenxiang($pagesize=5,$field="*"){
	global $duoduo;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	$cat_arr=$webset['baobei']['cat'];
	$do=$_GET['do']?$_GET['do']:'share';
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$pagesize=$pagesize;
	$frmnum=($page-1)*$pagesize;
		
	if($do=='shai'){ //晒单
		$total=$duoduo->count('baobei',"uid='".$dduser['id']."' and trade_id>0");
		$baobei=$duoduo->select_all('baobei',$field, "uid='".$dduser['id']."' and trade_id>0 order by id desc limit $frmnum,$pagesize");
	}
	elseif($do=='share'){  //分享
		$total=$duoduo->count('baobei',"uid='".$dduser['id']."' and trade_id=0");
		$baobei=$duoduo->select_all('baobei',$field, "uid='".$dduser['id']."' and trade_id=0 order by id desc limit $frmnum,$pagesize");
	}
	elseif($do=='baoliao'){ //爆料
		$total=$duoduo->count('ddzhidemai',"uid='".$dduser['id']."'");
		$baobei=$duoduo->select_all('ddzhidemai','*', "uid='".$dduser['id']."' order by id desc limit $frmnum,$pagesize");
	}
	elseif($do=='ddtuiguang'){
		$total=$duoduo->count('ddtuiguang'," fuid='".$dduser["id"]."'");
		$baobei=$duoduo->select_all('ddtuiguang','*'," fuid='".$dduser["id"]."' order by id desc limit $frmnum,$pagesize");
		foreach($baobei as $k=>$row){
			$baobei[$k]['username']=$duoduo->select('user','ddusername','id="'.$row['uid'].'"');
			if($row['code']=='zdm'){
				$baobei[$k]['type']='值得买';
				$_mod='zhidemai';
				$_table='ddzhidemai';
			}
			elseif($row['code']=='share'){
				$baobei[$k]['type']='晒单分享';
				$_mod='baobei';
				$_table='baobei';
			}
			$baobei[$k]['url']=u($_mod,'view',array('id'=>$row['shuju_id']));
			$a=$duoduo->select($_table,'title,img','id="'.$row['shuju_id'].'"');
			$baobei[$k]['title']=$a['title'];
			$baobei[$k]['img']=$a['img'];
			$baobei[$k]['money']=$baobei[$k]['money']?$baobei[$k]['money']:'——';
		}
	}
	foreach($baobei as $k=>$row){
		if($do=='share' || $do=='shai'){
			$baobei[$k]['url']=u('baobei','view',array('id'=>$row['id']));
			$baobei[$k]['cat_name']=$cat_arr[$row["cid"]];
		}elseif($do=='baoliao'){
			$baobei[$k]['url']=u('zhidemai','view',array('id'=>$row['id']));
		}
	}
	unset($duoduo);
	$parameter['cat_arr']=$cat_arr;
	$parameter['do']=$do;
	$parameter['pagesize']=$pagesize;
	$parameter['total']=$total;
	$parameter['baobei']=$baobei;
	return $parameter;
}
?>