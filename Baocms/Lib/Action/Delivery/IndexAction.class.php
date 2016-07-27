<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class IndexAction extends CommonAction {

    public function index() {
        
            if(!cookie('DL')){
                header("Location: " . U('login/index'));
            }else{
                 $cid = $this->reid();
                 $dv = D('Delivery');
                 $rdv = $dv -> where('id ='.$cid) -> find();
                 if(!$rdv){
                     header("Location: " . U('login/logout'));
                 }else{
                     $this->assign('rdv',$rdv);
                 }
                 
                 //未配送订单
                 $do = D('DeliveryOrder');

                 
                 $today = strtotime(date('Y-m-d'));
                 
                 //今日配送
                 $today_p = $do -> where('update_time >='.$today.' and delivery_id ='.$cid.' and status =2') -> count();
                 $this->assign('today_p',$today_p);
                 
                 //今日完成
                 $today_ok = $do -> where('update_time >='.$today.' and delivery_id ='.$cid.' and status =8') -> count();
                 $this->assign('today_ok',$today_ok);
                 
                 //总计完成
                 $all_ok = $do -> where('delivery_id ='.$cid.' and status =8') -> count();
                 $this->assign('all_ok',$all_ok);
                 
                 //抢新单
                 $new = $do -> where('status <2 and delivery_id =0') ->count();
                 $this->assign('new',$new);
                 
                 //配送中
                 $ing = $do -> where('status = 2 and delivery_id ='.$cid) -> count();
                 $this->assign('ing',$ing);
                 
                 //已完成
                 $ed = $do -> where('status = 8 and delivery_id ='.$cid) -> count();
                 $this->assign('ed',$ed);
                 
                 $this->display();
            }

    }
    


}