<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class AdminModel extends CommonModel{
    protected $pk   = 'admin_id';
    protected $tableName =  'admin';
    
     public function getAdminByUsername($username){
        $data = $this->find(array('where'=>array('username'=>$username)));
        return $this->_format($data);
    }
    
    public  function _format($data){
        static  $roles;
        if(empty($roles)) $roles = D('Role')->fetchAll();
        if(!empty($data)) $data['role_name'] = $roles[$data['role_id']]['role_name'];    
        return $data;
    }
}