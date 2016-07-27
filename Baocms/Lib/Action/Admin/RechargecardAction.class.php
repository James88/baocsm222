<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class RechargecardAction extends CommonAction {

    private $create_fields = array('card_id', 'name', 'card_key','num', 'value', 'end_date');
    private $edit_fields = array('card_id', 'name', 'card_key', 'value', 'end_date');

    public function index() {
        $Rechargecard = D('Rechargecard');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('end_date' => array('EGT', TODAY));
        $keyword = $this->_param('keyword', 'htmlspecialchars');
        if ($keyword) {
            $map['name'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword', $keyword);
        }

        $count = $Rechargecard->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 15); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $Rechargecard->where($map)->order(array('card_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板
    }

    public function create() {
        if ($this->isPost()) {
            $data = $this->createCheck();
            $obj = D('Rechargecard');
            for ($i = 1; $i < $data['num']; $i++) {
                $val = rand_string(32, '5', '');
                if (!$detail = $obj->where(array('card_key' => $val))->find()) {
                    $datas[$i]['card_key'] = $val;
                }
                $datas[$i]['name'] = $data['name'];
                $datas[$i]['value'] = $data['value']*100;
                $datas[$i]['end_date'] = $data['end_date'];
                $datas[$i]['create_time'] = NOW_TIME;
                $datas[$i]['create_ip'] = get_client_ip();
            }
            foreach ($datas as $key => $val) {
                $card_id = $obj->add($val);
            }
            if (!empty($card_id)) {
                $this->baoSuccess('添加成功', U('rechargecard/index'));
            } else {
                $this->baoError('操作失败！');
            }
        } else {
            $this->display();
        }
    }

    private function createCheck() {
        $data = $this->checkFields($this->_post('data', false), $this->create_fields);
        $data['value'] = (int) $data['value'];
        if(empty($data['value'])){
             $this->baoError('充值卡面额不能为空');
        }
        $data['name'] = htmlspecialchars($data['name']);
        if (empty($data['name'])) {
            $this->baoError('充值卡名称不能为空');
        } 
        $data['num'] = (int) $data['num'];
        if (empty($data['num'])) {
            $this->baoError('添加数量不能为空');
        }$data['end_date'] = htmlspecialchars($data['end_date']);
        if (empty($data['end_date'])) {
            $this->baoError('过期时间不能为空');
        }
        return $data;
    }


    public function delete($card_id = 0) {
        if (is_numeric($card_id) && ($card_id = (int) $card_id)) {
            $obj = D('Rechargecard');
            $obj->delete($card_id);
            $this->baoSuccess('删除成功！', U('rechargecard/index'));
        } else {
            $card_id = $this->_post('card_id', false);
            if (is_array($card_id)) {
                $obj = D('Rechargecard');
                foreach ($card_id as $id) {
                    $obj->delete($id);
                }
                $this->baoSuccess('删除成功！', U('rechargecard/index'));
            }
            $this->baoError('请选择要删除的充值卡');
        }
    }


}
