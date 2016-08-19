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

$role_arr=$duoduo->select_2_field('role');

if($_POST['sub']!=''){

	$role_arr=$_POST['role'];
	unset($_POST['role']);
	
    $id=empty($_POST['id'])?0:(int)$_POST['id'];
	if(isset($_POST['sort']) && $_POST['sort']==''){$_POST['sort']=0;}
	unset($_POST['id']);
	unset($_POST['sub']);
	unset($_POST['act_id']);
	unset($_POST['mod_id']);
	unset($_POST['node_id']);
	unset($_POST['pid']);
	
	if($id==0){
		if($_POST['act']=='' && $_POST['mod']==''){
		    $_POST['listorder']=$_POST['sort']+10000;
		    unset($_POST['sort']);
	        $menuid=$duoduo->select('menu','id','`node`="'.$_POST['node'].'" and `mod`="" and `act`=""');
		    if($menuid>0){
		        jump(-1,'节点已存在');
		    }
		    $data=array('parent_id'=>0,'node'=>$_POST['node'],'mod'=>$_POST['mod'],'act'=>$_POST['act'],'title'=>$_POST['title'],'hide'=>$_POST['hide'],'listorder'=>$_POST['listorder'],'url'=>$_POST['url']);
			$menuid=$duoduo->insert('menu',$data);
			$data=array('role_id'=>1,'menu_id'=>$menuid);
			$duoduo->insert('menu_access',$data);
	    }
		elseif($_POST['act']=='' || $_POST['mod']==''){
		    jump(-1,'缺少模块或行为文件');
		}
	    else{
	        $menuid=$duoduo->select('menu','id','`mod`="'.$_POST['mod'].'" and act="'.$_POST['act'].'"');
		    if($menuid>0){
		        jump(-1,'菜单已存在');
		    }
			$parent_menuid=$duoduo->select('menu','id','`node`="'.$_POST['node'].'" and `mod`="" and act=""');
		    $data=array('parent_id'=>$parent_menuid,'node'=>$_POST['node'],'mod'=>$_POST['mod'],'act'=>$_POST['act'],'title'=>$_POST['title'],'hide'=>$_POST['hide'],'sort'=>$_POST['sort'],'url'=>$_POST['url']);
			//print_r($data);exit;
			$menuid=$duoduo->insert('menu',$data);
			foreach($role_arr as $k=>$v){
				if($v==1){
					$data=array('role_id'=>$k,'menu_id'=>$menuid);
					$duoduo->insert('menu_access',$data);
				}
			}
			
		}
		jump('-2','保存成功');
	}
	else{
		if($_POST['act']=='' && $_POST['mod']==''){
		    $_POST['listorder']=$_POST['sort'];
		    unset($_POST['sort']);
			$menuid=$duoduo->select('menu','id','`node`="'.$_POST['node'].'" and `mod`="" and `act`="" and id<>"'.$id.'"');
		    if($menuid>0){
		        jump(-1,'节点已存在');
		    }
		}
		elseif($_POST['act']=='' || $_POST['mod']==''){
		    jump(-1,'缺少模块或行为文件');
		}
	    else{
	        $menuid=$duoduo->select('menu','id','`mod`="'.$_POST['mod'].'" and act="'.$_POST['act'].'" and id<>"'.$id.'"');
		    if($menuid>0){
		        jump(-1,'菜单已存在');
		    }
		}
		$_POST['parent_id']=$duoduo->select('menu','id','`node`="'.$_POST['node'].'" and `mod`="" and act=""');
		if($_POST['parent_id']==$id){$_POST['parent_id']=0;}
	    $duoduo->update(MOD,$_POST,'id="'.$id.'"');
		
		$duoduo->delete('menu_access','menu_id='.$id);
		foreach($role_arr as $k=>$v){
			if($v==1){
				$data=array('role_id'=>$k,'menu_id'=>$id);
				$duoduo->insert('menu_access',$data);
			}
		}
		
		jump('-2','修改成功');
	}
}
else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
	$mod_arr=$duoduo->select_2_field('menu','id,`mod`','`mod`<>"" group by `mod`');
	$node_arr=$duoduo->select_2_field('menu','node,`title`','`parent_id`=0 order by `listorder` desc');
    if($id==0){
	    $row=array();
	}
	else{
	    $row=$duoduo->select(MOD,'*','id="'.$id.'"');
		$a=$duoduo->select_all('menu_access','*','menu_id='.$id);
		foreach($a as $k=>$v){
			$role_select_arr[]=$v['role_id'];
		}
	}
}
?>