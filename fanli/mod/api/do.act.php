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
dd_session_start();

if(!defined('INDEX')){
	exit('Access Denied');
}

$do=$_GET['do'];
if($do!='add' && $do!='del' && $do!='go'){
    $do='add';
}
if($do=='go'){
	$code=$_GET['code'];
	if($_SESSION['api_login_reffrer']==''){
		$_SESSION['api_login_reffrer']=$_SERVER['HTTP_REFERER'];
	}
	$arr=array('do'=>'go');
	if($_GET['state']!=''){
		$arr['state']=$_GET['state'];
	}
	jump(u('api',$code,$arr));
}
if($do=='del'){
    $web=$_GET['web'];
	if($web==''){error_html();}
	if($dduser['id']>0){
	    $duoduo->delete('apilogin','uid="'.$dduser['id'].'" and web="'.$web.'"');
		jump(u('user','info',array('do'=>'apilogin')));
	}
	else{
	    error_html('非法操作！');
	}
}
$webname=$_POST['webname'];
$webid=authcode($_POST['webid'],'DECODE',DDKEY);
$web=$_POST['web'];

if($webname=='' || $webid=='' || $web==''){
    error_html('缺少必要参数！');
}

if(strlen($webid)>20){
	$webid=substr($webid,0,20);
}

if($dduser['id']>0){ //处于登陆状态
	$apilogin=$duoduo->select('apilogin','*','uid="'.$dduser['id'].'" and web="'.$web.'"');
	if($apilogin['id']>0){ //如果会员存在当前ACT的登录信息
		if($apilogin['webid']==$webid){//验证是否是自己，是自己，返回
			jump(u('user','info',array('do'=>'apilogin')));
		}
		else{
			jump(u('user','info',array('do'=>'apilogin')),'您已经绑定，请先解绑');
		}
	}
	else{ //登陆信息不存在，插入
	    $data=array('uid'=>$dduser['id'],'webid'=>$webid,'webname'=>$webname,'web'=>$web);
		$duoduo->insert('apilogin',$data);
		jump(u('user','info',array('do'=>'apilogin')));
	}
}
else{
	$row=$duoduo->select('apilogin as a,user as b', 'b.id,b.ddusername,b.ddpassword,b.ucid,a.webid,a.web,a.uid,a.id as apilogin_id', 'a.uid=b.id and a.webid="'.$webid.'" and a.web="'.$web.'" and b.del=0');
	if($row['id']>0){
		$set_con_arr=array(array('f'=>'lastlogintime','v'=>$sj),array('f'=>'loginnum','e'=>'+','v'=>1));
		if($row['ddpassword']==''){
			$key_md5webid=md5(dd_crc32(DDKEY.$webid));
			$set_con_arr[]=array('f'=>'ddpassword','v'=>$key_md5webid,'e'=>'=');
			$row['ddpassword']=$key_md5webid;
		}
		$duoduo->update('user', $set_con_arr, 'id="' . $row['uid'].'"');
		user_login($row['uid'],$row['ddpassword']);
		if($webset['ucenter']['open']==1){
			include DDROOT.'/comm/uc_define.php';
			include_once DDROOT.'/uc_client/client.php';
			echo $ucsynlogin = uc_user_synlogin($row['ucid']); //同步登陆代码
		}

		if($_SESSION['api_login_reffrer']!=''){
			$url=$_SESSION['api_login_reffrer'];
			unset($_SESSION['api_login_reffrer']);
			jump($url);
		}
		else{
			jump(u('user','index'));
		}
	}
	else{
	    $input=array('webname'=>$webname,'webid'=>$webid,'web'=>$web,'apireg'=>authcode(1,'ENCODE',DDKEY));
		if($_SESSION['api_login_reffrer']!=''){
			$forward=$_SESSION['api_login_reffrer'];
			unset($_SESSION['api_login_reffrer']);
		}
		else{
			$forward=u('user','index');
		}
	    echo postform(u('user','register').'&forward='.urlencode($forward),$input);
	}
}
?>