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

$page = isset($_GET['page'])?intval($_GET['page']):1;
$pagesize=isset($_GET['pagesize'])?(int)$_GET['pagesize']:500;

$url=$webset['phpwind']['url'];
$url=preg_replace('|/$|','',$url);
if($url==''){jmp(-1,'phpwind地址未设置');}
$url=$url.'/phpwind2dd.php?key='.md5($webset['phpwind']['key']).'&page='.$page.'&pagesize='.$pagesize;
$row=dd_get_xml($url);
if($row['error']==1){
    PutInfo('密钥错误，请检查网站和phpwind内的设置是否相同！',-1);
	exit;
}
$num=$row['count']?$row['count']:0;
$onLoad = 0;
$daoru_num=$_GET['daoru_num']?(int)$_GET['daoru_num']:0;

if ($_GET['sub']!='') {
    foreach($row['item'] as $r){
	    $data['ddusername']=$r['username'];
		$data['ddpassword']=$r['password'];
		$data['email']=$r['email'];
		$data['regtime']=date('Y-m-d H:i:s',$r['regdate']);
		$data['email']=$r['email'];
		$data['lastlogintime']=date('Y-m-d H:i:s',$r['lastvisit']);
		if(strpos($r['onlineip'],'|')!==false){
		    $a=explode('|',$r['onlineip']);
			$r['onlineip']	=$a[1];			 
		}
		$data['regip']=$r['onlineip'];
		$duoduo->insert('user',$data);
		$daoru_num++;
	}
	$onLoad = 1;
}