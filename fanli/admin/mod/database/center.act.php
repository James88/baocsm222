<?php
/**
 * ============================================================================
 * 版权所有 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
$yuan1='淘宝';
$yuan2='返现';
$step=$_GET['step']?(int)$_GET['step']:0;
$tihuan=$_GET['tihuan']?(int)$_GET['tihuan']:0;
//define('TIHUANLOG',DDROOT.'/data/temp/tihuanlog.txt');//替换日志文件地址
if($step==0){
	$word='第一步：导航检测&nbsp;&nbsp;(检测关键词“淘宝”，“返现”，“现金”，“提现”)';
	//导航表nav
	$jiance_arr=array('淘宝','返现','现金','提现');
	foreach($jiance_arr as $v){
		$nav=$duoduo->select_all('nav','*','title like "%'.$v.'%" or alt like "%'.$v.'%"');
		foreach($nav as $r){
			$show[$r['id']]['title']=$r['title'];
			$show[$r['id']]['word'][]=$v;
		}
	}
	
	foreach($show as $k=>$v){
		foreach($show[$k]['word'] as $l){
			$w.='【'.$l.'】';
		}
		$show[$k]=$v['title'].'&nbsp;&nbsp;&nbsp;&nbsp;可能存在违规词'.$w.'&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.u('nav','addedi',array('id'=>$k)).'" target="_blank">[修改]</a>';
	}
}elseif($step==1){
	$word='第二步：数据库检测&nbsp;&nbsp;(检测关键词“返现”，“现金”，“提现”)';
	//文章表article
	$jiance_arr=array('返现','现金','提现');
	foreach($jiance_arr as $v){
		$a=$duoduo->select_all('article','*','title like "%'.$v.'%" or content like "%'.$v.'%"');
		foreach($a as $r){
			$article[$r['id']]['title']=$r['title'];
			$article[$r['id']]['word'][]=$v;
		}
	}
	foreach($article as $k=>$v){
		foreach($article[$k]['word'] as $l){
			$w.='【'.$l.'】';
		}
		$article[$k]=$v['title'].'&nbsp;&nbsp;&nbsp;&nbsp;可能存在违规词'.$w.'&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.u('article','addedi',array('id'=>$k)).'" target="_blank">[修改]</a>';
	}
	if(empty($article)){
		$article=array();
	}
	//seo表seo
	foreach($jiance_arr as $v){
		$a=$duoduo->select_all('seo','*','title like "%'.$v.'%" or keyword like "%'.$v.'%" or desc like "%'.$v.'%" or label like "%'.$v.'%"');
		foreach($seo as $r){
			$seo[$r['id']]['title']=$r['title'];
			$seo[$r['id']]['word'][]=$v;
		}
	}
	foreach($seo as $k=>$v){
		foreach($seo[$k]['word'] as $l){
			$w.='【'.$l.'】';
		}
		$seo[$k]=$v['title'].'&nbsp;&nbsp;&nbsp;&nbsp;可能存在违规词'.$w.'&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.u('seo','addedi',array('id'=>$k)).'" target="_blank">[修改]</a>';
	}
	if(empty($seo)){
		$seo=array();
	}
	$show=array_merge($article,$seo);
}elseif($step==2){
	$word='第三步：检测当前使用的模版文件&nbsp;&nbsp;(检测关键词“返现”，“现金”，“提现”)';
	$dir=DDROOT.'/template/'.MOBAN;
	$moban=1;
}elseif($step==3){
	$word='检查完成，请按提示修改，未提示说明暂时无问题。';
	$over=1;
}

function jianceglob($dir){
	global $yuan2;
	$a=glob($dir.'/*');
	$houzhui=array('php','html','htm');
	foreach($a as $v){
		if(is_dir($v)){
			jianceglob($v);
		}else{
			$info = pathinfo($v);
			if(in_array($info['extension'],$houzhui)){
				$html=file_get_contents($v);
				$jiance_arr=array('返现','现金','提现');
				$w='';
				foreach($jiance_arr as $r){
					if(strpos($html,$r)>0){
						$t=1;
						$w.='【'.$r.'】';
					}
				}
				if($w!=''){
					echo '<li>'.str_replace(DDROOT.'/','',$v).'&nbsp;&nbsp;&nbsp;&nbsp;可能存在违规词'.$w.'&nbsp;&nbsp;&nbsp;&nbsp<li>';
				}
				
			}
		}
	}
}
?>