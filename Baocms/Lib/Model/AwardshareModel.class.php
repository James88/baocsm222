<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class  AwardshareModel  extends  CommonModel{
    protected $pk   = 'id';
    protected $tableName =  'award_share';
    
    public function  getdata($award_id){
        $award_id = (int)$award_id;
        $ip = get_client_ip();
        if(!$data=$this->find(array('where'=>array('award_id'=>$award_id,'ip'=>$ip)))){
            $data = array(
                'award_id'=>$award_id,
                'ip'      => $ip,
                'is_used' => 0,
                'num' => 0,
            );
            $data['id']=$this->add($data);
        }
        return $data;
    }

	public function get_count()
	{
		$count = $this->count();
		return $count;
	}
    
    
}