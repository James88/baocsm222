<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class CommunityAction extends CommonAction {

    // public function index() {
    //     $community_id = cookie('community_id');
    //      if ($community_id && empty($_GET['change'])) {
    //          $this->detail($community_id);
    //          die;
    //      }
    //     $map  = array('community_id'=>$community_id,'closed'=>0,'audit'=>1);
    //     $news = D('Communitynews')->where($map)->order('create_time DESC')->limit(10)->select();
    //     $this->assign('news',$news);

    //     $phones = D('Convenientphonemaps')->alias('cpm')
    //     ->join("RIGHT JOIN bao_convenient_phone cp ON cpm.phone_id=cp.phone_id")
    //     ->where("cpm.community_id={$community_id}")->limit(5)->select();
    //     $this->assign('phones',$phones);

    //     $goods = D('Goods')->limit(18)->select();
    //     $keys  = array_keys($goods);shuffle($keys);
    //     $this->assign('goods',$goods);
    //     $this->assign('keys',$keys);
    //     $this->assign('community_id',$community_id);
    //     $this->display(); // 输出模板 
    // }

    public function index() {
        $community_id = cookie('community_id');
        if ($community_id && empty($_GET['change'])) {
            $this->detail($community_id);
            die;
        }
        $keyword = $this->_param('keyword', 'htmlspecialchars');
        $this->assign('keyword', $keyword);
        //$areas = D('Area')->fetchAll();
        //$this->assign('areas', $areas);
        $area = (int) $this->_param('area');
        $this->assign('area_id', $area);
        $this->assign('nextpage', LinkTo('community/loaddata', array('area' => $area, 't' => NOW_TIME,'change'=>'1', 'keyword' => $keyword, 'p' => '0000')));
        $this->display(); // 输出模板 
    }


    public function loaddata() {

        $community = D('Community');
        import('ORG.Util.Page'); // 导入分页类
        //初始数据
        $map = array('closed' => 0,'city_id'=>$this->city_id);
        if ($keyword = $this->_param('keyword', 'htmlspecialchars')) {
            $map['name|addr'] = array('LIKE', '%' . $keyword . '%');
        }
        $area = (int) $this->_param('area');
        if ($area) {
            $map['area_id'] = $area;
        }
        $lat = addslashes(cookie('lat'));
        $lng = addslashes(cookie('lng'));
        if (empty($lat) || empty($lng)) {
            $lat = $this->city['lat'];
            $lng = $this->city['lng'];
        }
        $orderby = " (ABS(lng - '{$lng}') +  ABS(lat - '{$lat}') ) asc ";
        $count = $community->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 8); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出

        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }
        $list = $community->order($orderby)->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->select();

        foreach ($list as $k => $val) {
            $list[$k]['d'] = getDistance($lat, $lng, $val['lat'], $val['lng']);
        }
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板   
    }

    public function detail($community_id) {
        $community_id = (int) $community_id;
        $community = D('Community');
        if (empty($community_id)) {
            $this->error('没有该小区');
            die;
        }
        if (!$detail = $community->find($community_id)) {
            $this->error('没有该小区');
            die;
        }
        if ($detail['closed']) {
            $this->error('该小区已经被删除');
            die;
        }
        cookie('community_id', $community_id, 365 * 86400);
        $phone = D('Convenientphonemaps')->where(array('community_id' => $community_id))->limit(0, 6)->select();
        $phone_ids = array();
        foreach ($phone as $val) {
            $phone_ids[$val['phone_id']] = $val['phone_id'];
        }
        if (!empty($phone_ids)) {
            $this->assign('phones', D('Convenientphone')->itemsByIds($phone_ids));
        }
        $map = array('community_id' => $community_id, 'closed' => 0, 'audit' => 1);
        $news = D('Communitynews')->where($map)->limit(0, 6)->select();

        $this->assign('community_id',$community_id);
        $weicates = $this->CONFIG['weidian'];
        $this->assign('weicates', $weicates);
        $cat = (int) $this->_param('cat');
        $this->assign('cat', $cat);
        $map = array('closed' => 0, 'audit' => 1, 'city_id' => $this->city_id, 'end_date' => array('EGT', TODAY));
        $goods = D('Goods')->where($map)->limit(18)->select();
        $keys  = array_keys($goods);shuffle($keys);
        $this->assign('goods',$goods);
        $this->assign('keys', $keys);
        //$this->assign('nexts', LinkTo('community/loading', array('t' => NOW_TIME, 'cat' => $cat, 'community_id' => $community_id, 'p' => '0000')));
        $this->assign('news', $news);
        $this->assign('detail', $detail);
        $this->display('detail');
    }

    public function loading() {
        $community_id = (int) $this->_param('community_id');
        import('ORG.Util.Page'); // 导入分页类
        $shop = D('Shop');
        $weicates = $this->CONFIG['weidian'];
        $this->assign('weicates', $weicates);
        $map = array('closed' => 0, 'audit' => 1, 'is_mall' => 1);
        $cat = (int) $this->_param('cat');
        if ($cat) {
           $catids = D('Shopcate')->getChildren($cat);
            if (!empty($catids)) {
                $map['cate_id'] = array('IN', $catids);
            } else {
                $map['cate_id'] = $cat;
            }
        }else{
            $map['cate_id'] = $this->CONFIG['weidian']['bianlidian'];
        }
        $lat = $detail['lat'];
        $lng = $detail['lng'];
        if (empty($lat) || empty($lng)) {
            $lat = $this->city['lat'];
            $lng = $this->city['lng'];
        }
        $orderby = " (ABS(lng - '{$lng}') +  ABS(lat - '{$lat}') ) asc ";
        $count = $shop->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 5); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $shop->order($orderby)->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->select();
        foreach ($list as $k => $val) {
            $list[$k]['d'] = getDistance($lat, $lng, $val['lat'], $val['lng']);
        }

        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display();
    }


    public function newslist() {
        $community_id = (int) $this->_param('community_id');
        $this->assign('next', LinkTo('community/load', array('t' => NOW_TIME, 'community_id' => $community_id, 'p' => '0000')));
        $this->display(); // 输出模板
    }

    public function load() {
        $community_id = (int) $this->_param('community_id');
        $news = D('Communitynews');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('closed' => 0, 'audit' => 1);
        $map['community_id'] = $community_id;
        $count = $news->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 8); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出

        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }

        $list = $news->order(array('news_id' => 'desc'))->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板   
    }

    public function news() {
        $news_id = (int) $this->_param('news_id');
        if (!$detail = D('Communitynews')->find($news_id)) {
            $this->error('没有该物业通知');
            die;
        }
        if ($detail['closed']) {
            $this->error('该物业通知已经被删除');
            die;
        }
        if (!$detail['audit']) {
            $this->error('该物业通知未通过审核');
            die;
        }
        D('Communitynews')->updateCount($news_id, 'views');
        $this->assign('detail', $detail);
        $this->display();
    }

    public function feedback($community_id) {
        if (empty($this->uid)) {
            $this->error('登录状态失效!', U('passport/login'));
        }
        $community_id = (int) $community_id;
        if (!$detail = D('Community')->find($community_id)) {
            $this->error('要反馈的小区不存在');
        }
        if (!empty($detail['closed'])) {
            $this->error('要反馈的小区不存在');
        }
        if ($this->isPost()) {
            $data = $this->checkFeed();
            $data['community_id'] = $community_id;
            $data['create_time'] = NOW_TIME;
            $data['create_ip'] = get_client_ip();
            $obj = D('Feedback');
            if ($obj->add($data)) {
                $this->success('反馈提交成功', U('community/detail', array('community_id' => $community_id)));
            }
            $this->error('操作失败！');
        } else {
            $this->assign('community_id', $community_id);
            $this->display();
        }
    }

    public function checkFeed() {
        $data = $this->checkFields($this->_post('data', false), array('title', 'content'));
        $data['user_id'] = (int) $this->uid;
        $data['title'] = $data['title'];
        if (empty($data['title'])) {
            $this->error('标题不能为空');
        }
        $data['content'] = htmlspecialchars($data['content']);
        if (empty($data['content'])) {
            $this->error('反馈内容不能为空');
        }
        if ($words = D('Sensitive')->checkWords($data['content'])) {
            $this->baoError('反馈内容含有敏感词：' . $words);
        }
        return $data;
    }
    //申请合作
    public function together($community_id=null)
    {
        if(!$community_id){
            $this->error('参数不正确！');
        }else if($data=$this->_post('data',false)){
            $data['expiry_date'] = NOW_TIME;
            $data['orderby'] =  0;
            if(empty($data['name'])){
                $this->error('项目名称不能为空！');
            }
            if(empty($data['phone'])){
                $this->error('手机号码不能为空！');
            }
            if($phone_id=D('Convenientphone')->add($data)){
              if(D('Convenientphonemaps')->add(array('phone_id'=>$phone_id,'community_id'=>$community_id))){
                $this->success('您的申请提交成功,等待审核', U('community/index'));
              }else{
                $this->error('申请失败');
              }
            }else{
                $this->error('申请失败');
            }
        }else{
            $this->assign('community_id',$community_id);
            $this->display();    
        }
    }
    //News详情
    public function newsdetail($news_id=null)
    {
        if(!$news_id){
            $this->error('参数不正确!');
        }else{
           $model  = D('Communitynews');
           if($detail = $model->find($news_id)){
                $model->where("news_id={$news_id}")->setInc('views',1);
           };
           $this->assign('detail',$detail);
           $this->display();
        }
    }

}
