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

function over_tishi(){
	$title = '系统提示';
	$jump='';
	$meta='';
	$msg='您好！群发请求已经提交，请耐心等待审核发送。<br/>预计6小时内完成。<br/>审核时间段为 9点到17:30， 下班时间第二日早上完成。</br/>如有问题联系客服： 在线客服  链接：<br/><a href="http://bbs.duoduo123.com/html/stopic/server.html" target="_blank">http://bbs.duoduo123.com/portal/kefu.html</a>';
	$msginfo = "<html>\n<head>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />\r\n" . $meta . "
		<title>" . $title . "</title>
		<base target='_self'/>\n
		</head>\n<body style='text-align:center'>\n
		<br/>
		<div style='margin:auto;width:400px;'>
		<div style='width:400px; padding-top:4px;height:24;font-size:10pt;border-left:1px solid #cccccc;border-top:1px solid #cccccc;border-right:1px solid #cccccc;background-color:#DBEEBD; text-align:center'>" . $title . "</div>
		<div style='width:390px;height:140px;font-size:10pt;border:1px solid #cccccc;background-color:#F4FAEB; text-align:left; padding-left:10px'>
		<span style='line-height:160%'><br/>".$msg."</span></div></div>";
	echo $msginfo . "\n</body>\n</html>";dd_exit();
}

if(isset($_GET['sub']) && $_GET['sub']!=''){
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$pagesize=200;
	$frmnum=($page-1)*$pagesize;
	
	$ids=$_GET['ids'];
	$do=$_GET['do'];
	$sign=$_GET['sign'];
	$id=$_GET['id']?$_GET['id']:0;
	if($sign==''){
		jump(-1,'方案标记不能为空');
	}
	else{
		$content=$duoduo->select('qunfa_tag','content','sign="'.$sign.'"');
	}
	if($do==''){
		jump(-1,'行为不能为空');
	}
	if($do=='sms'){
		$ddopen=fs('ddopen');
		$ddopen->sms_ini($webset['sms']['pwd']);
		
		if(empty($ids)){
			$user_temp_arr=$duoduo->select_all('user_temp','*','sign="'.$sign.'" order by id asc limit '.$frmnum.','.$pagesize);
			if(empty($user_temp_arr)){
				over_tishi();
			}
		}
		else{
			$ids=implode($ids,',');
			$user_temp_arr=$duoduo->select_all('user_temp','*','sign="'.$sign.'" and id in ('.$ids.') order by id desc');
		}
		
		foreach($user_temp_arr as $row){
			$mobile_arr[]=$row['mobile'];
		}

		$mobile=implode(',',$mobile_arr);
		$re=$ddopen->sms_qunfa($sign,$content,$mobile,count($mobile_arr));
		if($re['s']==0){
			$data=array('status'=>-1,'msg'=>$re['r']);
			$duoduo->update('qunfa_tag',$data,'sign="'.sign.'"');
			jump(u('user_temp','list'),$re['r']?$re['r']:'接口未知错误');
		}
		else{
			$data=array(array('f'=>'status','v'=>$re['r'],'e'=>'='),array('f'=>'msg','v'=>'','e'=>'='),array('f'=>'ynum','v'=>count($mobile_arr),'e'=>'+'));
			$duoduo->update('qunfa_tag',$data,'sign="'.$sign.'"');
			
			foreach($user_temp_arr as $row){
				$duoduo->delete('user_temp','id="'.$row['id'].'"');
			}
		}
		
		if(empty($ids)){
			$page++;
			$page_arr['do']=$do;
			$page_arr['sign']=$sign;
			$page_arr['sub']=1;
			$url=u(MOD,ACT,$page_arr);
			putInfo('<b style="color:red">已提交【'.(count($mobile_arr)).'】个。。。</b><br/><img src="../images/wait2.gif" /><br/><a href="'.$url.'">如果浏览器没有跳转，请点击这里</a>',$url);
		}
		else{
			over_tishi();
		}
	}
}
?>