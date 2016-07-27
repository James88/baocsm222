<?php

class InfoAction extends CommonAction {

    public function sendsms() {
        $mobile = $this->_post('mobile');
        if (isMobile($mobile)) {
            session('mobile', $mobile);
            $randstring = session('code');
            if (empty($randstring)) {
                $randstring = rand_string(6, 1);
                session('code', $randstring);
            }
            D('Sms')->sendSms('sms_code', $mobile, array('code' => $randstring));
        }
    }

    public function password() {
        if ($this->isPost()) {
            $oldpwd = $this->_post('oldpwd', 'htmlspecialchars');
            if (empty($oldpwd)) {
                $this->baoMsg('旧密码不能为空！');
            }
            $newpwd = $this->_post('newpwd', 'htmlspecialchars');
            if (empty($newpwd)) {
                $this->baoMsg('请输入新密码');
            }
            $pwd2 = $this->_post('pwd2', 'htmlspecialchars');
            if (empty($pwd2) || $newpwd != $pwd2) {
                $this->baoMsg('两次密码输入不一致！');
            }
            if ($this->member['password'] != md5($oldpwd)) {
                $this->baoMsg('原密码不正确');
            }
            if (D('Passport')->uppwd($this->member['account'], $oldpwd, $newpwd)) {
                clearUid();
                $this->baoMsg('更改密码成功！', U('mobile/passport/login'));
            }
            $this->baoMsg('修改密码失败！');
        } else {
            $this->display();
        }
    }

}
