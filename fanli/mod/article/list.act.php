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
* @name 文章列表页面
* @copyright duoduo123.com
* @example 示例article_list();
* @param $cid 文章栏目分类id
* @param $pagesize 每页默认20篇
* @param $field 字段
* @param $limit 限制
*/
function act_article_list($pagesize=20,$limit=10,$field='id,title,addtime'){
	global $duoduo;
	include(DDROOT.'/comm/article.class.php');
	$article_class=new article($duoduo);
	if($_GET['cid']){
		$cid=empty($_GET['cid'])?1:intval($_GET['cid']);
	}
	$page = empty($_GET['page'])?'1':intval($_GET['page']);
	$page2=($page-1)*$pagesize;
	$catname=$duoduo->select('type','title','id="'.$cid.'"');
	
	$list = $article_class->select_all("cid='".$cid."' order by sort=0 asc, sort asc,id desc limit $page2,$pagesize",1,$field);
	foreach($list['data'] as $k=>$row){
		$list['data'][$k]['url']=u('article','view',array('id'=>$row['id']));
		$list['data'][$k]['add_time']=date('m-d',$row['addtime']);
	}
	$total = $list['total'];

	$type_all=dd_get_cache('type');
	$type=$type_all['article'];
	
	//热门文章
	$hotnews=$article_class->hotnews($limit);
	$page_url=u(MOD,ACT,array('cid'=>$cid));
	unset($duoduo);
	$parameter['list']=$list['data'];
	$parameter['total']=$total;
	$parameter['pagesize']=$pagesize;
	$parameter['page_url']=$page_url;
	$parameter['hotnews']=$hotnews;
	$parameter['catname']=$catname;
	$parameter['type']=$type;
	$parameter['cid']=$cid;
	$parameter['index_url']=u(MOD,'index');
	$parameter['type_name']=$type[$cid];
	$parameter['pageurl']=pageft($total,$pagesize,$page_url,WJT);
	return $parameter;
}
?>