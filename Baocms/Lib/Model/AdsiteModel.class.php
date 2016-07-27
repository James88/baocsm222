<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class AdsiteModel extends CommonModel {

    protected $pk = 'site_id';
    protected $tableName = 'ad_site';
    protected $token = 'ad_site';

    public function getType() {
        return array(1 => '文字广告', 2 => '图片广告', 3 => '代码广告');
    }

    public function getPlace() {
        return array(
            1 => 'PC首页',
            2 => 'PC抢购',
            3 => 'PC活动',
            4 => 'PC上门服务',
            5 => 'PC同城优购',
            6 => 'PC外卖',
            7 => 'PC订座',
            8 => 'PC同城信息',
            9 => 'PC优惠券',
            10 => 'PC商家',
            11 => 'PC积分商城',
            12 => 'PC榜单',
            13 => 'PC专题',
            14 => '手机首页',
            15 => '手机抢购',
            16 => '手机商家',
            17 => '手机活动',
            18 => '手机同城优购',
            19 => '手机家政',
            20 => '手机外卖',
            21 => '手机订座',
            22 => '手机附近活动',
            23 => '手机优惠券',
            24 => '手机社区',
            25 => '手机卖场',
            26 => '手机积分商城',
            27 => '手机生活信息',
            28 => '手机推广员',
            29 => '手机微店',
            30 => '手机会员卡',
            31 => '手机榜单',
            32 => '手机附近工作',
            33 => '手机APP首页',
        );
    }

}
