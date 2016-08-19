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

set_time_limit(3600);

if(function_exists('ini_set')){
	ini_set('max_execution_time',3600);
}

$data = dd_get_cache('basedata','array');

$repaire=$_GET['repaire']?1:0;
$miss_table_msg=array();
$creat_table_msg=array();
$miss_field_msg=array();
$creat_field_msg=array();
$error_msg=array();
$repair_msg=array();

$sql="SELECT count( `trade_id` ) AS num, `trade_id` FROM ".BIAOTOU."tradelist GROUP BY `trade_id` HAVING count( `trade_id` ) >1";
$a=$duoduo->sql_to_array($sql);
if(empty($a)){$a=array();}
foreach($a as $b){
	$c=$duoduo->select_all('tradelist','id,trade_id','trade_id="'.$b['trade_id'].'" order by id asc limit 1,'.($b['num']-1));
	foreach($c as $k=>$d){
		if($repaire==0){
			$error_msg[]='订单'.$d['trade_id'].'重复';
		}
		else{
			$duoduo->delete('tradelist','id="'.$d['id'].'"');
			$repair_msg[]='订单'.$d['trade_id'].'重复';
		}
	}
}

$sql="SELECT count( `email` ) AS num, `email` FROM ".BIAOTOU."user GROUP BY `email` HAVING count( `email` ) >1";
$a=$duoduo->sql_to_array($sql);
if(empty($a)){$a=array();}
foreach($a as $b){
	$c=$duoduo->select_all('user','id,email,ddusername','email="'.$b['email'].'" order by id asc limit 1,'.($b['num']-1));
	foreach($c as $k=>$d){
		if($repaire==0){
			$error_msg[]='邮箱'.$d['email'].'重复';
		}
		else{
			$data_a=array('email'=>$d['email'].'_'.$k);
			$duoduo->update('user',$data_a,'id="'.$d['id'].'"');
			$repair_msg[]='邮箱'.$d['email'].'重复';
		}
	}
}

$sql="SELECT count( `ddusername` ) AS num, `ddusername` FROM ".BIAOTOU."user GROUP BY `ddusername` HAVING count( `ddusername` ) >1";
$a=$duoduo->sql_to_array($sql);
if(empty($a)){$a=array();}
foreach($a as $b){
	$c=$duoduo->select_all('user','id,ddusername','ddusername="'.$b['ddusername'].'" order by id asc limit 1,'.($b['num']-1));
	foreach($c as $k=>$d){
		if($repaire==0){
			$error_msg[]='帐号'.$d['ddusername'].'重复';
		}
		else{
			$data_a=array('ddusername'=>$d['ddusername'].'_'.$k);
			$duoduo->update('user',$data_a,'id="'.$d['id'].'"');
			$repair_msg[]='帐号'.$d['ddusername'].'重复';
		}
	}
}

$sql="SELECT count( `salt` ) AS num, `salt` FROM ".BIAOTOU."tuan_goods GROUP BY `salt` HAVING count( `salt` ) >1";
$a=$duoduo->sql_to_array($sql);
if(empty($a)){$a=array();}
foreach($a as $b){
	$c=$duoduo->select_all('tuan_goods','id,salt','salt="'.$b['salt'].'" order by id asc limit 1,'.($b['num']-1));
	foreach($c as $d){
		if($repaire==0){
			$error_msg[]='团购商品'.$d['salt'].'重复';
		}
		else{
			$duoduo->delete('tuan_goods','id="'.$d['id'].'"');
			$repair_msg[]='团购商品'.$d['sid'].'重复';
		}
	}
}

$sql = "Show Tables";
$pre=BIAOTOU;
$query = $duoduo->query($sql);
while ($row = $duoduo->fetch_array($query,MYSQL_NUM)) {
	if (preg_match('/^'.$pre.'/', $row[0])) {
		$aa=preg_replace('/^'.$pre.'/','',$row[0]);
		if(isset($data[$aa])){
			$duoduoSysTables[] =$aa;
		}
		$_duoduoSysTables[] =$aa;
	}
}

$sql_arr=array();

foreach($data as $table=>$field){
	
	if(!in_array($table,$duoduoSysTables)){ //没有表
		if($repaire==0){
		    $miss_table_msg[]=BIAOTOU.$table;
		}
	    else{
			$sql_arr[]=$duoduo->creat_table($table,$field);
		    $creat_table_msg[]=BIAOTOU.$table;
		}
	}
	else{ //检测字段
		$field_arr=$duoduo->show_fields($table);
		foreach($field as $k=>$v){
			if($k!='duoduo_table_index'){
			    if(!in_array($k,$field_arr)){
			        if($repaire==0){
				        $miss_field_msg[]=BIAOTOU.$table.'：'.$k;
				    }
				    else{
				        $sql_arr[]=$duoduo->reapaire_field($table,$k,$v);
					    $creat_field_msg[]=BIAOTOU.$table.' '.$k;
				    }
			    }
			}
			else{
				unset($a);unset($p);unset($error_index_num);
				$error_index_num=2;
				$indexs_1=$duoduo->show_index($table);

				foreach($indexs_1 as $o){
					if(preg_match('/_\d{1,2}$/',$o)){
						if($repaire==0){
							$miss_field_msg[]=BIAOTOU.$table.'：重复索引'.$o;
						}
						else{
							$sql="ALTER TABLE `".BIAOTOU.$table."` DROP INDEX `".$o."`";
							$duoduo->query($sql);
							$creat_field_msg[]=BIAOTOU.$table.'：删除重复索引'.$o;
						}
					}
				}
				
				$indexs_2=$v;
				$index_2=explode(',',$indexs_2);
				foreach($index_2 as $val){
					$val=trim($val);
					preg_match('/\(`(\w+)`\)/',$val,$b);
					$a[$b[1]]=array();
					if(preg_match('/^PRIMARY KEY/',$val)){
						$a[$b[1]]='PRIMARY';
					}
					elseif(preg_match('/^UNIQUE KEY/',$val)){
						$a[$b[1]]='UNIQUE';
					}
					elseif(preg_match('/^KEY/',$val)){
						$a[$b[1]]='KEY';
					}
				}
				foreach($a as $n=>$m){
					if(!in_array($n,$indexs_1)){
						if($repaire==0){
				        	$miss_field_msg[]=BIAOTOU.$table.'：缺少索引'.$n;
				    	}
						else{
							if($m=='KEY'){
								$sql="ALTER TABLE `".BIAOTOU.$table."` ADD INDEX ( `".$n."` )";
							}
							elseif($m=='UNIQUE'){
								$sql="ALTER TABLE `".BIAOTOU.$table."` ADD UNIQUE ( `".$n."` )";
							}
							$duoduo->query($sql);
							$creat_field_msg[]=BIAOTOU.$table.'：添加索引'.$n;
						}
					}
				}
			}
		}
	}
}

