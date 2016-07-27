<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class ElecateModel extends CommonModel{
    protected $pk   = 'cate_id';
    protected $tableName =  'ele_cate';
    
    public function updateNum($cate_id){
        $cate_id = (int) $cate_id;
        $count = D('Eleproduct')->where(array('cate_id'=>$cate_id))->count();
        return $this->save(array(
            'cate_id' => $cate_id,
            'num'     => (int)$count
        ));
    }
    
}