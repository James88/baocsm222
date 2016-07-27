<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class LifeAction extends CommonAction {
    private $edit_fields = array('title', 'cate_id','city_id', 'area_id', 'business_id', 'user_id', 'is_shop', 'text1', 'text2', 'text3', 'num1', 'num2', 'select1', 'select2', 'select3', 'select4', 'select5', 'urgent_date', 'top_date', 'photo', 'contact', 'mobile', 'qq', 'addr', 'views', 'lng', 'lat');

    protected $cates = array();
    private $create_fields = array('title','city_id', 'area_id', 'business_id', 'text1', 'text2', 'text3', 'num1', 'num2', 'select1', 'select2', 'select3', 'select4', 'select5', 'photo', 'contact', 'mobile', 'qq', 'addr', 'lng', 'lat');

    public function _initialize() {
        parent::_initialize();
        $this->cates = D('Lifecate')->fetchAll();
        $this->assign('cates', $this->cates);
    }

    public function main() {
        $this->assign('tops', D('Life')->randTop());
        $this->assign('attrs', D('Lifecateattr')->fetchAll());
        $this->assign('channelmeans', D('Lifecate')->getChannelMeans());
        $this->display();
    }
 
    public function detail($life_id) {
        $life_id = (int) $life_id;
        if (empty($life_id)) {
            $this->error('很抱歉该信息不存在');
        }
        if (!$detail = D('Life')->find($life_id)) {
            $this->error('很抱歉该信息不存在');
        }
        if ($detail['audit'] != 1) {
            $this->error('很抱歉该信息不存在');
        }
        $this->assign('user', D('Users')->find($detail['user_id']));
        $this->assign('cate', $this->cates[$detail['cate_id']]);
        $this->assign('detail', $detail);
        $this->assign('pics', D('Lifephoto')->getPics($detail['life_id']));
        $this->assign('ex', D('Lifedetails')->find($detail['life_id']));
        $attrs = D('Lifecateattr')->getAttrs($detail['cate_id']);
        D('Life')->updateCount($life_id, 'views');
        $this->assign('channel', $this->cates[$detail['cate_id']]['channel_id']);
        $this->assign('attrs', $attrs);
        $this->seodatas['title'] = $detail['title'];
        $this->assign('list', D('Life')->where(array('user_id' => $detail['user_id'], 'audit' => 1, 'life_id' => array('NEQ', $life_id)))->limit(0, 5)->order('last_time desc')->select());
        $this->display();
    }

    public function love($life_id) {
        if (empty($this->uid)) {
            $this->ajaxLogin();
        }
        $life_id = (int) $life_id;
        if (!$detail = D('Life')->find($life_id)) {
            $this->baoError('该信息不存在');
        }
        if (D('Lifelove')->check($life_id, $this->uid)) {
            $this->baoError('您已经收藏过了！');
        }
        $arr = array(
            'user_id' => $this->uid,
            'life_id' => $life_id,
            'create_time' => NOW_TIME,
            'create_ip' => get_client_ip()
        );
        D('Lifelove')->add($arr);
        $this->baoSuccess('收藏成功', U('life/detail', array('life_id' => $life_id)));
    }

    public function report($life_id) {
        if (empty($this->uid)) {
            $this->ajaxLogin();
        }
        $life_id = (int) $life_id;
        if (!$detail = D('Life')->find($life_id)) {
            $this->baoError('该信息不存在');
        }
        if (D('Lifereport')->check($life_id, $this->uid)) {
            $this->baoError('您已经举报过了！');
        }
        $arr = array(
            'user_id' => $this->uid,
            'life_id' => $life_id,
            'create_time' => NOW_TIME,
            'create_ip' => get_client_ip()
        );
        D('Lifereport')->add($arr);
        $this->baoSuccess('举报成功', U('life/detail', array('life_id' => $life_id)));
    }

    public function index() {
        $Life = D('Life');
        import('ORG.Util.Page'); // 导入分页类
        $linkArr = array();
        $map = array('audit'=>1,'city_id'=>$this->city_id);
        $keyword = $this->_param('keyword');
        if ($keyword) {
            $map['qq|mobile|contact|title'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword', $keyword);
            $linkArr['keyword'] = $keyword;
        }
        $areas = D('Area')->fetchAll();
        if ($area_id = (int) $this->_param('area')) {
            $map['area_id'] = $area_id;
            $this->assign('area', $area_id);
            $this->seodatas['area_name'] = $areas[$area_id]['area_name'];
            $linkArr['area'] = $area_id;
        }
        if ($channel = (int) $this->_param('channel')) {
            $cates_ids = array();
            foreach ($this->cates as $val) {
                if ($val['channel_id'] == $channel) {
                    $cates_ids[] = $val['cate_id'];
                }
            }
            if (!empty($cates_ids))
                $map['cate_id'] = array('IN', $cates_ids); //这个保留 因为下面有 cate_id 的时候 会覆盖条件

            $this->assign('channel', $channel);
            $linkArr['channel'] = $channel;
        }
        if ($cate_id = (int) $this->_param('cat')) {
            if ($cate = $this->cates[$cate_id]) {
                $map['cate_id'] = $cate_id;
                $this->assign('cat', $cate_id);
                $linkArr['cat'] = $cate_id;
                $this->assign('cate', $cate);
                $this->assign('channel', $cate['channel_id']);
                $attrs = D('Lifecateattr')->getAttrs($cate_id);
                for ($i = 1; $i <= 5; $i++) {
                    if (!empty($cate['select' . $i])) {
                        $s{$i} = (int) $this->_param('s' . $i);
                        if ($attrs['select' . $i][$s{$i}]) {
                            $this->assign('s' . $i, $s{$i});
                            $linkArr['s' . $i] = $s{$i};
                        }
                    }
                }
                $this->assign('attrs', $attrs);
            }
        }
        if ($business_id = (int) $this->_param('business')) {
            $map['business_id'] = $business_id;
            $this->assign('business', $business_id);
            $this->seodatas['business_name'] = $this->bizs[$business_id]['business_name'];
            $linkArr['business'] = $business_id;
        }
        $count = $Life->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 25); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $Life->where($map)->order(array('top_date' => 'desc', 'last_time' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();


        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->assign('channelmeans', D('Lifecate')->getChannelMeans());
        $this->assign('linkArr', $linkArr);
        $this->assign('tops', D('Life')->randTop());
        $this->display();
    }

    public function rand() {
        $this->assign('tops', D('Life')->randTop());
        $this->display();
    }

    public function fabu() {
        $this->assign('channelmeans', D('Lifecate')->getChannelMeans());
        $this->display();
    }

    public function create($cat) {
        $cat = (int) $cat;
        if (empty($cat)) {
            $this->error('请选择分类');
        }
        if (!$cate = $this->cates[$cat]) {
            $this->error('请选择正确分类');
        }

        if ($this->isPost()) {
            if (empty($this->uid)) {
                $this->ajaxLogin();
            }

            $data = $this->createCheck();
            $shop = D('Shop')->find(array("where" => array('user_id' => $this->uid, 'closed' => 0, 'audit' => 1)));
            if ($shop) {
                $data['is_shop'] = 1;
            }
            $data['user_id'] = $this->uid;
            $data['cate_id'] = $cat;
            $details = $this->_post('details', 'SecurityEditorHtml');
            if ($words = D('Sensitive')->checkWords($details)) {
                $this->baoAlert('商家介绍含有敏感词：' . $words);
            }
            if ($life_id = D('Life')->add($data)) {
                $photos = $this->_post('photos', false);
                if (!empty($photos)) {
                    D('Lifephoto')->upload($life_id, $photos);
                }
                if ($details) {
                    D('Lifedetails')->updateDetails($life_id, $details);
                }
                $this->baoSuccess('发布信息成功，通过审核后将会显示！', U('member/life/index'));
            }
            $this->baoError('发布信息失败！');
        } else {
            $this->assign('channelmeans', D('Lifecate')->getChannelMeans());
            $this->assign('cate', $cate);
            $this->assign('attrs', D('Lifecateattr')->getAttrs($cat));
            $lat = $this->_get('lat', 'htmlspecialchars');
            $lng = $this->_get('lng', 'htmlspecialchars');

            $this->assign('lat', $lat ? $lat : $this->city['lat']);
            $this->assign('lng', $lng ? $lng : $this->city['lng']);
            $this->display();
        }
    }

    private function createCheck() {
        $data = $this->checkFields($this->_post('data', false), $this->create_fields);
        $data['title'] = htmlspecialchars($data['title']);
        if (empty($data['title'])) {
            $this->baoError('标题不能为空');
        }
         $data['city_id'] = (int) $data['city_id'];
        if (empty($data['city_id'])) {
            $this->baoError('城市不能为空');
        }
        $data['area_id'] = (int) $data['area_id'];
        if (empty($data['area_id'])) {
            $this->baoError('地区不能为空');
        }
        $data['business_id'] = (int) $data['business_id'];
        if (empty($data['business_id'])) {
            $this->baoError('商圈不能为空');
        }
        $data['text1'] = htmlspecialchars($data['text1']);
        $data['text2'] = htmlspecialchars($data['text2']);
        $data['text3'] = htmlspecialchars($data['text3']);
        $data['num1'] = (int) $data['num1'];
        $data['num2'] = (int) $data['num2'];
        $data['select1'] = (int) $data['select1'];
        $data['select2'] = (int) $data['select2'];
        $data['select3'] = (int) $data['select3'];
        $data['select4'] = (int) $data['select4'];
        $data['select5'] = (int) $data['select5'];
        $data['urgent_date'] = TODAY;
        $data['top_date'] = TODAY;
        $data['photo'] = htmlspecialchars($data['photo']);
        if (!empty($data['photo']) && !isImage($data['photo'])) {
            $this->baoError('缩略图格式不正确');
        }
        $data['contact'] = htmlspecialchars($data['contact']);
        if (empty($data['contact'])) {
            $this->baoError('联系人不能为空');
        } $data['mobile'] = htmlspecialchars($data['mobile']);
        if (empty($data['mobile'])) {
            $this->baoError('电话不能为空');
        }
        if (!isMobile($data['mobile']) && !isPhone($data['mobile'])) {
            $this->baoError('电话格式不正确');
        }
        $data['qq'] = htmlspecialchars($data['qq']);
        $data['addr'] = htmlspecialchars($data['addr']);
        $data['lng'] = htmlspecialchars(trim($data['lng']));
        $data['lat'] = htmlspecialchars(trim($data['lat']));
        $data['views'] = (int) $data['views'];
        $data['create_time'] = NOW_TIME;
        $data['last_time'] = NOW_TIME + 86400 * 30;
        $data['create_ip'] = get_client_ip();
        return $data;
    }
}
