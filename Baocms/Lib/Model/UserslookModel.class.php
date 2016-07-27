<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */
class  UserslookModel extends CommonModel{
    protected $pk   = 'look_id';
    protected $tableName =  'users_look';
    
    public function look($user_id,$shop_id){
        $user_id = (int)$user_id;
        $shop_id = (int)$shop_id;
        $data = $this->find(array("where"=>array('user_id'=>$user_id,'shop_id'=>$shop_id)));
        if(empty($data)){
            return $this->add(array(
                'user_id'   => $user_id,
                'shop_id'   => $shop_id,
                'last_time' => NOW_TIME
            ));
        }else{
            return $this->save(array(
                'look_id'   => $data['look_id'],
                'last_time' => NOW_TIME
            ));
            
        }        
    }
}
