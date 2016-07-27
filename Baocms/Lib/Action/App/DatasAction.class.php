<?php

class  DatasAction extends  CommonAction{
    

    public function cityareas(){
        $data = array();
        $data['city']       = D('City')->fetchAll();
        $data['area']       = D('Area')->fetchAll();
        $data['status'] = self::BAO_REQUEST_SUCCESS;
        echo json_encode($data);
        die;
    }
	
	 public  function cityarea(){
        $data = array();
        $data['city']       = D('City')->fetchAll();
        $data['area']       = D('Area')->fetchAll();
        header("Content-Type:application/javascript");
        echo   'var  cityareas = '.  json_encode($data);die;
    }
    
    public function cab() { //城市地区商圈
        $name = htmlspecialchars($_GET['name']);
        $data = array();
        $data['city']       = D('City')->fetchAll();
        $data['area']       = D('Area')->fetchAll();
        $data['business']   = D('Business')->fetchAll();
        header("Content-Type:application/javascript");
        echo  'var '.$name.'='.  json_encode($data).';';
        die;
    }
	
	/*
    * 获取accessid以及accesstoken
    */
	public function xinge(){ 
        $plat = $this->get('plat');
        $where = array('k'=>'xinge');
        $xinge = D('setting')->where($where)->find();
        if(empty($xinge))
        {
            $data = array('status'=>self::BAO_DB_ERROR,'msg'=>'未能成功获取accesskey');
            $this->stringify($data);
        }
        $xinge = unserialize($xinge['v']);
        switch ($plat) {
            case 'ios':
             if(!empty($xinge['iosappid'])&&!empty($xinge['iosappaccesskey']))
             $data = array('status'=>self::BAO_REQUEST_SUCCESS,'accessid'=>$xinge['iosappid'],'accesskey'=>$xinge['iosappaccesskey']);
             $this->stringify($data);
             break;
            default:
             if(!empty($xinge['appid'])&&!empty($xinge['appaccesskey']))
             $data = array('status'=>self::BAO_REQUEST_SUCCESS,'accessid'=>$xinge['appid'],'accesskey'=>$xinge['appaccesskey']);
             $this->stringify($data);
             break;
        }
        $data = array('status'=>self::BAO_DB_ERROR,'msg'=>'未能成功获取accesskey');
        $this->stringify($data);
	}

	public function cab_app() { //城市地区商圈
        $name = htmlspecialchars($this->_param('name'));
        $data = array();
        $data['city']       = D('City')->fetchAll();
        $data['area']       = D('Area')->fetchAll();
        $data['business']   = D('Business')->fetchAll();
        //header("Content-Type:application/javascript");
		$data = array('status'=>self::BAO_REQUEST_SUCCESS,'cityareas'=>$data);
        $this->stringify($data);
    }
    
	public function cates(){ //店铺团购商品
		$data = array();
		$data['shopcates'] = D('Shopcate')->fetchAll();
		$data['tuancates'] = D('Tuancate')->fetchAll();
		$data['goodscates'] = D('Goodscate')->fetchAll();
        $data['status'] = self::BAO_REQUEST_SUCCESS;
        echo json_encode($data);
        die;
	}
	
    
}