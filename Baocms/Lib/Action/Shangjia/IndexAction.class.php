<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class IndexAction extends CommonAction {

    public function index() {
        $this->display();
    }

    public function main() {
        $counts = array();
        $bg_time = strtotime(TODAY);
        $counts['totay_order'] = (int) D('Tuanorder')->where(array(
                    'shop_id' => $this->shop_id,
                    'create_time' => array(
                        array('ELT', NOW_TIME),
                        array('EGT', $bg_time),
                    ), 'status' => array(
                        'EGT', 0
                    ),
                ))->count();
        $counts['order'] = (int) D('Tuanorder')->where(array(
                    'shop_id' => $this->shop_id,
                    'status' => array(
                        'EGT', 0
                    ),
                ))->count();

        $counts['today_yuyue'] = (int) D('Shopyuyue')->where(array(
                    'shop_id' => $this->shop_id,
                    'create_time' => array(
                        array('ELT', NOW_TIME),
                        array('EGT', $bg_time),
            )))->count();
        $counts['yuyue'] = (int) D('Shopyuyue')->where(array(
                    'shop_id' => $this->shop_id,
                    'create_time' => array(
                        array('ELT', NOW_TIME),
                        array('EGT', $bg_time),
            )))->count();


        $counts['today_coupon'] = (int) D('Coupondownload')->where(array(
                    'shop_id' => $this->shop_id,
                    'create_time' => array(
                        array('ELT', NOW_TIME),
                        array('EGT', $bg_time),
            )))->count();
        $counts['coupon'] = (int) D('Coupondownload')->where(array(
                    'shop_id' => $this->shop_id,
                ))->count();
        $counts['dianping'] = (int) D('Shopdianping')->where(array(
                    'shop_id' => $this->shop_id,
                ))->count();

        $counts['orderby'] = (int) D('Shop')->where(array(
                    'ranking' => array(
                        'EGT', $this->shop['ranking']
                    )
                ))->count();

        $this->assign('counts', $counts);
        
        /* 统计抢购 */
        $bg_date = date('Y-m-d', NOW_TIME - 86400 * 6);
        $end_date = TODAY;
        $bg_time = strtotime($bg_date);
        $end_time = strtotime($end_date);
        $this->assign('bg_date', $bg_date);
        $this->assign('end_date', $end_date);
        $this->assign('money', D('Tuanorder')->money($bg_time, $end_time, $this->shop_id));
        $this->assign('ordermoney', D('Order')->money($bg_time, $end_time, $this->shop_id));
        $this->assign('shopmoney', D('Shopmoney')->money($bg_time, $end_time, $this->shop_id));
        $this->display();
    }

}
