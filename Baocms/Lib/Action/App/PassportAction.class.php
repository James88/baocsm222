<?php 
/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class PassportAction extends CommonAction{

	private $create_fields = array('account', 'password', 'nickname');


    private function createCheck() {
        $data = $this->checkFields($this->_post('data', false), $this->create_fields);
        $data['account'] = htmlspecialchars($_POST['account']);
        if (!isMobile($data['account'])) {
            $data = array('status' => self::BAO_INPUT_ERROR ,'msg' =>'只允许手机号注册' );
            $this->stringify($data);
        }
        $data['password'] = htmlspecialchars($_POST['password']); //整合UC的时候需要

        if (empty($data['password']) || strlen($_POST['password']) < 6) {
            session('verify', null);
            $data = array('status' => self::BAO_INPUT_ERROR ,'msg' =>'密码长度必须要在6个字符以上' );
            $this->stringify($data);
        }
        $data['nickname'] = $data['account'];
        $data['ext0'] = $data['account']; //兼容UCENTER
        $data['mobile'] = $data['account'];
        $data['reg_ip'] = get_client_ip();
        $data['reg_time'] = NOW_TIME;
        return $data;
    }

    public function register() {
        if ($this->isPost()) {
            if (isMobile(htmlspecialchars($_POST['account']))) {
                if (!$scode = trim($_POST['scode'])) {
                    $data = array('status' => self::BAO_SCODE_ERROR ,'msg' =>'请输入短信验证码！' );
                    $this->stringify($data);
                }
				/*
                $scode2 = session('scode');
                if (empty($scode2)) {
                    $data = array('status' => self::BAO_SCODE_EMPTY,'msg' =>'请获取短信验证码！' );
                    $this->stringify($data);
                }
                if ($scode != $scode2) {
                    $data = array('status' => self::BAO_SCODE_NOTSAME,'msg' =>'请输入正确的短信验证码！' );
                    $this->stringify($data);
                }
				*/
            }
			
            $data = $this->createCheck();
			/*
            $invite_id = (int) session('invite_id');
            if (!empty($invite_id)) {
                $data['invite_id'] = $invite_id;
            }*/
            $password2 = $this->_post('password2');
            if ($password2 !== $data['password']) {
                $data = array('status' => self::BAO_REG_PSWD_ERROR,'msg' =>'两次密码不一致' );
                $this->stringify($data);
            }
            //开始其他的判断了
            if (true == D('Passport')->register($data)) {
                $data = array('status' => self::BAO_REQUEST_SUCCESS,'msg' =>'恭喜您注册成功' );
                //TODO
                $this->stringify($data);
            }
            $data = array('status' => self::BAO_DB_ERROR,'msg' => D('Passport')->getError() );
            $this->stringify($data);
        }
    }

    public function sendsms() {
        if (!$mobile = htmlspecialchars($_POST['mobile'])) {
            $data = array('status' => self::BAO_INPUT_ERROR,'msg' =>'请输入正确的手机号码' );
            $this->stringify($data);
        }
        if (!isMobile($mobile)) {
            $data = array('status' => self::BAO_INPUT_ERROR,'msg' =>'请输入正确的手机号码' );
            $this->stringify($data);
        }
        $findpass = (int)$_POST['findpass'];
        if ($findpass < 0 &&$user = D('Users')->getUserByAccount($mobile)) {
            $data = array('status' => self::BAO_INPUT_ERROR,'msg' =>'该手机号已经被注册' );
            $this->stringify($data);
        }
		//APPCAN无法存储COOKIE，直接传入本地进行比对
        $randstring = session('scode');
        if(empty($randstring)) {
            $randstring = rand_string(6, 1);
            session('scode', $randstring);
        }
        //die(session('scode'));
        D('Sms')->sendSms('sms_code', $mobile, array('code' => $randstring));
		$data = array('status' => self::BAO_REQUEST_SUCCESS,'scode' =>$randstring );
		$this->stringify($data);
    }

	public function logout() {
        D('Passport')->logout();
        $this->stringify(array('status'=>self::BAO_REQUEST_SUCCESS,'msg'=>'退出登录成功！'));
    }

    public function bind() {
       // $this->display();
    }

	
	public function index(){
		//$this->redirect('login');
	}


    public function login() {
        if($this->uid){
            $data = array('status' => self::BAO_LOGIN_ALREADY ,'msg' =>'您已经登录了,不要重复登录!' );
            $this->stringify($data);
        }
        
        if ($this->isPost()) {
           
            if(!$account = $this->_post('account')){
                $data = array('status' => self::BAO_LOGIN_ACCOUNT_ERROR,'msg' =>'请输入用户名！' );
                $this->stringify($data);
            }
            if(!$password = $this->_post('password')){
                $data = array('status' => self::BAO_LOGIN_PSWD_ERROR,'msg' =>'请输入登录密码！' );
                $this->stringify($data);
            }

            $passport = D('Passport');
            if (true == $passport->login($account, $password)) {
                $token     = $passport->getToken();
                $user_info = $passport->getUserInfo();
                $data = array('status' => self::BAO_LOGIN_SUCCESS,'msg' =>'登录成功！','user_token'=>$token,'user_info'=>$user_info);
                $this->stringify($data);
            } else {
                $data = array('status' => self::BAO_LOGIN_ERROR ,'msg' => D('Passport')->getError() );
                $this->stringify($data);
            }
        }
    }

	public function newpwd() {
		$yzm = $this->_param('yzm');
		$account = $this->_param('account');
        if (empty($account)) {
            session('verify', null);
			$data = array('status' => self::BAO_INPUT_ERROR, 'msg'=>"请输入用户名!");
        }else if(!$user = D('Users')->getUserByAccount($account)){
			 session('verify', null);
			 $data = array('status'=>self::BAO_USER_NOT_EXISTS,'msg'=>'用户不存在!');
		}else{
			$way = $this->_param('way');
			$password = rand_string(8, 1);
			switch ($way) {
				case 1:
					$email = $this->_param('email');
					if (empty($email) || $email != $user['email']) {
						$data = array('status'=>self::BAO_INPUT_ERROR,'msg'=>'邮件不正确!');
					}else{
						D('Passport')->uppwd($user['account'], '', $password);
						D('Email')->sendMail('email_newpwd', $email, '重置密码', array('newpwd' => $password));
						$data = array('status'=>self::BAO_REQUEST_SUCCESS ,'msg'=>'重置密码成功!');
					}
                    break;
				default:
					$mobile = $this->_param('mobile');
					if (empty($mobile) || $mobile != $user['mobile']) {
						$data = array('status'=>self::BAO_INPUT_ERROR,'msg'=>'手机号码不正确!');
					}else{
						D('Passport')->uppwd($user['account'], '', $password);
						D('Sms')->sendSms('sms_newpwd', $mobile, array('newpwd' => $password));
						$data = array('status'=>self::BAO_REQUEST_SUCCESS ,'msg'=>'重置密码成功！');
					}
                    break;
			}
		}
		$this->stringify($data);
    }

    public function hello()
    {
        $this->stringify(array('status'=>111111,'msg'=>'OOOOOOOOOK'));
    }
}
