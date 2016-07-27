<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class CommonAction extends Action {

    protected $uid = 0;
    protected $member = array();
    protected $_CONFIG = array();
    protected $citys = array();
    protected $areas = array();
    protected $bizs = array();
    protected $template_setting = array();
    protected $city_id = 0;

    protected function _initialize() {
        //global $domains, $city;
         define('__HOST__', 'http://' . $_SERVER['HTTP_HOST']);
        
        
        $this->_CONFIG = D('Setting')->fetchAll();
        $this->citys = D('City')->fetchAll();
        $this->assign('citys', $this->citys);
        
       
        $this->city_id = cookie('city_id');
        if(empty($this->city_id)){
            import('ORG/Net/IpLocation');
            $IpLocation = new IpLocation('UTFWry.dat'); // 实例化类 参数表示IP地址库文件
            $result = $IpLocation->getlocation($_SERVER['REMOTE_ADDR']);
            foreach ($this->citys as $val) {
                if (strstr($result['country'], $val['name'])) {
                    $city = $val;
                    $this->city_id = $val['city_id'];
                    break;
                }
            }
            if(empty($city)){
                $this->city_id = $this->_CONFIG['site']['city_id'];
                $city = $this->citys[$this->_CONFIG['site']['city_id']];
            }  
        }  else{
            $city = $this->citys[$this->city_id];
        }
       

      
        $this->uid =  getUid();
        if (empty($this->uid)) {
            header("Location: " . U('pchome/passport/login'));
            die;
        }
        if (!empty($this->uid)) {
            $this->member = D('Users')->find($this->uid);
        }
        
        $this->_CONFIG = D('Setting')->fetchAll();
        $this->assign('CONFIG', $this->_CONFIG);
        $this->assign('MEMBER', $this->member);
        $this->assign('today', TODAY); //兼容模版的其他写法

        $this->areas = D('Area')->fetchAll();
        $this->assign('areas', $this->areas);
        $this->bizs = D('Business')->fetchAll();
        $this->assign('bizs', $this->bizs);
        $this->assign('tuancates',D('Tuancate')->fetchAll());
        $this->assign('ctl', strtolower(MODULE_NAME)); //主要方便调用
        $this->assign('act', ACTION_NAME);
        $this->assign('nowtime', NOW_TIME); // 主要标签短
        $this->assign('bao_city', BAO_CITY ? 1 : 0); //是否切换城市的开关
        $this->assign('domains', $domains); //城市列表加域名
        $this->assign('city_name', $city['name']); //您当前可能在的城市
        $this->assign('city_id', $this->city_id);
        //模版的选择
        $this->getTemplateTheme();
        $this->template_setting = D('Templatesetting')->detail($this->theme);
    }

    //购物车

    private function tmplToStr($str, $datas) {
        return tmplToStr($str, $datas);
    }

    public function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '') {
        parent::display($this->parseTemplate($templateFile), $charset, $contentType, $content = '', $prefix = '');
    }

    private function parseTemplate($template = '') {

        $depr = C('TMPL_FILE_DEPR');
        $template = str_replace(':', $depr, $template);
        // 获取当前主题名称
        $theme = $this->getTemplateTheme();
        define('NOW_PATH',BASE_PATH.'/themes/'.$theme.'Member/');
        // 获取当前主题的模版路径
        define('THEME_PATH', BASE_PATH . '/themes/default/Member/');
        define('APP_TMPL_PATH', __ROOT__ . '/themes/default/Member/');
     
        // 分析模板文件规则
        if ('' == $template) {
            // 如果模板文件名为空 按照默认规则定位
            $template = strtolower(MODULE_NAME) . $depr . strtolower(ACTION_NAME);
        } elseif (false === strpos($template, '/')) {
            $template = strtolower(MODULE_NAME) . $depr . strtolower($template);
        }  
        $file = NOW_PATH . $template . C('TMPL_TEMPLATE_SUFFIX');
        if(file_exists($file)) return $file;
        return THEME_PATH . $template . C('TMPL_TEMPLATE_SUFFIX');
    }

    private function getTemplateTheme() {
        
        define('THEME_NAME','default');

        if ($this->theme) { // 指定模板主题
            $theme = $this->theme;
        } else {
            /* 获取模板主题名称 */
            $theme = D('Template')->getDefaultTheme();
            if (C('TMPL_DETECT_THEME')) {// 自动侦测模板主题
                $t = C('VAR_TEMPLATE');
                if (isset($_GET[$t])) {
                    $theme = $_GET[$t];
                } elseif (cookie('think_template')) {
                    $theme = cookie('think_template');
                }
                if (!in_array($theme, explode(',', C('THEME_LIST')))) {
                    $theme = C('DEFAULT_THEME');
                }
                cookie('think_template', $theme, 864000);
            }
            $this->theme = $theme;
        }
        // 当前模板主题名称
        return $theme ? $theme . '/' : '';
    }

   protected function baoMsg($message, $jumpUrl = '', $time = 3000,$callback = '',$parent=true) {
        $parents = $parent ? 'parent.':'';
        $str = '<script>';
        $str .=$parents.'bmsg("' . $message . '","' . $jumpUrl .'","'.$time. '","'.$callback.'");';
        $str.='</script>';
        exit($str);
    }
    
    protected function baoOpen($message, $close = true, $style) {
        $str = '<script>';
        $str .='parent.bopen("' . $message . '","' . $close .'","'.$style. '");';
        $str.='</script>';
        exit($str);
    }
    
    protected function baoSuccess($message, $jumpUrl = '', $time = 3000, $parent = true) {
        $this->baoMsg($message,$jumpUrl,$time,'',$parent);
    }

    protected function baoJump($jumpUrl) {
        $str = '<script>';
        $str .='parent.jumpUrl("' . $jumpUrl . '");';
        $str.='</script>';
        exit($str);
    }

    protected function baoErrorJump($message, $jumpUrl = '', $time = 3000) {
        $this->baoMsg($message,$jumpUrl,$time);
    }

    protected function baoError($message, $time = 3000, $yzm = false, $parent = true) {

        $parent = $parent ? 'parent.' : '';
        $str = '<script>';
        if ($yzm) {
            $str .= $parent . 'bmsg("' . $message . '","",' . $time . ',"yzmCode()");';
        } else {
            $str .= $parent . 'bmsg("' . $message . '","",' . $time . ');';
        }
        $str.='</script>';
        exit($str);
    }

    /*public function error($message = '', $jumpUrl = '', $ajax = false) {
        $this->assign('message', $message);
        $this->assign('jumpUrl', $jumpUrl);
        $this->display('error');
        die;
    }
     */

    protected function baoLoginSuccess() { //异步登录
        $str = '<script>';
        $str .='parent.parent.LoginSuccess();';
        $str.='</script>';
        exit($str);
    }

    protected function ajaxLogin() {
        if ($mini = $this->_get('mini')) { //如果是迷你的弹出层操作就输出0即可
            die('0');
        }
        $str = '<script>';
        $str .='parent.ajaxLogin();';
        $str.='</script>';
        exit($str);
    }

    protected function checkFields($data = array(), $fields = array()) {
        foreach ($data as $k => $val) {
            if (!in_array($k, $fields)) {
                unset($data[$k]);
            }
        }
        return $data;
    }

    protected function ipToArea($_ip) {
        return IpToArea($_ip);
    }

    protected function getMenus() {
        $menus = $this->memberMenu();
        return $menus;
    }

    protected function memberMenu() {

        return array(
            'account' => array(
                'name' => '账户管理',
                'url' => U('member/password'),
                'items' => array(
                    'info' => array(
                        'name' => '我的账户',
                        'items' => array(
                            array(
                                'name' => '昵称设置',
                                'url' => U('member/nickname'),
                            ),
                            array(
                                'name' => '修改密码',
                                'url' => U('member/password'),
                            ),
                            array(
                                'name' => '修改头像',
                                'url' => U('member/face'),
                            ),
                            array(
                                'name' => '收货地址',
                                'url' => U('member/myaddress'),
                            ),
                        ),
                    ),
                    'auth' => array(
                        'name' => '认证管理',
                        'items' => array(
                            array(
                                'name' => '手机认证',
                                'url' => U('member/mobile'),
                            ),
                            array(
                                'name' => '邮件认证',
                                'url' => U('member/email'),
                            ),
                        ),
                    ),
                    'logs' => array(
                        'name' => '日志管理',
                        'items' => array(
                            array(
                                'name' => '积分日志',
                                'url' => U('member/integral'),
                            ),
                            array(
                                'name' => '金块日志',
                                'url' => U('member/goldlogs'),
                            ),
                            array(
                                'name' => '余额日志',
                                'url' => U('member/moneylogs'),
                            ),
                            array(
                                'name' => '代金券日志',
                                'url' => U('member/rechargecard'),
                            ),
                        ),
                    ),
                ),
            ),
            'consume' => array(
                'name' => '消费管理',
                'url' => U('member/order'),
                'items' => array(
                    'order' => array(
                        'name' => '我的订单',
                        'items' => array(
                            array(
                                'name' => '抢购订单',
                                'url' => U('member/order'),
                            ),
                            array(
                                'name' => '订餐订单',
                                'url' => U('member/eleorder'),
                            ),
                            array(
                                'name' => '商城订单',
                                'url' => U('member/goods'),
                            ),
                        ),
                    ),
                    'card' => array(
                        'name' => '票券积分',
                        'items' => array(
                            array(
                                'name' => '我的抢购券',
                                'url' => U('member/ordercode'),
                            ),
                            array(
                                'name' => '优惠券下载',
                                'url' => U('member/coupon'),
                            ),
                            array(
                                'name' => '我的兑换',
                                'url' => U('member/exchange'),
                            ),
                            array(
                                'name' => '我的预约',
                                'url' => U('member/yuyue'),
                            )
                        ),
                    ),
                ),
            ),
            'other' => array(
                'name' => '其他管理',
                'url' => U('member/order'),
                'items' => array(
                    'order' => array(
                        'name' => '充值管理',
                        'items' => array(
                            array(
                                'name' => '余额充值',
                                'url' => U('member/money'),
                            ),
                            array(
                                'name' => '代金券充值',
                                'url' => U('member/recharge'),
                            ),
                            array(
                                'name' => '金块充值',
                                'url' => U('member/gold'),
                            ),
                        ),
                    ),
                    'cash' => array(
                        'name' => '提现管理',
                        'items' => array(
                            array(
                                'name' => '提现记录',
                                'url' => U('member/cashlog'),
                            ),
                            array(
                                'name' => '申请提现',
                                'url' => U('member/cash'),
                            )
                        ),
                    ),
                    'huodong' => array(
                        'name' => '活动信息',
                        'items' => array(
                            array(
                                'name' => '我的活动',
                                'url' => U('member/myactivity'),
                            ),
                            array(
                                'name' => '我的信息',
                                'url' => U('member/life'),
                            ),
                            array(
                                'name' => '我的点评',
                                'url' => U('member/dianping'),
                            ),
                            array(
                                'name' => '我的关注',
                                'url' => U('member/favorites'),
                            ),
                            array(
                                'name' => '我的分享',
                                'url' => U('member/bbs'),
                            ),
                        ),
                    ),
                    'tuiguang' => array(
                        'name' => '代理商',
                        'items' => array(
                            array(
                                'name' => '商户列表',
                                'url' => U('member/myshop'),
                            ),
                            array(
                                'name' => '代理成果',
                                'url' => U('member/tongji'),
                            ),
                        ),
                    )
                ),
            ),
        );
    }

}
