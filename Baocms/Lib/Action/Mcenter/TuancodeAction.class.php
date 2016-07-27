<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class TuancodeAction extends CommonAction {

    public function codeloading() {

        $Tuancode = D('Tuancode');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('user_id' => $this->uid); //这里只显示 实物

        $aready = (int) $this->_param('aready');

        if ($aready == 2) {
            $map['is_used'] = 1;
        } elseif ($aready == 1) {
            $map['status'] = 0;
            $map['is_used'] = 0;
        } else {
            $aready == null;
        }


        if ($order_id = (int) $this->_get('order_id')) {
            $map['order_id'] = $order_id;
        }
        $count = $Tuancode->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 10); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }
        $list = $Tuancode->where($map)->order(array('code_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $tuan_ids = array();
        foreach ($list as $val) {
            $tuan_ids[$val['tuan_id']] = $val['tuan_id'];
        }
        $this->assign('tuans', D('Tuan')->itemsByIds($tuan_ids));
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板
    }

    public function index() {

        $aready = (int) $this->_param('aready');
        $this->assign('aready', $aready);
        $this->display(); // 输出模板
    }

    public function refund($code_id) {
        $code_id = (int) $code_id;
        if ($detail = D('Tuancode')->find($code_id)) {
            if ($detail['user_id'] != $this->uid) {
                $this->error('非法操作');
            }
            if ($detail['status'] != 0 || $detail['is_used'] != 0) {
                $this->error('该抢购券不能申请退款');
            }
            if (D('Tuancode')->save(array('code_id' => $code_id, 'status' => 1))) {
                $this->success('申请成功！等待网站客服处理！', U('tuancode/index'));
            }
        }
        $this->error('操作失败');
    }

    public function weixin() {
        $code_id = $this->_get('code_id');
        if (!$detail = D('Tuancode')->find($code_id)) {
            $this->error('没有该抢购券');
        }
        if ($detail['user_id'] != $this->uid) {
            $this->error("抢购券不存在！");
        }
        if ($detail['status'] != 0 || $detail['is_used'] != 0) {
            $this->error('该抢购券属于不可消费的状态');
        }

        $url = U('weixin/index', array('code_id' => $code_id, 't' => NOW_TIME, 'sign' => md5($code_id . C('AUTH_KEY') . NOW_TIME)));

        $token = 'tuancode_' . $code_id;

        $file = baoQrCode($token, $url);
        $this->assign('file', $file);
        $this->assign('detail', $detail);
        $this->display();
    }

}
