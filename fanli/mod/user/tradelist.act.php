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

if (!defined('INDEX')) {
	exit ('Access Denied');
}

function act_user_tradelist($pagesize = 10) {
	global $duoduo;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	$do = empty ($_GET['do']) ? 'taobao' : $_GET['do'];
	$page = !($_GET['page']) ? '1' : intval($_GET['page']);
	$pagesize = 10;
	$frmnum = ($page -1) * $pagesize;
	$cat_arr = $webset['baobei']['cat'];
	$status_arr = include (DDROOT . '/data/status_arr.php'); //订单状态
	if ($do == 'taobao') {
		$total = $duoduo->count('tradelist', 'uid="' . $dduser['id'] . '" and (checked=2 or checked=3) and del=0');
		$dingdan = $duoduo->select_all('tradelist', '*', "uid=" . $dduser['id'] . " and (checked=2 or checked=3) and del=0 order by create_time desc,id desc limit $frmnum,$pagesize");
		foreach($dingdan as $k=>$row){
			$baobei=$duoduo->select('baobei','*','trade_id="'.$row['id'].'"');
			$dingdan[$k]['baobei_id']=$baobei['id'];
			$dingdan[$k]['baobei_status']=$baobei['status'];
			$dingdan[$k]['baobei_reason']=$baobei['reason'];
			$dingdan[$k]['baobei_userimg']=$baobei['userimg'];
			$dingdan[$k]['baobei_cid']=$baobei['cid'];
			$dingdan[$k]['baobei_content']=$baobei['content'];
			$dingdan[$k]['trade_id']=preg_replace('/_\d+/','',$row['trade_id']);
		}
	}
	elseif ($do == 'lost') {
		if (isset ($_GET['q']) && is_numeric($_GET['q']) && $_GET['q']>0) {
			$q = $_GET['q'];
			if(TAOTYPE==1){
				$where = ' and trade_id_former = "' . $q . '"';
			}
			else{
				$where = ' and trade_id = "' . $q . '"';
			}
			$dingdan = $duoduo->select_all('tradelist', '*', 'uid=0 and del=0' . $where . ' limit ' . $frmnum . ',' . $pagesize);
			if(empty($dingdan)){
				$where = ' and mini_trade_id = "' . substr($q,0,8).substr($q,-4) . '"';
				$dingdan = $duoduo->select_all('tradelist', '*', 'uid=0 and del=0 and checked=0' . $where . ' limit ' . $frmnum . ',' . $pagesize);
			}
			foreach($dingdan as $k=>$row){
				$dingdan[$k]['trade_id']=fuzzyTradeId(preg_replace('/_\d+/','',$row['trade_id']));
			}
			$total=count($dingdan);
			if (empty ($dingdan)&&$q) {
				jump(-1,"订单号为" . $q . "的订单不存在或者已经被认领，请联系站长！");
			}
		}
		else{
			jump(-1,"订单号格式错误");
		}
	}
	elseif ($do == 'paipai') {
		$total = $duoduo->count('paipai_order', 'uid="' . $dduser['id'] . '" and del=0');
		$dingdan = $duoduo->select_all('paipai_order', '*', 'uid="' . $dduser['id'] . '" and del=0 order by  id desc limit ' . $frmnum . ',' . $pagesize);
	}
	elseif ($do == 'paipailost') {
		if (isset ($_GET['q'])) {
			$q = $_GET['q'];
			$where = ' and dealId = "' . $q . '"';
			$total = $duoduo->count('paipai_order', 'uid=0 and del=0' . $where);
			$dingdan = $duoduo->select_all('paipai_order', '*', 'uid=0 and del=0' . $where . ' limit ' . $frmnum . ',' . $pagesize);
		}
	}
	elseif ($do == 'mall') {
		$total = $duoduo->count('mall_order', 'uid="' . $dduser['id'] . '" and del=0');
		$dingdan = $duoduo->select_all('mall_order', '*', 'uid="' . $dduser['id'] . '" and del=0 order by  order_time desc limit ' . $frmnum . ',' . $pagesize);
	}
	elseif ($do == 'malllost') {
		if (isset ($_GET['q'])) {
			$q = $_GET['q'];
			$where = ' and order_code = "' . $q . '"';
			$total = $duoduo->count('mall_order', 'uid=0 and del=0' . $where);
			$dingdan = $duoduo->select_all('mall_order', '*', 'uid=0 and del=0' . $where . ' limit ' . $frmnum . ',' . $pagesize);
		}
	}
	elseif ($do == 'checked') {
		$total = $duoduo->count('tradelist', 'uid="' . $dduser['id'] . '" and checked=1 and del=0');
		$dingdan = $duoduo->select_all('tradelist', '*', 'uid="' . $dduser['id'] . '" and checked=1 and del=0 order by id desc limit ' . $frmnum . ',' . $pagesize);
	}
	elseif ($do == 'task') {
		$total = $duoduo->count('task', 'memberid="' . $dduser['id'] . '" and del=0');
		$dingdan = $duoduo->select_all('task', '*', 'memberid="' . $dduser['id'] . '" and del=0 order by  id desc limit ' . $frmnum . ',' . $pagesize);
	}
	unset ($duoduo);
	$parameter['do'] = $do;
	$parameter['cat_arr'] = $cat_arr;
	$parameter['status_arr'] = $status_arr;
	$parameter['total'] = $total;
	$parameter['pagesize'] = $pagesize;
	$parameter['dingdan'] = $dingdan;
	$parameter['q'] = $q;
	$parameter['ziguanlian'] = $ziguanlian;
	return $parameter;
}
?>