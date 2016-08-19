<?php
/**
 * ============================================================================
 * 版权所有 多多网络，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}

function put_info($msg, $url,$inputArr) {
	$title = '系统提示';
	$jump='';
	$meta='';
	$input='';
	foreach($inputArr as $k=>$v){
		$input.='<input type="hidden" name="'.$k.'" value="'.$v.'" />';
	}
	
	$msginfo = "<html>\n<head>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />\r\n" . $meta . "
		<title>" . $title . "</title>
		<base target='_self'/>\n
		</head>\n<body style='text-align:center'>\n
		<br/>
		<div style='margin:auto;width:400px;'>
		<div style='width:400px; padding-top:4px;height:24;font-size:10pt;border-left:1px solid #cccccc;border-top:1px solid #cccccc;border-right:1px solid #cccccc;background-color:#DBEEBD; text-align:center'>" . $title . "</div>
		<div style='width:400px;height:100px;font-size:10pt;border:1px solid #cccccc;background-color:#F4FAEB; text-align:center'>
		<span style='line-height:160%'><br/>".$msg."</span></div></div>
		<form name='gonext' method='post' action='".$url."'>".$input."</form>
		<script language='javascript'>function GotoNextPage(){document.gonext.submit();}setTimeout('GotoNextPage()',500);</script>";
	echo $msginfo . "\n</body>\n</html>";dd_exit();
}

if($_POST['sub']!='' || $_GET['subm']!=''){  //$_GET['subm']表示群发全站会员的提交标记
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$pagesize=200;
	$frmnum=($page-1)*$pagesize;
	del_magic_quotes_gpc($_POST,1);
	$name=$_POST['username'];
	$admin=$ddadmin['name'];
	$content=$_POST['content'];
	if($content==''){
		$content=$_SESSION['qunfa_msg'];
	}
	else{
		$_SESSION['qunfa_msg']=$content;
	}
	if($content==''){
		jump('-1','发送内容不能为空！');
	}
	if($name==''){
		$user_arr=$duoduo->select_all('user','id','1=1 order by id asc limit '.$frmnum.', '.$pagesize);
		if(!empty($user_arr)){
			foreach($user_arr as $i=>$row){
		    	$uid=$row['id'];
		    	$data=array('title'=>'站内消息','content'=>$content,'uid'=>$uid,'admin'=>$admin,'senduser'=>0,'addtime'=>date('Y-m-d H:i:s'),'see'=>0);
				$duoduo->insert('msg',$data);
			}
			put_info('已发送会员'.($i+1).'人<br/><br/><img src="../images/wait2.gif" />',u('msg','addedi',array('page'=>$page+1,'subm'=>1)));
		}
		else{
			unset($_SESSION['qunfa_msg']);
			PutInfo('发送完毕',u('msg','list',array('do'=>'from','uname'=>'网站客服')));
		}
	}
    elseif(strstr($name,'|')){
	    $name_arr=explode('|',$name);
		foreach($name_arr as $k=>$v){
			$uid=$duoduo->select('user','id','ddusername="'.$v.'"');
		    $data=array('title'=>'站内消息','content'=>$content,'uid'=>$uid,'admin'=>$admin,'senduser'=>0,'addtime'=>date('Y-m-d H:i:s'),'see'=>0);
			$duoduo->insert('msg',$data);
		}
	}
	else{
	    $uid=$duoduo->select('user','id','ddusername="'.$name.'"');
		$data=array('title'=>'站内消息','content'=>$content,'uid'=>$uid,'admin'=>$admin,'senduser'=>0,'addtime'=>date('Y-m-d H:i:s'),'see'=>0,'sid'=>$_POST['sid']);
		$duoduo->insert('msg',$data);
		$duoduo->update('msg',array('admin'=>$admin),'id="'.$_POST['sid'].'"');
	}
	jump(u('msg','list'),'发送成功！');
}
else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
	$sid=empty($_GET['sid'])?0:(int)$_GET['sid'];
    if($id==0){
	    $row=array();
		$name=$_GET['name'];
	}
	else{
	    $row=$duoduo->select(MOD,'*','id="'.$id.'"');
		if($row['uid']==0 && $row['see']==0){
		    $duoduo->update('msg',array('see'=>1),'id="'.$row['id'].'"');
		}
		$msg_senduser=$duoduo->select('user','ddusername','id="'.$row['senduser'].'"');
		$msg_re=$duoduo->select_all('msg','*','(senduser="'.$row['senduser'].'" or uid="'.$row['senduser'].'") and title="站内消息" order by id desc limit 50');
		//$msg_tree=$duoduo->select_all('msg','*','(uid="'.$row['uid'].'" and senduser="'.$row['senduser'].'") or (uid="'.$row['senduser'].'" and senduser="'.$row['uid'].'") order by id desc limit 10');
	}
}