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
* @name 拍拍列表页面
* @copyright duoduo123.com
* @example 示例paipai_list();
* @param $pagesize 每页显示多少商品
* @param $field 字段
* @param $limit 每页显示多少
* @return $parameter 结果集合
*/
function act_paipai_list($keyWord='热卖',$sort=86,$pagesize=20){
	global $duoduo;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	if($keyWord==''){$keyWord='热卖';}
	if($sort==''){$sort='86';}
	if($pagesize==''){$pagesize='20';}
	include(DDROOT.'/comm/paipai.class.php');
	$paipai_set['userId']=$webset['paipai']['userId'];
	$paipai_set['qq']=$webset['paipai']['qq'];
	$paipai_set['appOAuthID']=$webset['paipai']['appOAuthID'];
	$paipai_set['secretOAuthKey']=$webset['paipai']['secretOAuthKey'];
	$paipai_set['accessToken']=$webset['paipai']['accessToken'];
	$paipai_set['fxbl']=$webset['paipaifxbl'];
	$paipai_set['cache_time']=$webset['paipai']['cache_time'];
	$paipai_set['errorlog']=$webset['paipai']['errorlog'];
	$paipai=new paipai($dduser,$paipai_set);
	
	$sort_arr=include(DDROOT.'/data/paipai_sort.php');
	$property_arr=array(0=>'全部','16'=>'免运费','512'=>'7天包退','0x20000'=>'假1赔3');
	
	$list=$_GET['list']?(int)$_GET['list']:2;  //注意全局变量
	$liebiao=(int)get_cookie('liebiao',0);
	if($list==0){
		if($liebiao>0){
			$list=$liebiao;
		}
		else{
			$list=$webset['liebiao'];
		}
	}
	set_cookie('liebiao', $list, 12000,0);
	
	$q=$_GET['q']?$_GET['q']:$keyWord;
	$cid=(int)$_GET['cid'];
	
	if(is_url($q)){
		$commId=$paipai->url2commId($q);
		if($commId!=''){
			$thegoods=$paipai->cpsCommQueryAction(array('commId'=>$commId));
			if(!empty($thegoods)){
				$thegoods['url']=u(MOD,ACT,array('q'=>$thegoods["title"]));
			}
			$seelog=array('type'=>'paipai','id'=>$thegoods['dwNum'],'jump'=>$thegoods['jump'],'pic'=>$thegoods['smallImg'],'title'=>$thegoods['title'],'price'=>$thegoods['price']);
			if($thegoods==102){error_html('该商品无返利',-1,1);}
			$q=$thegoods['title'];
			$list=1;
		}
		else{
			error_html('请输入的规范的拍拍网址，如：http://auction1.paipai.com/AF5AF632000000000401000013577BF3');
		}
	}
	
	$begPrice=(float)$_GET['begPrice'];
	$endPrice=(float)$_GET['endPrice'];
	
	if(isset($_GET['sort'])){
		$sort = (int)$_GET['sort'];
		if(!isset($sort_arr[$sort])) $sort=86;
	}
	if(isset($_GET['property'])){
		$property = $_GET['property'];
		if(!isset($property_arr[$property])) $property='';
	}
	else{
		$property='';
	}
	
	$property=$_GET['property'];
	
	$page=$_GET['page']?$_GET['page']:'1';
	
	$parame['classId']=$cid;
	$parame['keyWord']=$q;
	$parame['orderStyle']=$sort;
	$parame['begPrice']=$begPrice;
	$parame['endPrice']=$endPrice;
	$parame['property']=$property;
	$parame['pageIndex']=$page;
	$parame['pageSize']=$pagesize;
	$parameter['act_seelog']=$seelog;
	$goods=$paipai->cpsCommSearch($parame);
	$total=$goods['total'];
	unset($goods['total']);
	foreach($goods as $k=>$row) {
		$goods[$k]['url']=u(MOD,ACT,array('q'=>$row["title"]));
	}
	if($total>0){
		//最多显示100页
		if($total>$pagesize*100){
			$total=100*$pagesize;
		}
		//网站头
		if($q=='') $q='拍拍精选商品';
	}
	else{
		//error_html('商品不存在',-1,1);
	}
	
	$show_parameter=array('cid'=>$cid,'q'=>$q,'sort'=>$sort,'property'=>$property,'begPrice'=>$begPrice,'endPrice'=>$endPrice,'list'=>$list,'page'=>$page);
	$showpic_list1=u(MOD,ACT,arr_replace($show_parameter,'list',1)); //小图显示
	$showpic_list2=u(MOD,ACT,arr_replace($show_parameter,'list',2)); //大图显示
	unset($show_parameter['page']);
	$show_page_url=u(MOD,ACT,$show_parameter);
	unset($duoduo);
	$parameter['q']=$q;
	$parameter['cid']=$cid;
	$parameter['goods']=$goods;
	$parameter['begPrice']=$begPrice;
	$parameter['endPrice']=$endPrice;
	$parameter['thegoods']=$thegoods;
	$parameter['property_arr']=$property_arr;
	$parameter['property']=$property;
	$parameter['sort_arr']=$sort_arr;
	$parameter['sort']=$sort;
	$parameter['showpic_list1']=$showpic_list1;
	$parameter['showpic_list2']=$showpic_list2;
	$parameter['list']=$list;
	$parameter['total']=$total;
	$parameter['pagesize']=$pagesize;
	$parameter['show_page_url']=$show_page_url;
	return $parameter;
}

