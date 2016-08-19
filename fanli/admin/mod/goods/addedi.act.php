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
if($_GET['do']=='tishi'){
	include(DDROOT.'/comm/ddu.class.php');
	$ddu_class=new ddu();
	$goods_tishi=$ddu_class->goods_tishi();
	echo json_encode($goods_tishi);
	exit();
}
//获取时间
if($_GET['do']=='shijian'){
	$code=$_GET['code'];
	//时间设置
	$bankuai_time=$duoduo->select('bankuai','*',"code='".$code."'");
	$goods_time=goods_time($bankuai_time);
	if($goods_time['starttime']){
		$goods_time['starttime']=date('Y-m-d H:i:s',$goods_time['starttime']);
	}else{
		$goods_time['starttime']="";
	}
	if($goods_time['endtime']){
		$goods_time['endtime']=date('Y-m-d H:i:s',$goods_time['endtime']);
	}else{
		$goods_time['endtime']="";
	}
	echo json_encode($goods_time);
	dd_exit();
}
//获取手机价格
if($_GET['do']=='shouji_price'){
	$iid=(float)get_tao_id($_GET['url']);
	$return=get_tao_mobile_price($iid);
	echo dd_json_encode($return);
	exit();
}
//获取商品
if($_GET['url']){
	include_once (DDROOT . '/comm/Taoapi.php');
	include_once (DDROOT . '/comm/ddTaoapi.class.php');
	$ddTaoapi = new ddTaoapi();
	include_once(DDROOT.'/comm/ddu.class.php');
	$ddu_class=new ddu();
	$data=$ddu_class->goods_url($_GET['url']);
	if($data['s']==1){
		$cun=$duoduo->select('goods','id',"data_id='".$data['r']['data_id']."'");
		if($cun){
			$data['r']['cun']=1;
		}
	}
	
	if(preg_match('/(taobao\.com|tmall\.com)/',$_GET['url'])==1){
		if($data['r']['taoke']==1){
			$a=$ddTaoapi->taobao_tbk_rebate_auth_get($data['r']['data_id']);
			if((int)$a[0]['rebate']==0){
				$data['tip']='该商品不允许返利';
			}
		}
		else{
			$data['tip']='该商品没有参加淘客推广';
		}
		$num_iid=get_tao_id($_GET['url']);
		if($num_iid>0){
			$a=$ddTaoapi->taobao_tbk_item_info_get($num_iid);
			if(!empty($a)){
				$data['r']['small_images'][]=$data['r']['img'];
				foreach($a[0]['small_images']['string'] as $v){
					$data['r']['small_images'][]=$v;
				}
			}
		}
	}
	
	echo dd_json_encode($data);
	exit();
}

		
$type=$duoduo->select_all('type','*',"tag='goods'");
foreach($type as $vo){
	$cid_arr[$vo['id']]=$vo['title'];
}
$bankuai_data=$duoduo->select_all('bankuai','code,title',"1");
foreach($bankuai_data as $vo){
	$bankuai[$vo['code']]=$vo['title'];
}
if($_POST['sub']!=''){
	unset($_POST['sub']);
	del_magic_quotes_gpc($_POST,1);
	if(empty($_POST['data_id'])){
		$_POST['data_id']="sj_".time();
	}
	$ddusername=$_POST['ddusername'];
	unset($_POST['ddusername']);
	if($ddusername){
		$_POST['uid']=$duoduo->select('user','id',"ddusername='".$ddusername."'");
	}else{
		$_POST['uid']=0;
	}
    $id=empty($_POST['id'])?0:(int)$_POST['id'];
	unset($_POST['id']);
	unset($_POST['sub']);
	$_POST['starttime']=strtotime($_POST['starttime']);
	if($_POST['endtime']=='' || $_POST['endtime']==0){
		$_POST['endtime']=0;
	}
	else{
		$_POST['endtime']=strtotime($_POST['endtime']);
	}
	$bankuai_id=$_POST['bankuai_id'];
	$_POST['domain']=get_domain($_POST['url']);
	$_POST['goods_attribute']=serialize($_POST['goods_attribute']);
	$_POST['ding']=(int)$_POST['ding'];
	$_POST['cai']=(int)$_POST['cai'];
	$_POST['sell']=(int)$_POST['sell'];
	$_POST['pinglun']=(int)$_POST['pinglun'];
	$_POST['fanli_bl']=(float)$_POST['fanli_bl'];
	$_POST['price_man']=(float)$_POST['price_man'];
	$_POST['price_jian']=(float)$_POST['price_jian'];
	$_POST['shouji_price']=(float)$_POST['shouji_price'];
	if(empty($id)){
		$_POST['addtime']=time();
		$cun=$duoduo->select(MOD,'id',"data_id='".$_POST['data_id']."'");
		if($cun){
			$duoduo->update(MOD,array('endtime'=>TIME),"data_id='".$_POST['data_id']."'",0);
		}
		$id=$duoduo->insert(MOD,$_POST);
		if($id>0){
			jump(u(MOD,'list',array('code'=>$_POST['code'])),'添加成功');
		}else{
			echo mysql_error();
			exit();
			jump(-1,'添加失败');
		}
		exit();
	}
	if($_POST['sort']>0&&$id){
		include_once(DDROOT.'/comm/goods.class.php');
		$goods_class=new goods($duoduo);
		$goods_class->update_sort($id,$_POST['sort']);
	}
	$duoduo->update(MOD,$_POST,'id="'.$id.'"');
	del_ddcache('','sql/'.MOD);
	jump(-2,'修改完成');
}
else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
    if($id==0){
	    $row=array();
		$row['code']=$_GET['code']?$_GET['code']:$bankuai_data[0]['code'];
		//时间设置
		$bankuai_time=$duoduo->select('bankuai','*',"code='".$row['code']."'");
		$goods_time=goods_time($bankuai_time);
		$starttime=$goods_time['starttime'];
		$row['endtime']=$goods_time['endtime'];
	}
	else{
	    $row=$duoduo->select(MOD,'*','id="'.$id.'"');
		if(preg_match('/(taobao\.com|tmall\.com)/',$row['url'])==1){
			$num_iid=get_tao_id($row['url']);
			if($num_iid>0){
				include_once (DDROOT . '/comm/Taoapi.php');
				include_once (DDROOT . '/comm/ddTaoapi.class.php');
				$ddTaoapi = new ddTaoapi();
				$a=$ddTaoapi->taobao_tbk_item_info_get($num_iid);
				if(!empty($a)){
					$row['small_images'][]=$a[0]['pict_url'];
					foreach($a[0]['small_images']['string'] as $v){
						$row['small_images'][]=$v;
					}
				}
			}
		}
	}
	$row['goods_attribute']=unserialize($row['goods_attribute']);
	$goods_attribute=$duoduo->select_all('goods_attribute','id,title',' 1 order by sort asc ');
}