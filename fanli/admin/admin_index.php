<?php
define('ADMIN',1);
include_once '../comm/dd.config.php';
define('ADMINROOT',str_replace(DIRECTORY_SEPARATOR,'/',dirname(__FILE__)));
define('ADMINTPL',ADMINROOT.'/template');
define('ADMINDIR',str_replace(DDROOT,'',ADMINROOT));
$mod=isset($_GET['mod'])?$_GET['mod']:'index'; //当前模块
$act=isset($_GET['act'])?$_GET['act']:'index'; //当前行为

if(!preg_match('/^[\w-_]+$/',$mod)){
	exit('error mod');
}

if(!preg_match('/^[\w-_]+$/',$act)){
	exit('error act');
}

define('MOD',$mod);
define('ACT',$act);

function get_auth($duoduo_auth_url,$duoduo){
	foreach($duoduo_auth_url as $url){
		$url=$url.'/new_install.php?url='.urlencode("http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF']).'&key='.urlencode(DDKEY);
		$authcode=dd_get($url); //授权码
		if($authcode==''){
			$authcode=file_get_contents($url); //授权码
		}
		if($authcode=='' || strlen($authcode)<130){
			$word='授权获取失败！';
			dd_exit($word);
		}
		else{ //获取的授权码正确
			$data=array('val'=>$authcode);
			$duoduo->update('webset',$data,'var="authorize"');
			$duoduo->webset(1);
			return $authcode;
		}
	}
	$webset['authorize']=$duoduo->select('webset','val','var="authorize"');
	return $webset['authcode']; //服务器错误获取不到授权码时，返回数据库纪录的授权信息
}

$domain_url=get_domain();
$duoduo_auth_url=array(DD_AUTH_URL,'http://auth.cnduo.com');
$webset['authorize']=$duoduo->select('webset','val','var="authorize"'); //从数据库调用
if($domain_url!='localhost'){
	if(isset($_GET['duoduoauthget']) && $_GET['duoduoauthget']==1){
		get_auth($duoduo_auth_url,$duoduo);
		jump(u('webset','center'),'授权获取成功！');
	}

	$get_auth_url=u(MOD,ACT,array('duoduoauthget'=>'1'));
	$auth_arr=authcode($webset['authorize'],'DECODE',md5('luzhouyue'.$domain_url.'luzhouyue'));
	if(empty($auth_arr)){
		echo '授权码验证失败，请重新获取。<a href="'.$get_auth_url.'">获取授权码</a>。（失败原因：您擅自修改了数据库授权字段，或者您当前的网址不是您的授权网址！）<a href="http://bbs.duoduo123.com/read-htm-tid-122501-ds-1.html">常见问题</a>';
		dd_exit();
	}

	$auth_arr=unserialize($auth_arr);
	if(date('Ymd')-$auth_arr['ckdate']>6){
		$authcode=get_auth($duoduo_auth_url,$duoduo);
		$auth_arr=authcode($authcode,'DECODE',md5('luzhouyue'.$domain_url.'luzhouyue'));
		$auth_arr=unserialize($auth_arr);
	}
	
	if($auth_arr['type']==0){
		if(time()>$auth_arr['etime']){
			echo '您的免费体验已到期（'.$auth_arr['day'].'天），请购买官方正版授权后获授取权码。<a target="_blank" href="'.$duoduo_auth_url[0].'">购买地址</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$get_auth_url.'">获取授权码</a>';
			dd_exit();
		}
	}
	
	/*if(time()>$auth_arr['etime']){
		$limit_mod=dd_get($duoduo_auth_url[0].'/limit_mod.html');
		if($limit_mod!=''){
			$limit_mod=explode(',',$limit_mod);
			if($auth_arr['type']>0 && in_array(MOD,$limit_mod)){
				echo '您的授权已到期（'.$auth_arr['day'].'天），请续费后重新获取授权码。<a target="_blank" href="'.$duoduo_auth_url[0].'">购买地址</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$get_auth_url.'">获取授权码</a>';
				dd_exit();
			}
		}
	}*/
}
else{
	/*$limit_mod=dd_get($duoduo_auth_url[0].'/limit_mod.html');
	$limit_mod=explode(',',$limit_mod);
	if(in_array(MOD,$limit_mod)){
		echo '请购买授权下载升级包。<a target="_blank" href="'.$duoduo_auth_url[0].'">购买地址</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$get_auth_url.'">获取授权码</a>';
		dd_exit();
	}*/
}

$duoduo_type=dd_get_cache('type');
if(array_key_exists(MOD,$duoduo_type)){
    $this_type=$duoduo_type[MOD];
}

$menu_arr['index'][]=array('mod'=>'index','act'=>'left');
$menu_arr['index'][]=array('mod'=>'index','act'=>'top');
$menu_arr['index'][]=array('mod'=>'index','act'=>'index');

dd_session_start();
if ($mod != 'login') {
	$ddadmin = $_SESSION['ddadmin'];
	if ($ddadmin['name'] == '') {
		jump(u('login', 'login'));
	}
	else{
		$menu_id=$duoduo->select('menu as a,menu_access as b','a.id','a.`mod`="webset" and a.`act`="center" and a.id=b.menu_id and b.role_id="'.$ddadmin['role_id'].'"');
		if(!$menu_id){
		    $menu=$duoduo->select('menu as a,menu_access as b','a.`mod`,a.`act`','a.id=b.menu_id and b.role_id="'.$ddadmin['role_id'].'" and hide=0 and a.act<>"" and a.mod<>"" order by a.id asc');
			$_GET['go_mod']=$menu['mod'];
			$_GET['go_act']=$menu['act'];
		}
		else{
			$_GET['go_mod']='webset';
			$_GET['go_act']='center';
		}
	    $url_ok = 1;
	}

	$sql = "select a.* from " . BIAOTOU . "menu as a," . BIAOTOU . "menu_access as b where a.id=b.menu_id and b.role_id='" . $ddadmin['role_id'] . "' and a.mod<>'fun' order by a.listorder desc,a.sort desc,a.id asc";
	$query = $duoduo->query($sql);
	while ($row = $duoduo->fetch_array($query)) {
		if ($row['parent_id'] == 0) {

			$menu_arr[$row['node']] = array();
			$parent_menu[$row['node']]['title']=$row['title'];
			$parent_menu[$row['node']]['hide']=$row['hide'];
		} else {
			$menu_arr[$row['node']][] = $row;
		}
	}
	$url_ok = 0;
	foreach ($menu_arr as $key => $row) {
		foreach ($row as $arr) {
			//print_r($arr);
			if (MOD==$arr['mod'] && ACT == $arr['act']) {
				$url_ok = 1;
			}
		}
	}
	
	if(MOD=='fun') $url_ok = 1;

	if ($url_ok != 1) {
		PutInfo('你没有权限');
		dd_exit();
	}
}
else{
	include (DDROOT.'/comm/checkpostandget.php');
	if(ACT!='exit' && ACT!='login'){
		dd_exit('error mod act');
	}
}

$mod_name=$mod.'/'.$act;

if(isset($_POST['sub']) && $_POST['sub']!=''){
	if(MOD!='tradelist' || ACT!='import'){
	    dd_addslashes($_POST);
	} 
    
	if(ACT=='set'){
	    $duoduo->admin_log('set');
	}
	elseif(ACT=='addedi'){
	    if($_POST['id']>0){
		    $duoduo->admin_log('update');
		}
		else{
		    $duoduo->admin_log('insert');
		}
	}
}
elseif(ACT=='del'){
	$duoduo->admin_log('delete');
}

include(ADMINROOT.'/mod/public/admin.act.php'); //公用共享文件

if(strpos(MOD,'_type')){ //团购分类不采用集成分类
    $mod_name='type/'.ACT;
	$a=explode('_',MOD);
	$a_c=count($a)-1;
	$mod_tag='';
	for($i=0;$i<$a_c;$i++){
	    $mod_tag.=$a[$i].'_';
	}
	$mod_tag = preg_replace('/_$/', '', $mod_tag);
}

/*if((ACT=='addedi' || ACT=='set' || MOD=='data') && isset($_POST['sub'])){
	if($_GET['token']!=$_SESSION['token']){
		jump(-1,'令牌错误！');
	}
	else{
		unset($_SESSION['token']);
	}
}*/

$admin_name=str_replace(DDROOT,'',ADMINROOT);
$admin_name=str_replace('/','',$admin_name);
define('ADMIN_NAME',$admin_name);

if(file_exists(ADMINROOT.'/mod/'.MOD.'/public.act.php')){
	include(ADMINROOT.'/mod/'.MOD.'/public.act.php'); //引入私有模块共有行为文件
}
$public_sub=isset($_GET['public_sub'])?$_GET['public_sub']:'0';
if(file_exists(ADMINROOT.'/mod/'.$mod_name.'.act.php') &&  $public_sub!=1){
	include(ADMINROOT.'/mod/'.$mod_name.'.act.php'); //引入私有行为文件
}
elseif(file_exists(ADMINROOT.'/mod/public/'.ACT.'.act.php')){
    include(ADMINROOT.'/mod/public/'.ACT.'.act.php'); //没有私有行为文件则引入公用行为文件
}

if(file_exists(ADMINROOT.'/template/'.$mod_name.'.tpl.php')){
	$_SESSION['token']=rand(100000,999999);
	$form_post_action="index.php?mod=".MOD."&act=".ACT.'&token='.$_SESSION['token']; //带有表单令牌的提交地址
    include(ADMINROOT.'/template/'.$mod_name.'.tpl.php'); //引入模板
}

$duoduo->close();
unset($duoduo);
unset($webset);
?>