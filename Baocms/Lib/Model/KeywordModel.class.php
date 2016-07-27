<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class KeywordModel extends CommonModel {

    protected $pk = 'key_id';
    protected $tableName = 'keyword';

    public function getKeyType() {
        $res = array(
            '0' => '不限',
            '1' => '商家',
            '2' => '抢购',
            '3' => '生活信息',
            '4' => '商品',
            '5' => '分享',
			'6' => '订座',
        );
        return $res;
    }
}
