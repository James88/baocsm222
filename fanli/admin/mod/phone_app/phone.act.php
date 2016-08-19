<?php
/**
 * ============================================================================
 * 版权所有 多多科技，保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}
$code = 'phone_app';
$id=$duoduo->select('plugin','id,install','code="'.$code.'"');

if($id['id']>0&&$id['install']==0 || !file_exists(DDROOT.'/plugin/phone_app')){
	jump(u('plugin','update',array('code'=>$code,'do'=>'install')),'请先安装！');
}
if($id['id']>0){
	jump(u('plugin','admin',array('plugin_id'=>$id['id'])));
}else{
	jump(u('plugin','list',array('code'=>$code)));
}