<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class VoteoptionModel extends CommonModel {

    protected $pk = 'option_id';
    protected $tableName = 'vote_option';

    public function upload($vote_id, $photos) {
        $vote_id = (int) $vote_id;
        $option_id = (int) $option_id;
        $this->delete(array("where" => array('option_id' => $option_id)));
        foreach ($photos as $val) {
            $this->add(array('option' => $val, 'vote_id' => $vote_id));
        }
        return true;
    }
    
    

    public function getPics($option_id) {
        $option_id = (int) $option_id;
        return $this->where(array('option_id' => $option_id))->select();
    }

}
