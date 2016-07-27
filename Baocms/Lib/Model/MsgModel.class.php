<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class MsgModel extends CommonModel{
    protected $pk   = 'msg_id';
    protected $tableName =  'msg';
    
    protected $types = array(
        'gift'      => '红包礼物',
        'movie'     => '电影资讯',
        'message'   => '个人消息',
        'coupon'    => '抢购优惠',
    );
    
    public function getType(){
        return $this->types;
    }
    
}