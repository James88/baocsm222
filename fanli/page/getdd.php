<?php
if(!defined('DDROOT')){
	include ('../comm/dd.config.php');
	include (DDROOT.'/comm/checkpostandget.php');
}

class ddget{
	public $duoduo;
	public $check_p_arr=array('taobao','mall');
	
	function __construct($duoduo,$p){
		$get=var_export($_GET, true)."\r\n".var_export($_POST, true).'|'.$_SERVER['REMOTE_ADDR']."\r\n";
		$dir =DDROOT.'/data/getdd_'.substr(md5(DDKEY),0,16).'/'. date("Y").'/'.date('md').'.txt';
		create_file($dir,$get,1);
		
		$this->duoduo=$duoduo;
		
		if(in_array($p,$this->check_p_arr)){
			$this->ddget_check_key();
		}
	}
	
	function ddget_check_key(){
		$dkey=DDYUNKEY;
		
		if(md5($dkey)!=$_GET['key']||empty($_GET['key'])){
			$re=array('s'=>0,'r'=>'无法通过认证');
			echo dd_json_encode($re);
			dd_exit();
		}
	}
	
	function ddget_plugin(){
		$code=$_GET['code'];
		$url=DD_YUN_URL.'/index.php?m=Api&a=one&code='.$code.'&url='.urlencode(SITEURL);
		$data=dd_get_json($url);
		if($data['s']==1){
			$plugin_id=$this->duoduo->select('plugin','id','code="'.$code.'"');
			if($data['r']['yongprice']>0){
				$plugin_data['price']=$data['r']['yongprice'];
			}
			elseif($data['r']['nianprice']>0){
				$plugin_data['price']=$data['r']['nianprice'];
			}
			elseif($data['r']['yueprice']>0){
				$plugin_data['price']=$data['r']['nianprice'];
			}
			$plugin_data['key']=$data['r']['ddkey'];
			$plugin_data['code']=$data['r']['code'];
			$plugin_data['title']=$data['r']['title'];
			$plugin_data['toper_name']=$data['r']['username'];
			$plugin_data['toper_qq']=$data['r']['qq'];
			$plugin_data['endtime']=$data['r']['endtime'];
			$plugin_data['addtime']=$data['r']['addtime'];
			$plugin_data['banben']=$data['r']['banben'];
			$plugin_data['version']=$data['r']['version'];
			$plugin_data['jiaocheng']=$data['r']['jiaocheng'];
			$plugin_data['authcode']=$data['r']['authcode'];
			
			$table=$this->duoduo->get_table_struct('plugin');
			if(isset($table['level'])){
				$plugin_data['level']=$data['r']['level'];
			}

			if($plugin_id==0){
				$this->duoduo->insert('plugin',$plugin_data);
			}
			else{
				$this->duoduo->update('plugin',$plugin_data,'id="'.$plugin_id.'"');
			}
		}
	}
	
	function ddget_taobao(){
		$duoduo=$this->duoduo;
		$id=$duoduo->select('tradelist', 'id', 'trade_id="'.$_GET['trade_id'].'"');
		if($id>0){
			$re=array('s'=>0,'r'=>'订单已经存在');
			return dd_json_encode($re);
		}
		$row=array();
		$row['pay_time']=$_GET['pay_time'];
		$row['num_iid']=$_GET['num_iid'];
		$row['pay_price']=$_GET['pay_price'];
		$row['real_pay_fee']=$_GET['real_pay_fee'];
		$row['commission_rate']=$_GET['commission_rate'];
		$row['commission']=$_GET['commission'];
		$row['item_num']=$_GET['item_num'];
		$row['trade_id']=$_GET['trade_id'];
		$row['outer_code']=$_GET['outer_code'];
		$row['category_id']=$_GET['category_id'];
		$row['create_time']=$_GET['create_time'];
		$row['category_name']=$_GET['category_name'];
		$row['platform']=1;//手机来源
		$row['item_title']=urldecode($_GET['item_title']);
		$row['shop_title']=urldecode($_GET['shop_title']);
		$row['seller_nick']=urldecode($_GET['seller_nick']);
		$row['app_key']="";//没有这个值的
		$duoduo->do_report($row);
		$re=array('s'=>1,'r'=>'订单接收成功');
		echo dd_json_encode($re);	
	}
	
