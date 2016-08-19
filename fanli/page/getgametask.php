<?php 
define('INDEX',1);
include_once '../comm/dd.config.php';
include (DDROOT.'/comm/checkpostandget.php');

//$_GET=array (
//  'memberid' => '5',
//  'point' => '1.3',
//  'money' => '2.16',
//  'eventid' => 'a84bd4957b861f1bda608af64364191b',
//  'immediate' => '1',
//  'key' => '5abbee73020c6522',
//  'pass' => 'db3f061cc1723df042837bf646f07558',
//  'checktime' => '1402990578',
//  'programname' => '[棋牌]JJ斗地主-新手快速赛赚501经验值（先注册后安装）',
//  'addtime' => '1402990570',
//);

$_GET['ip']=$_SERVER['REMOTE_ADDR'];
$get=var_export($_GET, true)."\r\n";
$dir =DDROOT.'/data/gametask_'.substr(md5(DDKEY),0,16).'/'. date("Y").'/'.date('md').'.txt';
create_file($dir,$get,1);
	
if(isset($_GET['eventid']) && $_GET['eventid']!=''){
	$re=array('s'=>0,'r'=>'失败');
	$page_arr=$_GET;
	extract($page_arr);
	
	$gametask=$webset['gametask'];
	if($key!=DDYUNKEY && !empty($key)){
		$re=array('s'=>0,'r'=>'密钥错误');
		echo dd_json_encode($re);
		dd_exit();
	}
	if($money < $point){
		$re=array('s'=>5,'r'=>'数据错误');
		echo dd_json_encode($re);
		dd_exit();
	}
	$t=time()-$checktime;
	if($t > 600 || $checktime==0){
		$re=array('s'=>6,'r'=>'验证超时');
		echo dd_json_encode($re);
		dd_exit();
	}
	
	$passcode=md5($memberid.$point.$money.$eventid.$immediate.DDYUNKEY);
	
	if($eventid!='' && !empty($key) && $passcode==$pass){
		//入数据库
		$info=$duoduo->select('task','id','eventid="'.$eventid.'"');
		unset($data);
		$data['memberid']=$memberid;
		$data['commission']=$money;
		$data['type']=$type;//表示游戏返利订单
		$data['point']=$point;
		$data['immediate']=$immediate;
		$data['eventid']=$eventid;
		$data['programname']=$programname;
		$data['addtime']=date('Y-m-d H:i:s');
		if($addtime!=''){
			$data['addtime']=date('Y-m-d H:i:s',$addtime);
		}
		if(empty($info)){
			$i=$duoduo->insert('task',$data);
			if($i>0){
				$re=array('s'=>1,'r'=>'更新成功');
			}else{
				$re=array('s'=>2,'r'=>mysql_error());
			}
			//给会员结算
				unset($arr);
				$arr=array(array('f'=>'money','e'=>'+','v'=>$point),array('f'=>'level','e'=>'+','v'=>1));
				$duoduo->update('user',$arr,'id="'.$memberid.'"');
				//插入明细
				$data=array('uid'=>$memberid,'shijian'=>'29','money'=>$point,'source'=>'任务名：'.$programname);
				$duoduo->mingxi_insert($data);
		}else{
			$duoduo->update('task',$data,'id="'.$info.'"');
			$re=array('s'=>4,'r'=>'更新成功');
		}
	}else{
		$re=array('s'=>3,'r'=>'验证失败');
	}
	echo dd_json_encode($re);
	dd_exit();
}
?>