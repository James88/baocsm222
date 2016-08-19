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

if(isset($_GET['uid'])){
	$duoduo->delete('baobei','uid="'.$_GET['uid'].'"');
	jump(u(MOD,'list'),'删除完成');
}
$do=$_GET['do'];
$ids=$_GET['ids'];
$d=$duoduo->get_table_struct(MOD);
if($do=='' && empty($d['del'])){
	$do='del';
}
if($do=='del'){
	foreach($ids as $v){
		$hart=$duoduo->select('baobei_hart','id,uid','baobei_id="'.$v.'"');
		if($hart['uid']>0){
			$data[]=array('f'=>'hart','e'=>'-','v'=>1);
			$duoduo->delete('baobei_hart','id="'.$hart['id'].'"');
		}
		$baobei=$duoduo->Select('baobei','tao_id,jifen,uid','id="'.$v.'"');
		if($baobei['jifen']>0){
			$data[]=array('f'=>'jifen','e'=>'-','v'=>$baobei['jifen']);
			$duoduo->update('user',$data,'id="'.$baobei['uid'].'"');
			unset($data);
		}
		$data=array('tao_id'=>$baobei['tao_id'],'addtime'=>TIME);
		$duoduo->insert('baobei_blacklist',$data);
	}
}

include(ADMINROOT.'/mod/public/del.act.php');
?>