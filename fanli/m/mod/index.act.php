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

function act_wap_index($bankuai_num=4){
	global $duoduo,$dd_tpl_data;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;

	$slides=$duoduo->select_all('slides','*','cid="wap" and hide=0 order by sort=0 asc,sort asc,id desc');
	
	if(!empty($slides)){
		foreach($slides as $k=>$row){
			if(preg_match('#^http://(item\.taobao\.com)|(detail\.tmall\.com)|(h5\.m\.taobao\.com)|(detail\.m.tmall\.com)#',$row['url'])){
				$iid=(float)get_tao_id($row['url']);
				if($iid>0){
					$slides[$k]['url']=wap_l('tao','view',array('iid'=>$iid));
				}
			}
			else if(is_url($row['url'])){
				$slides[$k]['url']=$row['url'];
			}
			else{
				$slides[$k]['url']=wap_l('tao','list',array('q'=>$row['url']));
				$slides[$k]['waibu_url']=1;
			}
		}
	}
	
	$bankuai=$duoduo->select_all('bankuai','*','status=1 and mobile_status=1 ORDER BY sort =0 ASC');
	foreach($bankuai as $row){
		$bankuai_wap[]=array('img'=>$row['mobile_logo'],'title'=>$row['title'],'code'=>$row['code'],'url'=>wap_l('goods','index',array('code'=>$row['code'])));
	}
	
	if(count($bankuai_wap)>$bankuai_num && count($bankuai_wap)%$bankuai_num!=0){
		$bankuai_wap[]=array('img'=>'m/template/default/inc/images/more.png','title'=>'更多','url'=>wap_l('goods','bankuai'));
	}
	$parameter['slides']=$slides;
	$parameter['slide_num']=count($slides);
	$parameter['bankuai_wap']=$bankuai_wap;
	$parameter['webtitle']=$dd_tpl_data['title'].'-首页';
	unset($duoduo);
	unset($webset);
	unset($dduser);
	unset($dd_tpl_data);
	return $parameter;
}
?>