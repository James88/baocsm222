<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.taobao.com
 * 邮件: youge@baocms.com  QQ 800026911
 */
class  CleanAction extends CommonAction{
    
    
    public function cache(){
        
        delFileByDir(APP_PATH.'Runtime/');
        $time = NOW_TIME - 900;//15分钟的会删除
        M("session")->delete(array('where'=>" session_expire < '{$time}' "));
        $this->success('更新缓存成功！',U('index/main'));
    }
    
}
