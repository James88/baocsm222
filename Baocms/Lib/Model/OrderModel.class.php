<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class OrderModel extends CommonModel{
    
    protected $pk   = 'order_id';
    protected $tableName =  'order';
    
    protected $types = array(
            0 => '等待付款',
            1 => '等待发货',
            2 => '仓库已捡货',
            8 => '已完成配送', 
    );
    
    public function getType(){
        return $this->types;
    }
    
    public function money($bg_time,$end_time,$shop_id){      
        $bg_time   = (int)$bg_time;
        $end_time  = (int)$end_time;
        $shop_id = (int) $shop_id;
        if(!empty($shop_id)){
            $data = $this->query(" SELECT sum(total_price)/100 as price,FROM_UNIXTIME(create_time,'%m%d') as d from  ".$this->getTableName()."   where status=8 AND create_time >= '{$bg_time}' AND create_time <= '{$end_time}' AND shop_id = '{$shop_id}'  group by  FROM_UNIXTIME(create_time,'%m%d')");   
        }else{
            $data = $this->query(" SELECT sum(total_price)/100 as price,FROM_UNIXTIME(create_time,'%m%d') as d from  ".$this->getTableName()."   where status=8 AND create_time >= '{$bg_time}' AND create_time <= '{$end_time}'  group by  FROM_UNIXTIME(create_time,'%m%d')");      
        }
        $showdata = array();
        $days = array();
        
        for($i=$bg_time;$i<=$end_time;$i+=86400){
            $days[date('md',$i)] = '\''.date('m月d日',$i).'\''; 
        }
        $price = array();
        foreach($days  as $k=>$v){
            $price[$k] = 0;
            foreach($data as $val){
                if($val['d'] == $k){
                    $price[$k] = $val['price'];
                }
            }
        }
       $showdata['d'] = join(',',$days);
       $showdata['price'] = join(',',$price);
        return $showdata;
    }
    
}