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
$bankuai_data=$duoduo->select_all('bankuai','code,title',"1");
foreach($bankuai_data as $vo){
	$bankuai[$vo['code']]=$vo['title'];
	$code_arr[] = $vo['code'];
	$code1_arr[] = $vo['title'];
}
$pagesize=20;
if($_GET['jiance']!=''){
	$table_name=$_GET['table_name'];
	//goods表检测
	if(empty($table_name)){
		$buzhou=$_GET['buzhou']?$_GET['buzhou']:1;
		if($buzhou>3){
			jump(u(MOD,ACT),'检测完毕！');
		}
		$code = $_GET['code']?$_GET['code']:0;
		if($code<count($code_arr)){
			$auto_del = $_GET['auto_del'];
			$page_no=$_GET['page']?$_GET['page']:'1';
			$page1 = ($page_no-1)*$pagesize;
			$where = 'laiyuan_type<=2 and endtime>'.time().' and code = "'.$code_arr[$code].'" and del=0';
			$total = $duoduo->count('goods',$where);
			$goods = $duoduo->select_all('goods','id,data_id,discount_price',$where.' order by id desc limit '.$page1.','.$pagesize);
			$butongguo=array();
			if($buzhou==1||$buzhou==3){
				include (DDROOT . '/comm/Taoapi.php');
				include (DDROOT . '/comm/ddTaoapi.class.php');
				$ddTaoapi = new ddTaoapi();
			}
			if($buzhou==1){
				foreach($goods as $row){
					$status=$ddTaoapi->taobao_taobaoke_rebate_authorize_get($row['data_id']);
					if($status==0){
						$butongguo[]=$row['id'];
					}
				}
			}elseif($buzhou==2){
				$str='';
				$aa=array();
				foreach($goods as $row){
					$str.=$row['data_id'].',';
					$aa[(string)$row['data_id']]=$row['id'];
				}
				$arr=check_sold_out($str);
				foreach($arr as $k=>$v){
					if($v==1){
						$butongguo[]=$aa[$k];
					}
				}
			}
			if($buzhou==3){
				//更新数据
				foreach($goods as $row){
					$return=$ddTaoapi->taobao_tbk_tdj_get($row['data_id']);
					if($return['promotion_price']&&$return['promotion_price']!=$row['discount_price']){
						$save=array();
						$save['discount_price']=$return['promotion_price'];
						if($return['price']){
							$save['price']=$return['price'];
						}
						$duoduo->update('goods',$save,'id='.$row['id']);
						echo mysql_error();
					}				
				}
			}else{
				//删除
				array_filter($butongguo);
				if($butongguo){
					if($auto_del==0){
						$duoduo->update('goods',array('xiajia'=>'1'),'id in('.implode(',',$butongguo).')');
						echo mysql_error();
					}else{	
						$duoduo->delete('goods','id in('.implode(',',$butongguo).')');
						echo mysql_error();
					}
				}		
			}
			if(count($goods)<$pagesize || $page_no>25){
				if($code>=(count($code_arr)-1)){
					$buzhou++;
					PutInfo('<img src="../images/wait2.gif"><br><br>将进行下一步骤的检测，请不要刷新页面...',u(MOD,ACT,array('page'=>1,'jiance'=>1,'auto_del'=>$auto_del,'code'=>0,'buzhou'=>$buzhou)));
				}else{
					$code++;
					PutInfo('<img src="../images/wait2.gif"><br><br>将检测下一个栏目，请不要刷新页面...',u(MOD,ACT,array('page'=>1,'jiance'=>1,'auto_del'=>$auto_del,'code'=>$code,'buzhou'=>$buzhou)));
				}
			}else{
				$page_no++;
				if($buzhou==1){
					$buzhou_title="容许返利检测";
				}elseif($buzhou==2){
					$buzhou_title="商品下架检测";
				}else{
					$buzhou_title="商品价格更新检测";
				}
				PutInfo('<img src="../images/wait2.gif"><br><br>检测【'.$code1_arr[$code].'】商品：正在进行第'.($page_no-1).'页的'.$buzhou_title.'，请不要刷新页面...',u(MOD,ACT,array('page'=>$page_no,'jiance'=>1,'auto_del'=>$auto_del,'code'=>$code,'buzhou'=>$buzhou)));
			}
		}
	}
}
else{
	$where='`xiajia`=1';
	$page_arr=array();
	if($_GET['title']!=''){
		$title=$_GET['title'];
		$where.=' and title like "%'.$title.'%"';
		$page_arr['title']=$title;
	}
	include(DDROOT.'/comm/goods.class.php');
	$ddgoods_class=new goods($duoduo);
	$data=$ddgoods_class->admin_list($pagesize,$where);
	$zhidemai_data=$data['data'];
	$total=$data['total'];
}
?>