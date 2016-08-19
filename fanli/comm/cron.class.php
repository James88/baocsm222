<?php
class cron{
	public $filename;
	public $duoduo;
	public $cron_re;
	public $cron_cache;
	public $cron_cache_all;
	public $run_time;
	public $admin_run;
	public $base_url;
	public $admin_run_param;
	public $from;
	public $cron_id;
	public $log=0;
	public $exit_status=0;
	
	function __construct($duoduo){	
		$this->duoduo=$duoduo;
		$jiaoben=$_GET['jiaoben'];
		$plugin=$_GET['plugin'];
		$cron_id=(int)$_GET['cron_id'];
		$cron=dd_get_cache('cron');
		
		dd_session_start();
		if ((isset ($_GET['admin']) && ddStrCode($_GET['admin'],DDKEY, 'DECODE') == 'admin_run') || ($_SESSION['ddadmin']['name']!='' && AJAX==0)) {  //判断是否是后台人工执行
			$this->admin_run=1;
			$this->admin_run_param='&admin='.urlencode(ddStrCode('admin_run',DDKEY,'ENCODE'));
		}
		else{
			$this->admin_run=0;
			if(time()-ddStrCode($_GET['t'],DDKEY,'DECODE')>30){
				$this->_exit('访问超时'.time(),'--'.ddStrCode($_GET['t'],DDKEY,'DECODE'));
			}
		}
		
		$this->cron_cache_all=$this->do_cron_jiegou($cron);
		
		if($cron_id>0){  //如果有id号
			foreach($this->cron_cache_all as $arr){
				if($arr['id']==$cron_id){
					$this->cron_cache=$arr;
					$_GET['jiaoben']=$jiaoben=$arr['filename'];
					if($arr['leixing']==1){
						$_GET['plugin']=$plugin=$arr['plugin_name'];
					}
					$this->cron_id=$arr['id'];
					break;
				}
			}
		}
		else{
			if($jiaoben==''){
				$this->_exit('计划任务脚本不能为空');
			}
			
			if(!preg_match('#\.php$#',$jiaoben)){
				$_GET['jiaoben']=$jiaoben=$jiaoben.'.php';
			}
			
			if(!preg_match('#^cron_#',$jiaoben)){
				$_GET['jiaoben']=$jiaoben='cron_'.$jiaoben;
			}
			
			if(preg_match('/^cron_[a-z0-9_]+\.php$/',$jiaoben)==0){
				$this->_exit('脚本名不符合规范');
			}
			
			foreach($this->cron_cache_all as $arr){
				if($arr['filename']==$jiaoben && $arr['plugin_name']==$plugin){
					$this->cron_cache=$arr;
					$this->cron_id=$arr['id'];
					break;
				}
			}
		}
		if(empty($this->cron_cache) && $this->admin_run==1){
			$this->cron_cache=array('filename'=>$jiaoben);
		}
		if(empty($this->cron_cache)){
			$this->_exit('脚本不存在或已关闭');
		}
		include_once(DDROOT.'/comm/php_lock.class.php');
		$phplock=new phplock('cron_'.$this->cron_id);
		if($phplock->status==0){
			$this->_exit('请求过多，请稍后再试');
		}
		
		$next_time=cron_next_time($this->cron_cache);
		if($this->admin_run==0 && $next_time>date('Y-m-d H:i:s') && $this->cron_cache['jindu']==0){
			$this->_exit('时间未到，请稍后再试'.$next_time.'--'.date('Y-m-d H:i:s').'--'.$this->cron_cache['jindu']);
		}
		
		if($this->log==1){
			create_file(DDROOT.'/data/cron/'.date('Ymd').'.txt',CUR_URL.'--'.date('Y-m-d H:i:s').'--'.$this->admin_run.'--'.$next_time.'--'.$this->cron_cache['jindu']."\r\n",FILE_APPEND);
		}
		
		$this->from=$_GET['from']?$_GET['from']:$_SERVER['HTTP_REFERER'];
		if(strpos($this->from,'http')===false){
			$this->from=SITEURL.'/'.$this->from;
		}
		$this->base_url=u(MOD,ACT,array('cron_id'=>$this->cron_id,'jiaoben'=>$_GET['jiaoben'],'plugin'=>$_GET['plugin'],'from'=>$this->from,'t'=>urlencode(ddStrCode(TIME,DDKEY))));
		
		if($plugin==''){
			$filename=DDROOT.'/comm/cron/'.$jiaoben;
		}
		else{
			$filename=DDROOT.'/plugin/'.$plugin.'/cron/'.$jiaoben;
		}
		$this->filename=$filename;
	}
	
	function _exit($msg){
		if($this->log==1){
			create_file(DDROOT.'/data/cron/'.date('Ymd').'_error.txt',CUR_URL.'--'.date('Y-m-d H:i:s').'--'.$msg."\r\n",FILE_APPEND);
		}
		$this->exit_status=1;
		exit($msg);
	}
	
