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

$pagesize=50;  //每次处理多少条订单
$page=(int)$_GET['page'];
$fromnum=$pagesize*$page;
$do = (int) $_GET['do']; //表示联盟

$sday=$_POST['sday']?$_POST['sday']:$_GET['sday'];
$eday=$_POST['eday']?$_POST['eday']:$_GET['eday'];
$cday=$_GET['cday']?trim($_GET['cday']):$sday;

if ($_POST['sub'] != '' || $_GET['sub'] != '') {
	$insert_num=0; //记录插入订单
	$update_num=0; //记录更新订单
	
	include(DDROOT.'/comm/mall.class.php');
	$mall_class=new mall($duoduo);
	
	if($do==8){
		$url=DD_U_URL.'/index.php?m=DdApi&a=mall_order_list&url='.DOMAIN.'&key='.DDYUNKEY.'&stime='.$sday.'&etime='.$eday;
		$a=dd_json_decode(dd_get($url),1);
		if($a['s']==0) {dd_exit($a['r']);}
		foreach($a['r']['result'] as $row){
			unset($arr);
			$arr['order_time']=$row['order_time'];
			$arr['mall_name']=$row['mall_name'];
			$arr['uid']=$row['mid'];
			list($arr['uid'],$code,$fuid,$shuju_id)=do_back_code($arr['uid']);
			$arr['order_code']=$row['order_code'];
			$arr['commission']=$row['commission'];
			$arr['item_count']=$row['item_count'];
			$arr['item_price']=$row['item_price'];
			$arr['sales']=$row['sales'];
			$arr['addtime']=$row['addtime'];
			$arr['status']=$row['status'];
			$arr['qrsj']=$row['qrsj'];
			$arr['unique_id']=$row['unique_id'];
			$arr['domain']=$row['domain'];
			$arr['platform']=$row['platform'];
			
			$arr['mall_id']=0;
			if($arr['domain']!=''){
				$mall=$mall_class->view($arr['domain']);
				if(!empty($mall)){
					$mall_name=$mall['title'];
					$arr['mall_id']=$mall['id'];
				}
			}

			if($arr['uid']>0){
				$dduser=$duoduo->select('user','*','id="'.$arr['uid'].'"');
			}
			else{
				$dduser=array('level'=>0,'tjr'=>0);
			}
			$arr['fxje']=fenduan($arr['commission'],$webset['mallfxbl'],$dduser['type']);
			$arr['jifen']=round($arr['fxje']*$webset['jifenbl']);
			if($mall['type']==2){ //返积分
				$arr['fxje']=0;
			}
			if($dduser['tjr']>0){
				$arr['tgyj']=round($arr['fxje']*$webset['tgbl']);
			}
			else{
				$arr['tgyj']=0;
			}
			$mall_order = $duoduo->select("mall_order", "*", 'unique_id="' . $arr['unique_id'] . '"');
			if ($mall_order['id'] == '') { //交易不存在
				$arr['adid']=(int)$arr['adid'];
				$insert_id=$duoduo->insert("mall_order", $arr);
				$tuiguang_insert_data=array('fuid'=>$fuid,'uid'=>$arr['uid'],'order_id'=>$insert_id,'mall'=>1,'code'=>$code,'shuju_id'=>$shuju_id);
				$duoduo->ddtuiguang_insert($tuiguang_insert_data);
				$arr['id']=$insert_id;
				$insert_num++;
			}
			else{
				$duoduo->update('mall_order', $arr, "id='".$mall_order['id']."'");
				$arr['id']=$mall_order['id'];
				$update_num++;
			}
			
			if($mall_order['status']!=1 && $arr['status']==1){//给会员结算
				if($dduser['id']>0 && ($arr['fxje']>0 || $arr['jifen']>0)){
					$duoduo->rebate($dduser,$arr,3);
				}
			}
			elseif($arr['status']!=1 && $mall_order['status']==1 && $dduser['id']>0){ //商城订单退款
				$refund_arr['uid']=$dduser['id'];
				$refund_arr['money']=$arr['fxje'];
				$refund_arr['jifen']=$arr['jifen'];
				$refund_arr['source']=$arr['mall_name'].'返利，订单号'.$arr['order_code'];
				$duoduo->dd_refund($refund_arr,23);
			}
		}
		jump(-1,'本次获取订单'.$a['r']['allcount'].'条，插入订单'.$insert_num.'条，更新订单'.$update_num);
	}
	elseif ($do == 4) { //多麦
		$sd = date('Y-m-d', strtotime(trim($cday)));
		$ed = date('Y-m-d', strtotime(trim($cday)) + 24 * 60 * 60); //多麦当天的不算的必须加一天

		$url = 'http://www.duomai.com/api/order.php?format=xml&action=query&hash=' . $webset['duomai']['key'] . '&site_id=' . $webset['duomai']['wzid'] . '&time_from=' . $sd . '&time_to=' . $ed . '&limit=0,10000,order=time,desc';
		$arr = dd_get_xml($url);
		unset ($arr['@attributes']);
		$c=count($arr)?count($arr):0;
		if($c==0){$arr=array();}
		
		if($fromnum+$pagesize>$c-1){
		    $maxnum=$c;
		}
		else{
		    $maxnum=$fromnum+$pagesize;
		}
		if($c==0){$arr=array();$maxnum=0;}

	    for($i=$fromnum;$i<$maxnum;$i++){
		    $row=$arr['fix_'.$i];
			$ads_id = $row['ads_id']; //活动ID
			$mall=$mall_class->view('duomaiid="'.$ads_id.'"');
			$ads_name = $mall['title']; //活动名
			$site_id = $row['site_id']; //网站ID
			$link_id = $row['link_id']; //活动链接ID
			$uid = $row['euid']; //	网站主设定的反馈标签
			list($uid,$code,$fuid,$shuju_id)=do_back_code($uid);
			$order_code = $row['order_sn']; //	订单编号
			$order_time = strtotime($row['order_time']); //	下单时间
			$sales = $row['orders_price']; //订单金额
			$commission = $row['siter_commission']; //	订单佣金
			$status = $row['status']; //订单状态  -1 无效 0 未确认 1 确认 2 结算
			$unique_id=$order_code;  //唯一编号，多麦订单号可确定唯一
			if ($status == 1){
			    $status = 0;
			}	
			elseif ($status == 2){
				$status = 1;
			}
			if ($status == 1) {
				$sales = $row['confirm_price']; //确认金额
				$commission = $row['confirm_siter_commission']; //	确认佣金
				$qrsj = strtotime($row['confirm_time']);
			}
			
			$mall_order = $duoduo->select("mall_order", "*", 'unique_id="' . $unique_id . '" and lm=4'); //会员找回订单后，就有会员id了
			if($mall_order['uid']>0){
				$uid=$mall_order['uid'];
			}
			
			if($uid>0){
				$dduser=$duoduo->select('user','id,level,tjr,ddusername,type','id="'.$uid.'"');
			}
			else{
		        $dduser=array('level'=>0,'tjr'=>0);
			}
			
            $fxje=fenduan($commission,$webset['mallfxbl'],$dduser['type']);
            $jifen=round($fxje*$webset['jifenbl']);
			if($mall['type']==2){ //返积分
				$fxje=0;
			}
			if($user['tjr']>0){
				$tgyj=round($fxje*$webset['tgbl']);
			}
			else{
				$tgyj=0;
			}
			
			if ($mall_order['id'] == '') { //交易不存在
				$field_arr = array (
					'adid' => $ads_id,
					'lm' => 4,
					'order_time' => $order_time,
					'mall_name' => $ads_name,
					'mall_id'=>(int)$mall['id'],
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
				    'addtime' => TIME,
					'unique_id' => $unique_id,
				);
				if ($status == 1) {
					$field_arr['qrsj'] = $qrsj;
				}
				$insert=$duoduo->insert("mall_order", $field_arr);
				
				$tuiguang_insert_data=array('fuid'=>$fuid,'uid'=>$uid,'order_id'=>$insert,'mall'=>1,'code'=>$code,'shuju_id'=>$shuju_id);
				$duoduo->ddtuiguang_insert($tuiguang_insert_data);
				
				$mall_order=$field_arr;
				$mall_order['id']=$insert;
                $insert_num++;
				if ($status == 1 && $insert>0) {
					if($dduser['id']>0 && (abs($fxje)>0 || abs($jifen)>0)){
						$duoduo->rebate($dduser, $mall_order, 3);
					}
				}
			}
			elseif ($mall_order['id'] > 0 and ($mall_order['status']==0 || $mall_order['status']==-1) and $status == 1) {
			    $mall_order['commission']=$commission;
				$mall_order['fxje']=$fxje;
				$mall_order['jifen']=$jifen;
				$update_num++;
	            if($dduser['id']>0 && (abs($fxje)>0 || abs($jifen)>0)){
	                $duoduo->rebate($dduser,$mall_order,3);
	            }
				else{
					$field_arr_order = array (
		           		'status' => 1,
		            	'qrsj' => $qrsj,
						'commission' => $commission,
						'fxje' => $fxje,
						'jifen' => $jifen,
	            	);
					$duoduo->update('mall_order', $field_arr_order, "id='".$mall_order['id']."'");
				}
			}
			elseif ($mall_order['id'] > 0 and $mall_order['status'] == 0 and $status == -1) {
			    $field_arr_order = array (
		            'status' => -1,
		            'qrsj' => $qrsj,
					'commission' => $commission,
					'fxje' => $fxje,
					'jifen' => $jifen,
	            );
	            $duoduo->update('mall_order', $field_arr_order, "id='".$mall_order['id']."'");
				$update_num++;
			}
		}
	}
	
	
	
	
	if ($do == 6) { //59秒
		$date = date('Ymd', strtotime(trim($cday)));
		
		include(DDROOT.'/comm/59miao.config.php');
		
		unset($param);
		$param['date']=$date;
		$param['total']=1;
		$param['no_cache']=1;
		$arr=$dd59miao->orders_report_get($param);
		$total=$arr['total'];
		unset($arr['total']);
		
		if($arr[0]==''){unset($arr[0]);}
		$c=count($arr);
		$maxnum=$c;

		foreach($arr as $row){
			$commission=$row['commission'];
			$order_time=strtotime($row['created']);
			$sales=$row['order_amount'];
			$mall_order['item_price']=$row['order_amount'];
			$mall_order['item_count']=1;
			$order_code=$row['order_id'];
			$product_code=$row['order_code'];
			$unique_id=$row['order_id']; //订单号确认唯一
			$uid=$row['outer_code'];
			list($uid,$code,$fuid,$shuju_id)=do_back_code($uid);
			$adid=$row['seller_id'];
			$status=$row['status'];

			$mall=$mall_class->view('wujiumiaoid="'.$adid.'"');
			$mall_name=$mall['title'];
			
			if($status=='未确认'){
				$status=0;
			}
			elseif($status=='有效'){
				$status=1;
			}
			elseif($status=='无效'){
				$status=-1;
			}
			
			$mall_order = $duoduo->select("mall_order", "*", 'unique_id="' . $unique_id . '" and lm=6'); //会员找回订单后，就有会员id了
			if($mall_order['uid']>0){
				$uid=$mall_order['uid'];
			}
			
			if($uid>0){
				$dduser=$duoduo->select('user','id,level,tjr,ddusername,type','id="'.$uid.'"');
			}
			else{
		        $dduser=array('level'=>0,'tjr'=>0);
			}
			
            $fxje=fenduan($commission,$webset['mallfxbl'],$dduser['type']);
            $jifen=round($fxje*$webset['jifenbl']);
			if($mall['type']==2){ //返积分
				$fxje=0;
			}
			if($user['tjr']>0){
				$tgyj=round($fxje*$webset['tgbl']);
			}
			else{
				$tgyj=0;
			}
			
			if ($mall_order['id'] == '') { //交易不存在
				$field_arr = array (
					'adid' => $adid,
					'lm' => 6,
					'order_time' => $order_time,
					'mall_name' => $mall_name,
					'mall_id'=>(int)$mall['id'],
					'uid' => $uid,
					'order_code' => $order_code,
					'product_code' => $product_code,
					'item_count' => 1,
					'item_price' => $sales,
					'sales' => $sales,
					'commission' => $commission,
					'status' => $status,
					'fxje' => $fxje,
					'jifen' => $jifen,
					'tgyj' => $tgyj,
				    'addtime' => TIME,
					'unique_id' => $unique_id,
				);
				if ($status == 1) {
					$field_arr['qrsj'] = TIME;
				}
				$insert=$duoduo->insert("mall_order", $field_arr);
				
				$tuiguang_insert_data=array('fuid'=>$fuid,'uid'=>$uid,'order_id'=>$insert,'mall'=>1,'code'=>$code,'shuju_id'=>$shuju_id);
				$duoduo->ddtuiguang_insert($tuiguang_insert_data);
				
				$mall_order=$field_arr;
				$mall_order['id']=$insert;
                $insert_num++;
				if ($status == 1 && $insert>0) {
					if($dduser['id']>0 && (abs($fxje)>0 || abs($jifen)>0)){
						$duoduo->rebate($dduser, $mall_order, 3);
					}
				}
			}
			elseif ($mall_order['id'] > 0 and ($mall_order['status']==0 || $mall_order['status']==-1) and $status == 1) {
			    $mall_order['commission']=$commission;
				$mall_order['fxje']=$fxje;
				$mall_order['jifen']=$jifen;
				$update_num++;
	            if($dduser['id']>0 && (abs($fxje)>0 || abs($jifen)>0)){
	                $duoduo->rebate($dduser,$mall_order,3);
	            }
				else{
					$field_arr_order = array (
		           		'status' => 1,
		            	'qrsj' => $qrsj,
						'commission' => $commission,
						'fxje' => $fxje,
						'jifen' => $jifen,
	            	);
					$duoduo->update('mall_order', $field_arr_order, "id='".$mall_order['id']."'");
				}
			}
			elseif ($mall_order['id'] > 0 and $mall_order['status'] == 0 and $status == -1) {
			    $field_arr_order = array (
		            'status' => -1,
		            'qrsj' => $qrsj,
					'commission' => $commission,
					'fxje' => $fxje,
					'jifen' => $jifen,
	            );
	            $duoduo->update('mall_order', $field_arr_order, "id='".$mall_order['id']."'");
				$update_num++;
			}
		}
	}
	
	if ($do == 2) { //领克特
	    $mm = md5("linktech^" . $webset['linktech']['pwd']);
		$sday = $sday;
		$eday = $eday;

		$url = "http://www.linktech.cn/AC/trans_list.htm?account_id=" . $webset['linktech']['name'] . "&sign=" . $mm . "&syyyymmdd=" . $sday . "&eyyyymmdd=" . $eday . "&affiliate_id=" . $webset['linktech']['wzbh'] . "&output_type=xml&type=cps";
		//$url='http://www.linktech.cn/AC/trans_list.htm?account_id=51lehui&sign=390a9f7909406e3a39f730b0d520b6c9&syyyymmdd='.$cday.'&eyyyymmdd='.$cday.'&affiliate_id=A100105523&output_type=xml&type=cps';
		$row = dd_get_xml($url);
		$arr1=$row['order_list']['order'];
		if(!isset($arr1[0])){
			$arr[0]=$arr1;
		}
		else{
			$arr=$arr1;
		}
		unset($arr1);
		$c=$row['order_list']['@attributes']['count']?$row['order_list']['@attributes']['count']:0;
		if($fromnum+$pagesize>$c-1){
		    $maxnum=$c;
		}
		else{
		    $maxnum=$fromnum+$pagesize;
		}
		if($c==0){$arr=array();$maxnum=0;}
		for($i=$fromnum;$i<$maxnum;$i++){
		    $row=$arr[$i];
			$merchant_id = $row['merchant_id']; //活动ID
			$mall=$mall_class->view('merchant="'.$merchant_id.'"');
			$mall_name = $mall['title']; //活动名
			$uid = $row['u_id']; //	网站主设定的反馈标签
			list($uid,$code,$fuid,$shuju_id)=do_back_code($uid);
			$order_code = $row['order_code']; //	订单编号
			$product_code = $row['product_code']; //	商品编号
			$order_time = strtotime($row['order_time']); //	下单时间
			$item_count = $row['item_count']; //商品数量
			$item_price = $row['item_price']; //商品单价
			if(strpos($item_price,',')!==false){
			    $item_price=str_replace(',','',$item_price);
			}
			$sales = $row['sales']; //商品总价
			if(strpos($sales,',')!==false){
			    $sales=str_replace(',','',$sales);
			}
			$commission = $row['commission']; //	订单佣金
			if(strpos($commission,',')!==false){
			    $commission=str_replace(',','',$commission);
			}
			$status = $row['stat_desc']; //订单状态  -1 无效 0 未确认 1 确认 2 结算
			$unique_id=$order_code.'*'.$product_code;  //唯一编号，领克特订单号+商品编号可确定唯一
			if ($status =='未核对' ){
			    $status = 0;
			}	
			elseif ($status == '核对有效'){
				$status = 1;
			}
			else{
			    $status = -1;
			}
			if ($status == 1) {
				$qrsj = TIME;
			}
			
			$mall_order = $duoduo->select("mall_order", "*", 'unique_id="' . $unique_id . '"  and lm=2'); //会员找回订单后，就有会员id了
			if($mall_order['uid']>0){
				$uid=$mall_order['uid'];
			}
			
			if($uid>0){
				$dduser=$duoduo->select('user','id,level,tjr,ddusername,type','id="'.$uid.'"');
			}
			else{
		        $dduser=array('level'=>0,'tjr'=>0);
			}
			
            $fxje=fenduan($commission,$webset['mallfxbl'],$dduser['type']);
            $jifen=round($fxje*$webset['jifenbl']);
			if($mall['type']==2){ //返积分
				$fxje=0;
			}
			if($user['tjr']>0){
				$tgyj=round($fxje*$webset['tgbl']);
			}
			else{
				$tgyj=0;
			}

			if ($mall_order['id'] == '') { //交易不存在
				$field_arr = array (
					'adid' => $merchant_id,
					'lm' => 2,
					'order_time' => $order_time,
					'mall_name' => $mall_name,
					'mall_id'=>(int)$mall['id'],
					'uid' => $uid,
					'order_code' => $order_code,
					'product_code' => $product_code,
					'item_count' => $item_count,
					'item_price' => $item_price,
					'sales' => $sales,
					'commission' => $commission,
					'status' => $status,
					'fxje' => $fxje,
					'jifen' => $jifen,
					'tgyj' => $tgyj,
				    'addtime' => TIME,
					'unique_id' => $unique_id,
				);
				if ($status == 1) {
					$field_arr['qrsj'] = $qrsj;
				}
				$insert=$duoduo->insert("mall_order", $field_arr);
				
				$tuiguang_insert_data=array('fuid'=>$fuid,'uid'=>$uid,'order_id'=>$insert,'mall'=>1,'code'=>$code,'shuju_id'=>$shuju_id);
				$duoduo->ddtuiguang_insert($tuiguang_insert_data);
				
				$mall_order=$field_arr;
				$mall_order['id']=$insert;
                $insert_num++;
				if ($status == 1 && $insert>0) {
					if($dduser['id']>0 && (abs($fxje)>0 || abs($jifen)>0)){
						$duoduo->rebate($dduser, $mall_order, 3);
					}
				}
			}
			elseif ($mall_order['id'] > 0 and $mall_order['status'] == 0 and $status == 1) {
			    $mall_order['commission']=$commission;
				$mall_order['fxje']=$fxje;
				$mall_order['jifen']=$jifen;
				$update_num++;
	            if($dduser['id']>0 && (abs($fxje)>0 || abs($jifen)>0)){
	                $duoduo->rebate($dduser,$mall_order,3);
	            }
			}
			elseif ($mall_order['id'] > 0 and $mall_order['status'] == 0 and $status == -1) {
			    $field_arr_order = array (
		            'status' => -1,
		            'qrsj' => $qrsj, 
	            );
	            $duoduo->update('mall_order', $field_arr_order, "id='".$mall_order['id']."'");
				$update_num++;
			}
		}
	}
	
	if ($do == 3) { //亿起发
		$sday = date('Y-m-d', strtotime(trim($sday)));
		$eday = date('Y-m-d', strtotime(trim($eday)));

		$url = 'http://o.yiqifa.com/servlet/queryCpsMultiRow?sid=' . $webset['yiqifa']['uid'] . '&username=' . $webset['yiqifa']['name'] . '&privatekey=' . $webset['yiqifa']['key'] . '&ed=' . $eday . '&st=' . $sday . '&action_id=&order_no=&wid=' . $webset['yiqifa']['wzid'] . '&status=';
		$content = dd_get($url);
		if(strpos($content,'||')===false){
	        $content='';
			$c=0;
	    }
		
		if($content!=''){
		    $arr_data = preg_split('/[\n\r]+/i', $content);
			$c=count($arr_data);
		    if($arr_data[$c-1]==''){unset($arr_data[$c-1]);$c=$c-1;}
		}
		
		if($fromnum+$pagesize>$c-1){
		    $maxnum=$c;
		}
		else{
		    $maxnum=$fromnum+$pagesize;
		}
		if($c==0){$arr_data=array();$maxnum=0;}
			
	    for($i=$fromnum;$i<$maxnum;$i++){
		    $row=$arr_data[$i];
			if ($row != '' && !is_array($row)) {
				$arr = explode('||', $row);
				$unique_id = $arr[0];
				$adid = $arr[1];
				$mall=$mall_class->view('yiqifaid="'.$adid.'"');
				$mall_name=$mall['title'];
				$order_time = $arr[4]?strtotime($arr[4]):TIME;
				$order_code = $arr[5];
				$product_code = trim(iconv('gbk', 'utf-8//IGNORE', $arr[7]));
				if($product_code=='汇总'){
				    $item_count=1;
				}
				else{
				    $item_count = $arr[8];
				}
				$item_price = $arr[9];
				$sales = $item_price * $item_count;
				$commission = $arr[12];
				$uid = $arr[10];
				list($uid,$code,$fuid,$shuju_id)=do_back_code($uid);
				
				if(strpos($uid,'_')!==false){
                   $abc=explode('_',$uid);
	               $uid=$abc[0];
                }
                else{
	                $uid=rep($uid);
                }
                if($uid=='null'){
	                $uid=0;
                }

                $uid=(int)$uid;
				
				$status = $arr[11]; //订单状态
				switch($status){
                    case 'R': $status=0;
	                break;
	                case 'A': $status=1;
	                break;
	                case 'F': $status=-1;
	                break;
                }
			}
			if ($status == 1) {
				$qrsj = TIME;
			}
			
			$mall_order = $duoduo->select("mall_order", "*", 'unique_id="' . $unique_id . '" and lm=3'); //会员找回订单后，就有会员id了
			if($mall_order['uid']>0){
				$uid=$mall_order['uid'];
			}
			
			if($uid>0){
				$dduser=$duoduo->select('user','id,level,tjr,ddusername,type','id="'.$uid.'"');
			}
			else{
		        $dduser=array('level'=>0,'tjr'=>0);
			}
			
            $fxje=fenduan($commission,$webset['mallfxbl'],$dduser['type']);
            $jifen=round($fxje*$webset['jifenbl']);
			if($mall['type']==2){ //返积分
				$fxje=0;
			}
			if($user['tjr']>0){
				$tgyj=round($fxje*$webset['tgbl']);
			}
			else{
				$tgyj=0;
			}

			if ($mall_order['id'] == '') { //交易不存在
				$field_arr = array (
					'adid' => $adid,
					'lm' => 3,
					'order_time' => $order_time,
					'mall_name' => $mall_name,
					'mall_id'=>(int)$mall['id'],
					'uid' => $uid,
					'order_code' => $order_code,
					'product_code' => $product_code,
					'unique_id' => $unique_id,
					'item_count' => $item_count,
					'item_price' => $item_price,
					'sales' => $sales,
					'commission' => $commission,
					'status' => $status,
					'fxje' => $fxje,
					'jifen' => $jifen,
					'tgyj' => $tgyj,
				    'addtime' => TIME,
					'unique_id'=>$unique_id
				);
				if ($status == 1) {
					$field_arr['qrsj'] = $qrsj;
				}
				$insert=$duoduo->insert("mall_order", $field_arr);
				
				$tuiguang_insert_data=array('fuid'=>$fuid,'uid'=>$uid,'order_id'=>$insert,'mall'=>1,'code'=>$code,'shuju_id'=>$shuju_id);
				$duoduo->ddtuiguang_insert($tuiguang_insert_data);
				
				$mall_order=$field_arr;
				$mall_order['id']=$insert;
                $insert_num++;
				if ($status == 1 && $insert>0) {
					if($dduser['id']>0 && (abs($fxje)>0 || abs($jifen)>0)){
						$duoduo->rebate($dduser, $mall_order, 3);
					}
				}
			}
			elseif ($mall_order['id'] > 0 and $mall_order['status'] == 0 and $status == 1) {
			    $mall_order['commission']=$commission;
				$mall_order['fxje']=$fxje;
				$mall_order['jifen']=$jifen;
				$update_num++;
	            if($dduser['id']>0 && (abs($fxje)>0 || abs($jifen)>0)){
	                $duoduo->rebate($dduser,$mall_order,3);
	            }
			}
			elseif ($mall_order['id'] > 0 and $mall_order['status'] == 0 and $status == -1) {
			    $field_arr_order = array (
		            'status' => -1,
		            'qrsj' => $qrsj, 
	            );
	            $duoduo->update('mall_order', $field_arr_order, "id='".$mall_order['id']."'");
				$update_num++;
			}
		}
	}
	
	if ($do == 1) { //成果
		$sday = date('Y-m-d', strtotime(trim($sday)));
		$eday = date('Y-m-d', strtotime(trim($eday)));
		$sday = preg_replace('/^\d{2}/','',$sday);
		$eday = preg_replace('/^\d{2}/','',$eday);
		$collect=new collect();
		
		if (get_cookie('chanet_j_id') == '') {
		    $url = 'http://www.chanet.com.cn/rest/as/get_as_ec_list.cgi?user_name=' . $webset['chanet']['name'] . '&password=' . $webset['chanet']['pwd'] . '&token=' . $webset['chanet']['key'] . '&as_id=' . $webset['chanet']['wzid'] . '&start_time=' . $sday . '&end_time=' . $eday . '&confirm_status=all&userinfo=yes';
			$collect->get($url);
			$c = $collect->val;
			if(strpos($c,'Too frequently request')){
			    PutInfo('获取频繁，请20分钟后再获取订单！',-1);
			}
		    $content = str_replace(':', '', $c);
		    $content = str_replace('xmlns', 'id', $content);
		    $xmlCode = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);
		    $arrdata = $collect->get_object_vars_final($xmlCode);
			$chanet_j_id=$arrdata['soapBody']['get_action_listResponse']['job_id'];
			set_cookie("chanet_j_id",$chanet_j_id,1200);
	    }
		else{
		    $chanet_j_id=get_cookie('chanet_j_id');
		}
        
		$url = 'http://www.chanet.com.cn/soap/as/get_report.cgi?u=' . $webset['chanet']['name'] . '&p=' . $webset['chanet']['pwd'] . '&t=' . $webset['chanet']['key'] . '&j=' . $chanet_j_id;
		$collect->get($url);
		$content = $collect->val;
	    preg_match('/xsd:urtype\[(\d+)\]/', $content, $b);
	    $c = $b[1]?$b[1]:0;
		if($c>0){
		    $content = str_replace(':', '', $content);
		    $content = str_replace('xmlns', 'id', $content);
		    $xmlCode = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);
		    $arrdata = $collect->get_object_vars_final($xmlCode);

		    $data = $arrdata['soapBody']['get_action_listResponse']['action_list']['action'];

		    if ($c == 1) {
			    $a = $data;
			    unset ($data);
			    $data[0] = $a;
		    }
			
			if($fromnum+$pagesize>$c-1){
		        $maxnum=$c;
		    }
		    else{
		        $maxnum=$fromnum+$pagesize;
		    }
		    if($c==0){$data=array();$maxnum=0;}

			for($i=$fromnum;$i<$maxnum;$i++){
		        $row=$data[$i];
			    $adid = $row['promotion_id']; //活动ID
				$mall=$mall_class->view('chanetid="'.$adid.'"'); //活动名
			    $mall_name = $mall['title'];
				
				$uid = $row['user_info']; //	网站主设定的反馈标签
				list($uid,$code,$fuid,$shuju_id)=do_back_code($uid);
			    
			    $order_code = $row['action_info']; //	订单编号
				$unique_id=$order_code; //成果订单号确认唯一
			    $order_time = strtotime($row['record_time']); //	下单时间
				$commission = round($row['price'], 2);
				
			    $sales = 0; //订单金额
				$item_count=0;
				$item_price=0;
				
				if ($row['confirm_status'] == 'unconfirmed') {
				    $status = 0;
			    }
			    elseif ($row['confirm_status'] == 'confirmed') {
				    $status = 1;
					$qrsj=TIME;
			    }
			    elseif ($row['confirm_status'] == 'refused') {
				    $status = -1;
			    }
				
				$goods = $row['action_ec_list']['ec'];
				//var_export($goods);exit;
			    if (!array_key_exists('0', $goods)) {
				    $item_count = $goods['amount'];
				    $item_price = $goods['order_price'];
					$sales = $item_count*$item_price;
			    } else {
				    foreach ($goods as $arr) {
					    $item_count += $arr['amount'];
					    $item_price += $arr['order_price'];
						$sales += $arr['amount']*$arr['order_price'];
				    }
			    }
				
			    $item_price = round($item_price, 2);
			    $sales = round($sales, 2);
				
				$mall_order = $duoduo->select("mall_order", "*", 'unique_id="' . $unique_id . '" and lm=1'); //用订单编号和商品编号查 //会员找回订单后，就有会员id了
				if($mall_order['uid']>0){
					$uid=$mall_order['uid'];
				}
				
				if($uid>0){
				    $dduser=$duoduo->select('user','id,type,tjr,ddusername','id="'.$uid.'"');
				}
				else{
				    $dduser=array('level'=>0,'tjr'=>0);
				}
				
				$unique_id=$order_code;  //唯一编号，成果订单号可确定唯一
				
                $fxje=fenduan($commission,$webset['mallfxbl'],$dduser['type']);
                $jifen=round($fxje*$webset['jifenbl']);
				if($mall['type']==2){ //返积分
					$fxje=0;
				}
				if($user['tjr']>0){
					$tgyj=round($fxje*$webset['tgbl']);
				}
				else{
					$tgyj=0;
				}

			    if ($mall_order['id'] == '') { //交易不存在
				    $field_arr = array (
					    'adid' => $adid,
					    'lm' => 1,
					    'order_time' => $order_time,
					    'mall_name' => $mall_name,
						'mall_id'=>(int)$mall['id'],
					    'uid' => $uid,
					    'order_code' => $order_code,
					    'item_count' => $item_count,
					    'item_price' => $item_price,
					    'sales' => $sales,
					    'commission' => $commission,
					    'status' => $status,
					    'fxje' => $fxje,
					    'jifen' => $jifen,
						'tgyj' => $tgyj,
				        'addtime' => TIME,
						'unique_id'=>$unique_id
				    );
				    if ($status == 1) {
					    $field_arr['qrsj'] = $qrsj;
				    }
				    $insert=$duoduo->insert("mall_order", $field_arr);
					
					$tuiguang_insert_data=array('fuid'=>$fuid,'uid'=>$uid,'order_id'=>$insert,'mall'=>1,'code'=>$code,'shuju_id'=>$shuju_id);
					$duoduo->ddtuiguang_insert($tuiguang_insert_data);
					
					$mall_order=$field_arr;
					$mall_order['id']=$insert;
                    $insert_num++;
				    if ($status == 1 && $insert>0) {
					    if($dduser['id']>0 && (abs($fxje)>0 || abs($jifen)>0)){
						    $duoduo->rebate($dduser, $mall_order, 3);
					    }
				    }
			    }
			    elseif ($mall_order['id'] > 0 and $mall_order['status'] == 0 and $status == 1) {
			        $mall_order['commission']=$commission;
					$mall_order['fxje']=$fxje;
					$mall_order['jifen']=$jifen;
				    $update_num++;
	                if($dduser['id']>0 && (abs($fxje)>0 || abs($jifen)>0)){
	                    $duoduo->rebate($dduser,$mall_order,3);
	                }
			    }
			    elseif ($mall_order['id'] > 0 and $mall_order['status'] == 0 and $status == -1) {
			        $field_arr_order = array (
		                'status' => -1,
		                'qrsj' => $qrsj, 
	                );
	                $duoduo->update('mall_order', $field_arr_order, "id='".$mall_order['id']."'");
				    $update_num++;
			    }
			}
		}
	}
	if ($do == 7) { //一起惠
		PutInfo('一起惠联盟暂无主动获取订单，一起惠官方正努力开发中 ^_^');
	}
	if($do==5){
		$sday = date('Y-m-d', strtotime(trim($sday)));
		$eday = date('Y-m-d', strtotime(trim($eday))+24 * 60 * 60);
		$url="http://service.weiyi.com/dataget.aspx?memberid=".$webset['weiyi']['name']."&pwd=".$webset['weiyi']['pwd']."&datatype=cps&dataformat=xml&unit=1&starttime=".$sday."&endtime=".$eday;
		$collect = new collect();
		$collect -> get($url);
		$xml = $collect -> val;
		
		if(preg_match('/^\[error\]/',$xml)){
			preg_match('/^\[error\](.*)\[\/error\]$/',$xml,$a);
			//PutInfo($a[1].'，请1分钟后读取！',-1);
		}
		$xmlCode = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
		$arrdata = $collect -> get_object_vars_final($xmlCode);
		$datarow = $arrdata['datarow'];
		if(is_array($datarow)){
			if (!$datarow[0]) {
				$content[] = $datarow;
			} else {
				$content = $datarow;
			} 
		}
		else{
			$content=array();
		}
		
		$c = count($content);
		if ($c > 0) {
			if ($fromnum + $pagesize > $c-1) {
				$maxnum = $c;
			} else {
				$maxnum = $fromnum + $pagesize;
			} 
			if ($c == 0) {
				$arr_data = array();
				$maxnum = 0;
			} 
			
			if ($maxnum) {
				foreach($content as $key=>$vo) {
					//get_object_vars_final转化后空数据是个数组要删掉
					foreach($vo as $k=>$v){
						if(is_array($v)){
							$vo[$k]="";
						}
					}
					$weiyiid = $vo['merchantid']; //广告主
					$mall = $mall_class->view('weiyiid="' . $weiyiid . '" and lm=5');
					
					if($vo['merchantid']=="weiyi"){
						unset($vo);//有比订单是唯一联盟注册赠送20元的删了，免的影响
						break;//别执行下面的了
					}
					$websitid=$vo['websitid'];
					if($websitid!=$webset['weiyi']['wzbh']){
						unset($vo);//网站编号不一致，不是这个网站的K掉
						break;//别执行下面的了
					}
					
					$mall_name = $mall['title']; //活动名
					$uid = $vo['uid']; //	网站主设定的反馈标签
					list($uid,$code,$fuid,$shuju_id)=do_back_code($uid);
					$order_code = $vo['orderid']; //	定单号
					$product_code = $vo['pid']; //	商品号
					$order_time = strtotime($vo['cdate']); //	定单日期
					$item_count = (int)$vo['pnum']; //商品数量
					$item_price = $vo['price']; //商品单价
					$sales = $vo['sumprice']; // 总价
					$unit = $vo['unit']; //佣金类型
					$mper = $vo['mper']; //佣金比例
					$commission = $vo['commission']; //佣金
					$status = $vo['stat']; //确认状态	整型（0=未核对 1=已确认(可以支付佣金) 2=核对无效 3=核对有效）
					if ($status == 2) { // 订单状态  -1 无效 0 未确认 1 确认 2 结算
						$status = -1;
					} 
					if ($status == 3) { // 订单状态  -1 无效 0 未确认 1 确认 2 结算
						$status = 2;
					} 
					if ($status == 1) {
						$qrsj = TIME;
					} 
					
					$unique_id = $order_code . '*' . $product_code; //唯一编号，定单号+商品编号可确定唯		
					$mall_order = $duoduo -> select("mall_order", "*", 'unique_id="' . $unique_id . '"  and lm=5');
					if($mall_order['uid']>0){
						$uid=$mall_order['uid'];
					}

					if ($uid > 0) {
						$dduser = $duoduo -> select('user', 'id,type,tjr,ddusername', 'id="' . $uid . '"');
					} else {
						$dduser = array('level' => 0, 'tjr' => 0);
					} 

					$fxje = fenduan($commission, $webset['mallfxbl'], $dduser['type']);
					$jifen = round($fxje * $webset['jifenbl']);
					if ($mall['type'] == 2) { // 返积分
						$fxje = 0;
					} 
					if ($user['tjr'] > 0) {
						$tgyj = round($fxje * $webset['tgbl']);
					} else {
						$tgyj = 0;
					} 
					
					if ($mall_order['id'] == '') { // 交易不存在
						$field_arr = array ('adid' => $weiyi_merchant,
							'lm' => 5,
							'adid' => $weiyiid,
							'order_time' => $order_time,
							'mall_name' => $mall_name,
							'mall_id' => (int)$mall['id'],
							'uid' => $uid,
							'order_code' => $order_code,
							'product_code' => $product_code,
							'item_count' => $item_count,
							'item_price' => $item_price,
							'sales' => $sales,
							'commission' => $commission,
							'status' => $status,
							'fxje' => $fxje,
							'jifen' => $jifen,
							'tgyj' => $tgyj,
							'addtime' => TIME,
							'unique_id' => $unique_id,
							);
						if ($status == 1) {
							$field_arr['qrsj'] = $qrsj;
						}
						$insert = $duoduo -> insert("mall_order", $field_arr);
						
						$tuiguang_insert_data=array('fuid'=>$fuid,'uid'=>$uid,'order_id'=>$insert,'mall'=>1,'code'=>$code,'shuju_id'=>$shuju_id);
						$duoduo->ddtuiguang_insert($tuiguang_insert_data);
						
						$mall_order = $field_arr;
						$mall_order['id'] = $insert;
						$insert_num++;
						if ($status == 1 && $insert > 0) {
							if ($dduser['id'] > 0 && ($fxje > 0 || $jifen > 0)) {
								$duoduo -> rebate($dduser, $mall_order, 3);
							} 
						} 
					} elseif ($mall_order['id'] > 0 and ($mall_order['status'] == 0 || $mall_order['status'] == -1) and $status == 1) {
						$mall_order['commission'] = $commission;
						$mall_order['fxje'] = $fxje;
						$mall_order['jifen'] = $jifen;
						$update_num++;
						if ($dduser['id'] > 0 && ($fxje > 0 || $jifen > 0)) {
							$duoduo -> rebate($dduser, $mall_order, 3);
						} 
						else{
							$field_arr_order = array (
								'status' => 1,
								'qrsj' => $qrsj,
								'commission' => $commission,
								'fxje' => $fxje,
								'jifen' => $jifen,
							);
							$duoduo -> update('mall_order', $field_arr_order, "id='" . $mall_order['id'] . "'");
						}
					} elseif ($mall_order['id'] > 0 and $mall_order['status'] == 0 and $status == -1) {
						$field_arr_order = array (
							'status' => -1,
							'qrsj' => $qrsj,
							'commission' => $commission,
							'fxje' => $fxje,
							'jifen' => $jifen,
						);
						$duoduo -> update('mall_order', $field_arr_order, "id='" . $mall_order['id'] . "'");
						$update_num++;
					} 
				} 
			} 
		}
		
	}
	
	if($c==0){
		if($cday<$eday){
			$cday=date('Ymd', strtotime($cday." +1 day"));
			$page=0;
			$url="index.php?mod=mall_order&act=get&do=".$do."&sday=".$sday."&eday=".$eday."&cday=".$cday."&sub=1&page=".$page;
			$word=$cday.'共有订单'.$c.'条，插入订单'.$insert_num.'条，更新订单'.$update_num.'条！<br/><br/><img src="../images/wait2.gif" />';
		}
		else{
			$url="-1";
			$word=$cday.'无订单';
		}
		
	}
	elseif($maxnum!=0 && $maxnum<$c){
		$page++;
		$url="index.php?mod=mall_order&act=get&do=".$do."&sday=".$sday."&eday=".$eday."&cday=".$cday."&sub=1&page=".$page;
		$word=$cday.'共有订单'.$c.'条，插入订单'.$insert_num.'条，更新订单'.$update_num.'条！<br/><br/><img src="../images/wait2.gif" />';
	}
	else{
		if($cday<$eday){
			$cday=date('Ymd', strtotime($cday." +1 day"));
			$page=0;
			$url="index.php?mod=mall_order&act=get&do=".$do."&sday=".$sday."&eday=".$eday."&cday=".$cday."&sub=1&page=".$page;
			$word=$cday.'共有订单'.$c.'条，插入订单'.$insert_num.'条，更新订单'.$update_num.'条！<br/><br/><img src="../images/wait2.gif" />';
		}
		else{
			$url="index.php?mod=mall_order&act=get&do=".$do;
			$word=$cday.'共有订单'.$c.'条，插入订单'.$insert_num.'条，更新订单'.$update_num.'条！';
		}
	}

	PutInfo($word, $url);
}
else {
	
}
?>