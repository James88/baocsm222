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
	
	$old_user=$duoduo->select(MOD,'*','id="'.$id.'"');
	
	if($duoduo->check_my_email($_POST['email'],$_POST['id'])>0){
		jump(-1,'email已被使用！');
	}
	if($_POST['alipay']!=''){
		if($duoduo->check_my_field('alipay',$_POST['alipay'],$_POST['id'])>0){
			jump(-1,'支付宝已被使用！');
		}
	}
	if($_POST['tenpay']!=''){
		if($duoduo->check_my_field('tenpay',$_POST['tenpay'],$_POST['id'])>0){
			jump(-1,'财付通已被使用！');
		}
	}
	if($_POST['tjr']*$_POST['tjr_over']!=0){
		jump(-1,'推荐人id和推荐人（已结束）有一个必须为0！');
	}
	if($_POST['bank_code']>0){
		if($duoduo->check_my_field('bank_code',$_POST['bank_code'],$_POST['id'])>0){
			jump(-1,'银行账号已被使用！');
		}
	}
	else{
		$_POST['bank_code']=0;
	}
	
	if($_POST['mobile']!='' && $_POST['mobile_test']==1 && reg_mobile($_POST['mobile'])==1){
		$a=$duoduo->select('user','id,ddusername,mobile_test','mobile="'.$_POST['mobile'].'" and mobile_test=1 and id<>"'.$id.'"');
		if($a['mobile_test']==1){
			jump(-1,'该手机已验证，验证会员id：'.$a['id']);
		}
	}
	
	if($_POST['ddpassword']!='' && $_POST['ddpassword']!=DEFAULTPWD && $webset['ucenter']['open']==1){
		include DDROOT.'/comm/uc_define.php';
		include_once DDROOT.'/uc_client/client.php';
		$uc_name=iconv("utf-8","utf-8//IGNORE",$_POST['ddusername']);
		$ucresult = uc_user_edit($uc_name,'',$_POST['ddpassword'],$_POST['email'],1);
		if ($ucresult == -4) {
			jump(-1,'email格式错误！');
		}
		elseif ($ucresult == -5) {
			jump(-1,'email已被使用！');
		}
		elseif ($ucresult == -6) {
			jump(-1,'email已被使用！');
		}
		elseif($ucresult<0){
			jump(-1,'未知错误！');
		}
	}
	
	if($old_user['tbnick']!=$_POST['tbnick']){
		$tbnick_arr=explode(',',$old_user['tbnick']);
		$tbnick_arr=array_unique($tbnick_arr);
		foreach($tbnick_arr as $v){
			$a=get_4_tradeid($v);
			if($a['0']>0){
				$duoduo->trade_uid($id,$a['0'],'del');
			}
		}
		$u_trade_uid="";
		$tbnick=explode(',',$_POST['tbnick']);
		foreach($tbnick as $v){
			$a=get_4_tradeid($v);
			if($a['0']>0){
				$duoduo->trade_uid($id,$a['0']);
				$u_trade_uid.=($u_trade_uid?',':'').$v;
			}
		}
		$_POST['tbnick']=$u_trade_uid;
	}
	$arr=array('money','jifen','level','tjr','yitixian','mobile','lasttixian');
	empty2zero($_POST,$arr);
	
	if(isset($_POST['ddpassword'])){
		if($_POST['ddpassword']=='' || $_POST['ddpassword']==DEFAULTPWD){
	    	unset($_POST['ddpassword']);
		}
		else{
	    	$_POST['ddpassword']=md5($_POST['ddpassword']);
		}
	}
	
	if(reg_time($_POST['lasttixian'])==1){
	    $_POST['lasttixian']=strtotime($_POST['lasttixian']);
	}
	else{
	    $_POST['lasttixian']=0;
	}
	
	if(isset($_POST['signtime'])){
		$_POST['signtime']=(int)strtotime($_POST['signtime']);
	}
	
	if($webset['taoapi']['freeze']==1){
		/*$freeze_money=$duoduo->sum('income','money','uid="'.$id.'"');
		$freeze_jifen=$duoduo->sum('income','jifen','uid="'.$id.'"');
		
		$_POST['money']-=$freeze_money;
		$_POST['jifen']-=$freeze_jifen;*/
	}
	
	/*if($webset['taoapi']['auto_fanli']==1){
		$user=$duoduo->select('user','*','id="'.$id.'"');
		if($_POST['trade_uid']!=$user['trade_uid']){
			$user_trade_uid_arr=explode(',',$user['trade_uid']); //删除现有后四位
			foreach($user_trade_uid_arr as $v){
				$duoduo->trade_uid($id,$v,'del');
			}
	
			if($_POST['trade_uid']!=''){
				$trade_uid_arr=explode(',',$_POST['trade_uid']);  //增加后四位
				foreach($trade_uid_arr as $v){
					$duoduo->trade_uid($id,$v,'add');
				}
			}
		}
	}*/
	
	unset($_POST['id']);
	unset($_POST['sub']);
	if($id==0){
	    $id=$duoduo->insert(MOD,$_POST);
		jump('-2','保存成功');
	}
	else{
	    $duoduo->update(MOD,$_POST,'id="'.$id.'"');
		jump('-2','修改成功');
	}
}
else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
    if($id==0){
	    $row=array();
	}
	else{
		$spend_jifenbao=$duoduo->sum('duihuan','spend','`mode`=1 and status=1 and uid="'.$id.'"');
		$spend_jifen=$duoduo->sum('duihuan','spend','`mode`=2 and status=1 and uid="'.$id.'"');
		$webnames='';
	    $row=$duoduo->select(MOD,'*','id="'.$id.'"');
		$apiweb=$duoduo->select_all('apilogin as a,api as b','b.code,b.title','a.uid="'.$id.'" and a.web=b.code');
		foreach($apiweb as $k=>$arr){
		    $webnames.='<img src="../images/login/'.$arr['code'].'_1.gif" alt="'.$arr['title'].'" /> &nbsp;';
		}
		$row=$duoduo->freeze_user($row);
	}
}
?>