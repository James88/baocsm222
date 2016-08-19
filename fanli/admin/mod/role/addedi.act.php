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

function linshi($arr,$id){
	$t=1;
	foreach($arr as $row){
		if($row['id']==$id){
			$t=0;
			break;
		}
	}
	return $t;
}

if($_POST['sub']!=''){
    $id=empty($_POST['id'])?0:(int)$_POST['id'];
	unset($_POST['id']);
	unset($_POST['sub']);
	$data=array('title'=>$_POST['title'],'status'=>1);
	$ids=$_POST['ids'];
	
	if($id==0){
	    $id=$duoduo->insert(MOD,$data);
		foreach($ids as $v){
		    $info=array('role_id'=>$id,'menu_id'=>$v);
			$duoduo->insert('menu_access',$info);
		}
		jump('-2','保存成功');
	}
	else{
		$duoduo->delete('menu_access','role_id="'.$id.'"');
		foreach($ids as $v){
		    $info=array('role_id'=>$id,'menu_id'=>$v);
			$duoduo->insert('menu_access',$info);
		}
		
	    $duoduo->update(MOD,$data,'id="'.$id.'"');
		jump('-2','修改成功');
	}
}
else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
	
	$arr=$duoduo->select_all('menu','id,title,`parent_id`,node,`mod`,`act`,listorder','1="1" order by listorder desc,`mod` desc');
	foreach($arr as $a){
		if($a['parent_id']==0){
			$menus[$a['id']]['children']=array();
			$menus[$a['id']]['title']=$a['title'];
			$menus[$a['id']]['id']=$a['id'];
			$menus[$a['id']]['node']=$a['node'];
		}
		else{
		    $menus[$a['parent_id']]['children'][]=$a;
		}
	}
	
	foreach($arr as $a){  //二次循环，如果节点在节点菜单后添加，第一次循环会漏掉
		if($a['parent_id']>0){
			$t=linshi($menus[$a['parent_id']]['children'],$a['id']);
			if($t==1){
				$menus[$a['parent_id']]['children'][]=$a;
			}
		}
	}
	
    if($id==0){
	    $row=array();
		$role_menu_arr=array();
	}
	else{
	    $row=$duoduo->select(MOD,'*','id="'.$id.'"');
		$role_menu_arr=$duoduo->select_2_field('menu_access','menu_id,id','role_id="'.$id.'"');
	}
}
?>