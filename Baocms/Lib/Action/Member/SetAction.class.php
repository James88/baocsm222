<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class SetAction extends CommonAction {

    public function nickname() {
        if ($this->isPost()) {
            $nickname = $this->_post('nickname', 'htmlspecialchars');
            if (empty($nickname)) {
                $this->baoError('请填写昵称');
            }
            $data = array('user_id' => $this->uid, 'nickname' => $nickname);
            if (false !== D('Users')->save($data)) {
                $this->baoSuccess('昵称设置成功！', U('set/nickname'));
            }
            $this->baoError('昵称设置失败');
        } else {
            $this->display();
        }
    }

    public function face() {
        if ($this->isPost()) {
            $face = $this->_post('face', 'htmlspecialchars');
            if (empty($face)) {
                $this->baoError('请上传头像');
            }
            if (!isImage($face)) {
                $this->baoError('头像格式不正确');
            }
            $data = array('user_id' => $this->uid, 'face' => $face);
            if (false !== D('Users')->save($data)) {
                $this->baoSuccess('上传头像成功！', U('set/face'));
            }
            $this->baoError('更新头像失败');
        } else {
            $this->display();
        }
    }

    public function password() {
        if ($this->isPost()) {
            $oldpwd = $this->_post('oldpwd', 'htmlspecialchars');
            if (empty($oldpwd)) {
                $this->baoError('旧密码不能为空！');
            }
            $newpwd = $this->_post('newpwd', 'htmlspecialchars');
            if (empty($newpwd)) {
                $this->baoError('请输入新密码');
            }
            $pwd2 = $this->_post('pwd2', 'htmlspecialchars');
            if (empty($pwd2) || $newpwd != $pwd2) {
                $this->baoError('两次密码输入不一致！');
            }
            if ($this->member['password'] != md5($oldpwd)) {
                $this->baoError('原密码不正确');
            }
            if (D('Passport')->uppwd($this->member['account'], $oldpwd, $newpwd)) {
                session('uid', null);
                $this->baoSuccess('更改密码成功！', U('pchome/passport/login'));
            }
            $this->baoError('修改密码失败！');
        } else {
            $this->display();
        }
    }
    
    public function mobile() {
        if ($this->isPost()) {
            $mobile = $this->_post('mobile');
            $yzm = $this->_post('yzm');
            if (empty($mobile) || empty($yzm))
                $this->baoError('请填写正确的手机及手机收到的验证码！');
            $s_mobile = session('mobile');
            $s_code = session('code');
            if ($mobile != $s_mobile)
                $this->baoError('手机号码和收取验证码的手机号不一致！');
            if ($yzm != $s_code)
                $this->baoError('验证码不正确');
            $data = array(
                'user_id' => $this->uid,
                'mobile' => $mobile
            );
            if (D('Users')->save($data)) {
                D('Users')->integral($this->uid, 'mobile');
                D('Users')->prestige($this->uid, 'mobile');
                $this->baoSuccess('恭喜您通过手机认证', U('set/mobile'));
            }
            $this->baoError('更新数据失败！');
        } else {

            $this->display();
        }
    }

    public function mobile2() {
        if ($this->isPost()) {
            $mobile = $this->_post('mobile');
            $yzm = $this->_post('yzm');
            if (empty($mobile) || empty($yzm))
                $this->baoError('请填写正确的手机及手机收到的验证码！');
            $s_mobile = session('mobile');
            $s_code = session('code');
            if ($mobile != $s_mobile)
                $this->baoError('手机号码和收取验证码的手机号不一致！');
            if ($yzm != $s_code)
                $this->baoError('验证码不正确');
            $data = array(
                'user_id' => $this->uid,
                'mobile' => $mobile
            );
            if (D('Users')->save($data)) {
                $this->baoSuccess('恭喜您成功更换绑定手机号', U('set/mobile'));
            }
            $this->baoError('更新数据失败！');
        } else {

            $this->display();
        }
    }

    
    public function sendsms() {
        if (!$mobile = $this->_post('mobile')) {
            $this->ajaxReturn(array('status'=>'error','msg'=>'请输入正确的手机号码'));
        }
        if (!isMobile($mobile)) {
            $this->ajaxReturn(array('status'=>'error','msg'=>'请输入正确的手机号码'));
        }
        if ($user = D('Users')->where(array('mobile' => $mobile))->find()) {
            $this->ajaxReturn(array('status'=>'error','msg'=>'手机号码已经存在！'));
        }
        session('mobile', $mobile);
        $randstring = session('code');
        if (empty($randstring)) {
            $randstring = rand_string(6, 1);
            session('code', $randstring);
        }
        D('Sms')->sendSms('sms_code', $mobile, array('code' => $randstring));
        $this->ajaxReturn(array('status'=>'success','msg'=>'短信发送成功，请留意收到的短信','code'=>session('code')));
    }

    public function email() {

        $this->display();
    }

    public function sendemail() {
        $email = $this->_post('email');
        if (isEmail($email)) {
            $link = 'http://' . $_SERVER['HTTP_HOST'];
            $uid = $this->uid;
            $local = array(
                'email' => $email,
                'uid' => $uid,
                'time' => NOW_TIME,
                'sig' => md5($uid . $email . NOW_TIME . C('AUTH_KEY'))
            );
            $link .=U('public/email', $local);
            D('Email')->sendMail('email_rz', $email, $this->_CONFIG['site']['sitename'] . '邮件认证', array('link' => $link));
        }
    }
    
}
