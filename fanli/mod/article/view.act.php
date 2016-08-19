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
* @name 文章页面首页
* @copyright duoduo123.com
* @example 示例article_view();
* @param $cid 文章栏目分类id
* @param $pagesize 每页默认20篇
* @param $field 字段
* @param $limit 限制
*/
function act_article_view($pagesize=20,$limit=10,$field='*'){
	global $duoduo;
	if($_GET['id']){
		$id=intval($_GET['id']);
	}
	include(DDROOT.'/comm/article.class.php');
	$article_class=new article($duoduo);
	$data=array('f'=>'hits','e'=>'+','v'=>1);
	$article_class->update('id="'.$id.'"',$data);
	
	$article = $article_class->select('id="'.$id.'"',$field);
	$article['url']=u('article','list',array('cid'=>$article['cid']));
	$article['add_time']=date('Y-m-d H:i:s',$article['addtime']);
	$type_all=dd_get_cache('type');
	$type=$type_all['article'];

	if($article['id']<=0){
		error_html('文章不存在');
	}
	
	$next_last = $article_class->next_last($id);
	
	$last_article = $next_last['last_article'];
	$next_article = $next_last['next_article'];
	
	//热门文章
	$hotnews=$article_class->select_all("cid='".$article['cid']."' order by sort=0 asc, sort asc,id desc limit 10",1,'id,title');
	unset($duoduo);
	$parameter['hotnews']=$hotnews['data'];
	$parameter['next_article']=$next_article['title']?$next_article['title']:'没有了';
	$parameter['last_article']=$last_article['title']?$last_article['title']:'没有了';
	$parameter['next_url']=u('article','view',array('id'=>$next_article['id']));
	$parameter['last_url']=u('article','view',array('id'=>$last_article['id']));
	$parameter['article']=$article;
	$parameter['article']=$article;
	$parameter['article']=$article;
	$parameter['type']=$type;
	return $parameter;
}
?>