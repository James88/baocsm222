<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class MoneyAction extends CommonAction {

    public function index() { //余额充值
        $this->assign('payment', D('Payment')->getPayments());
        $this->display(); 
    }
   
       
   public function moneypay() { //后期优化
        $money = (int) ($this->_post('money') * 100);
        $code = $this->_post('code', 'htmlspecialchars');
        if ($money <= 0) {
            $this->error('请填写正确的充值金额！');
        }
        $payment = D('Payment')->checkPayment($code);
        if (empty($payment)) {
            $this->error('该支付方式不存在');
        }
        $logs = array(
            'user_id' => $this->uid,
            'type' => 'money',
            'code' => $code,
            'order_id' => 0,
            'need_pay' => $money,
            'create_time' => NOW_TIME,
            'create_ip' => get_client_ip(),
        );
        $logs['log_id'] = D('Paymentlogs')->add($logs);
        $this->assign('button', D('Payment')->getCode($logs));
        $this->assign('money', $money);
        $this->display();
    }

    public function recharge() { //代金券充值
        if ($this->isPost()) {
            $card_key = $this->_post('card_key', htmlspecialchars);
            //if (!D('Lock')->lock($this->uid)) { //上锁
               // $this->baoError('服务器繁忙，1分钟后再试');
           // }
            if(empty($card_key)){
               //  D('Lock')->unlock();
                $this->baoError('充值卡号不能为空');
            }
            if (!$detail = D('Rechargecard')->where(array('card_key' => $card_key))->find()) {
             //   D('Lock')->unlock();
                $this->baoError('该充值卡不存在');
            }
            if ($detail['is_used'] == 1) {
               // D('Lock')->unlock();
                $this->baoError('该充值卡已经使用过了');
            }
            $member = D('Users')->find($this->uid);
            $member['money'] += $detail['value'];
            if (D('Users')->save(array('user_id' => $this->uid, 'money' => $member['money']))) {
                D('Usermoneylogs')->add(array(
                    'user_id' => $this->uid,
                    'money' => +$detail['value'],
                    'create_time' => NOW_TIME,
                    'create_ip' => get_client_ip(),
                    'intro' => '代金券充值' . $detail['card_id'],
                ));
                $res = D('Rechargecard')->save(array('card_id' => $detail['card_id'], 'is_used' => 1));
                if (!empty($res)) {
                    D('Rechargecard')->save(array('card_id' => $detail['card_id'], 'user_id' => $this->uid, 'used_time' => NOW_TIME));
                }
                $this->baoSuccess('充值成功！', U('money/rechargecard'));
            }
          //  D('Lock')->unlock();
        } else {
            $this->display();
        }
    }

    public function gold() {

        $this->assign('payment', D('Payment')->getPayments());
        $this->display();
        
    }

    public function goldpay() { //后期优化
        $gold = (int) $this->_post('gold');
        $code = $this->_post('code', 'htmlspecialchars');
        if ($gold <= 0) {
            $this->error('请填写正确的金块数！');
            die;
        }
        $payment = D('Payment')->checkPayment($code);
        if (empty($payment)) {
            $this->error('该支付方式不存在');
            die;
        }
        $logs = array(
            'user_id' => $this->uid,
            'type' => 'gold',
            'code' => $code,
            'order_id' => 0,
            'need_pay' => $gold * 100,
            'create_time' => NOW_TIME,
            'create_ip' => get_client_ip(),
        );
        $logs['log_id'] = D('Paymentlogs')->add($logs);

        $this->assign('button', D('Payment')->getCode($logs));
        $this->assign('gold', $gold);
        $this->display();
    }

  
    
}
