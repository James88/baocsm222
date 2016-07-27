<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class UsersgoodsModel extends CommonModel{
    protected $pk   = 'record_id';
    protected $tableName =  'users_goods';
    
    public function getRecord($user_id,$goods_id){
        if (!empty($user_id)) {
            $result['user_id'] = $user_id;
            $result['goods_id'] = $goods_id;
            $result['record_time'] = NOW_TIME;
            $result['record_ip'] = get_client_ip();
            $res = $this->where(array('user_id' => $user_id, 'goods_id' => $goods_id))->find();
            if (empty($res)) {
                $record_id = $this->add($result);
            } else {
                $result['record_id'] = $res['record_id'];
                $this->save($result);
            }
        }
    }
    
}