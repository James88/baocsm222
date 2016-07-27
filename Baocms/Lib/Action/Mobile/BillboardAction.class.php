<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class BillboardAction extends CommonAction {

    protected function _initialize() {
        parent::_initialize();
        $billcate = D('Billcate')->select();
        $this->assign('billcate', $billcate);
    }

    public function index() {
		$cate_id = (int) $this->_param('cate_id'); 
		if($cate_id){
			$arr['cate_id'] = $cate_id;
			$this->assign('cate_id',$cate_id);
		}
		
		$is_hot = (int) $this->_param('is_hot');
		if($is_hot){
			$arr['is_hot'] = $is_hot;
			$this->assign('is_hot',$is_hot);
		}  
        $is_new = (int) $this->_param('is_new');
		if($is_new){
			$arr['is_new'] = $is_new;
			$this->assign('is_new',$is_new);
		}   
        $is_chose = (int) $this->_param('is_chose');
		if($is_chose){
			$arr['is_chose'] = $is_chose;
			$this->assign('is_chose',$is_chose);
		} 
		if($arr){
			$this->assign('nextpage', LinkTo('billboard/loaddata',$arr,array('t' => NOW_TIME,'p' => '0000')));
		}else{
			$this->assign('nextpage', LinkTo('billboard/loaddata',array('t' => NOW_TIME,'p' => '0000')));
		}
        $this->display(); // 输出模板 
    }

	public function loaddata() {
		$Billboard = D('Billboard');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('closed' => 0,);
        $cate_id = (int) $this->_param('cate_id');
        if ($cate_id) {
            $map['cate_id'] = $cate_id;
            $this->seodatas['cate_name'] = $this->billcate[$cate_id]['cate_name'];
        }
		$this->assign('cate_id',$cate_id);
		if ($is_hot = (int) $this->_param('is_hot')) {
            $map['is_hot'] = 1;
        }
        $this->assign('is_hot', $is_hot);
        if ($is_new = (int) $this->_param('is_new')) {
            $map['is_new'] = 1;
        }
        $this->assign('is_new', $is_new);
        if ($is_chose = (int) $this->_param('is_chose')) {
            $map['is_chose'] = 1;
        }
        $this->assign('is_chose', $is_chose);

        $count = $Billboard->where($map)->count(); // 查询满足要求的总记录数 
        $this->assign('count', $count); // 赋值分页输出

        $Page = new Page($count, 8); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
		$var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }
        $list = $Billboard->where($map)->order(array('list_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->assign('count', $count); // 赋值分页输出	
		$this->display();
	}

   public function bddetails($list_id) {
        $list_id = (int)$list_id;
        if(empty($list_id)) {
            $this->error('榜单不存在');
        }
        if(!$detail = D('Billboard')->find($list_id)){
            $this->error('榜单不存在');
        }
        if($detail['closed'] != 0){
            $this->error('榜单不存在');
        }
        $Billshop = D('Billshop');
        $list = $Billshop->where(array('list_id' => $list_id))->order(array('list_id' => 'desc'))->select();
		//echo $Billshop->getLastSql();echo "File:", __FILE__, ',Line:',__LINE__;exit;
        import('ORG.Util.Page'); // 导入分页类
        $count = $Billshop->where(array('list_id' => $list_id))->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 15); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $this->assign('count', $count); // 赋值分页输出
        $list = $Billshop->where(array('list_id' => $list_id))->limit($Page->firstRow . ',' . $Page->listRows)->order(array('list_id' => 'desc'))->select();
        $dianping = D('Shopdianping');
        $users = D('Users');
        $shop_ids = $user_ids = array();
        foreach ($list as $k => $val) {
            $list[$k]['dianping'] = $dianping->order('show_date desc')->find(array('where' => array('shop_id' => $val['shop_id'], 'closed' => 0, 'show_date' => array('ELT', TODAY))));
            $user_ids[$k] = $list[$k]['dianping']['user_id'];
            if ($val['shop_id']) {
                $shop_ids[$val['shop_id']] = $val['shop_id'];
            }
            $result = D('Billvote')->where(array('user_id' => $this->uid, 'bill_id' => $val['bill_id']))->select();
            if (empty($result)) {
                $list[$k]['work'] = 1;
            } else {
                $list[$k]['work'] = 0;
            }
        }
        if (!empty($user_ids)) {
            $this->assign('users', D('Users')->itemsByIds($user_ids));
        }
        $this->assign('billshops', D('Shop')->itemsByIds($shop_ids));
        $this->assign('list', $list); // 赋值数据集
        D('Billboard')->updateCount($list_id, 'looknum');
        $this->assign('billdetail',$detail);
        $this->seodatas['title'] = $detail['title'];
        $this->assign('page', $show); // 赋值分页输出     
        $this->display();
    }

    public function vote($bill_id) {
        if (empty($this->uid)) {
            $this->ajaxLogin();
        }
        $bill_id = (int) $bill_id;
        $bill = D('Billshop')->find($bill_id);
        $board = D('Billboard')->find($bill['list_id']);
        $shops = D('Shop')->find($bill['shop_id']);
        $this->seodatas['title'] = $board['title'];
        $this->seodatas['shop_name'] = $shops['shop_name']; 
        $obj = D('Billvote');
        $detail = $obj->find(array('where' => array('bill_id' => $bill_id, 'user_id' => $this->uid)));
        if (!empty($detail)) {echo "File:", __FILE__, ',Line:',__LINE__;exit;
            $this->baoMsg('您已经投过票了');
        }
        $rel = D('Billshop')->find($bill_id);
        $data['user_id'] = $this->uid;
        $data['bill_id'] = $bill_id;
        if ($obj->add($data)) {
            D('Billshop')->updateCount($bill_id, 'votenum');
            $this->baoMsg('投票成功', U('billboard/bddetails', array('list_id' => $rel['list_id'])));
        }
    }
    
}
