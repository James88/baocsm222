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

function act_wap_mingxi(){
	global $duoduo,$dd_tpl_data;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	
	if($dduser['id']==0){
		jump(wap_l('user','login'));
	}
	
	$do=$_GET['do'];
	$page=(int)$_GET['page'];
	$page=$page==0?1:$page;
	$page_size=20;
	$uid=$dduser['id'];
	
	if($do=='in'){
		$mingxi=$duoduo->select_all('mingxi','shijian,money,jifenbao,jifen,source,addtime',"uid='".$uid."' and (jifen>0 or money>0 or jifenbao>0) order by id desc limit ".($page-1)*$page_size.','.$page_size);
		$mingxi_tpl=include(DDROOT.'/data/mingxi.php'); //明细结构数据
		foreach($mingxi as $k=>$r){
			$m[$k]['title']=$mingxi_tpl[$r["shijian"]]['title'];
			$m[$k]['content']=mingxi_content($r,$mingxi_tpl[$r["shijian"]]['content']);
			$m[$k]['addtime']=$r['addtime'];
		}
		$title='收入';
	}
	elseif($do=='out'){
		$mingxi=$duoduo->select_all('tixian','*',"uid='".$uid."' order by id desc limit ".($page-1)*$page_size.','.$page_size);
		$tixian_arr=array(0=>'<span style="color:#ff3300">提现待审核</span>',1=>'<span style="color:#009900">提现成功</span>',2=>'<span style="color:#333333">提现失败</span>');
		foreach($mingxi as $k=>$r){
			$m[$k]['status']=$tixian_arr[$r["status"]];
			if($r['money']==0){
				$r['money']=$r['money2'];
			}
			if($r['type']==1){
				$m[$k]['content']='提现'.TBMONEY.'：'.(float)$r['money'].TBMONEYUNIT;
			}
			else{
				$m[$k]['content']='提现金额：'.(float)$r['money'].'元';
			}
			$m[$k]['addtime']=date('Y-m-d H:i:s',$r['addtime']);
		}
		$title='提现';
	}

	$total=count($m);
	
	$webtitle=$title.'-'.$dd_tpl_data['title'];
	
	unset($duoduo);
	unset($webset);
	unset($dduser);
	unset($dd_tpl_data);
	$parameter['shuju_data']=$m;
	$parameter['do']=$do;
	$parameter['webtitle']=$webtitle;
	$parameter['title']=$title;
	$parameter['page']=$page;
	$parameter['page_size']=$page_size;
	$parameter['total']=$total;
	return $parameter;
}
?>