	function do_cron_jiegou($cron){
		foreach($cron as $row){
			$row['dev']=strpos($row['dev'],'a:')===0?unserialize($row['dev']):$row['dev'];
			$_cron[$row['id']]=$row;
		}
		return $_cron;
	}
	
	function run(){
		if(!empty($this->cron_cache)){
			$admin_run=$this->admin_run;
			$duoduo=$this->duoduo;
			$webset=$duoduo->webset;
			$dduser=$duoduo->dduser;
			$cron_cache=$this->cron_cache;
			if($_GET['plugin']!=''){
				$plugin_data=dd_get_cache('plugin/'.$_GET['plugin']);
			}
			$this->run_time=date('Y-m-d H:i:s');
			include($this->filename);
			$data=array('dev'=>$this->cron_cache['dev'],'jindu'=>$this->cron_cache['jindu'],'last_time'=>$this->run_time);
			$this->duoduo->update('cron',$data,'id="'.$this->cron_id.'"');
			if($this->log==1){
				create_file(DDROOT.'/data/cron/'.date('Ymd').'_sql.txt',CUR_URL.'--'.date('Y-m-d H:i:s').'--'.$this->duoduo->lastsql."\r\n",FILE_APPEND);
			}
			
		}else{
			$this->_exit("cron_cache为空");
		}
	}
	
	function error($msg='执行错误'){
		$this->msg($msg);
		$this->over($msg); //如果有错误，该任务结束，否则会一直执行
		return false;
	}
	
	function over($msg='执行完成'){
		$this->jindu(0);
		if($this->admin_run==1){
			PutInfo($msg.'<br/><br/><a href="'.$this->from.'">点击返回</a>');
		}
		return false;
	}

	function dev($var,$val){
		$this->cron_cache['dev'][$var]=$val;
		$this->update_cache('dev',$this->cron_cache['dev']);
	}

	function msg($msg){
		$this->update_cache('msg',$msg);
	}
	
	function jindu($jindu){
		$this->update_cache('jindu',$jindu);
	}
	
	function update_cache($var,$val){
		$this->cron_cache[$var]=$val;
	}
	
	function __destruct(){
		if($this->exit_status==0){
			if(!empty($this->cron_cache)){
				if($this->run_time!=''){
					$this->update_cache('last_time',$this->run_time);
				}
				$this->cron_cache_all=dd_get_cache('cron');
				if(!empty($this->cron_cache_all)){
					$this->cron_cache_all[$this->cron_id]=$this->cron_cache;
					dd_set_cache('cron',$this->cron_cache_all);
				}
			}
			unset($this->duoduo);
			if($this->admin_run==1 && defined('CRON_ADMIN_TIP')){
				PutInfo(CRON_ADMIN_TIP);
			}
		}
		else{
			unset($this->duoduo);
		}
	}
}
function get_cron_time($t){
	$str=dd_crc32(SITEUTL.$t);
	$str=sprintf("%04d", substr($str,-4,4));
	if($str>2200 || $str<1600){
		$str=$str%600+1600;
	}
	$m=substr($str,-2,2);
	$m=$m<60?$m:$m-60;
	return substr($str,0,2).':'.$m;
}
function cron_next_time($row){
	$next_time='';
	if($row['last_time']==''){ //如果上次执行时间为空，给一个默认值
		$row['last_time']='2000-01-01';
	}
	if($row['fangshi']==1 || $row['dd']==1){
		if($row['dd']==1){
			$row['execute_time']=get_cron_time($row['dev']);
		}else{
			$row['execute_time'].=':00';
		}
		$last_day=date('Ymd',strtotime($row['last_time']));
		if($last_day<date('Ymd')){  //上次触发时间小于今天
			if(date('H')>=$row['execute_time']){  //如果当前的小时大于等于设置的小时
				$next_time=date('Y-m-d H:00:00');  //执行时间为当前
			}
			else{ //如果当前小时小于设置小时，说明还没到时间
				$next_time=date('Y-m-d '.$row['execute_time'].':00');  //执行时间为设置的小时
			}
		}
		else{  //如果是今天执行过
			$next_time=date('Y-m-d '.$row['execute_time'].':00',strtotime('+1 day'));  //执行时间为明天设置的时间
		}
	}
	elseif($row['fangshi']==2){
		if($row['last_time']!='2000-01-01'){  //如果上次执行时间不为空，用上次执行时间加设置的时钟
			$next_time=date('Y-m-d H:i:00',strtotime($row['last_time']." +".$row['interval_time']." minute"));
		}
		else{  //如果上次执行时间为空
			$next_time=date('Y-m-d H:i:00');;  //执行
		}
	}
	else{
		if(rand(1,1000)<=$row['rand']){ //在随机数内
			$next_time=date('Y-m-d H:i:s',strtotime('-1 second'));;  //执行
		}
		else{
			$next_time=date('Y-m-d H:i:s',strtotime('+10 second'));  //不执行
		}
	}
	return $next_time;
}