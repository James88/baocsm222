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
define('INDEX',1);
$malls=$duoduo->select_all(get_mall_table_name(),'id,title','1');
//$paipai=$duoduo->select_all('pai_words','id,wordName','1 order by addtime desc');
$nav=dd_get_cache('nav');
include(DDROOT.'/comm/article.class.php');
$article_class=new article($duoduo);
$article=$article_class->select_all('1','0','id,title');

$n=0;
foreach($nav as $k=>$row){
	$nav_arr[$n]['title']=$row['title'];
	if($row['link']==''){
		$nav_arr[$n]['url']=SITEURL.'/index.php';
	}elseif(strpos($row['link'],'http://')!==false){
		$nav_arr[$n]['url']=$row['link'];
	}else{
		$nav_arr[$n]['url']=SITEURL.'/'.$row['link'];
	}
	$n++;
	if(isset($row['child']) && !empty($row['child']['0'])){
		foreach($row['child'] as $l){
			$nav_arr[$n]['title']=$l['title'];
			if($l['link']==''){
				$nav_arr[$n]['url']=SITEURL.'/index.php';
			}elseif(strpos($l['link'],'http://')!==false){
				$nav_arr[$n]['url']=$l['link'];
			}else{
				$nav_arr[$n]['url']=SITEURL.'/'.$l['link'];
			}
			$n++;
		}
	}
}

//$goods=$duoduo->select_all('goods','*','del="0" and endtime >= "'.time().'" and starttime <= "'.time().'" order by id desc limit 2000');

$bankuai=dd_get_cache('bankuai');
$i=0;
foreach($bankuai as $k=>$v){
	if($v['status']==1){
		$list=$duoduo->select_all('goods','*','del="0" and code="'.$v['code'].'" and endtime >= "'.time().'" order by id  desc limit 500');
		if(!empty($list)){
			$goods_arr[$i]['title']=$v['title'];
			$goods_arr[$i]['list']=$list;
			$i++;
		}
	}
}
?>
<?php 
$xml.= '<?xml version="1.0" encoding="utf-8"?>';
$xml.= '<urlset>';
foreach($nav_arr as $row){
	$xml.= '<url>';
	$xml.= '<loc>'.str_replace('&','&amp;',$row['url']).'</loc>';
	$xml.= '<lastmod>'.date("Y-m-d H:i:s").'</lastmod>';
	$xml.= '<changefreq>daily</changefreq>';
	$xml.= '<priority>1</priority>';
	$xml.= '</url>';
}
foreach($goods_arr as $v){
	foreach($v['list'] as $row){
		$xml.= '<url>';
		$xml.= '<loc>'.str_replace('&','&amp;',u('goods','view',array('code'=>$row['code'],'id'=>$row['id']))).'</loc>';
		$xml.= '<lastmod>'.date("Y-m-d H:i:s").'</lastmod>';
		$xml.= '<changefreq>daily</changefreq>';
		$xml.= '<priority>0.8</priority>';
		$xml.= '</url>';
	}
}
/*foreach($paipai as $row){
	$xml.= '<url>';
	$xml.= '<loc>'.str_replace('&','&amp;',u('paipai','list',array('q'=>$row['wordName']))).'</loc>';
	$xml.= '<lastmod>'.date("Y-m-d H:i:s").'</lastmod>';
	$xml.= '<changefreq>daily</changefreq>';
	$xml.= '<priority>0.8</priority>';
	$xml.= '</url>';
}*/
foreach($malls as $row){
	$xml.= '<url>';
	$xml.= '<loc>'.str_replace('&','&amp;',u('mall','view',array('id'=>$row['id']))).'</loc>';
	$xml.= '<lastmod>'.date("Y-m-d H:i:s").'</lastmod>';
	$xml.= '<changefreq>daily</changefreq>';
	$xml.= '<priority>0.7</priority>';
	$xml.= '</url>';
}
foreach($article as $row){
	$xml.= '<url>';
	$xml.= '<loc>'.str_replace('&','&amp;',u('article','view',array('id'=>$row['id']))).'</loc>';
	$xml.= '<lastmod>'.date("Y-m-d H:i:s").'</lastmod>';
	$xml.= '<changefreq>daily</changefreq>';
	$xml.= '<priority>0.6</priority>';
	$xml.= '</url>';
}
$xml.= '</urlset>';
return $xml;
?>

