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

function act_wap_order(){
	global $duoduo,$dd_tpl_data;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	
	if($dduser['id']==0){
		jump(wap_l('user','login'));
	}
	$q=$_GET['q'];
	$do=$_GET['do'];
	$page=(int)$_GET['page'];
	$page=$page==0?1:$page;
	$page_size=20;
	$uid=$dduser['id'];
	if ($do == 'lost') {
		if (isset ($_GET['q']) && is_numeric($_GET['q']) && $_GET['q']>0) {
			$q =$_GET['q'];
			if(TAOTYPE==1){
				$where = ' and trade_id_former = '.$q;
			}
			else{
				$where = ' and trade_id ='.$q;
			}
			$order=$duoduo->select_all('tradelist','id, item_title, num_iid, pay_price,jifenbao,trade_id,pay_time,create_time,status',"uid=0 and del=0 ".$where." order by id desc limit ".($page-1)*$page_size.','.$page_size);
			if(empty($order)){
				$where = ' and mini_trade_id = "' . substr($q,0,8).substr($q,-4) . '"';
				$order=$duoduo->select_all('tradelist','id, item_title, num_iid, pay_price,jifenbao,trade_id,pay_time,create_time,status',"uid=0 and del=0 and checked=0 ".$where." order by id desc limit ".($page-1)*$page_size.','.$page_size);
			}
			foreach($order as $k=>$r){
				$order[$k]['trade_id']=preg_replace('/_\d+/','',$r['trade_id']);
				$order[$k]['jifenbao']=(float)$r['jifenbao'];
				$order[$k]['fxje']=$r['jifenbao']>0?(float)$r['jifenbao'].' '.TBMONEY:'待结算';
				$order[$k]['create_time']=$r['pay_time']!=''?$r['pay_time']:$r['create_time'];
				$order[$k]['status_tip']=$status_arr[$r['status']];
			}
			$title='淘宝订单';
			if (empty ($order)&&$q) {
				jump(wap_l('user','order',array('do'=>'taobao')),"订单号为" . $q . "的订单不存在或者已经被认领，请联系站长！");
			}
		}
		else{
			jump(wap_l('user','order',array('do'=>'taobao')),"订单号格式错误");
		}
	}
	if($do=='taobao'){	
		$status_arr = include (DDROOT . '/data/status_arr.php'); //订单状态
		$order=$duoduo->select_all('tradelist','id, item_title, num_iid, pay_price,jifenbao,trade_id,pay_time,create_time,status',"uid='".$uid."' order by id desc limit ".($page-1)*$page_size.','.$page_size);
		foreach($order as $k=>$r){
			$order[$k]['trade_id']=preg_replace('/_\d+/','',$r['trade_id']);
			$order[$k]['jifenbao']=(float)$r['jifenbao'];
			$order[$k]['fxje']=$r['jifenbao']>0?(float)$r['jifenbao'].' '.TBMONEY:'待结算';
			$order[$k]['create_time']=$r['pay_time']!=''?$r['pay_time']:$r['create_time'];
			$order[$k]['status_tip']=$status_arr[$r['status']];
		}
		$title='淘宝订单';
	}
	elseif($do=='mall'){
		$status_arr = include(DDROOT.'/data/status_arr_mall.php');//订单状态
		$order=$duoduo->select_all('mall_order','id, order_code, mall_name, sales,order_time,item_count,fxje,status',"uid='".$uid."' order by id desc limit ".($page-1)*$page_size.','.$page_size);
		foreach($order as $k=>$r){
			$order[$k]["order_code"]=preg_replace('/_\d+/','',$r["order_code"]);
			$order[$k]['order_time']=date('Y-m-d H:i:s',$r['order_time']);
			$order[$k]['item_title']=$r['mall_name'].' 订单号：'.$r['order_code'];
			$order[$k]['create_time']=$r['order_time'];
			$order[$k]['fxje']=$r['fxje'].'元';
			$order[$k]['status_tip']=$status_arr[$r['status']];
		}
		$title='商城订单';
	}
	elseif($do=='paipai'){
		$checked_status=include(DDROOT.'/data/status_arr_paipai.php'); //订单状态
		$order=$duoduo->select_all('paipai_order','id, commName, fxje, addtime,checked',"uid='".$uid."' order by id desc limit ".($page-1)*$page_size.','.$page_size);
		foreach($order as $k=>$r){
			$order[$k]['addtime']=date('Y-m-d H:i:s',$r['addtime']);
			$order[$k]['item_title']=$r['commName'];
			$order[$k]['create_time']=$r['addtime'];
			$order[$k]['fxje']=$r['fxje'].'元';
			$order[$k]['status_tip']=$checked_status[$r['checked']];
		}
		
		$title='拍拍订单';
	}
	$total=count($order);
	
	$webtitle=$title.'-'.$dd_tpl_data['title'];
	
	unset($duoduo);
	unset($webset);
	unset($dduser);
	unset($dd_tpl_data);
	$parameter['shuju_data']=$order;
	$parameter['webtitle']=$webtitle;
	$parameter['title']=$title;
	$parameter['page']=$page;
	$parameter['page_size']=$page_size;
	$parameter['total']=$total;
	return $parameter;
}
?>