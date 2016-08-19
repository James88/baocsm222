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
if(isset($_GET['title']) && isset($_GET['sign'])){
		$content=trim($_GET['content']);
		$title=trim($_GET['title']);
		$sign=$_GET['sign'];
		$reset=(int)$_GET['reset'];
		if($title==''){
			jump(-1,'群发标题不能为空！');
		}
		if($content==''){
			jump(-1,'群发内容不能为空！');
		}
		
		$ddopen=fs('ddopen');
		$ddopen->sms_ini($webset['sms']['pwd']);
		
		$re=$ddopen->sms_content_check($content);
		if($re['s']==1){
			jump(u(MOD,'qunfa_set',array('qf_content'=>$content,'qf_title'=>$title)),'包含违规词【'.$re['r'].'】，请重新修改短信内容');
		}
		
		if($sign==''){
			jump(-1,'未知错误！');
		}
		
		/*$duoduo->update_serialize('sms','content',$content);
		$duoduo->webset();*/
		
		$data=array();
		$data['title']=$title;
		$data['content']=$content;
		$data['sign']=$sign;
		$data['reset']=$reset;
		$data['addtime']=date("Y-m-d H:i:s");
		$id=$duoduo->select('qunfa_tag','id','sign="'.$sign.'"');
		
		if($id>0){
			$ddopen=fs('ddopen');
			$ddopen->sms_ini($webset['sms']['pwd']);
			$re=$ddopen->sms_qunfa($data['sign'],$data['content']);
			if($re['s']==0 && $re['g']!=1){
				jump(-1,$re['r']);
			}
			$duoduo->update('qunfa_tag',$data,'id="'.$id.'"');
			jump(u(MOD,'qunfa_tag'),$word);
		}
		else{
			$data['status']=1;
			$duoduo->insert('qunfa_tag',$data);
			jump(u(MOD,ACT,array('sign'=>$sign,'p'=>2)),$word);
		}
		
}
if(isset($_GET['sub']) && $_GET['sub']!=''){
	$_GET['page'] = !($_GET['page'])?'1':intval($_GET['page']);
	$page=$_GET['page'];
	$pagesize=$_GET['pagesize']?$_GET['pagesize']:20;
	$frmnum=($page-1)*$pagesize;
	$page_arr=$_GET;
	extract($page_arr);
	
	$tbtxstatus=(int)$tbtxstatus;
	$txstatus=(int)$txstatus;
	$mobile_test=(int)$mobile_test;
	
	if($do=='sms'){
		$where=" mobile<>'' ";
	}
	else{
		$where="1 ";
	}
	
	if($sid>0){
		$where.=" and ".(int)$sid."<=id";
	}
	if($eid>0){
		$where.=" and id<=".(int)$eid;
	}
	if($ddusername!=''){
		$where.=" and ddusername like '".$ddusername."'";
	}
	if($mobile_test<=1){
		$where.=" and mobile_test =".$mobile_test;
	}
	if($slastlogintime!='' && $elastlogintime!=''){
		$where.=" and lastlogintime between '".date("Y-m-d 00:00:00",strtotime($slastlogintime))."' and '".date("Y-m-d 23:59:59",strtotime($elastlogintime))."'";
	}
	if($sregtime!='' && $eregtime!=''){
		$where.=" and regtime between '".date("Y-m-d 00:00:00",strtotime($sregtime))."' and '".date("Y-m-d 23:59:59",strtotime($eregtime))."'";
	}
	if($smoney>0){
		$where.=" and ".(float)$smoney."<=money";
	}
	if($emoney>0){
		$where.=" and money <=".(float)$emoney;
	}
	if($sjifenbao>0){
		$where.=" and ".(float)$sjifenbao."<=jifenbao";
	}
	if($ejifenbao>0){
		$where.=" and jifenbao <=".(float)$ejifenbao;
	}
	if($syitixian>0){
		$where.=" and ".(float)$syitixian."<=yitixian";
	}
	if($eyitixian>0){
		$where.=" and yitixian <=".(float)$eyitixian;
	}
	if($stbyitixian>0){
		$where.=" and ".(float)$stbyitixian."<=tbyitixian";
	}
	if($etbyitixian>0){
		$where.=" and tbyitixian <=".(float)$etbyitixian;
	}
	if($tbtxstatus<=1){
		$where.=" and tbtxstatus =".$tbtxstatus;
	}
	if($txstatus<=1){
		$where.=" and txstatus =".$txstatus;
	}
	if($slevel>=0){
		$where.=" and level>=".(int)$slevel;
	}
	if($elevel>0){
		$where.=" and level <=".(int)$elevel;
	}
	if($page==1){
		//检索数量
		$total=(int)$duoduo->count('user',$where);	
		if($total==0){
			jump(-1,'检索结果为空，请检查检索条件');
		}
		
		//是否重置
		$reset=$duoduo->select('qunfa_tag','reset','sign="'.$sign.'"');
		if($reset==1){//1重置 0新增
			//重置该记录
			$duoduo->delete('user_temp','sign="'.$sign.'"',0);
			
			//优化表
			$sql='OPTIMIZE TABLE  `'.BIAOTOU.'user_temp`';
			$duoduo->query($sql);
			//更新待发数量
			$duoduo->update('qunfa_tag',array('num'=>$total),'sign="'.$sign.'"');
		}
	}
	$page_arr['reset']=$reset;
	
	$users=$duoduo->select_all('user','id,mobile,ddusername',$where.' order by '.$by.' id desc limit '.$frmnum.','.$pagesize);
	$u_num=0;
	foreach($users as $row){
		$data=array();
		$data['sign']=$sign;
		$data['uid']=$row['id'];
		$data['mobile']=$row['mobile'];
		$data['ddusername']=$row['ddusername'];
		if($reset==0){
			$u_id=$duoduo->select('user_temp','id','sign="'.$sign.'" and  uid="'.$row['id'].'"');
		}
		if(empty($u_id)){
			if($reset==0){
				$u_num++;
			}
			$duoduo->insert('user_temp',$data);
		}
	}
	if($reset==0){
		$duoduo->update('qunfa_tag',array('f'=>'num','e'=>'+','v'=>$u_num),'sign="'.$sign.'"');
	}
	if(count($users)<$pagesize){
		jump(u('user_temp','list',array('sign'=>$sign)));
	}
	$page_arr['page']=$page+1;
	$url='index.php?'.http_build_query($page_arr);
	
	putInfo('<b style="color:red">已检索【'.$pagesize*$page.'】。。。</b><br/><img src="../images/wait2.gif" /><br/><a href="'.$url.'">如果浏览器没有跳转，请点击这里</a>',$url);
}
else{
	$p=$_GET['p']?$_GET['p']:1;
	if($_GET['sign']==''){
		$sign=time();
	}else{
		$sign=$_GET['sign'];
		$qf_sign=$duoduo->select('qunfa_tag','*','sign="'.$sign.'"');
	}
	
}
?>