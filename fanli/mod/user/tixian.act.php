<?php

/**
 * ============================================================================
 * 版权所有 多多科技，保留所有权利。
网站地址: http://soft.duoduo123.com；
----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
使用；不允许对程序代码以任何形式任何目的的再发布。
============================================================================
 */
if (!defined('INDEX')) {
	exit ('Access Denied');
}

function act_user_tixian() {
	global $duoduo,$dd_user_class;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	$errorData = $duoduo->errorData;

	$msgset = dd_get_cache('msgset');
	$default_pwd = $dd_user_class->get_default_pwd($dduser['id']);

	$type = isset ($_GET['type']) ? (int) $_GET['type'] : 1;
	if ($type > 2) {
		dd_exit('数据错误');
	}

	$bank = dd_get_cache('bank');
	foreach ($bank as $k => $row) {
		if ($row['name'] == $dduser['bank_name']) {
			$bank_id = $k;
		}
		$bank_arr[$k] = $row['name'];
	}

	if ($webset['sms']['open'] == 1 && $webset['sms']['need_yz'] == 1 && $dduser['mobile_test'] == 0) {
		jump(u('user', 'info', array (
			'do' => 'mobile'
		)), '请验证您的手机号码');
	}

	if ($type == 1) {
		if ($dduser['alipay'] == '') {
			jump(u('user', 'info', array (
				'do' => 'caiwu'
			)), '请设置您的支付宝账号信息');
		}
		if ($dduser['tbtxstatus'] == 1) {
			jump(-1, '您的提现正在处理中');
		}
	}
	elseif ($type == 2) {
		if ($dduser['alipay'] == '' && $dduser['tenpay'] == '' && $dduser['bank_code'] == '') {
			jump(u('user', 'info', array (
				'do' => 'caiwu'
			)), '请设置您的财务账号信息');
		}
		if ($dduser['txstatus'] == 1) {
			jump(-1, '您的提现正在处理中');
		}
	}

	if ($webset['tixian']['level'] > 0 && $webset['tixian']['level'] > $dduser['level']) {
		jump(-1, '用户等级（' . $dduser['level'] . '）达到等级（' . $webset['tixian']['level'] . "）时方可提现");
	}

	if ($dduser['realname'] == '') {
		jump(u('user', 'info', array (
			'do' => 'caiwu'
		)), '请设置您的真实姓名');
	}

	if ($type == 1) {
		$tipword = '您申请的提现我们会打入您的支付宝账户，请仔细填写您的支付宝和对应姓名！支付宝规定集分宝提现一次最多'.JFB_TX_MAX;
		$txxz = $webset['tixian']['tbtxxz'];
		$tixian_limit = $webset['tixian']['tblimit'] ? $webset['tixian']['tblimit'] : 1;
		$live_money = $dduser['live_jifenbao'];
		$money_name = '集分宝';
		$unit = TBMONEY;
	}
	elseif ($type == 2) {
		$tipword = '您申请的提现我们会打入您的支付宝或者银行账户，请仔细填写您的汇款信息，以免出错！';
		$txxz = $webset['tixian']['txxz'];
		$tixian_limit = $webset['tixian']['limit'] ? $webset['tixian']['limit'] : 0.01;
		$live_money = $dduser['live_money'];
		$money_name = '金额';
		$unit = '元';
	}

	if ($txxz > 0) {
		$max_money = $live_money - $live_money % $txxz;
	} else {
		$max_money = $live_money;
	}
	
	if($type == 1 && $max_money>JFB_TX_MAX){
		$max_money=JFB_TX_MAX;
	}

	if (isset ($_POST['sub'])) {
		
		$phplock=new phplock('tixian_'.$dduser['id']);
		if($phplock->status==0){
			jump(-1, 71);
		}
		
		$money = (float) $_POST['money'];
		$remark = htmlspecialchars($_POST['remark']);

		if ($dduser['mobile'] != '') {
			$mobile = $dduser['mobile'];
		} else {
			$mobile = (float) $_POST['mobile'];
		}

		$ddpassword = $_POST['ddpassword'];
		$tool = $_POST['tool'];
		$realname = $dduser['realname'];
		if ((int) $dduser['id'] == 0) {
			jump(-1, 10);
		}

		if ($dduser['ddpassword'] != md5($ddpassword)) {
			jump(-1, 4);
		}

		if ($money > $live_money || $money < $tixian_limit || ($txxz > 0 && zhengchu($money, $txxz) == 0)) {
			jump(-1, 42);
		}

		$data = array (
			'uid' => $dduser['id'],
			'money' => $money,
			'addtime' => TIME,
		'ip' => get_client_ip(), 'realname' => $realname, 'remark' => $remark, 'mobile' => $mobile, 'status' => 0, 'type' => $type);

		if ($type == 1) {
			
			if($money>JFB_TX_MAX){
				jump(-1, 42);
			}
			
			if ($dduser['tbtxstatus'] == 1) {
				jump(-1, 38);
			}
			$money_field = 'jifenbao';
			$tx_field = 'tbtxstatus';

			if ($dduser['alipay'] != '') {
				$data['code'] = $dduser['alipay'];
			} else {
				$data['code'] = $_POST['alipay'];
				$user_data[] = array (
					'f' => 'alipay',
					'e' => '=',
					'v' => $data['code']
				);
			}
			if ($data['code'] == '') {
				jump(-1, 35); //支付宝格式错误
			}
			$money2 = (int) ($money * (100 / TBMONEYBL));
		}
		elseif ($type == 2) {
			$money2 = $money;
			if ($user['txstatus'] == 1) {
				jump(-1, 38);
			}
			$money_field = 'money';
			if ($tool == 1) {
				if ($dduser['alipay'] != '') {
					$data['code'] = trim($dduser['alipay']);
				} else {
					$data['code'] = trim($_POST['alipay']);
					$user_data[] = array (
						'f' => 'alipay',
						'e' => '=',
						'v' => $data['code']
					);
				}
				if ($data['code'] == '') {
					jump(-1, 35); //支付宝格式错误
				}
				$data['tool'] = 1;
			}
			elseif ($tool == 2) {
				if ($dduser['tenpay'] != '') {
					$data['code'] = $dduser['tenpay'];
				} else {
					$data['code'] = $_POST['tenpay'];
					$user_data[] = array (
						'f' => 'tenpay',
						'e' => '=',
						'v' => $data['code']
					);
				}
				if ($data['code'] == '') {
					jump(-1, 62); //财付通格式错误
				}
				$data['tool'] = 2;
			}
			elseif ($tool == 3) {
				if ($dduser['bank_name'] != '' && $dduser['bank_code'] != '') {
					$data['code'] = $dduser['bank_name'] . '|' . $dduser['bank_code'];
				}
				elseif ($_POST['bank_id'] > 0 && $_POST['bank_code'] != '') {
					$_POST['bank_name'] = $bank_arr[$_POST['bank_id']];
					$data['code'] = $_POST['bank_name'] . '|' . $_POST['bank_code'];
					$user_data[] = array (
						'f' => 'bank_name',
						'e' => '=',
						'v' => $_POST['bank_name']
					);
					$user_data[] = array (
						'f' => 'bank_code',
						'e' => '=',
						'v' => $_POST['bank_code']
					);
				} else {
					jump(-1, 60); //银行账号格式错误
				}

				$data['tool'] = 3;
			}
			$tx_field = 'txstatus';
		}

		$data['money2'] = $money2;

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

		if ($dduser['mobile'] == '' && $mobile != '') {
			$user_data[] = array (
				'f' => 'mobile',
				'e' => '=',
				'v' => $mobile
			);
		}

		$tixian_data=$duoduo->select('tixian','money,addtime','uid="'.$dduser['id'].'" order by id desc');
		if($tixian_data['money']==$data['money'] && TIME-$tixian_data['addtime']<30){
			jump(-1, '两次提现间隔太短');
		}
		$id=$duoduo->insert('tixian', $data);
		if($id>0){
			$duoduo->update('user', $user_data, 'id="' . $dduser['id'] . '"');
		}
		else{
			jump(-1, '数据插入错误');
		}
		jump(u('user', 'index'));

	} else {
		if ($dduser['realname'] != '') {
			$realname_dis = 'disabled="disabled"';
		}
		if ($dduser['alipay'] != '') {
			$alipay_dis = 'disabled="disabled"';
		}
		if ($dduser['tenpay'] != '') {
			$tenpay_dis = 'disabled="disabled"';
		}
		if ($dduser['bank_code'] != '') {
			$bank_code_dis = 'disabled="disabled"';
		}
		unset($duoduo);
		$parameter['realname_dis'] = $realname_dis;
		$parameter['alipay_dis'] = $alipay_dis;
		$parameter['tenpay_dis'] = $tenpay_dis;
		$parameter['bank_code_dis'] = $bank_code_dis;
		$parameter['mobile'] = $mobile;
		$parameter['tipword'] = $tipword;
		$parameter['txxz'] = $txxz;
		$parameter['tixian_limit'] = $tixian_limit;
		$parameter['live_money'] = $live_money;
		$parameter['money_name'] = $money_name;
		$parameter['unit'] = $unit;
		$parameter['max_money'] = $max_money;
		$parameter['bank_arr'] = $bank_arr;
		$parameter['bank_id'] = $bank_id;
		$parameter['type'] = $type;
		$parameter['default_pwd'] = $default_pwd;
		return $parameter;
	}
}
?>