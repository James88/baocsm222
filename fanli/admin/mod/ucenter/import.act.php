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

if($webset['ucenter']['UC_DBHOST']==''){
    PutInfo('UC整合没有开启或者信息不全',-1);
	dd_exit();
}
$duoduo->BIAOTOU='`'.$dbname.'`.'.BIAOTOU;
$dz = new duoduo;
$dz->dbserver=$webset['ucenter']['UC_DBHOST'];
$dz->dbuser=$webset['ucenter']['UC_DBUSER'];
$dz->dbpass=$webset['ucenter']['UC_DBPW'];
$dz->dbname=$webset['ucenter']['UC_DBNAME'];
$dz->BIAOTOU='`' . $webset['ucenter']['UC_DBNAME'] . '`.' . $webset['ucenter']['UC_DBTABLEPRE'];
$dz->connect();

$_GET['limit']=!($_GET['limit']) ? '0' : intval($_GET['limit']);
$_GET['size']=!($_GET['size']) ? '500' : intval($_GET['size']);
$num=$duoduo->count('user');
$onLoad = 0;

if ($_GET['sub']!='') {
	$onLoad = 0;
	
	$arr=$duoduo->select_all('user','id,ddusername,ddpassword,email,regtime,regip','1="1" order by id desc limit '.$_GET['limit'] . ',' . $_GET['size']);
	foreach($arr as $row){
	    $salt = substr(uniqid(rand()), -6);
		$pwd = md5($row['ddpassword'].$salt);
		$data = array (
			'username' => $row['ddusername'],
			'password' => $pwd,
			'email' => $row['email'],
			'regip' => $row['regip']?$row['regip']:'127.0.0.1',
			'regdate' => mktime($row['regtime']), 
			'salt' => $salt
		);
		$ucid=$dz->select('members','uid','username="'.$row['ddusername'].'"');
		if($ucid>0){
		    $data=array('ucid'=>$ucid);
			$duoduo->update('user',$data,'id="'.$row['id'].'"');
		}
		else{
		    $ucid=$dz->insert('members',$data);
		    if($ucid>0){
		        $data = array ('uid' => $ucid,'blacklist' => '');
		        $dz->insert('memberfields',$data);
			    $data=array('ucid'=>$ucid);
			    $duoduo->update('user',$data,'id="'.$row['id'].'"');
		    }
		    else{
		    
		    }
		}
	}
	$_GET['limit'] = $_GET['limit'] + $_GET['size'];
	$onLoad = 1;
}