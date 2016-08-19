<?php
/**
这个计划任务是获取商城数据
**/

if(!defined('DDROOT')){
	exit('Access Denied');
}

$mall_field=$webset['mall_field'];
$duoduo->sql_cache_status=0; //关闭sql缓存

if($admin_run==1){
	$page=$_GET['page']?$_GET['page']:1;
}
else{
	$page=$cron_cache['jindu']>0?$cron_cache['jindu']:1;
}
$pagesize=100;
$yasuo=gzdeflate(1,9);
$yasuo=(int)gzinflate($a);
$url=DD_FANLICHENG_URL.'/api.php?mod=collect_api&act=mall&page='.$page.'&page_size='.$pagesize.'&url='.urlencode(get_domain(SITEURL)).'&key='.md5(DDYUNKEY)."&field=".$mall_field.'&yasuo='.$yasuo;

/*这么写的目的是，有的服务器解析json有问题，所以需要用自制的解json类，但是这个类又解析不了商城数据*/
$return=dd_get($url,'get',3600);
if($yasuo==1){
	$return=base64_decode($return);
	$return=gzinflate($return);
}
$_return=dd_json_decode($return,1);
if(!isset($_return['r'])){
	$_return=json_decode($return,1);
}
$return=$_return;
/**/

if(isset($return['s']) && $return['s']==0){
	return $this->error($return['r']);
}
else{
	$a=$return['r'];
}
if(count($a)<$pagesize){
	$next=0;
}
else{
	$next=1;
}

foreach($a as $v){
	$b=array();
	if(isset($v['title'])){
		$b['title']=$v['title'];
	}
	if(isset($v['pinyin'])){
		$b['pinyin']=$v['pinyin'];
	}
	if(isset($v['url'])){
		$b['url']=$v['url'];
	}
	if(isset($v['img'])){
		$b['img']=$v['img'];
	}
	if(isset($v['banner'])){
		$b['banner']=$v['banner'];
	}
	if(isset($v['cid'])){
		$b['cid']=$v['cid'];
	}
	if(isset($v['fan'])){
		$b['fan']=$v['fan'];
	}
	if(isset($v['des'])){
		$b['des']=$v['des'];
	}
	if(isset($v['content'])){
		$b['content']=$v['content'];
	}
	$b['domain']=$v['domain'];
	$b['host']=$v['host'];
	if(isset($v['sort'])){
		$b['sort']=$v['sort']>0?$v['sort']:DEFAULT_SORT;
	}
	$b['addtime']=TIME;
	if(isset($v['edate'])){
		$b['edate']=$v['edate'];
	}
	$mall=$duoduo->select('mall','id,suoding','host="'.$b['host'].'"');
	if($mall['id']==0){
		$b['lm']=8;
		$duoduo->insert('mall',$b);
	}
	elseif($mall['suoding']==0){//不锁定的不更新
		$duoduo->update('mall',$b,'id="'.$mall['id'].'"');
	}	
	if(mysql_error()){
		print_r($b);
		echo $duoduo->lastsql;
		exit(mysql_error());
	}
	del_ddcache('','sql/mall');
}

$page++;
if($admin_run==1){
	if($next==1){
		$url=$this->base_url.'&page='.$page.$this->admin_run_param;
		PutInfo('商城数据获取中。。。<br/><br/><img src="images/wait2.gif" />',$url);
	}
	else{
		return $this->over();
	}
}
else{
	if($next==1){
		$this->jindu($page);
	}
	else{
		return $this->over();
	}
}
?>