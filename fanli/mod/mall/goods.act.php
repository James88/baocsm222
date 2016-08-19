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
/**
* @name 商城商品
* @copyright duoduo123.com
* @example 示例mall_goods();
* @return $parameter 结果集合
*/
function act_mall_goods() {
	global $duoduo;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	include (DDROOT . '/comm/mallapi.config.php');
	$q = $_GET['q'] ? $_GET['q'] : '热卖';
	$page = $_GET['page'] ? (int) $_GET['page'] : 1;
	$pagesize = $mall_api_set['pagesize'];
	$order = $_GET['order'] ? (int) $_GET['order'] : 1;
	$start_price = $_GET['start_price'] ? (int) $_GET['start_price'] : 0;
	$end_price = $_GET['end_price'] ? (int) $_GET['end_price'] : 9999999;
	$merchantId = $_GET['merchantId'];

	$list = $_GET['list']?(int)$_GET['list']:2; //注意全局变量
	$liebiao = (int) get_cookie('liebiao', 0);
	if ($list == 0) {
		if ($liebiao > 0) {
			$list = $liebiao;
		} else {
			$list = $webset['liebiao'];
		}
	}
	set_cookie('liebiao', $list, 12000, 0);
	
	if(BIJIA==1){
		$pagesize=50;
		$goods=bijia($q,$page,$start_price,$end_price);
		$total=$goods['total'];
		unset($goods['total']);
		foreach($goods as $k=>$row){
			$goods[$k]['pic_url']=$row['img'];
			$goods[$k]['base64_pic']=base64_encode($row['img']);
			$goods[$k]['mall_name']=$row['mall'];
			$goods[$k]['merchantId']=1;
		}
		$goods['total']=$total;
	}
	else if (BIJIA==3) {
		$param['keyword'] = $q;
		$param['page_no'] = $page;
		$param['page_size'] = $pagesize;
		$param['webid'] = $merchantId;
		$param['price_range'] = $start_price . "," . $end_price;
		$param['orderby'] = $order;
		$goods = $ddYiqifa->product_search($param, 1); //获取商品
	}
	elseif (BIJIA==2) {
		$param['total'] = 1;
		$param['keyword'] = $q;
		$param['page_no'] = $page;
		$param['page_size'] = $pagesize;
		$param['outer_code'] = $dduser['id'];
		$param['start_price'] = $start_price;
		$param['end_price'] = $end_price;
		$goods = $dd59miao->items_search($param);
	}

	if ($goods['total'] > 0) {
		$total = $goods['total'];
		unset ($goods['total']);

		if ($total > $pagesize * 100) {
			$total = $pagesize * 100;
		}

		foreach ($goods as $k => $row) {
			if (!in_array($row['merchantId'], $shield_merchantId)) {
				$merchantId_arr[] = $row['merchantId'];
			}
		}

		if (!empty ($merchantId_arr)) {
			$merchantIds = implode($merchantId_arr, ',');
			$merchants = $duoduo->select_2_field('mall', $sjidname . ',fan', $sjidname . ' in (' . $merchantIds . ')');
		} else {
			$merchants = array ();
		}
		
		include(DDROOT.'/comm/mall.class.php');
		$mall_class=new mall($duoduo);
		
		if(REPLACE<3){
			$noword_tag='';
		}
		else{
			$noword_tag='3';
		}
		$nowords=dd_get_cache('no_words'.$noword_tag);
		
		foreach ($goods as $k => $row) {
			$goods[$k]['title']=dd_replace($goods[$k]['title'],$nowords);
			if (in_array($row['merchantId'], $shield_merchantId)) {
				$goods[$k]['fan'] = '无返利';
			} else {
				$goods[$k]['fan'] = $merchants[$row['merchantId']] ? $merchants[$row['merchantId']] : '10%';
			}
			$goods[$k]['renzheng'] = $merchants[$row['merchantId']] ? 1 : 0;
			
			if(BIJIA==1){
				$domain=get_domain($row['url']);
				$mall=$mall_class->view($domain);
				$goods[$k]['goods_jump'] = 'index.php?mod=jump&act=mall&mid='.$mall['id'].'&url='.$row['url'];
			}
			else{
				$goods[$k]['goods_jump'] = 'index.php?mod=jump&act=mall_goods&pic=' . urlencode($goods[$k]['base64_pic']) . '&name=' . $goods[$k]['name_url'] . '&url=' . urlencode(base64_encode($row['url'])) . '&price=' . $row['price'] . '&fan=' . urlencode($goods[$k]['fan']);
			}
			$goods[$k]['mall_jump'] = 'index.php?mod=jump&act=s8&url=' . urlencode(base64_encode($row['mall_url'])) . '&name=' . urlencode($row['mall_name']) . '&fan=' . urlencode($goods[$k]['fan']);
		}
	} else {
		error_html('商品不存在！');
	}

	$show_parameter = array (
		'merchantId' => $merchantId,
		'order' => $order,
		'start_price' => $start_price,
		'end_price' => $end_price,
		'list' => $list,
		'q' => $q,
		'page' => $page
	);

	$showpic_list1 = u(MOD, ACT, arr_replace($show_parameter, 'list', 1)); //小图显示
	$showpic_list2 = u(MOD, ACT, arr_replace($show_parameter, 'list', 2)); //大图显示
	unset ($show_parameter['page']);
	$show_page_url = u(MOD, ACT, $show_parameter);
	$start_price = $start_price == 0 ? '' : $start_price;
	$end_price = $end_price == 9999999 ? '' : $end_price;
	unset($duoduo);
	$parameter['q'] = $q;
	$parameter['start_price'] = $start_price;
	$parameter['end_price'] = $end_price;
	$parameter['merchantId'] = $merchantId;
	$parameter['showpic_list1'] = $showpic_list1;
	$parameter['showpic_list2'] = $showpic_list2;
	$parameter['total'] = $total;
	$parameter['goods'] = $goods;
	$parameter['pagesize'] = $pagesize;
	$parameter['list'] = $list;
	$parameter['liebiao'] = $liebiao;
	$parameter['show_page_url'] = $show_page_url;
	return $parameter;
}
$order_arr = array (
	1 => '按相似度',
	2 => '价格由低到高',
	3 => '价格由高到低'
);
?>