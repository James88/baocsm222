<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class  UsersexModel extends  CommonModel{
     protected $pk   = 'user_id';
     protected $tableName =  'users_ex';
    
     public function getUserex($user_id){
         $user_id = (int)$user_id;
         $data = $this->find($user_id);
         if(empty($data)){
             $data = array(
                 'user_id'  =>$user_id,
                 'last_uid' => 0,
                 'views'    => 0
             );
             $this->add($data);
         }
         return $data;
     }
    
}