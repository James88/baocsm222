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
* @name 兑换
* @copyright duoduo123.com
* @example 示例user_huan();
* @param $page 每页多少
* @param $pagesize 每页显示多少
* @param $field 字段
* @return $parameter 结果集合
*/
function act_user_huan($pagesize=5,$field='a.*,b.title,b.img,b.jifenbao,b.jifen'){
	global $duoduo;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	$huan_status=include(DDROOT.'/data/huan.php');
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$frmnum=($page-1)*$pagesize;
		
	$total=$duoduo->count('duihuan',"uid='".$dduser['id']."' and del=0");
	$huan=$duoduo->select_all('duihuan as a,huan_goods as b',$field, "uid='".$dduser['id']."' and a.huan_goods_id=b.id and a.del=0 order by a.id desc limit $frmnum,$pagesize");
	foreach($huan as $k=>$r){
		$huan[$k]['url']=u('huan','view',array('id'=>$r['huan_goods_id']));
		$huan[$k]['_addtime']=date('Y-m-d H:i:s',$r['addtime']);
		$huan[$k]['_spend']=$r['mode']==1?TBMONEY.'：'.jfb_data_type($r["spend"]):'积分'.'：'.$r["spend"];
		$huan[$k]['_status']=$huan_status['status'][$r["status"]];
	}
	unset($duoduo);
	$parameter['huan_status']=$huan_status;
	$parameter['total']=$total;
	$parameter['pagesize']=$pagesize;
	$parameter['huan']=$huan;
	return $parameter;
}
?>