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
/*
$menu_id=$duoduo->select('menu as a,access as b','a.id','a.`mod`="webset" and a.`act`="center" and a.id=b.menu_id and b.role_id="'.$ddadmin['role'].'"');
		if(!$menu_id){
		    $menu=$duoduo->select('menu as a,access as b','a.`mod`,a.`act`','a.id=b.menu_id and b.role_id="'.$ddadmin['role'].'" and hide=0');
			$array=array('go_mod'=>$menu['mod'],'go_act'=>$menu['act']);
		}
		else{
		    $array=array('go_mod'=>'webset','go_act'=>'center');
		}
	    jump(u($array[0],$array[1]));*/
?>