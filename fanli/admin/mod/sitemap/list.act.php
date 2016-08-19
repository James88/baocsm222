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
$do=$_GET['do'];
if($do=='jty'){
	$c=file_get_contents(SITEURL.'/page/sitemap.php');
	if($c!=''){
		file_put_contents(DDROOT.'/sitemap.html',$c);
	}
	
	$xml=include(ADMINROOT.'/mod/sitemap/sitemapxml.php');
	if($xml!=''){
		file_put_contents(DDROOT.'/sitemap.xml',$xml);
	}
	jump(-1,'生成成功');
}elseif($do=='paicj'){
	$url='http://etg.qq.com/cgi-bin/etgword_query?classid=0&pagesize=1000&pageno=1&callback=etgword_query_callback&t=0.9510542037483673&g_ty=ls';
	$content = file_get_contents($url);
	$content = iconv("gbk", "utf-8//IGNORE", $content);
	$content = str_replace('//', '', $content);
	$content = str_replace('etgword_query_callback', '', $content);
	$content = str_replace('({', '{', $content);
	$content = str_replace(');', '', $content);
	$re=dd_json_decode($content);
	$re=$re['data']['list'];
	foreach($re as $row){
	$id=$duoduo->select('pai_words','id','wordName="'.$row['wordName'].'"');
		if(empty($id)){
			unset($data);
			$data['wordName']=$row['wordName'];
			$data['sClassid']=$row['sClassid'];
			$data['addtime']=date("Y-m-d H:i:s");
			$duoduo->insert('pai_words',$data);
			if(mysql_error()!=''){
				echo mysql_error();exit;
			}
		}
	}
	jump(u(MOD,ACT),'采集拍拍关键词成功');
}elseif($do=='qingkong'){
	$sql="TRUNCATE `".BIAOTOU."pai_words`";
	$duoduo->query($sql);
	jump(u(MOD,ACT),'清空成功');
}

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;
if(isset($_GET['title']) && $_GET['title']!=''){
	$title=$_GET['title'];
	$where='wordName like "%'.$title.'%"';
	$page_arr['title']=$title;
}
else{
    $where='1=1';
}

$total=$duoduo->count('pai_words',$where);
$row=$duoduo->select_all('pai_words','*',$where.' order by id desc limit '.$frmnum.','.$pagesize);

?>