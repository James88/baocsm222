<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class IndexAction extends CommonAction{
    
     public function index(){
         $menu = D('Menu')->fetchAll();
         if ($this->_admin['role_id'] != 1) {
            if ($this->_admin['menu_list']) {
                foreach ($menu as $k => $val) {
                    if (!empty($val['menu_action']) && !in_array($k, $this->_admin['menu_list'])) {
                        unset($menu[$k]);
                    }
                }
                foreach ($menu as $k1 => $v1) {
                    if ($v1['parent_id'] == 0) {
                        foreach ($menu as $k2 => $v2) {
                            if ($v2['parent_id'] == $v1['menu_id']) {
                                $unset = true;
                                foreach ($menu as $k3 => $v3) {
                                    if ($v3['parent_id'] == $v2['menu_id']) {
                                        $unset = false;
                                    }
                                }
                                if ($unset)
                                    unset($menu[$k2]);
                            }
                        }
                    }
                }
                foreach ($menu as $k1 => $v1) {
                    if ($v1['parent_id'] == 0) {
                        $unset = true;
                        foreach ($menu as $k2 => $v2) {
                            if ($v2['parent_id'] == $v1['menu_id']) {
                                $unset = false;
                            }
                        }
                        if ($unset)
                            unset($menu[$k1]);
                    }
                }
            }else {
                $menu = array();
            }
        }
         $this->assign('menuList',$menu);
         $this->display();
     }
     
     public function main(){
        $bg_time = strtotime(TODAY);
        $counts['totay_order'] = (int)D('Order')->where(array(
            'type' => 'goods',
            'create_time'=> array(
                array('ELT',NOW_TIME),
                array('EGT',$bg_time),
            ),'status' => array(
                'EGT',0
            ),
        ))->count();
        $counts['order'] = (int)D('Order')->where(array(
            'type' => 'goods',
           'status' => array(
                'EGT',0
            ),
        ))->count();
        
        $counts['totay_gold'] = (int)D('Order')->where(array(
            'type' => 'gold',
            'create_time'=> array(
                array('ELT',NOW_TIME),
                array('EGT',$bg_time),
            ),'status' => array(
                'EGT',0
            ),
        ))->count();
        $counts['gold'] = (int)D('Order')->where(array(
            'type' => 'gold',
           'status' => array(
                'EGT',0
            ),
        ))->count();
        
        $counts['today_yuyue'] = (int)D('Shopyuyue')->where(array(
            'create_time'=> array(
                array('ELT',NOW_TIME),
                array('EGT',$bg_time),
            )))->count();
         $counts['yuyue'] = (int)D('Shopyuyue')->where(array(
            'create_time'=> array(
                array('ELT',NOW_TIME),
                array('EGT',$bg_time),
            )))->count();
         
         
         $counts['today_coupon'] = (int)D('Coupondownload')->where(array(
                 'create_time'=> array(
                array('ELT',NOW_TIME),
                array('EGT',$bg_time),
            )))->count();
         $counts['coupon'] = (int)D('Coupondownload')->count();
         $counts['dianping'] = (int)D('Shopdianping')->count();
         $counts['users'] = (int)D('Users')->count();
         $counts['shops'] = (int)D('Shop')->count();
         $counts['post'] = (int)D('Post')->count();
         $v = require BASE_PATH.'/version.php';//
         $this->assign('v',$v);
         $this->assign('counts',$counts);
         $this->display();
     }
     
     public function check(){ //后期获得通知使用！
         die('1');
     }
     
}