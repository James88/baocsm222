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

if(!defined('INDEX')){
	exit('Access Denied');
}

/**
* @name 用户信息
* @copyright duoduo123.com
* @example 示例user_msg();
* @param $page 页数
* @param $pagesize 每页显示多少商品
* @param $field 字段
* @return $parameter 结果集合
*/
function act_user_msg($pagesize=10,$field="*"){
	global $duoduo;
	$webset = $duoduo->webset;
	$dduser = $duoduo->dduser;
	no_cache();    
	$do=$_GET['do']?$_GET['do']:'in';
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$page2=($page-1)*$pagesize;
	
	if($do=='in'){
		$total = $duoduo->count('msg'," uid='".$dduser["id"]."'");
		$mgs_row=$duoduo->select_all('msg',$field," uid='".$dduser["id"]."' order by id desc limit $page2,$pagesize");
	}
	elseif($do=='out'){
		$total = $duoduo->count('msg'," senduser='".$dduser["id"]."'");
		$mgs_row=$duoduo->select_all('msg',$field," senduser='".$dduser["id"]."' order by id desc limit $page2,$pagesize");
	}
	elseif($do=='del'){
		$ids=$_GET['ids'];
		foreach($ids as $id){
			if($id>0){
				$duoduo->delete('msg','id="'.$id.'" and (uid="'.$dduser['id'].'" or senduser="'.$dduser['id'].'")');
			}
		}
		jump('-1','删除成功');
	}
	elseif($do=='save_send'){
		$captcha = $_POST['captcha'];
		if (reg_captcha($captcha) == 0) {
			jump(-1, 5); //验证码错误
		}
		$content=htmlspecialchars($_POST['content']);
		if($content!=''){
			$field_arr=array('title'=>'站内消息','content'=>$content,'addtime'=>SJ,'see'=>0,'uid'=>0,'senduser'=>$dduser['id']);
			$duoduo->insert('msg', $field_arr,0);
		}
		jump('-1','发送成功');
	}
	elseif($do=='read'){
	}
	foreach($mgs_row as $k=>$r){
		$mgs_row[$k]['url']=u('ajax','get_msg',array('id'=>$r["id"]));
		$mgs_row[$k]['_content']=utf_substr($r["content"],64);
	}
	unset($duoduo);
	$parameter['do']=$do;
	$parameter['page2']=$page2;
	$parameter['total']=$total;
	$parameter['pagesize']=$pagesize;
	$parameter['mgs_row']=$mgs_row;
	return $parameter;
}
?>