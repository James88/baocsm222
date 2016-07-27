<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class ShopmoneyModel extends CommonModel{
    protected $pk   = 'money_id';
    protected $tableName =  'shop_money';
    
    
    public function sumByIds($bg_date,$end_date,$shop_ids = array()){
        if(empty($shop_ids)) return array();
        $bg_time =  (int) strtotime($bg_date.' 00:00:00');
        $end_time = (int) strtotime($end_date.' 23:59:59');
        $shop_ids = join(',',$shop_ids);
        $datas = $this->query("SELECT  count(1) as num,sum(money) as money from ".$this->getTableName()." where  create_time >= '{$bg_time}' AND  create_time <='{$end_time}' AND shop_id IN({$shop_ids}) ");
        return $datas[0];
    }
      public function sumByIdsTop10($bg_date,$end_date,$shop_ids = array()){
        if(empty($shop_ids)) return array();
        $bg_time =  (int) strtotime($bg_date.' 00:00:00');
        $end_time = (int) strtotime($end_date.' 23:59:59');
        $shop_ids = join(',',$shop_ids);
        $datas = $this->query("SELECT shop_id,sum(money) as money from ".$this->getTableName()." where  create_time >= '{$bg_time}' AND  create_time <='{$end_time}' AND shop_id IN({$shop_ids}) group by  shop_id order by  sum(money) desc limit 0,10 ");
        return $datas;
    }
    
    public function  sum($bg_date,$end_date){
        $bg_time =  (int) strtotime($bg_date.' 00:00:00');
        $end_time = (int) strtotime($end_date.' 23:59:59');
        return $this->query("SELECT  shop_id,sum(money) as money from ".$this->getTableName()." where  create_time >= '{$bg_time}' AND  create_time <='{$end_time}' group by shop_id ");
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