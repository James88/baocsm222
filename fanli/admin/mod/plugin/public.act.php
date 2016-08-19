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

if(isset($_GET['ddyunpwd']) && ACT=='list'){
	$pwd=trim($_GET['ddyunpwd']);
	$url=DD_YUN_URL.'/index.php?g=Home&m=Api&a=index&domain='.get_domain().'&pwd='.urlencode($pwd).'&banben=3.0';
	$data=dd_get_json($url);
	if(!is_array($data)){
		jump(-1,'获取失败');
	}
	if($data['s']==0){
		jump(-1,$data['r']);
	}
	if($data['r']==''){
		jump(-1,'你没有订单');
	}
	$jiegou=$duoduo->get_table_struct('plugin');
	foreach($data['r'] as $row){
		foreach($row as $k=>$v){
			if(!isset($jiegou[$k])){
				unset($row[$k]);
			}
		}
		$id=(int)$duoduo->select('plugin','id','code="'.$row['code'].'"');
		if($id==0){
			$row['status']=0;
			$duoduo->insert('plugin',$row);

		}
		else{
			unset($row['version']);
			$duoduo->update('plugin',$row,'id="'.$id.'"');
		}
	}
	$a=$duoduo->select_2_field('plugin','code,status');
	dd_set_cache('plugin',$a);
	jump(-1,'更新完成');
}
?>