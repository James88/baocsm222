<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class  UsersvisitorsModel extends CommonModel{
    
    protected $pk   = 'visitors_id';
    protected $tableName =  'users_visitors';
    
    //UID 被访用户ID  
    public function  up($uid,$user_id){
        $uid = (int)$uid;
        $user_id = (int)$user_id;
        $data = $this->find(array("where"=>array('uid'=>$uid,'user_id'=>$user_id)));
        if(empty($data)){
            $data = array(
                'uid' => $uid,
                'user_id' => $user_id,
                'last_time'=>NOW_TIME,
            );
            $this->add($data);
        }else{
            $data['last_time'] = NOW_TIME;
            $this->save($data);
        }
        return $data;
    }
    
    public function last($uid,$num){
        $uid = (int)$uid;
        $num = (int)$num;
        $datas = $this->where(array('uid'=>$uid))->order(array('last_time'=>'desc'))->limit(0,$num)->select();
        if(!empty($datas)){
           $last_time = array();
           $uids = array();
           foreach($datas as $val){
               $uids[] = $val['user_id'];
               $last_time[$val['user_id']] = $val['last_time'];
           }
           $users = D('Users')->itemsByIds($uids);
           return array(
               'users'=>$users,
               't'  =>$last_time
           );
        }
        return array();
    }
    
}
