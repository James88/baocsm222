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

/*if(!empty($_GET['ids'])){
	$ids=implode($_GET['ids'],',');
	$duoduo->update(MOD,array('fabu_time'=>SJ),'id IN('.$ids.') and fabu_time>"'.SJ.'"',99);
	jump(-1,'更改完成');
}*/
if($_GET['audit'] && !empty($_GET['ids'])){
	$ids=$_GET['ids'];
	
	foreach($ids as $v){
		$baobei=$duoduo->select('baobei','*','id="'.$v.'"');
		if($baobei['id']>0 && $baobei['status']==2){
			$shijian=7;
			$m_id=$duoduo->select('mingxi','id','source="'.$baobei['id'].'" and shijian="'.$shijian.'"');
	
			if(empty($m_id)){
				$jifen=(int)$webset['baobei']['shai_jifen'];
				$jifenbao=(float)$webset['baobei']['shai_jifenbao'];
				if($jifen>0 || $jifenbao>0){
					$uid=$baobei['uid'];
					$user_update=array(array('f'=>'jifen','e'=>'+','v'=>$jifen),array('f'=>'jifenbao','e'=>'+','v'=>$jifenbao));
					
					$duoduo->update_user_mingxi($user_update,$uid,$shijian,$baobei['id']);
				}
			}
		}
		$duoduo->update(MOD,array('status'=>0),'id="'.$baobei['id'].'"');
	}
	jump(-1,'批量审核完成');
}
$select_arr=array('title'=>'商品名','ddusername'=>'会员名');

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;
$q=$_GET['q'];
$q1=$q;
$se=$_GET['se']?$_GET['se']:'title';
$se1=$se;
$status=isset($_GET['status']) && $_GET['status']>=0?(int)$_GET['status']:'-1';
$page_arr=array('se'=>$se,'q'=>$q);
if($se=='ddusername'){
    $se1='uid';
	$q1=$duoduo->select('user','id','ddusername="'.$q.'"');
}
$cid=(int)$_GET['cid'];
if($cid>0){
    $where=' and a.cid="'.$cid.'"';
	$page_arr['cid']=$cid;
}
else{
    $where='';
}
if($status>=0){
	$where.=' and status='.$status;
	$page_arr['status']=$status;
}
if($_GET['reycle']==1){
	$reycle=1;
	$where.=' and  a.`del`='.$reycle;
	$page_arr['reycle']=$reycle;
}else{
	$where.=' and a.`del`="0"';
}
$total=$duoduo->count('baobei as a',"`".$se1."` like '%$q1%'".$where);
$row=$duoduo->select_all('baobei as a,user as b','a.*,b.ddusername','a.`'.$se1.'` like "%'.$q1.'%" and a.uid=b.id '.$where.' order by a.status=2 desc, a.status asc ,a.sort=0 asc,a.sort asc,a.id desc limit '.$frmnum.','.$pagesize);
foreach($row as $k=>$v){
	$row[$k]['comment_num']=$duoduo->count('baobei_comment','baobei_id="'.$v['id'].'"');
}