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
function act_user_mypath(){
	global $duoduo,$dduser,$dd_tpl_data;
	
	if($_GET['del']==1){
		if($_GET['id']>0){
			$duoduo->delete('record_goods','id="'.$_GET['id'].'"');
			$duoduo->query("OPTIMIZE TABLE `record_goods` ");
			echo dd_json_encode(array('s'=>1,'r'=>'删除成功！'));exit;
		}
		$duoduo->delete('record_goods','uid="'.$dduser['id'].'" and type=1');
		$duoduo->query("OPTIMIZE TABLE `record_goods` ");
		jump(u(MOD,ACT),'清空完成');
	}

	$pagesize = 30;
	$page = $_GET['page']?$_GET['page']:1;
	$page1 = ($page-1)*$pagesize;
	$mypath = $duoduo->select_all('record_goods','*','type=1 and uid="'.$dduser['id'].'" order by id desc limit '.$page1.','.$pagesize);
	$total = $duoduo->count('record_goods','type=1 and uid="'.$dduser['id'].'"');
	foreach($mypath as $key=> $row){
		if($row['goods_id']>0){
			$mypath[$key]['url'] = u('goods','view',array('code'=>$row['code'],'id'=>$row['goods_id']));
		}else{
			if($row['code']==''){
				$mypath[$key]['url'] = u('tao','view',array('iid'=>$row['data_id']));
			}else{
				$mypath[$key]['url'] = u('goods','view',array('code'=>$row['code'],'iid'=>iid_encode($row['data_id'])));
			}
		}
		$tg_url=urlencode($mypath[$key]['url']."&rec=".$dduser['id']);
		$mypath[$key]['sina_url']="http://v.t.sina.com.cn/share/share.php?title=".urlencode($row['title'])."&url=".$tg_url;
		$mypath[$key]['qzone_url']="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=".$tg_url."&title=".urlencode($row['title'])."&summary=".urlencode($row['title'])."&pics=".urlencode(tb_img($row['img'],220))."&desc=".urlencode($row['title']);
		$mypath[$key]['renren_url']="http://widget.renren.com/dialog/share?resourceUrl=".$tg_url."&srcUrl=".$tg_url."&title=".urlencode($row['title'])."&images=".urlencode($row['img'])."&description=".urlencode($row['title']);
		$mypath[$key]['qqim_url']='http://connect.qq.com/widget/shareqq/index.html?url='.$tg_url.'&desc='.urlencode($row['title']).'&pics='.urlencode($row['img']).'&site=bshare';
		$mypath[$key]['qqmb_url']="http://share.v.t.qq.com/index.php?c=share&a=index&title=".urlencode($row['title'])."&site=".$tg_url."&pic=".urlencode($row['img'])."&url=".$tg_url."&appkey=dcba10cb2d574a48a16f24c9b6af610c&assname=${RALATEUID}";
		$mypath[$key]['zhe']=round($row['discount_price']/$row['price'],2)*10;
	}
	unset($duoduo);
	$parameter['mypath']=$mypath;
	$parameter['total']=$total;
	$parameter['ajax_load_num']=$dd_tpl_data['ajax_load_num'];
	$parameter['pagesize']=$pagesize;
	return $parameter;
}

?>