<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class EleorderModel extends CommonModel{
    protected $pk   = 'order_id';
    protected $tableName =  'ele_order';
    
    protected $cfg = array(
                     0 => '等待付款',
                     1 => '等待审核',
                     2 => '正在配送',
                     8 => '已完成',
                    );


    public function checkIsNew($uid,$shop_id){
        $uid = (int)$uid;
        $shop_id =(int) $shop_id;
        return $this->where(array('uid'=>$uid,'shop_id'=>$shop_id))->count();
    }
     
    public function getCfg(){
        return $this->cfg;
    }
}