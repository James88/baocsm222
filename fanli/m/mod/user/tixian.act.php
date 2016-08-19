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

function act_wap_tixian(){
	global $duoduo,$dd_tpl_data;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	
	if($dduser['id']==0){
		jump(wap_l('user','login'));
	}
	
	$uid=$dduser['id'];
	
	if($_GET['sub']==1){
		$type=(int)$_GET['type'];
		$remark = htmlspecialchars($_GET['remark']);
		$ddpassword=trim($_GET['ddpassword']);
		$data=array();
		
		if($_GET['money']>0){
			$type=2;
		}
		
		$user=$dduser;
		if ($ddpassword!='' && $user['ddpassword'] != md5($ddpassword)) {
			$json_data=array('s'=>0,'r'=>'登录密码错误！');
			echo dd_json_encode($json_data);exit;
		}
		if ($webset['sms']['open'] == 1 && $webset['sms']['need_yz'] == 1 && $user['mobile_test'] == 0) {
			$json_data=array('s'=>0,'r'=>'请验证您的手机号码！');
			echo dd_json_encode($json_data);exit;
		}
		if ($user['alipay'] == '') {
			$json_data=array('s'=>0,'r'=>'请设置您的支付宝账号信息！');
			echo dd_json_encode($json_data);exit;
		}
		if ($webset['tixian']['level'] > 0 && $webset['tixian']['level'] > $user['level']) {
			$json_data=array('s'=>0,'r'=>'用户等级（' . $user['level'] . '）达到等级（' . $webset['tixian']['level'] . "）时方可提现");
			echo dd_json_encode($json_data);exit;
		}
		if ($user['realname'] == '') {
			$json_data=array('s'=>0,'r'=>'请设置您的真实姓名！');
			echo dd_json_encode($json_data);exit;
		}
		if ($type == 1) {
			$tipword = '您申请的提现我们会打入您的支付宝账户，请仔细填写您的支付宝和对应姓名！支付宝规定集分宝提现一次最多'.JFB_TX_MAX;
			$txxz = $webset['tixian']['tbtxxz'];
			$tixian_limit = $webset['tixian']['tblimit'] ? $webset['tixian']['tblimit'] : 1;
			$live_money = $user['live_jifenbao'];
			$money_name = TBMONEY;
			$unit = TBMONEYUNIT;
			$money=(float)$_GET['jifenbao'];
		}
		elseif ($type == 2) {
			$tipword = '您申请的提现我们会打入您的支付宝或者银行账户，请仔细填写您的汇款信息，以免出错！';
			$txxz = $webset['tixian']['txxz'];
			$tixian_limit = $webset['tixian']['limit'] ? $webset['tixian']['limit'] : 0.01;
			$live_money = $user['live_money'];
			$money_name = '金额';
			$unit = '元';
			$money=(float)$_GET['money'];
		}
	
		if ($txxz > 0) {
			$max_money = $live_money - $live_money % $txxz;
		} else {
			$max_money = $live_money;
		}
		if($type == 1 && $max_money>JFB_TX_MAX){
			$max_money=JFB_TX_MAX;
		}
		
		if($money > $live_money){
			$json_data=array('s'=>0,'r'=>'当前'.$money_name.'不足提现，联系网站查看是否冻结');
			echo dd_json_encode($json_data);exit;
		}
		
		if($money < $tixian_limit){
			$json_data=array('s'=>0,'r'=>'最低提现！'.$tixian_limit);
			echo dd_json_encode($json_data);exit;
		}

		if ($txxz > 0 && zhengchu($money, $txxz) == 0) {
			$json_data=array('s'=>0,'r'=>'提现必须是'.$txxz.'的整数倍');
			echo dd_json_encode($json_data);exit;
		}
		
		$data = array (
			'uid' => $uid,
			'addtime' => TIME,
			'ip' => get_client_ip(), 
			'realname' => $user['realname'], 
			'remark' => $remark, 
			'mobile' => $user['mobile'], 
			'status' => 0, 
			'tool' => 1, 
			'code'=>$user['alipay'],
			'type' => $type
		);
		if($type==1){
			if($user['tbtxstatus']!='0'){
				$json_data=array('s'=>0,'r'=>'该帐号还有提现未处理！');
				echo dd_json_encode($json_data);exit;
			}
			$money_field = 'jifenbao';
			$tx_field = 'tbtxstatus';
			$data['money'] = $money;
			$data['money2'] = (int) ($money * (100 / TBMONEYBL));
		}
		elseif($type==2){
			if($user['txstatus']!='0'){
				$json_data=array('s'=>0,'r'=>'该帐号还有提现未处理！');
				echo dd_json_encode($json_data);exit;
			}
			$money_field = 'money';
			$tx_field = 'txstatus';
			$data['money'] = $money;
			$data['money2'] = $money;
		}
		else{
			exit('数据错误');
		}
		$user_data[] = array (
			'f' => $tx_field,
			'v' => 1
		);
		$user_data[] = array (
			'f' => $money_field,
			'e' => '-',
			'v' => $money
		);
		$user_data[] = array (
			'f' => 'lasttixian',
			'e' => '=',
			'v' => TIME
		);

		$tixian_data=$duoduo->select('tixian','money,addtime','uid="'.$uid.'" order by id desc');
		if($tixian_data['money']==$data['money'] && TIME-$tixian_data['addtime']<30){
			$json_data=array('s'=>0,'r'=>'两次提现间隔太短！');
			echo dd_json_encode($json_data);exit;
		}
		$duoduo->update('user', $user_data, 'id="' . $uid . '"');
		$id=$duoduo->insert('tixian', $data);
		$json_data=array('s'=>1,'r'=>'申请提现成功！');
		echo dd_json_encode($json_data);exit;
	}
	
	$type=$_GET['type']?$_GET['type']:1;
	$title_arr=array(1=>TBMONEY,2=>'现金');
	$title=$title_arr[$type].'提取';
	$webtitle=$title.'-'.$dd_tpl_data['title'];
	
	unset($duoduo);
	unset($webset);
	unset($dduser);
	unset($dd_tpl_data);
	$parameter['type']=$type;
	$parameter['title_arr']=$title_arr;
	$parameter['webtitle']=$webtitle;
	$parameter['title']=$title;
	return $parameter;
}
?>