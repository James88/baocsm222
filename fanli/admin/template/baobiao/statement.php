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

if(!defined('INDEX') && !defined('ADMIN')){
	exit('Access Denied');
}

	function plugin_statement_insert(){//list日期更新
		global $duoduo;
		
		//检索最早的一条订单时间
		$tbtime=$duoduo->select('tradelist','pay_time','checked="2" and pay_time<>"" and pay_time > "0000-00-00 00:00:00" order by pay_time asc');
		$tasktime=$duoduo->select('task','addtime','(immediate = "1" or immediate = "2") order by addtime asc');
		$stime=$tbtime>$tasktime&&!empty($tasktime)?$tasktime:$tbtime;
		if($stime!=''){
			$s=date("Y-m",strtotime($stime));
		}else{
			$s=date("Y-m",time());
		}
			$d=date("Y-m",time());
		$i=0;
		while( $s < $d){
			$time=strtotime($stime);
			$y=date("Y",$time);
			$m=date("m",$time);
			$data['stime']=date("Y-m-d H:i:s",mktime(0,0,0,$m+$i,1,$y));         // 创建本月开始时间
			$data['dtime']=date("Y-m-d H:i:s",mktime(0,0,0,$m+$i+1,1,$y));       // 创建本月结束时间
			$s=date("Y-m",strtotime($data['dtime']));
			$st=date("Y-m",strtotime($data['stime']));
			//查询数据库中有没这条记录
			$id=$duoduo->select('statement','id','date="'.$st.'"');
			//数据库中没有则继续下面
			if($id==''){
			$data['date']=date("Y-m",strtotime($data['stime']));
			//插入数据库
			$duoduo->insert('statement',$data);
			}
			$i++;
		}
	}

	function plugin_statement_update($id_arr){//数据更新
		global $duoduo;
		
		foreach($id_arr as $id){
			$arr=$duoduo->select('statement','stime,dtime','id="'.$id.'"');
			$stime=$arr['stime'];
			$dtime=$arr['dtime']; 
			
			//阿里妈妈联盟
			$where='pay_time >= "'.$stime.'" and pay_time < "'.$dtime.'" and checked >= "0"';
			$taobao=$duoduo->sum('tradelist','pay_price,commission,fxje',$where);
			$data['taocj']=$taobao['pay_price'];
			$data['taoyj']=$taobao['commission'];
			$data['taolr']=$data['taoyj']-$taobao['fxje'];
			
			//拍拍联盟chargeTime
			$where='chargeTime >= "'.strtotime($stime).'" and chargeTime < "'.strtotime($dtime).'" and checked >= "0"';
			$paipai=$duoduo->sum('paipai_order','careAmount,commission,fxje',$where);
			$data['paicj']=$paipai['careAmount'];
			$data['paiyj']=$paipai['commission'];
			$data['pailr']=$data['paiyj']-$paipai['fxje'];
			
			//商城联盟
			$where='order_time >= "'.strtotime($stime).'" and order_time < "'.strtotime($dtime).'" and status >= "0"';
			$mall=$duoduo->sum('mall_order','sales,commission,fxje',$where);
			$data['mallcj']=$mall['sales'];
			$data['mallyj']=$mall['commission'];
			$data['malllr']=$data['mallyj']-$mall['fxje'];
			
			//任务返利
			$where='addtime >= "'.$stime.'" and addtime < "'.$dtime.'" and (immediate = "1" or immediate = "2")';
			$task=$duoduo->sum('task','commission,point',$where);
			$data['taskyj']=$task['commission'];
			$data['tasklr']=$data['taskyj']-$task['point'];
	
			//更新数据库
			$duoduo->update('statement',$data,'id="'.$id.'"');
		}
	} 
	
	function plugin_statement_data($n,$t){//图标数据
		global $duoduo;
		
		$nf=$duoduo->select_all('statement','*','1 order by `date` desc limit 0,12');
		$dataxml = "<graph caption='".$n."' xAxisName='' yAxisName='' baseFontSize='14' decimalPrecision='2' formatNumberScale='0'>";
		foreach(array_reverse($nf) as $info){
			$dataxml.= "<set name='".$info['date']."' value='".$info[$t]."' color='AFD8F8' />";
		}
		$dataxml.= "</graph>";
		
		return $dataxml;
	}
?>