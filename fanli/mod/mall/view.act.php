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
* @name 商城列表
* @copyright duoduo123.com
* @example 示例mall_lists();
*/
function act_mall_view($mall_num=6,$goods_num=8){
	global $duoduo;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	include(DDROOT.'/comm/mallapi.config.php');
	$id=intval($_GET['id'])?intval($_GET['id']):0;
	$do=$_GET['do']?$_GET['do']:'content';
	
	$fanli_type=array(1=>'金额',2=>'积分');
	
	if($do!='content' && $do!='huodong' && $do!='goods'){
		$do='content';
	}
	if($id==0){
		error_html('miss id');
	}
	
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$pagesize=3;
	$frmnum=($page-1)*$pagesize;
	$zong_fen=0;
	$pjf='0.0';
	$x=0;
	$fen=0;
	
	//查找店铺数据库
	
	$mall=$duoduo->select('mall','*','id="'.$id.'"');
	
	include(DDROOT.'/comm/goods.class.php');
	$goods_class=new goods($duoduo);
	if(strstr($mall['url'],'tmall.com')){
		$mall['ico'] = 'tmall_ico';
		$goods=$goods_class->show(8,1,'*','nick="'.$mall['title'].'"');
	}
	elseif(strstr($mall['url'],'taobao.com')){
		$mall['ico'] = 'tb';
		$goods=$goods_class->show(8,1,'*','nick="'.$mall['title'].'"');
	}
	else{
		$mall['ico'] = 'jd_ico';
		$domian=get_domain($mall['url']);
		$goods=$goods_class->show(8,1,'*','domain="'.$domian.'"');
	}
	
	if($mall['id']==''){error_html('数据不存在！',-1);}
	
	$jump_arr=array('mid'=>$mall['id']);
	
	if($_GET['url']!=''){
		$jump_arr['url']=$_GET['url'];
	}
	if($mall['lm']==50){
		$jump='index.php?mod=jump&act=s8&url='.base64_encode($mall['pindao_url']);
	}else{
		$jump=l('jump','mall',$jump_arr);
	}
	if($_GET['jump']==1){
		jump($jump);
	}
	
	$mall_comment_total=$duoduo->count('mall_comment',"`mall_id` = '$id'");
	$mall_comment=$duoduo->select_all('mall_comment as a,user as b','a.*,b.ddusername,b.id',"a.`mall_id` = '$id' and a.uid=b.id order by a.id desc limit $frmnum,$pagesize");
	
	$malls=$duoduo->select_all('mall','*',"cid='".$mall['cid']."' and id<>".$id." order by sort asc limit ".$mall_num);
	$page_url=u(MOD,ACT,array('id'=>$id,'do'=>$do));
	unset($duoduo);
	$parameter['mall']=$mall;
	$parameter['jump']=$jump;
	$parameter['id']=$id;
	$parameter['fanli_type']=$fanli_type;
	$parameter['goods']=$goods;
	$parameter['page']=$page;
	$parameter['pagesize']=$pagesize;
	$parameter['mall_comment_total']=$mall_comment_total;
	$parameter['mall_comment']=$mall_comment;
	$parameter['total']=$total;
	$parameter['malls']=$malls;
	return $parameter;
}
?>