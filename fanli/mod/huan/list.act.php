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
* @name 兑换列表
* @copyright duoduo123.com
* @example 示例huan_list();
* @param $pagesize 每页数量12
* @param $field 字段
* @return $parameter 结果集合
*/
function act_huan_list($pagesize=12,$field='id,img,jifen,jifenbao,title,num,sdate,edate'){
	global $duoduo;
	$webset=$duoduo->webset;
	$dduser=$duoduo->dduser;
	$cid=(int)$_GET['cid'];
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$frmnum=($page-1)*$pagesize;
	
	$jifenbao_huan_goods=0;
	if(JIFENBAO==2 && $cid==0){
		if($page==1){
			$pagesize=11;
			$jifenbao_huan_goods=1;
		}
		else{
			$frmnum--;
		}
	}
	
	if($cid>0){
		$where=' and cid="'.$cid.'"';
	}
	else{
		$where='';
	}
	
	//类型
	$type_all=dd_get_cache('type');
	$huan_type=$type_all['huan_goods'];
	foreach($huan_type as $k=>$v){
		$huan_type_arr[$k]['url']=u('huan','list',array('cid'=>$k));
		$huan_type_arr[$k]['title']=$v;
	}
	$total=$duoduo->count('huan_goods',"hide='0' and num>0 and del=0 and (edate=0 or edate>'".TIME."')".$where);
	$huan=$duoduo->select_all('huan_goods',$field, "hide='0' and num>0 and del=0 and (edate=0 or edate>'".TIME."') and (sdate=0 or sdate<'".TIME."') ".$where." order by sort=0 asc,sort asc,id desc limit $frmnum,$pagesize");
	foreach($huan as $k=>$row){
		$huan[$k]['url']=u('huan','view',array('id'=>$row["id"]));
	}
	$page_url=u(MOD,ACT,array('cid'=>$cid));
	unset($duoduo);
	$parameter['cid']=$cid;
	$parameter['huan_type']=$huan_type;
	$parameter['huan_type_arr']=$huan_type_arr;
	$parameter['total']=$total;
	$parameter['huan']=$huan;
	$parameter['page_url']=$page_url;
	$parameter['jifenbao_huan_goods']=$jifenbao_huan_goods;
	$parameter['pagesize']=$pagesize;
	$parameter['tixian_jifenbao']=u('user','tixian',array('type'=>1,'from'=>'huan'));
	$parameter['info_jifenbao']=u('tao','jifenbao');
	$parameter['pageurl']=pageft($total,$pagesize,$page_url,WJT);
	return $parameter;
}
?>
