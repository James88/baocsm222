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

if(isset($_POST['sub']) && $_POST['sub']==1){
	$name=$_POST['username'];
	$pwd=$_POST['password'];
	$yzm=$_POST['yzm'];
	if (reg_captcha($yzm)==0){
	    jump('index.php','验证码错误！');
	}
    $admin=$duoduo->select('duoduo2010','*','adminname="'.$name.'" and adminpass="'.deep_jm($pwd).'"');
	if($admin['id']>0){
		$data = array (
	        array (
		        'f' => 'lastlogintime',
		        'e' => '=',
		        'v' => $admin['logintime']
	        ),
			array (
		        'f' => 'lastloginip',
		        'e' => '=',
		        'v' => $admin['loginip']
	        ),
			array (
		        'f' => 'loginnum',
		        'e' => '+',
		        'v' => 1
	        ),
			array (
		        'f' => 'logintime',
		        'e' => '=',
		        'v' => TIME
	        ),
			array (
		        'f' => 'loginip',
		        'e' => '=',
		        'v' => get_client_ip()
	        ),
        );
		$duoduo->update('duoduo2010',$data,'id='.$admin['id']);
		$_SESSION['ddadmin']['name']=$admin['adminname'];
		$_SESSION['ddadmin']['id']=$admin['id'];
		$_SESSION['ddadmin']['role_id']=$admin['role'];
		
		$menu_id=$duoduo->select('menu as a,menu_access as b','a.id','a.`mod`="webset" and a.`act`="center" and a.id=b.menu_id and b.role_id="'.$admin['role'].'"');
		if(!$menu_id){
		    $menu=$duoduo->select('menu as a,menu_access as b','a.`mod`,a.`act`','a.id=b.menu_id and b.role_id="'.$admin['role'].'" and hide=0');
			$array=array('go_mod'=>$menu['mod'],'go_act'=>$menu['act']);
		}
		else{
		    $array=array('go_mod'=>'webset','go_act'=>'center');
		}
		mkdir(DDROOT.'/data/temp/session/'.date("Ymd",strtotime("+1 day")));
		copy(DDROOT.'/data/temp/session/'.date('Ymd').'/sess_'.session_id(),DDROOT.'/data/temp/session/'.date("Ymd",strtotime("+1 day")).'/sess_'.session_id());
	    jump(u('index','index',$array));
	}
	else{
	    jump('index.php','账号密码错误！');
	}
}
?>