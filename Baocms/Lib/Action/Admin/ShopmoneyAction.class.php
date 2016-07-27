<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */
class ShopmoneyAction extends CommonAction{


    
    public  function index(){
       $Shopmoney = D('Shopmoney');
       import('ORG.Util.Page');// 导入分页类
       $map = array();
        if(($bg_date = $this->_param('bg_date',  'htmlspecialchars') )&& ($end_date=$this->_param('end_date','htmlspecialchars'))){
           $bg_time = strtotime($bg_date);
           $end_time = strtotime($end_date);
           $map['create_time'] = array(array('ELT',$end_time),array('EGT',$bg_time));
           $this->assign('bg_date',$bg_date);
           $this->assign('end_date',$end_date);
       }else{
           if($bg_date = $this->_param('bg_date',  'htmlspecialchars')){
               $bg_time = strtotime($bg_date);
               $this->assign('bg_date',$bg_date);
               $map['create_time'] = array('EGT',$bg_time);
           }
           if($end_date = $this->_param('end_date',  'htmlspecialchars')){
               $end_time = strtotime($end_date);
               $this->assign('end_date',$end_date);
               $map['create_time'] = array('ELT',$end_time);
           }
       }

       if($keyword = $this->_param('keyword','htmlspecialchars')){
           $map['order_id'] = array('LIKE', '%'.$keyword.'%');
           $this->assign('keyword',$keyword);
       } 
       if($shop_id = (int)$this->_param('shop_id')){
            $map['shop_id'] = $shop_id;
            $shop = D('Shop')->find($shop_id);
            $this->assign('shop_name',$shop['shop_name']);
            $this->assign('shop_id',$shop_id);
        }
       
       
       $count      = $Shopmoney->where($map)->count();// 查询满足要求的总记录数 
       $Page       = new Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
       $show       = $Page->show();// 分页显示输出
       $list = $Shopmoney->where($map)->order(array('money_id'=>'desc'))->limit($Page->firstRow.','.$Page->listRows)->select();
       $shop_ids = array();
       foreach($list as  $val){
           $shop_ids[$val['shop_id']] = $val['shop_id'];
       }
       $this->assign('shops',D('Shop')->itemsByIds($shop_ids));
       $this->assign('list',$list);// 赋值数据集
       $this->assign('page',$show);// 赋值分页输出
       $this->display(); // 输出模板
    }
    
    
    
    public function create(){
        if($this->isPost()){
            $data = $this->_post('data',false);
            $add = array('create_time'=>NOW_TIME,'create_ip'=>  get_client_ip());
            if(!$data['shop_id']){
                $this->baoError('请选择商家');
            }
            $add['shop_id'] = (int)$data['shop_id'];
            if(!$data['money']){
                $this->baoError('请数据MONEY');
            }
            $add['money'] = (int)($data['money']*100);
            if(!$data['type']){
                $this->baoError('请选择类型');
            }
            $add['type'] = htmlspecialchars($data['type']);
            if(!$data['order_id']){
                $this->baoError('请填写原始订单');
            }
            $add['order_id'] = (int)$data['order_id'];
            if(!$data['intro']){
                $this->baoError('请填写说明');
            }
            $add['intro'] =htmlspecialchars($data['intro']);
            D('Shopmoney')->add($add);
            $shop = D('Shop')->find($add['shop_id']);
            D('Users')->addMoney($shop['user_id'], $add['money'], $add['intro']);
            $this->baoSuccess('操作成功',U('shopmoney/index'));
        }else{
            $this->display(); 
        }      
    }



    
   
}