	function ddget_mall(){
		$duoduo=$this->duoduo;
		include(DDROOT.'/comm/mall.class.php');
		$mall_class=new mall($duoduo);
		$lm=(int)$_GET['lm'];
		$ads_id=$_GET['ads_id'];//活动ID
		$ads_name=$_GET['ads_name'];
		$site_id=$_GET['site_id'];//网站ID
		$link_id=$_GET['link_id'];//活动链接ID
		$uid=$_GET['euid'];//	网站主设定的反馈标签
		list($uid,$code,$fuid,$shuju_id)=do_back_code($uid);
		$order_sn=$_GET['order_sn'];//	订单编号
		$order_time=$_GET['order_time'];//	下单时间
		$orders_price=$_GET['orders_price'];//订单金额
		$unique_id=$_GET['unique_id'];
		$commission=$_GET['confirm_siter_commission']?$_GET['confirm_siter_commission']:$_GET['siter_commission'];//	订单佣金
		$status=$_GET['status'];
		$platform=$_GET['platform'];
		$domain=$_GET['domain'];
		$sales =$orders_price;
		$order_code=$order_sn; //订单编号
		$unique_id=$unique_id?$unique_id:$order_code;  //唯一编号
		
		$mall_id=0;
		$mall_name=$ads_name;
		if($domain!=''){
			$mall=$mall_class->view($domain);
			if(!empty($mall)){
				$mall_name=$mall['title'];
				$mall_id=$mall['id'];
			}
		}
		
		$dduser=$duoduo->select('user','*','id="'.$uid.'"');
		$fxje=fenduan($commission,$this->duoduo->webset['mallfxbl'],$dduser['type']);
		$jifen=round($fxje*$this->duoduo->webset['jifenbl']);
		if($mall['type']==2){ //返积分
			$fxje=0;
		}
		if($dduser['tjr']>0){
			$tgyj=round($fxje*$this->duoduo->webset['tgbl']);
		}
		else{
			$tgyj=0;
		}
		
		$field_arr = array (
			'adid' => $ads_id,
			'lm' => $lm,
			'order_time' => $order_time,
			'mall_name' => $mall_name,
			'mall_id'=>$mall_id,
			'domain'=>$domain,
			'uid' => $uid,
			'order_code' => $order_code,
			'item_count' => 1,
			'item_price' => $sales,
			'sales' => $sales,
			'commission' => $commission,
			'status' => $status,
			'fxje' => $fxje,
			'jifen' => $jifen,
			'tgyj' => $tgyj,
			'addtime'=>TIME,
			'platform'=>$platform,
			'unique_id'=>$unique_id
		);
		
		if($status==1){
    		$field_arr['qrsj']=TIME;
		}
		
		$mall_order = $duoduo->select("mall_order", "id,mall_name,status,fxje,jifen,commission,order_code", 'unique_id="'.$unique_id.'"'); //用订单编号查
		if ($mall_order['id'] == '') {
			$insert=$duoduo->insert("mall_order", $field_arr);
			$tuiguang_insert_data=array('fuid'=>$fuid,'uid'=>$uid,'order_id'=>$insert,'mall'=>1,'code'=>$code,'shuju_id'=>$shuju_id);
			$duoduo->ddtuiguang_insert($tuiguang_insert_data);
			$field_arr['id']=$insert;
			$re=array('s'=>1,'r'=>'订单接收成功');
		}
		else{
			$duoduo->update('mall_order', $field_arr, "id='".$mall_order['id']."'");
			$field_arr['id']=$mall_order['id'];
			$re=array('s'=>1,'r'=>'订单已存在');
		}
		
		if($mall_order['status']!=1 && $status==1){//给会员结算
			if($dduser['id']>0 && ($fxje>0 || $jifen>0)){
				$duoduo->rebate($dduser,$field_arr,3);
				$re=array('s'=>1,'r'=>'订单结算');
			}
		}
		/*elseif($status!=1 && $mall_order['status']==1 && $dduser['id']>0){ //商城订单退款
			$refund_arr['uid']=$dduser['id'];
			$refund_arr['money']=$fxje;
			$refund_arr['jifen']=$jifen;
			$refund_arr['source']=$mall_name.'返利，订单号'.$order_code;
			$duoduo->dd_refund($refund_arr,23);
			$re=array('s'=>1,'r'=>'订单退款');
		}*/
		
		echo dd_json_encode($re);
	}
	
