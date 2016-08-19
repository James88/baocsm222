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
	
	$id=empty($_POST['id'])?0:(int)$_POST['id'];
	$fangshi=(int)$_POST['fangshi'];
	$money=abs((float)$_POST['money']);
	$jifen=abs((int)$_POST['jifen']);
	$jifenbao=abs((float)$_POST['jifenbao']);
	$source=trim($_POST['source']);
	$name_arr=trim($_POST['ddusername']);
	$i=0;
	
	if($name_arr==''){
		jump('-1','请填写会员名');
	}
	
    if(isset($name_arr) && $name_arr!=''){
		$name_arr=strtoarray($name_arr);
	    $name_arr=serialize($name_arr);
	    $name_arr=unserialize($name_arr);
	}
	
	//检测会员是否存在
	foreach ($name_arr as $k=>$row){	
		$uid=$duoduo->select('user','id','ddusername="'.$name_arr[$k].'"');
			if($uid==''){
			$name_error.=$name_arr[$k].' ';
			$i++;
		}
	}

	if($name_error!=''){
		$name_arr=implode(',',$name_arr);
		jump(u('user','award',array('id'=>$id,'name'=>$name_arr)),'共有'.$i.'个会员名不存在，分别是 '.$name_error.'不存在,请重新填写');
	}
	
	//批量奖励
	foreach ($name_arr as $k=>$row){	
		$uid=$duoduo->select('user','id','ddusername="'.$name_arr[$k].'"');
		$user=$duoduo->select('user','ddusername,email,mobile,mobile_test','id="'.$uid.'"');
	
		if($fangshi==1){
			$mingxi_id=20;  //明细模板id
			$msg_set_id=9;  //站内信模板id
			$m=$money;
			$jf=$jifen;
			$jfb=$jifenbao;
		}
		else{
			$mingxi_id=21;  //明细模板id
			$msg_set_id=10;  //站内信模板id
			$m=-$money;
			$jf=-$jifen;
			$jfb=-$jifenbao;
		}
		$data=array(array('f'=>'money','e'=>'+','v'=>$m),array('f'=>'jifen','e'=>'+','v'=>$jf),array('f'=>'jifenbao','e'=>'+','v'=>$jfb));

    	//增加明细
		$duoduo->update_user_mingxi($data,$uid,$mingxi_id);
	
		if($source!=''){//发送站内信
			$m1='金额：'.$m.' 元，';
			$m2=''.TBMONEY.'：'.$jfb.'，';
			$m3='积分：'.$jf;
			$moneya=$m1.$m2.$m3;
			$msg_data=array('uid'=>$uid,'money'=>$moneya,'why'=>$source);
			$duoduo->msg_insert($msg_data,$msg_set_id);
		}
	}
    jump('-2','操作成功');
}
else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
    if($id==0){
	    jump('-1','数据错误');
	}
	else{
	    $row=$duoduo->select(MOD,'*','id="'.$id.'"');
		if($_GET['name']!=''){  $row['ddusername']=$_GET['name'];}
	}
}
?>