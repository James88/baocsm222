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

if(isset($_GET['msg'])){
	$id_arr=$_GET['ids'];
	if(empty($id_arr)){
		jump(-1,'无效参数');
	}
	foreach($id_arr as $k=>$v){
		if($k==0){
			$user_arr = $duoduo->select('user','ddusername','id='.$v);
		}else{
			$user_arr .= '|'.$duoduo->select('user','ddusername','id='.$v);
		}
	}
	jump(u('msg','addedi',array('name'=>$user_arr)));
}

if(isset($_GET['trade_uid'])){
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$pagesize=200;
	$frmnum=($page-1)*$pagesize;
	$a=$duoduo->select_all(MOD,'id,trade_uid','money>0 or jifenbao>0 or tbyitixian>0 or yitixian>0 limit '.$frmnum.','.$pagesize);
	if(empty($a)){
		jump(u(MOD,ACT),'提取完毕');
	}
	foreach($a as $row){
		if($row['trade_uid']!='0' && strpos($row['trade_uid'],'_')!==false){ //trade_uid包含下划线"_"
			$duoduo->trade_uid($row['id'],$row['trade_uid'].'_1','del');
		}
		$trade_id=$duoduo->select('tradelist','trade_id','uid="'.$row['id'].'" order by id desc');
		if($trade_id!=''){
			$duoduo->trade_uid($row['id'],$trade_id);
		}
	}
	
	$page++;
	PutInfo('提取淘宝订单会员id。。。<br/><br/><img src="../images/wait2.gif" />',u(MOD,ACT,array('trade_uid'=>1,'page'=>$page)));
}

if(isset($_GET['reg_trade_uid'])){
	$page = !($_GET['page'])?'1':intval($_GET['page']);
	$pagesize=200;
	$frmnum=($page-1)*$pagesize;
	$a=$duoduo->select_all('trade_uid','*','1 limit '.$frmnum.','.$pagesize);
	if(empty($a)){
		jump(u(MOD,ACT),'校正完毕');
	}
	foreach($a as $row){
		$uid_arr=explode(',',$row['uid']);
		foreach($uid_arr as $uid){
			$trade_uid=$duoduo->select('user','trade_uid','id="'.$uid.'"');
			if($trade_uid!=$row['trade_uid']){
			}
		}
	}
	
	$page++;
	PutInfo('提取淘宝订单会员id。。。<br/><br/><img src="../images/wait2.gif" />',u(MOD,ACT,array('trade_uid'=>1,'page'=>$page)));
}

$select1_arr=array('ddusername'=>'会员名','id'=>'会员ID','tjr'=>'推荐人名','qq'=>'QQ号码','alipay'=>'支付宝号','email'=>'邮箱','mobile'=>'手机号码','realname'=>'姓名','trade_uid'=>'后四位');
$select2_arr=array('money'=>'金额','jifenbao'=>TBMONEY,'jifen'=>'积分','level'=>'等级','loginnum'=>'登陆次数');
$select3_arr=array('0'=>'全部','1'=>'电脑','2'=>'手机');
$user_level_type=array('-1'=>'帐号类型')+$user_level_type;

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;
$by_field='';
$q=$_GET['q'];
$se2=$_GET['se2']; 
$se1=$_GET['se1']; 
$se3=$_GET['se3']; 
$t=$_GET['t']; 
$linput=$_GET['linput']!==''?$_GET['linput']:-999999; 
$hinput=$_GET['hinput']!==''?$_GET['hinput']:999999999; 
$page_arr=array();

$where='1=1';
if($se1=='tjr'){
    $q=$duoduo->select('user','id','ddusername="'.$q.'"');
}

if(isset($se1) && $q!=''){
    $where=' `'.$se1.'` = "'.$q.'"';
	
	if($se1=='ddusername' || $se1=='trade_uid'){
        $where=' `'.$se1.'` like "%'.$q.'%"';
    }
	
	$page_arr['q']=$q;
	$page_arr['se1']=$se1;
}

if(isset($se2)){
    $where.=' and ('.$se2.'>='.$linput.' and '.$se2.'<='.$hinput.')';
	
	$page_arr['linput']=$linput;
	$page_arr['hinput']=$hinput;
	$page_arr['se2']=$se2;
}

$by_field_arr=array('level','type','money','jifenbao','jifen','loginnum','lastlogintime');

foreach($_GET as $k=>$v){
    if(in_array($k,$by_field_arr)){
	    $by_field=$k;
	}
}

if(isset($se3) && $se3>0){
	$where.=' and `platform`='.$se3;
	$page_arr['se3']=$se3;
}

if(isset($t) && $t>=0){
	$where.=' and `type`='.$t;
	$page_arr['t']=$t;
}

if($_GET['reycle']==1){
	$reycle=1;
	$where.=' and  `del`='.$reycle;
	$page_arr['reycle']=$reycle;
}else{
	$where.=' and `del`="0"';
}

if($by_field!=''){
    if($_GET[$by_field]!='desc' && $_GET[$by_field]!='asc'){
	    $_GET[$by_field]='asc';
	}
	$by=$by_field.' '.$_GET[$by_field].',';
	$page_arr[$by_field]=$_GET[$by_field];
}
else{
    $by='';
}
if($_GET[$by_field]=='desc'){
    $listorder='asc';
}
else{
    $listorder='desc';
}

$total=$duoduo->count(MOD,$where);
$row=$duoduo->select_all(MOD,'*',$where.' order by '.$by.' id desc limit '.$frmnum.','.$pagesize);

if($se1=='tjr'){
    $q=$_GET['q'];
	$page_arr['q']=$q;
}
?>