	function check(){
		$miyue=$_GET['key'];
		if($miyue==''){$miyue=$_POST['key'];}
		if(md5(DDYUNKEY)!=$miyue){
			$re=array('s'=>0,'r'=>'通信密钥错误');
			echo dd_json_encode($re);exit;
		}
		else{
			$re=array('s'=>1,'r'=>'成功');
			$re=dd_json_encode($re);
		}
		return $re;
	}
	
	function ddgoods(){
		$result=array('insert'=>0,'ignore'=>0);
		$duoduo=$this->duoduo;
		$table_struct=$duoduo->get_table_struct('ddgoods');
		$this->check();
		$shuju=$this->dd_unxuliehua($_POST['data']);
		foreach($shuju as $row){
			$result=$this->ddgoods_insert($row,$table_struct,$result);
		}
		$re=array('s'=>1,'r'=>$result);
		echo dd_json_encode($re);
	}
	
	function dd_unxuliehua($data){
		$shuju=dd_unxuliehua($data);
		if(!isset($shuju[0])){
			$a[0]=$shuju;
			$shuju=$a;
		}
		return $shuju;
	}
	
	function ddgoods_insert($shuju,$table_struct,$result){
		$duoduo=$this->duoduo;
		
		if($shuju['status']==2){
			$duoduo->delete('ddgoods','iid="'.$shuju['iid'].'"');
			return '';
		}
		
		foreach($shuju as $k=>$v){
			if(isset($table_struct[$k])){
				$data[$k]=$v;
			}
		}
		$data['sort']=DEFAULT_SORT;
		unset($data['id']);
		$id=(float)$duoduo->select('ddgoods','id','iid="'.$data['iid'].'"');
		if($id==0){
			$data['starttime']=TIME-3600;
			$duoduo->insert('ddgoods',$data);
			$result['insert']++;
		}
		else{
			$result['ignore']++;
		}
		if(mysql_error()!=''){
			$re=array('s'=>0,'r'=>mysql_error());
			echo dd_json_encode($re);exit;
		}
		unset($duoduo);
		return $result;
	}
	
	function zhidemai(){
		$result=array('insert'=>0,'ignore'=>0,'update'=>0);
		$duoduo=$this->duoduo;
		$table_struct=$duoduo->get_table_struct('ddzhidemai');
		$this->check();
		$shuju=$this->dd_unxuliehua($_POST['data']);
		foreach($shuju as $row){
			$result=$this->zhidemai_insert($row,$table_struct,$result);
		}
		$re=array('s'=>1,'r'=>$result);
		unset($duoduo);
		echo dd_json_encode($re);
	}
	
