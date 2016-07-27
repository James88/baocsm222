<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class EledianpingModel extends CommonModel {

    protected $pk = 'order_id';
    protected $tableName = 'ele_dianping';

    public function check($order_id, $user_id) {
        $data = $this->find(array('where' => array('order_id' => (int) $order_id, 'user_id' => (int) $user_id)));
        return $this->_format($data);
    }

}