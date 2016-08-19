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

if($_POST['sub']!=''){
	if($_POST['step']==1){
	    $uc_url=$_POST['url'];
		$pwd=$_POST['pwd'];
		$url=preg_replace('|/$|','',$url);
		$url=$uc_url.'/index.php?m=app&a=add&ucfounder=&ucfounderpw='.$pwd.'&apptype=OTHER&appname=duoduo&appurl='.urlencode(SITEURL).'&appip=&appcharset=UTF-8&appdbcharset=utf8';
		$collect=new collect;
		$collect->get($url,'post');
		$c=$collect->val;
		if($c==''){
		    jump(-1,'验证失败');
		}
		elseif($c==-1){
		    jump(-1,'管理员密码错误');
		}
		else{
		    $a=explode('|',$c);
		    $uc['UC_KEY']=$a[0];
		    $uc['UC_APPID']=$a[1];
		    $uc['UC_DBHOST']=$a[2];
		    $uc['UC_DBNAME']=$a[3];
		    $uc['UC_DBUSER']=$a[4];
		    $uc['UC_DBPW']=$a[5];
		    $uc['UC_DBCHARSET']=$a[6];
		    $uc['UC_DBTABLEPRE']=$a[7];
		    $uc['UC_CHARSET']=$a[8];
		    $uc['UC_API']=$uc_url;
		    $uc['open']=1;
            $ucstr=serialize($uc);
		    $data=array('val'=>$ucstr);
	        $duoduo->update('webset',$data,'var="ucenter"');
		    $duoduo->webset(); //配置缓存
		    jump(u('ucenter','set',array('ucmyset'=>1)),'保存信息');
		}
	}
	elseif($_POST['step']==2){
	    $diff_arr=array('sub','step');
	    $_POST=logout_key($_POST, $diff_arr);
		$_POST['ucenter']['open'] = 1;
	    foreach($_POST as $k=>$v){
		    if(is_array($v)){$v=serialize($v);}
		    $data=array('val'=>$v);
	        $duoduo->update('webset',$data,'var="'.$k.'"');
	    }
	
	    $duoduo->webset(); //配置缓存
	
	    jump(u('ucenter','set'),'保存成功');
	}
}