	function zhidemai_insert($shuju,$table_struct,$result){

		$duoduo=$this->duoduo;
		$comment=$shuju['comment'];
		unset($shuju['comment']);
		$shuju['sort']=DEFAULT_SORT;
		$shuju['data_id']=$shuju['id'];
		unset($shuju['id']);
		unset($shuju['uid']);
		
		$my=$shuju['site_shenhe'];
		unset($shuju['site_shenhe']);
		
		if($my==1){ //自己的数据，保留uid
			$shuju['uid']=$shuju['user_uid'];
			if($shuju['status']==2){
				$duoduo->delete('ddzhidemai','data_id="'.$shuju['data_id'].'"');
				return '';
			}
		}
		unset($shuju['user_uid']);
		unset($shuju['id']);
		unset($shuju['pinglun']);
		foreach($shuju as $k=>$v){
			if(isset($table_struct[$k])){
				$data[$k]=$v;
			}
		}

		$id=(float)$duoduo->select('ddzhidemai','id','data_id="'.$data['data_id'].'"');

		if($id==0){
			if($data['web']==1){
				if($data['img']!=''){$data['img']=img_caiji($data['img'],'zhidemai');}
				$domain=get_domain($data['url']);
				$mid=(int)$duoduo->select(get_mall_table_name(),'id','domain="'.$domain.'"');
			}
			else{
				$mid=1;
			}
			if($my==1){$mid=1;}
			if($data['title']!='' && $mid>0){
				//$data['starttime']=TIME-3600;
				if($data['ding']==0){
					$data['ding']=rand(100,900);
				}
				if($data['cai']==0){
					$data['cai']=rand(0,10);
				}
				$id=(int)$duoduo->insert('ddzhidemai',$data);
				$result['insert']++;
			}
			else{
				$result['ignore']++;
				$id=0;
			}
			if($id>0 && $my==1){
				$webset=$this->duoduo->webset;
				if($webset['zhidemai']['jiangli_value']>0 && $duoduo->select('user','id','id="'.$data['uid'].'"')>0){
					$update_user_data=array();
					if($webset['zhidemai']['jiangli_huobi']==1){
						$update_user_data[]=array('f'=>'money','v'=>$webset['zhidemai']['jiangli_value'],'e'=>'+');
					}
					if($webset['zhidemai']['jiangli_huobi']==2){
						$update_user_data[]=array('f'=>'jifenbao','v'=>$webset['zhidemai']['jiangli_value'],'e'=>'+');
					}
					if($webset['zhidemai']['jiangli_huobi']==3){
						$update_user_data[]=array('f'=>'jifen','v'=>$webset['zhidemai']['jiangli_value'],'e'=>'+');
					}
					$duoduo->update_user_mingxi($update_user_data,$data['uid'],24,$data['title'],0,0,'',$id);
				}
			}
		}
		elseif($my==1){
			$duoduo->update('ddzhidemai',$data,'id="'.$id.'"');
			$result['update']++;
		}
		else{
			$result['ignore']++;
		}
		
		if(mysql_error()!=''){
			$re=array('s'=>0,'r'=>mysql_error());
			echo dd_json_encode($re);exit;
		}
		$pinglun=0;
		if(!empty($comment)){
			foreach($comment as $row){
				unset($row['id']);
				$id=(float)$duoduo->select('ddzhidemai_comment','id','data_id="'.$row['data_id'].'" and username="'.$row['username'].'"');
				if($id==0){
					$row['addtime']=strtotime(preg_replace('/\d{2}:\d{2}$/','',date('Y-m-d H:i:s')).sprintf('%02d',rand(01,59)).':'.rand(01,59));
					$duoduo->insert('ddzhidemai_comment',$row);
					$pinglun++;
				}
			}
		}
		if($pinglun>0){
			$update_data=array('f'=>'pinglun','v'=>$pinglun,'e'=>'+');
			$this->duoduo->update('ddzhidemai',$update_data,'data_id="'.$data['data_id'].'"');
		}
		unset($duoduo);
		return $result;
	}
	
	function lanmu(){
		$duoduo=$this->duoduo;
		$this->check();
		$data=dd_unxuliehua($_POST['data']);
		foreach($data as $row){
			$re[$row['code']]=$row['title'];
		}
		$duoduo->set_webset('ddgoodslanmu',$re);
		$duoduo->webset();
		$re=array('s'=>1,'r'=>'成功');
		echo dd_json_encode($re);
	}
	
	function dd_generateSign(){
		if(isset($_POST['pass'])){
			$pass=trim($_POST['pass']);
			$params=$_POST;
		}
		else{
			$pass=trim($_GET['pass']);
			unset($_GET['p']);
			$params=$_GET;
		}
		$key=DDYUNKEY;
		unset($params['pass']);
		ksort($params);
		foreach ($params as $k => $v){
			$stringToBeSigned .=$k.urldecode($v);
		}
		$sign_pass=strtolower(md5($key.$stringToBeSigned.$key));
		if($sign_pass!=$pass){
			$re=array('s'=>0,'r'=>'通信密钥错误');
			echo dd_json_encode($re);
			exit;
		}
	}
}

$p=$_GET['p'];
if(empty($p)){
	$re=array('s'=>0,'r'=>'参数不对');
	echo dd_json_encode($re);
}
else{
	$ddget = new ddget($duoduo,$p);
	if($p=="taobao"){
		$ddget->ddget_taobao();
	}
	elseif($p=="mall"){
		$ddget->ddget_mall();
	}
	elseif($p=="plugin"){
		$ddget->ddget_plugin();
	}
	elseif($p=="check"){
		echo $ddget->check();
	}
	elseif($p=="ddgoods"){
		$ddget->ddgoods();
	}
	elseif($p=="ddzhidemai" || $p=="zhidemai"){
		$ddget->zhidemai();
	}
	elseif($p=="lanmu"){
		$ddget->lanmu();
	}
}
?>