//数据结构
/*foreach ($_duoduoSysTables as $tablename) {
	$query = $duoduo->query('show fields from `' . BIAOTOU . $tablename.'`;');
	while ($arr = $duoduo->fetch_array($query)) {
		$info = $arr['Type'];
		if ($arr['Null'] == 'NO') {
			$info .= ' NOT NULL';
		}
		$type = strtolower(preg_replace('/\((.*)\)/', '', $arr['Type']));
		if ($type == 'int' or $type == 'tinyint' or $type == 'bigint' or $type == 'double') { //数字类型<br>
			if ($arr['Default'] != '') {
				$info .= ' default "' . $arr['Default'] . '"';
			}
		} else {
			if ($arr['Null'] == 'YES') {
				if ($arr['Default'] != '') {
					$info .= ' default "' . $arr['Default'] . '"';
				} else {
					$info .= ' default NULL';
				}
			}
		}

		if ($arr['Extra'] != '') {
			$info .= ' ' . $arr['Extra'];
		}

		$table_data[$tablename][$arr['Field']] = $info;

		if ($arr['Key'] != '') {
			if ($arr['Key'] == 'PRI') {
				$duoduo_table_index = 'PRIMARY KEY  (`' . $arr['Field'] . '`)';
			}
			elseif ($arr['Key'] == 'UNI') {
				$duoduo_table_index .= ',UNIQUE KEY `' . $arr['Field'] . '` (`' . $arr['Field'] . '`)';
			}
			elseif($arr['Key'] == 'MUL'){
				$duoduo_table_index .= ',KEY `' . $arr['Field'] . '` (`' . $arr['Field'] . '`)';
			}
		}
	}
	$table_data[$tablename]['duoduo_table_index'] = $duoduo_table_index;
}

if(DOMAIN=='localhost' || DOMAIN=='duoduo123.com'){
	dd_set_cache('basedata',$table_data,'array');
}*/

//删除站内信错误
$msg=$duoduo->select_all('msg','senduser','uid="0"');
foreach($msg as $row){
	if($row['senduser']==0){
		$duoduo->delete('msg','uid="0" and senduser="0"');
	}
	$id=$duoduo->select('user','id','id="'.$row['senduser'].'"');
	if($id==''){
		$duoduo->delete('msg','uid="0" and senduser="'.$row['senduser'].'"');
	}	
}

//删除提现错误
$tixian=$duoduo->select_all('tixian','uid','status="0"');
foreach($tixian as $row){
	$id=$duoduo->select('user','id','id="'.$row['uid'].'"');
	if($id==''){
		$duoduo->delete('tixian','status="0" and uid="'.$row['uid'].'"');
	}
}

//删除兑换错误
$duihuan=$duoduo->select_all('duihuan','uid','status="0"');
foreach($duihuan as $row){
	$id=$duoduo->select('user','id','id="'.$row['uid'].'"');
	if($id==''){
		$duoduo->delete('duihuan','status="0" and uid="'.$row['uid'].'"');
	}
}

$menu_access=$duoduo->select_all('menu_access','id','role_id=1 and menu_id=39 limit 1,1000');
foreach($menu_access as $row){
	$duoduo->delete('menu_access','id="'.$row['id'].'"');
}
$menu_access=$duoduo->select_all('menu_access','id','role_id=1 and menu_id=40 limit 1,1000');
foreach($menu_access as $row){
	$duoduo->delete('menu_access','id="'.$row['id'].'"');
}
$menu_access=$duoduo->select_all('menu_access','id','role_id=1 and menu_id=124 limit 1,1000');
foreach($menu_access as $row){
	$duoduo->delete('menu_access','id="'.$row['id'].'"');
}

$sql="ALTER TABLE `".BIAOTOU."tuan_goods` CHANGE `salt` `salt` BIGINT( 20 ) NOT NULL DEFAULT '0'";
$duoduo->query($sql);

$sql="ALTER TABLE `".BIAOTOU."trade_uid` DROP INDEX `uid` ";
$duoduo->query($sql);

$sql="ALTER TABLE `".BIAOTOU."shop` CHANGE `created` `created` DATETIME NULL DEFAULT NULL ";
$duoduo->query($sql);

$sql="ALTER TABLE `".BIAOTOU."goods` CHANGE `logo` `logo` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ";
$duoduo->query($sql);
?>