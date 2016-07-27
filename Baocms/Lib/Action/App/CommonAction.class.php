<?php 
/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class CommonAction extends BaseAction {
   
    protected $uid = 0;
    protected $token = '';
    protected $_CONFIG = array();

    protected $member = array();

    //缓存用
    protected $citys = array();  //城市列表
    protected $areas = array();  //地区列表
    protected $bizs = array();   
    protected $shopcates = array(); //店铺类型
    protected $tuancates = array();  //团购类型
    protected $goodscates = array(); //商品类型

    protected $session = '';
    protected $city_id = 0;
    protected $city  = array();
    protected $lat = 0;
    protected $lng = 0;

    public function _initialize(){
        $this->_CONFIG = D('Setting')->fetchAll();
        
        $this->lat = addslashes($this->_param('lat'));
        $this->lng = addslashes($this->_param('lng'));

        $this->uid = $this->_get('uid');
        if($this->uid > 0){
        	$this->member = D('Users')->find($this->uid);
        }
        //客户端TOKEN比对
        $token = $this->_get('user_token');
        if(!empty($token)){
           if($token!=$this->member['token']){
                $data = array('status' => self::BAO_LOGIN_ERROR, 'msg'=>"登录异常,请重新登录");
                $this->stringify($data);
           }else{
                $this->token = $token;
           }
        }else{
                $this->uid = '';
        }
        

        $this->city_id = $this->_get('city_id');
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
        $this->city = $city;

        $this->shopcates = D('Shopcate')->fetchAll();
		$this->tuancates = D('Tuancate')->fetchAll();
		$this->goodscates = D('Goodscate')->fetchAll();
	 	$this->areas = D('Area')->fetchAll();
	 	$this->bizs = D('Business')->fetchAll();


    }

    public function verify() {
        import('ORG.Util.Image');
        Image::buildImageVerify(4,2,'png',60,30);
    }
    //到这里去
	public function gps($shop_id){
        $shop_id = (int)$shop_id;
        if(empty($shop_id)){
            $this->error('该商家不存在');
            $this->stringify(array('status'=>self::BAO_DETAIL_NO_EXSITS,'msg'=>'数据不存在！'));
        }
        $shop = D('Shop')->find($shop_id);
        $this->stringify(array('status'=>self::BAO_REQUEST_SUCCESS,'shop'=>$shop));
    }
   
    protected function checkFields($data = array(), $fields = array()) {
        foreach ($data as $k => $val) {
            if (!in_array($k, $fields)) {
                unset($data[$k]);
            }
        }
        return $data;
    }




}