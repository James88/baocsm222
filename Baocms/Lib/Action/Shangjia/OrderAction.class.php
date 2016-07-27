<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class OrderAction extends CommonAction {
    
    private function check_weidian(){
        
        $wd = D('WeidianDetails');
        $wd_res = $wd->where('shop_id ='.($this->shop_id)) -> find();
        if(!$wd_res){
            $this->error('请先完善微店资料！',U('goods/weidian'));
        }elseif($wd_res['audit'] == 0){
            $this->error('您的微店正在审核中，请耐心等待！',U('index/index'));
        }elseif($wd_res['audit'] == 2){
            $this->error('您的微店未通过审核！',U('index/index'));
        }
        
    }
    
    public function index(){
        $this->check_weidian();
        $Ordergoods = D('Ordergoods');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('shop_id' => $this->shop_id);
        if (($bg_date = $this->_param('bg_date', 'htmlspecialchars') ) && ($end_date = $this->_param('end_date', 'htmlspecialchars'))) {
            $bg_time = strtotime($bg_date);
            $end_time = strtotime($end_date);
            $map['create_time'] = array(array('ELT', $end_time), array('EGT', $bg_time));
            $this->assign('bg_date', $bg_date);
            $this->assign('end_date', $end_date);
        } else {
            if ($bg_date = $this->_param('bg_date', 'htmlspecialchars')) {
                $bg_time = strtotime($bg_date);
                $this->assign('bg_date', $bg_date);
                $map['create_time'] = array('EGT', $bg_time);
            }
            if ($end_date = $this->_param('end_date', 'htmlspecialchars')) {
                $end_time = strtotime($end_date);
                $this->assign('end_date', $end_date);
                $map['create_time'] = array('ELT', $end_time);
            }
        }

        if ($keyword = $this->_param('keyword', 'htmlspecialchars')) {
            $map['order_id'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword', $keyword);
        }
        
        $count = $Ordergoods->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 15); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $Ordergoods->where($map)->order(array('id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $goods_ids = array();
        $order_ids = array();
        foreach($list as $val){
            $goods_ids[$val['goods_id']] = $val['goods_id'];
            $order_ids[$val['order_id']] = $val['order_id'];
        }
        $this->assign('orders',D('Order')->itemsByIds($order_ids));
        $this->assign('goods',D('Goods')->itemsByIds($goods_ids));
        $this->assign('types',D('Ordergoods')->getType());
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板
    }
    
    public function wait() {
        $this->check_weidian();
        if(empty($this->shop['is_pei'])){
            $this->error('您签订的是由配送员配送！您管理不了订单！');
        }
        $Order = D('Order');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('closed' => 0, 'status' => 1,'shop_id'=>  $this->shop_id,'is_shop'=>1);
        $keyword = $this->_param('keyword', 'htmlspecialchars');
        if ($keyword) {
            $map['order_id'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword', $keyword);
        }

        if (($bg_date = $this->_param('bg_date', 'htmlspecialchars') ) && ($end_date = $this->_param('end_date', 'htmlspecialchars'))) {
            $bg_time = strtotime($bg_date);
            $end_time = strtotime($end_date);
            $map['create_time'] = array(array('ELT', $end_time), array('EGT', $bg_time));
            $this->assign('bg_date', $bg_date);
            $this->assign('end_date', $end_date);
        } else {
            if ($bg_date = $this->_param('bg_date', 'htmlspecialchars')) {
                $bg_time = strtotime($bg_date);
                $this->assign('bg_date', $bg_date);
                $map['create_time'] = array('EGT', $bg_time);
            }
            if ($end_date = $this->_param('end_date', 'htmlspecialchars')) {
                $end_time = strtotime($end_date);
                $this->assign('end_date', $end_date);
                $map['create_time'] = array('ELT', $end_time);
            }
        }
        
        // var_dump($map);die();
        $count = $Order->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 10); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $Order->where($map)->order(array('order_id' => 'asc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        //print_r($Order->getLastSql());
        $user_ids = $order_ids  = $addr_ids = array();
        foreach ($list as $key => $val) {
            $user_ids[$val['user_id']] = $val['user_id'];
            $order_ids[$val['order_id']] = $val['order_id'];
            $addr_ids[$val['addr_id']] = $val['addr_id'];
 
        }
        if (!empty($order_ids)) {
            $goods = D('Ordergoods')->where(array('order_id' => array('IN', $order_ids)))->select();
            $goods_ids = array();
            foreach ($goods as $val) {
                $goods_ids[$val['goods_id']] = $val['goods_id'];
            }
            $this->assign('goods', $goods);
            $this->assign('products', D('Goods')->itemsByIds($goods_ids));
        }
        $this->assign('addrs', D('Useraddr')->itemsByIds($addr_ids));
        $this->assign('areas', D('Area')->fetchAll());
        $this->assign('business', D('Business')->fetchAll());
        $this->assign('users', D('Users')->itemsByIds($user_ids));
        $this->assign('types', D('Order')->getType());
        $this->assign('goodtypes', D('Ordergoods')->getType());
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->assign('picks', session('order'));
        $this->display(); // 输出模板
    }
    
    
    public function wait2() {
        $this->check_weidian();
          if(empty($this->shop['is_pei'])){
            $this->error('您签订的是由配送员配送！您管理不了订单！');
        }
        $Order = D('Order');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('closed' =>0, 'status' =>0, 'is_daofu' =>1,'shop_id'=>$this->shop_id,'is_shop'=>1);
        $keyword = $this->_param('keyword', 'htmlspecialchars');
        if($keyword){
            $map['order_id'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword', $keyword);
        }

        if (($bg_date = $this->_param('bg_date', 'htmlspecialchars') ) && ($end_date = $this->_param('end_date', 'htmlspecialchars'))) {
            $bg_time = strtotime($bg_date);
            $end_time = strtotime($end_date);
            $map['create_time'] = array(array('ELT', $end_time), array('EGT', $bg_time));
            $this->assign('bg_date', $bg_date);
            $this->assign('end_date', $end_date);
        } else {
            if ($bg_date = $this->_param('bg_date', 'htmlspecialchars')) {
                $bg_time = strtotime($bg_date);
                $this->assign('bg_date', $bg_date);
                $map['create_time'] = array('EGT', $bg_time);
            }
            if ($end_date = $this->_param('end_date', 'htmlspecialchars')) {
                $end_time = strtotime($end_date);
                $this->assign('end_date', $end_date);
                $map['create_time'] = array('ELT', $end_time);
            }
        }
        
        // var_dump($map);die();
        $count = $Order->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 10); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $Order->where($map)->order(array('order_id' => 'asc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $user_ids = $order_ids  = $addr_ids = array();
        foreach ($list as $key => $val) {
            $user_ids[$val['user_id']] = $val['user_id'];
            $order_ids[$val['order_id']] = $val['order_id'];
            $addr_ids[$val['addr_id']] = $val['addr_id'];
 
        }
        if (!empty($order_ids)) {
            $goods = D('Ordergoods')->where(array('order_id' => array('IN', $order_ids)))->select();
            $goods_ids = array();
            foreach ($goods as $val) {
                $goods_ids[$val['goods_id']] = $val['goods_id'];
            }
            $this->assign('goods', $goods);
            $this->assign('products', D('Goods')->itemsByIds($goods_ids));
        }
        $this->assign('addrs', D('Useraddr')->itemsByIds($addr_ids));
        $this->assign('areas', D('Area')->fetchAll());
        $this->assign('business', D('Business')->fetchAll());
        $this->assign('users', D('Users')->itemsByIds($user_ids));
        $this->assign('types', D('Order')->getType());
        $this->assign('goodtypes', D('Ordergoods')->getType());
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->assign('picks', session('order'));
        $this->display(); // 输出模板
    }
    public function pick() {
        $this->check_weidian();
        $order_ids = session('order');
        $orders = $this->_post('order_id', false);
        foreach ($orders as $val) {
            if ($detail = D('Order')->find($val)) {
                if ($detail['status'] == 1 || ($detail['staus'] == 0 && $detail['is_daofu'] == 1 && $detail['shop_id'] == $this->shop_id)) {
                    $order_ids[$val] = $val;
                }
            }
        }
        session('order', $order_ids);
        if ($this->_get('wait')) {
            $this->baoSuccess('加入捡货单成功！', U('order/wait2'));
        } else {
            $this->baoSuccess('加入捡货单成功！', U('order/wait'));
        }
    }

    public function clean() {
        $this->check_weidian();
        session('order', null);
        if ($this->_get('wait')) {
            $this->baoSuccess('清空捡货队列成功！', U('order/wait2'));
        } else {
            $this->baoSuccess('清空捡货队列成功！', U('order/wait'));
        }
    }
    
     //创建捡货单
    public function create() {
        $this->check_weidian();
        $order_ids = session('order');
        $local = array();
        foreach ($order_ids as $val) {
            if ($detail = D('Order')->find($val)) {
                if ($detail['status'] == 1 || ($detail['staus'] == 0 && $detail['is_daofu'] == 1  && $detail['shop_id'] == $this->shop_id)) {
                    $local[$val] = $val;
                }
            }
        }
        if (empty($local)) {
            $this->baoError('请选择要加入捡货的订单！');
        }

        $data = array(
            'admin_id' => 0,
            'shop_id' => $this->shop_id,
            'create_time' => NOW_TIME,
            'create_ip' => get_client_ip(),
            'order_ids' => join(',', $local),
            'name' => '捡货单' . date('Y-m-d H:i:s'),
        );
        if ($pick_id = D('Orderpick')->add($data)) {
            D('Order')->save(array('status' => 2), array("where" => array('order_id' => array('IN', $local))));
            D('Ordergoods')->save(array('status' => 1), array("where" => array('order_id' => array('IN', $local))));
            session('order', null);
            $this->baoSuccess('创建捡货单成功！', U('order/pickdetail', array('pick_id' => $pick_id)));
        }
        $this->baoError('创建捡货单失败');
    }
    
    
      public function pickdetail($pick_id) {
          $this->check_weidian();
        $pick_id = (int) $pick_id;
        $pick = D('Orderpick')->find($pick_id);
        if($pick['shop_id'] != $this->shop_id){
            $this->error('请不要恶意操作其他人的订单！');
        }
        $orderids = explode(',', $pick['order_ids']);

        $Order = D('Order');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('order_id' => array('IN', $orderids));
        $list = $Order->where($map)->order(array('order_id' => 'asc'))->select();
        $user_ids = $order_ids = $addr_ids = array();
        foreach ($list as $key => $val) {
            $user_ids[$val['user_id']] = $val['user_id'];
            $order_ids[$val['order_id']] = $val['order_id'];
            $addr_ids[$val['addr_id']] = $val['addr_id'];
        }
        if (!empty($order_ids)) {
            $goods = D('Ordergoods')->where(array('order_id' => array('IN', $order_ids)))->select();
            $goods_ids  = array();
            foreach ($goods as $val) {
                $goods_ids[$val['goods_id']] = $val['goods_id'];
            }
            $this->assign('goods', $goods);
            $this->assign('products', D('Goods')->itemsByIds($goods_ids));
        }
        $this->assign('addrs', D('Useraddr')->itemsByIds($addr_ids));
        $this->assign('areas', D('Area')->fetchAll());
        $this->assign('business', D('Business')->fetchAll());
        $this->assign('users', D('Users')->itemsByIds($user_ids));
        $this->assign('types', D('Order')->getType());
        $this->assign('goodtypes', D('Ordergoods')->getType());
        $this->display();
    }
    
    
    
    public function count(){
        
        $dvo = D('DeliveryOrder'); // 实例化User对象
        $bg_date = strtotime(I('bg_date',0,'trim'));
        $end_date = strtotime(I('end_date',0,'trim'));
        $this->assign('btime',$bg_date);
        $this->assign('etime',$end_date);
        
        if($bg_date && $end_date){
            $pre_btime = date('Y-m-d H:i:s',$bg_date);
            $pre_etime = date('Y-m-d H:i:s',$end_date);
            $this->assign('pre_btime',$pre_btime);
            $this->assign('pre_etime',$pre_etime);
        }
        
        $map = array();
        $map['shop_id'] = $this->shop_id;
        $map['type'] = 0;
        if($bg_date && $end_date){
           $map['create_time'] = array('between',array($bg_date,$end_date)); 
        }
        
        import('ORG.Util.Page');// 导入分页类
        $count      = $dvo->where($map)->count();// 查询满足要求的总记录数
        $Page       = new Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $dvo->where($map)->order('order_id desc')->limit($Page->firstRow.','.$Page->listRows)->relation(true)->select();
   
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
       
        $this->display();
        
    }
    
    
    function delivery_count(){
        
        $delivery_id = I('did',0,'intval,trim');
        $btime = I('btime',0,'trim');
        $etime = I('etime',0,'trim');
        
        $map = array();
        if($btime && $etime){
           $map['create_time'] = array('between',array($btime,$etime)); 
        }
  
        if(!$delivery_id || !($this->shop_id)){
            $this->ajaxReturn(array('status'=>'error','message'=>'错误'));
        }else{
            $map['delivery_id'] = $delivery_id;
            $map['shop_id'] = $this->shop_id;
            $map['type'] = 0;
            $count = D('DeliveryOrder') ->where($map)-> count();
            if($count){
                $this->ajaxReturn(array('status'=>'success','count'=>$count));
            }else{
                $this->ajaxReturn(array('status'=>'error','message'=>'错误'));
            }
        }
    }
    
    
    public function picks() {
        $this->check_weidian();
        if(empty($this->shop['is_pei'])){
            //$this->error('您签订的是由配送员配送！您管理不了订单！');
        }
        $Orderpick = D('Orderpick');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('shop_id'=>  $this->shop_id);
        if (($bg_date = $this->_param('bg_date', 'htmlspecialchars') ) && ($end_date = $this->_param('end_date', 'htmlspecialchars'))) {
            $bg_time = strtotime($bg_date);
            $end_time = strtotime($end_date);
            $map['create_time'] = array(array('ELT', $end_time), array('EGT', $bg_time));
            $this->assign('bg_date', $bg_date);
            $this->assign('end_date', $end_date);
        } else {
            if ($bg_date = $this->_param('bg_date', 'htmlspecialchars')) {
                $bg_time = strtotime($bg_date);
                $this->assign('bg_date', $bg_date);
                $map['create_time'] = array('EGT', $bg_time);
            }
            if ($end_date = $this->_param('end_date', 'htmlspecialchars')) {
                $end_time = strtotime($end_date);
                $this->assign('end_date', $end_date);
                $map['create_time'] = array('ELT', $end_time);
            }
        }
        $keyword = $this->_param('keyword', 'htmlspecialchars');
        if ($keyword) {
            $map['name'] = array('LIKE', '%' . $keyword . '%');
        }
        $this->assign('keyword', $keyword);

        $count = $Orderpick->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 25); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $Orderpick->where($map)->order('pick_id desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('keyword', $keyword);
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板        
    }
    
    public function send($pick_id) {
        $this->check_weidian();
        $pick_id = (int) $pick_id;
        $pick = D('Orderpick')->find($pick_id);
        $orderids = explode(',', $pick['order_ids']);
        if($pick['shop_id'] != $this->shop_id){
            $this->error('请不要恶意操作其他人的订单！');
        }
        
        $Order = D('Order');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('order_id' => array('IN', $orderids));

        $list = $Order->where($map)->order(array('order_id' => 'asc'))->select();

        $user_ids = $order_ids  = $addr_ids = array();
        foreach ($list as $key => $val) {
            $user_ids[$val['user_id']] = $val['user_id'];
            $order_ids[$val['order_id']] = $val['order_id'];
            $addr_ids[$val['addr_id']] = $val['addr_id'];
        }
        if (!empty($order_ids)) {
            $goods = D('Ordergoods')->where(array('order_id' => array('IN', $order_ids)))->select();
            $goods_ids = array();
            foreach ($goods as $val) {
                $goods_ids[$val['goods_id']] = $val['goods_id'];
            }
            $this->assign('goods', $goods);
            $this->assign('products', D('Goods')->itemsByIds($goods_ids));
        }
        $this->assign('addrs', D('Useraddr')->itemsByIds($addr_ids));
        $this->assign('areas', D('Area')->fetchAll());
        $this->assign('business', D('Business')->fetchAll());
        $this->assign('users', D('Users')->itemsByIds($user_ids));
        $this->assign('types', D('Order')->getType());
        $this->assign('goodtypes', D('Ordergoods')->getType());
        $this->assign('list', $list);
        $this->display();
    }

	 public function delivery() {
        $this->check_weidian();
        if(empty($this->shop['is_pei'])){
            $this->error('您签订的是由配送员配送！您管理不了订单！');
        }
        $Orderpick = D('Orderpick');
        import('ORG.Util.Page'); // 导入分页类
        $map = array();

        $map = array('closed' => 0, 'status' => 2,'shop_id'=>  $this->shop_id ,'is_shop'=>1);
         if (($bg_date = $this->_param('bg_date', 'htmlspecialchars') ) && ($end_date = $this->_param('end_date', 'htmlspecialchars'))) {
            $bg_time = strtotime($bg_date);
            $end_time = strtotime($end_date);
            $map['create_time'] = array(array('ELT', $end_time), array('EGT', $bg_time));
            $this->assign('bg_date', $bg_date);
            $this->assign('end_date', $end_date);
        } else {
            if ($bg_date = $this->_param('bg_date', 'htmlspecialchars')) {
                $bg_time = strtotime($bg_date);
                $this->assign('bg_date', $bg_date);
                $map['create_time'] = array('EGT', $bg_time);
            }
            if ($end_date = $this->_param('end_date', 'htmlspecialchars')) {
                $end_time = strtotime($end_date);
                $this->assign('end_date', $end_date);
                $map['create_time'] = array('ELT', $end_time);
            }
        }
        $keyword = $this->_param('keyword', 'htmlspecialchars');
        if ($keyword) {
            $map['name'] = array('LIKE', '%' . $keyword . '%');
        }
        $this->assign('keyword', $keyword);
		$Order = D('Order');
        // var_dump($map);die();
        $count = $Order->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 10); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $Order->where($map)->order(array('order_id' => 'asc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $user_ids = $order_ids = $shop_ids = $addr_ids = array();
        foreach ($list as $key => $val) {
            $user_ids[$val['user_id']] = $val['user_id'];
            $order_ids[$val['order_id']] = $val['order_id'];
            $addr_ids[$val['addr_id']] = $val['addr_id'];
            $shop_ids[$val['shop_id']] = $val['shop_id'];
        }
        if (!empty($order_ids)) {
            $goods = D('Ordergoods')->where(array('order_id' => array('IN', $order_ids)))->select();
            $goods_ids = array();
            foreach ($goods as $val) {
                $goods_ids[$val['goods_id']] = $val['goods_id'];
            }
            $this->assign('goods', $goods);
            $this->assign('products', D('Goods')->itemsByIds($goods_ids));
        }
        $this->assign('shops', D('Shop')->itemsByIds($shop_ids));
        $this->assign('addrs', D('Useraddr')->itemsByIds($addr_ids));
        $this->assign('areas', D('Area')->fetchAll());
        $this->assign('business', D('Business')->fetchAll());
        $this->assign('users', D('Users')->itemsByIds($user_ids));
        $this->assign('types', D('Order')->getType());
        $this->assign('goodtypes', D('Ordergoods')->getType());
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->assign('picks', session('order'));
        $this->display(); // 输出模板
    }

	public function distribution() {
		$this->check_weidian();
        if(empty($this->shop['is_pei'])){
            $this->baoError('您签订的是由配送员配送！您管理不了订单！');
        }
        $order_id = (int) $this->_get('order_id');
        if (!$order_id) {
			$this->baoError('参数错误');
		}else if(!$order = D('Order')->find($order_id)){
			$this->baoError('该订单不存在');
		}else if($order['shop_id'] != $this->shop_id){
			$this->baoError('不能管理不是您的订单');
		}else if($order['is_shop'] != 1){
			$this->baoError('该商家不允许');
		}else if($order['status'] != 2){
			$this->baoError('该订单状态不正确，不能发货');
		}else{
            $userobj = D('Users');
			if(D('Order')->save(array('status' => 8, 'order_id' => $order_id))){
				$goods = D('Ordergoods')->where(array('order_id' => $order_id))->select();
				if (!empty($goods)) {
					D('Ordergoods')->save(array('status' => 8), array('where' => array('order_id' => $order_id)));
					if ($order['is_daofu'] == 0) {
						$ip = get_client_ip();
						foreach ($goods as $val) {
							if ($val['status'] == 1) {
								$info = '产品ID' . $val['goods_id'];
								$tg = $userobj->checkInvite($order['user_id'], $val['total_price']);
								if ($tg !== false) { //推广员分层的判断
									$userobj->addIntegral($tg['uid'], $tg['integral'], "分享获得积分！");
								}
								$money = $val['js_price'];
								if ($val['tui_uid']) { //推广员分成
									$gooddetail = D('Goods')->find($val['goods_id']);
									if (!empty($gooddetail['commission']) && $gooddetail['commission'] < $gooddetail['mall_price'] && $gooddetail['commission'] < $val['total_price']) { //小于的情况下才能返利不然你懂的
										$money -= $gooddetail['commission'];
										D('Users')->addMoney($val['tui_uid'], $gooddetail['commission'], '推广佣金');
										$info.='扣除了佣金' . round($gooddetail['commission'] / 100, 2);
									}
								}

								D('Shopmoney')->add(array(
									'shop_id' => $val['shop_id'],
									'money' => $money,
									'create_time' => NOW_TIME,
									'create_ip' => $ip,
									'type' => 'goods',
									'order_id' => $order_id,
									'intro' => $info,
								));
								
								$shop = D('Shop')->find($val['shop_id']);
								D('Users')->addMoney($shop['user_id'], $money, $info);
							}
						}
					}
					$this->baoSuccess('发货成功！', U('order/delivery'));
				}
			}
            $this->baoError('一键发货失败！');
        }
    }
}
