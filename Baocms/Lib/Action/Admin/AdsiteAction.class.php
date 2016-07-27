<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class AdsiteAction extends CommonAction {


    public function index() {
        $Adsite = D('Adsite');
        $this->assign('adsite',$Adsite->fetchAll());
        $this->assign('types', $Adsite->getType());
        $this->assign('place', $Adsite->getPlace());
        $this->display(); // 输出模板
    }

}
