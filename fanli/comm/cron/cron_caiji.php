<?php
/**
这个计划任务是采集板块数据
**/

if(!defined('DDROOT')){
	exit('Access Denied');
}
$page_size=50;

if($admin_run==1){
	$page=$_GET['page']?$_GET['page']:1;
}
else{
	$page=$cron_cache['jindu']>0?$cron_cache['jindu']:1;
}

$id=(int)$_GET['id'];
if($id==0){
	$id=$cron_cache['dev'];
}

if(empty($id)){
	return $this->error('参数ID丢失');
}
$collect=$duoduo->select('collect','*','id='.$id);
if(empty($collect)){
	return $this->error('没有这个采集规则');
}
//更新采集时间
if($page==1){
	$duoduo->update('collect',array('update_time'=>strtotime(SJ)),'id='.$id);
}
$num=$_GET['num']?$_GET['num']:0;
$up_num=$_GET['up_num']?$_GET['up_num']:0;
if($admin_run==0){
	$caiji_time=$_GET['caiji_time']?(int)$_GET['caiji_time']:0;//采集明天数据
}else{
	$caiji_time=$_GET['caiji_time']?(int)$_GET['caiji_time']:1;//采集当天数据
}

$max_page=$collect['page_no']?(int)$collect['page_no']:10;//最多采集10页
if($page>$max_page){
	return $this->over('采集完成');
}

if($collect['laiyuan']==2){
	$data=array();
	if($collect['api_kwd']){
    	$data['q']=$collect['api_kwd'];
	}
	if($collect['api_cid']){
    	$data['cat']=$collect['api_cid'];
	}
	if($collect['api_sort']){
    	$data['sort']=$collect['api_sort'];
	}

    $data['is_mall']=$collect['is_mall'];
	$data['start_price']=(int)$collect['start_price'];
	$data['end_price']=(int)$collect['end_price'];
    $data['start_tk_rate']=(int)$collect['start_tk_rate'];
    $data['end_tk_rate']=(int)$collect['end_tk_rate'];

	if($page){
		$data['page_no']=$page;
	}
	if($collect['page_size']>0){
    	$data['page_size']=$collect['page_size'];
	}
	$ddTaoapi = new ddTaoapi();
	$return=$ddTaoapi->taobao_tbk_item_get($data);
	if($return['s']==0){
		return $this->error($return['r']);
	}
	//获取时间
	$bankuai_time=$duoduo->select('bankuai','*',"code='".$collect['code']."'");
	$goods_time=goods_time($bankuai_time);
	$starttime=$goods_time['starttime'];
	$endtime=$goods_time['endtime'];
	foreach($return['r'] as $vo){
		$add=array();
		$add['url']=$vo['item_url'];
		$add['data_id']=$vo['num_iid'];
		$add['img']=$vo['pict_url'];
		$add['price']=$vo['reserve_price'];
		$add['discount_price']=$vo['zk_final_price'];
		$add['title']=strip_tags($vo['title']);
		$add['starttime']=$starttime;
		$add['endtime']=$endtime;
		$add['addtime']=TIME;
		$add['cid']=$collect['web_cid'];
		$add['code']=$collect['code'];
		if($vo['user_type']==1){
			$add['laiyuan']='天猫';
			$add['laiyuan_type']=2;
		}else{
			$add['laiyuan']='淘宝';
			$add['laiyuan_type']=1;
		}
		$cun=$duoduo->select('goods','id',"data_id=".$add['data_id']);
		if(empty($cun)){
			$goods_id=$duoduo->insert('goods',$add);
			if($goods_id>0){
				$num++;
			}
		}
		echo mysql_error();
	}
}
else{
	//综合平台
	if(empty($collect['api_url'])){
		return $this->error('采集地址不存在');
	}
	$collect['yun_cid']=unserialize($collect['yun_cid']);
	foreach($collect['yun_cid'] as $vo){
		$yun_cid[$vo['yun']]=$vo['bendi'];
		if($vo['bendi']>0){
			$yun_cid_arr[]=$vo['yun'];
		}
	}
	
	$yasuo=gzdeflate(1,9);
	$yasuo=(int)gzinflate($a);
	$url=$collect['api_url']."&caiji_time=".$caiji_time."&sprice=".$collect['sprice']."&eprice=".$collect['eprice']."&page=".$page."&page_size=".$page_size.'&key='.md5(DDYUNKEY).'&domain='.urlencode(DOMAIN)."&cid=".implode(',',$yun_cid_arr).'&yasuo='.$yasuo.'&version=2';
	$data=dd_get($url,'get',3600);
	if($yasuo==1){
		$data=base64_decode($data);
		$data=gzinflate($data);
	}
	$data=dd_json_decode($data,1);
	
	if($data['s']==0){
		return $this->error($data['r']?$data['r']:'服务器出错');
	}
	if(empty($data['r'])&&$page>1){
		return $this->over($data['tip']?$data['tip']:"采集完成");
	}
	$table_struct=$duoduo->get_table_struct('goods');
	foreach($data['r'] as $vv){
		$add=array();
		foreach($vv as $key=>$v){
			if(isset($table_struct[$key])){
				$add[$key]=$v;
			}
		}
		$add['cid']=$yun_cid[$vv['cid']];
		if($add['cid']==0){
			continue;//0得不采集
		}
		$add['code']=$collect['code'];
		$add['addtime']=TIME;
		if(empty($add['web_id'])){
			continue;//不采集
		}
		$goods_id=$duoduo->insert_select('goods',$add,"web_id = '".$add['web_id']."'");
		if($goods_id==0){
			$duoduo->update('goods',$add,"web_id = '".$add['web_id']."'");
			$up_num++;
		}
		else{
			$num++;
		}
	}
}

$page++;
if($admin_run==1){
	$url=$this->base_url.'&page='.$page.$this->admin_run_param.'&id='.$id.'&num='.$num.'&up_num='.$up_num."&caiji_time=".$caiji_time;
	PutInfo("接下来采集第".$page."页，新增".$num.'个商品，更新'.$up_num.'个商品，<br/><br/><img src="images/wait2.gif" />',$url);
}
else{
	$this->jindu($page);
}
?>