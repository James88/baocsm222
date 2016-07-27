<?php

/****************** 版权声明 ******************************
 *
 *----------------合肥生活宝网络科技有限公司-----------------
 *----------------      www.taobao.com    -----------------
 *QQ:800026911  
 *电话:0551-63641901  
 *EMAIL：youge@baocms.com
 * 
 ***************  未经许可不得用于商业用途  ****************/

class  HouseworkModel  extends  CommonModel{
    protected $pk   = 'housework_id';
    protected $tableName =  'housework';
    
    private  $svcCfg = array(
        1   =>  '家庭保洁',
        2   =>  '新居开荒',
        3   =>  '洗衣洗鞋',
        4   =>  '洗窗帘',
        5   =>  '洗地毯',
        6   =>  '油烟机清洗',
        7   =>  '空调清洗',
        8   =>  '冰箱除臭',
        9   =>  '微波炉清洗',
        10  =>  '电烤箱清洗',
        11  =>  '擦玻璃',
        12  =>  '厨房保养',
        13  =>  '卫生间保养',
        14  =>  '地板打蜡',
        15  =>  '皮质沙发保养',
    );
    
    public function  getCfg(){
        return $this->svcCfg;
    }
    
    
    
    
    
    
}