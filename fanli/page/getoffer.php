<?php 
define('INDEX',1);
include_once '../comm/dd.config.php';
include (DDROOT.'/comm/checkpostandget.php');

//$_GET=array (
//  'memberid' => '5',
//  'point' => '0.2',
//  'money' => '0.35',
//  'commission' => '0.35',
//  'eventid' => '939209c0f7bc41e0809c69c59f565d73',
//  'immediate' => '1',
//  'websiteid' => '1103',
//  'orderdate' => '1403026252',
//  'key' => '5abbee73020c6522',
//  'programname' => '免费赢Samsung',
//  'pass' => '0b1803bfa847e4cb10fdb9647ab9d8f8',
//  'checktime' => '1403026252',
//);

$_GET['ip']=$_SERVER['REMOTE_ADDR'];
$get=var_export($_GET, true)."\r\n";
$dir =DDROOT.'/data/task_'.substr(md5(DDKEY),0,16).'/'. date("Y").'/'.date('md').'.txt';
create_file($dir,$get,1);


if(isset($_GET['eventid']) && $_GET['eventid']!=''){
	$re=array('s'=>0,'r'=>'失败');
	$page_arr=$_GET;
	extract($page_arr);
	
	$t=time()-$checktime;
	if($t > 600 || $checktime==0){
		$re=array('s'=>4,'r'=>'验证超时');
		echo dd_json_encode($re);
		dd_exit();
	}
	
	$passcode=md5($memberid.$point.$commission.$eventid.$immediate.DDYUNKEY);
	if($eventid!='' && $passcode==$pass){
		//入数据库
		$info=$duoduo->select('task','id,immediate','eventid="'.$eventid.'"');
		
		unset($data);
		$data['memberid']=$memberid;
		$data['point']=$point;
		$data['type']=$type;//表示任务返利
		$data['eventid']=$eventid;
		$data['commission']=$commission;
		$data['programname']=$programname;
		$data['immediate']=$immediate;
		$data['addtime']=date('Y-m-d H:i:s');
		if($orderdate!=''){
			$data['addtime']=date('Y-m-d H:i:s',$orderdate);
		}
		if(empty($info)){
			$i=$duoduo->insert('task',$data);
			if($i>0){
				$re=array('s'=>1,'r'=>'添加成功');
				if($immediate==2 || $immediate==1){
					//给会员结算
					$arr=array(array('f'=>'money','e'=>'+','v'=>$point),array('f'=>'level','e'=>'+','v'=>1));
					$duoduo->update('user',$arr,'id="'.$memberid.'"');
					//插入明细
					$data=array('uid'=>$memberid,'shijian'=>'29','money'=>$point,'source'=>'任务名：'.$programname);
					$duoduo->mingxi_insert($data);
				}
				
			}else{
				$re=array('s'=>2,'r'=>mysql_error());
			}
		}else{
			$re=array('s'=>1,'r'=>'更新成功');
			$duoduo->update('task',$data,'id="'.$info['id'].'"');
			if(($immediate==2 || $immediate==1) && $info['immediate']==0){
				//给会员结算
				$arr=array(array('f'=>'money','e'=>'+','v'=>$point),array('f'=>'level','e'=>'+','v'=>1));
				$duoduo->update('user',$arr,'id="'.$memberid.'"');
				//插入明细
				$data=array('uid'=>$memberid,'shijian'=>'29','money'=>$point,'source'=>'任务名：'.$programname);
				$duoduo->mingxi_insert($data);
			}
		}
	}else{
		$re=array('s'=>3,'r'=>'验证错误');
	}
	echo dd_json_encode($re);
	dd_exit();
}