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

if(isset($_GET['msg']) && $_GET['msg']==1){
	$id_arr=$_GET['ids'];
	if(empty($id_arr)){
		jump(-1,'无效参数');
	}
	$id_tmp = implode(',', $id_arr); 
	$row = $duoduo->select_all(MOD,'uid','id in ('.$id_tmp.')');
	foreach($row as $k=>$v){
		if($k==0){
			$user_arr = $duoduo->select(user,'ddusername','id='.$v['uid']);
		}else{
			$user_arr .= '|'.$duoduo->select(user,'ddusername','id='.$v['uid']);
		}
	}
	jump(u('msg','addedi',array('name'=>$user_arr)));
}
if(isset($_GET['daochu'])){
	$pay_jfb=$duoduo->select_all(MOD,'code,money2','type=1 and status=0');
	if(empty($pay_jfb)){
		jump(-1,'无待提现集分宝');
	}
	$s="收款帐号,发放集分宝数（个）"."\n";
	foreach($pay_jfb as $row){
		$s.= $row['code'].",".(int)$row['money2']."\n";
	}
	$input=array('type'=>'csv','name'=>'jifenbao','content'=>$s);
	echo postform('../comm/echo_gbk.php',$input);
	dd_exit();
}


$select_arr=array('uid'=>'会员名','code'=>'提现账号');

$status2_arr['']='全部';
$status_arr=$status2_arr+$status_arr;
$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;

$type = (int)$_GET['type'];
if($type>0){
	$type_where=' and a.`type`='.$type;
}
else{
	$type_where='';
}

$tool = (int)$_GET['tool'];
if($tool>0){
	$tool_where=' and a.`tool`='.$tool;
}
else{
	$tool_where='';
}

//处理批量提现
if(isset($_GET['ids'])){
	$id_arr=$_GET['ids'];
	$id=$id_arr[0];
	$re=$duoduo->tixian($id,'yes');
		
	if($re['s']==0){
		jump(u('tixian','list'),$re['r']);
	}
		
	unset($id_arr[0]);
	if(empty($id_arr)){
		jump(u('tixian','list',array('status'=>0)),'确认完毕');
	}
	else{
		$url=u(MOD,ACT,array('type'=>1)).'&'.arr2canshu($id_arr);
		putInfo('提现批量处理中。。。<br/><br/><img src="../images/wait2.gif" />',$url);
	}

	/*if($type==1 && $duoduo->webset['tixian']['ddpay']==1){
		$id=$id_arr[0];
		$re=$duoduo->tixian($id,'yes');
		
		if($re===0){
			jump(-1,'数据错误。');
		}
		
		unset($id_arr[0]);
		if(empty($id_arr)){
			jump(u('tixian','list',array('status'=>0)),'确认完毕');
		}
		else{
			$url=u(MOD,ACT,array('type'=>1)).'&'.arr2canshu($id_arr);
			putInfo($row['code'].'。。。<br/><br/><img src="../images/wait2.gif" />',$url);
		}
	}
	else{
		foreach($id_arr as $id){
			$re=$duoduo->tixian($id,'yes');
		}
		jump(u('tixian','list',array('status'=>0)),'确认完毕');
	}*/
}
//处理批量提现

if($_GET['first']==1){
    $sql='select * from (SELECT status,type, count(`id`) as cishu FROM `'.BIAOTOU.'tixian` group by `uid`) m where m.`status` = "0" and m.`cishu` = "1" '.$type_where.$tool_where;
    $rs = $duoduo->query($sql);
    $total = $duoduo->num_rows($rs);	
	
	$sql='select sum(money) as sum from (SELECT `id`,`status`,`type`,`money`,count(`id`) as cishu FROM `'.BIAOTOU.'tixian` group by `uid`) m where m.`status` = "0" and m.`cishu` = "1" '.$type_where.$tool_where;
	$rs = $duoduo->query($sql);
	$row = $duoduo->fetch_array($rs);
	$sum=(float)$row['sum'];
	
    $sql='select * from (SELECT a.`uid`,a.`status`,a.`type`,a.`code`,a.`addtime`,count(a.`id`) as cishu,b.ddusername FROM `'.BIAOTOU.'tixian` as a,'.BIAOTOU.'user as b where a.uid=b.id group by  a.`uid`) as m where m.`status` = "0" and m.`cishu` = "1" '.$type_where.$tool_where.' order by m.`addtime` desc  limit '.$frmnum.','.$pagesize;
    $row = $duoduo->select2arr($sql);

	$page_arr['first'] = 1;
}
else {
	$q = $_GET['q'];
	$se = $_GET['se'];
	$status = $_GET['status'];
	$where = '1=1'.$type_where.$tool_where;

	if (isset ($status) && $status !== '') {
		$where .= ' and a.`status` = "' . $status . '"';
		$page_arr['status'] = $status;
	} else {
		unset ($status);
	}

	if ($se == 'uid') {
		$uid = $duoduo->select('user', 'id', 'ddusername="' . $q . '"');
		$wq=$uid;
	}
	elseif($se=='code'){
		$wq=$q;
	}

	if (isset ($se) && $q != '') {
		$where .= ' and a.`' . $se . '` = "' . $wq . '"';
		$page_arr['q'] = $q;
		$page_arr['se'] = $se;
	}

	if($_GET['reycle']==1){
		$reycle=1;
		$where.=' and  a.`del`='.$reycle;
		$page_arr['reycle']=$reycle;
	}else{
		$where.=' and a.`del`="0"';
	}

	$total = $duoduo->count('tixian as a,user as b', $where.' and a.uid=b.id '.$type_where.$tool_where);
	$row = $duoduo->select_all('tixian as a,user as b', 'a.*,b.ddusername', $where . ' and a.uid=b.id '.$type_where.$tool_where.' order by a.id desc limit ' . $frmnum . ',' . $pagesize);
	$sum=(float)$duoduo->sum('tixian as a,user as b','a.money',$where.' and a.uid=b.id and a.status=0 '.$type_where.$tool_where.' order by a.id desc limit ' . $frmnum . ',' . $pagesize);
}

$page_arr['type'] = $type;
$page_arr['tool'] = $tool;
?>