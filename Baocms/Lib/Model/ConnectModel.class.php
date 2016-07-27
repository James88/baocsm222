<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class  ConnectModel extends Model{
    protected $pk   = 'connect_id';
    protected $tableName =  'connect';
    
    public function getConnectByOpenid($type,$open_id){
        
        return $this->find(array("where"=>array(
            'type' => $type,
            'open_id' => $open_id
        )));     
    }
    
    
}