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

function show_table_info($t,$datatype,$mysql_version) {
	$sqlcode='';
	$dropsql = "DROP TABLE IF EXISTS `$t`;\r\n";
	$sqlcode .= $dropsql;
	//fwrite($fp, "DROP TABLE IF EXISTS `$t`;\r\n\r\n");
	$sql_show_table = "SHOW CREATE TABLE `" . $t . "`";
	$query_show_table = mysql_query($sql_show_table);
	$row = mysql_fetch_array($query_show_table, MYSQL_BOTH);
	//去除AUTO_INCREMENT
	$row[1] = preg_replace("/AUTO_INCREMENT=([0-9]{1,})[ \r\n\t]{1,}/", "", $row[1]);

	//4.1以下版本备份为低版本
	if ($datatype == 4.0 && $mysql_version > 4.0) {
		$eng1 = "/ENGINE=MyISAM[ \r\n\t]{1,}DEFAULT[ \r\n\t]{1,}CHARSET=/utf8";
		$tableStruct = preg_replace($eng1, "TYPE=MyISAM", $row[1]);
	}

	//4.1以下版本备份为高版本
	else
		if ($datatype == 4.1 && $mysql_version < 4.1) {
			$eng1 = "ENGINE=MyISAM DEFAULT CHARSET=utf8";
			$tableStruct = preg_replace("/TYPE=MyISAM/", $eng1, $row[1]);
		}

	//普通备份
	else {
		$tableStruct = $row[1];
	}
	$sqlcode .= $tableStruct.';' . "\r\n/*duoduo table info cup*/;\r\n";
	mysql_free_result($query_show_table);
	return $sqlcode;
}


if($dopost=="viewinfo") //查看表结构
{
	echo "<div style='float:right'>[<a onclick='javascript:HideObj(\"_mydatainfo\")'><u>关闭</u></a>]</div><br/><pre>";
	if(empty($tablename))
	{
		echo "没有指定表名！";
	}
	else
	{
		$sql="SHOW CREATE TABLE ".$tablename;
		$query=$duoduo->query($sql);
		$row2 = $duoduo->fetch_array($query,MYSQL_NUM);
		$ctinfo = $row2[1];
		echo trim($ctinfo);
	}
	echo '</pre>';
	dd_exit();
}
else if($dopost=="opimize") //优化表
{
	echo "<div style='float:right'>[<a onclick='javascript:HideObj(\"_mydatainfo\")'><u>关闭</u></a>]</div><br/><pre>";
	if(empty($tablename))
	{
		echo "没有指定表名！";
	}
	else
	{
		$rs = $duoduo->query("OPTIMIZE TABLE `$tablename` ");
		if($rs)
		{
			echo "执行优化表： $tablename  OK！";
		}
		else
		{
			echo "执行优化表： $tablename  失败，原因是：".$duoduo->error();
		}
	}
	echo '</pre>';
	dd_exit();
}
else if($dopost=="repair") //修复表
{
	echo "<div style='float:right'>[<a onclick='javascript:HideObj(\"_mydatainfo\")'><u>关闭</u></a>]</div><br/><pre>";
	if(empty($tablename))
	{
		echo "没有指定表名！";
	}
	else
	{
		$rs = $duoduo->query("REPAIR TABLE `$tablename` ");
		if($rs)
		{
			echo "修复表： $tablename  OK！";
		}
		else
		{
			echo "修复表： $tablename  失败，原因是：".$duoduo->error();
		}
	}
	echo '</pre>';
	exit();
}
elseif ($dopost == 'bak') {
	if (empty ($tablearr)) {
		PutInfo('你没选中任何表！');
		exit ();
	}
	
	$bkdir = DDBACKUPDATA."/".'backupdata_'.date('Ymd');
	if (!is_dir($bkdir)) {
		MkdirAll($bkdir);
	}

	//初始化使用到的变量
	$tables = explode(',', $tablearr);
	if (!isset ($isstruct)) {
		$isstruct = 0;
	}
	if (!isset ($startpos)) {
		$startpos = 0;
	}
	if (!isset ($iszip)) {
		$iszip = 0;
	}
	if (empty ($nowtable)) {
		$nowtable = '';
	}
	if (empty ($fsize)) {
		$fsize = 2048;
	}
	$fsizeb = $fsize * 1024-1000;

	if ($nowtable == '') {
		$tmsg = '';
		$dh = dir($bkdir);
		while ($filename = $dh->read()) {
			if (!preg_match("/php$/", $filename)) {
				continue;
			}
			$filename = $bkdir . "/$filename";
			if (!is_dir($filename)) {
				unlink($filename);
			}
		}
		$dh->close();
		$tmsg .= "清除备份目录旧数据完成...<br />";
		dd_file_put($bkdir.'/ddkey.php',DDKEY);
		if ($isstruct == 1) {
			$bkfile = $bkdir . "/tables_struct_" . substr(md5(TIME . mt_rand(1000, 5000) . DDKEY), 0, 16) . ".php";
			$mysql_version = $duoduo->get_version();
			
			$sqlcode=$phpstart;
			
			foreach ($tables as $t) {
				$sqlcode.=show_table_info($t,$datatype,$mysql_version);
			}
			dd_file_put($bkfile,$sqlcode,FILE_APPEND);
			unset($sqlcode);
			$tmsg .= "备份数据表结构信息完成...<br />";
		}

		$tmsg .= "<font color='red'>正在进行数据备份的初始化工作，请稍后...</font>";
		$doneForm = "<form name='gonext' method='post' action='index.php?mod=data&act=list'>
		           <input type='hidden' name='isstruct' value='$isstruct' />
		           <input type='hidden' name='dopost' value='bak' />
		           <input type='hidden' name='fsize' value='$fsize' />
		           <input type='hidden' name='tablearr' value='$tablearr' />
				   <input type='hidden' name='date' value='$date' />
		           <input type='hidden' name='nowtable' value='{$tables[0]}' />
		           <input type='hidden' name='startpos' value='0' />
		           <input type='hidden' name='iszip' value='$iszip' />\r\n</form>\r\n{$dojs}\r\n";
		PutInfo($tmsg.$doneForm);
		exit ();
	}
	//执行分页备份
	else {
		$j = 0;
		$fs = $bakStr = '';
		$values_str='';
		
		if($startpos==0){
			$bakStr.=show_table_info($nowtable,$datatype,$mysql_version);
		}

		//分析表里的字段信息
		$sql_fields = mysql_list_fields($dbname,$nowtable);
		$columns = mysql_num_fields($sql_fields);
		
		//读取表的内容
		$sq_table ="Select * From `$nowtable`";
		$query_table = mysql_query($sq_table);

		for ($i = 0; $i < $columns; $i++) {
			$field_type=mysql_field_type($query_table, $i);
			$fs[$j]['name'] = trim(mysql_field_name($sql_fields, $i));
			$fs[$j]['type'] = $field_type;
			if($values_str==''){$values_str.='`'.$fs[$j]['name'].'`';}
			else{$values_str.=','.'`'.$fs[$j]['name'].'`';}
			$j++;
		}
		$fsd = $j -1;
		$intable = "INSERT INTO `$nowtable` (".$values_str.") VALUES(";
		
		$m = 0;
		$bakfilename = "$bkdir/{$nowtable}_{$startpos}_" . substr(md5(TIME . mt_rand(1000, 5000) . DDKEY), 0, 16) . ".php";
		while ($row2 = mysql_fetch_array($query_table)) {
			if ($m < $startpos) {
				$m++;
				continue;
			}

			//检测数据是否达到规定大小
			
			if (strlen($bakStr) > $fsizeb) {
				$fp = fopen($bakfilename, "w");
				fwrite($fp, $phpstart.$bakStr);
				fclose($fp);
				$tmsg = "<font color='red'>完成到{$m}条记录的备份，继续备份{$nowtable}...</font>";
				$doneForm = "<form name='gonext' method='post' action='index.php?mod=data&act=list'>
				                <input type='hidden' name='isstruct' value='$isstruct' />
				                <input type='hidden' name='dopost' value='bak' />
				                <input type='hidden' name='fsize' value='$fsize' />
				                <input type='hidden' name='tablearr' value='$tablearr' />
				                <input type='hidden' name='nowtable' value='$nowtable' />
								<input type='hidden' name='date' value='$date' />
				                <input type='hidden' name='startpos' value='$m' />
				                <input type='hidden' name='iszip' value='$iszip' />\r\n</form>\r\n{$dojs}\r\n";
				PutInfo($tmsg.$doneForm);
			}

			//正常情况
			$line = $intable;
			for ($j = 0; $j <= $fsd; $j++) {
				$field_value=$row2[$fs[$j]['name']];
				if($field_value==''){
					if($fs[$j]['type']=='string' || $fs[$j]['type']=='blob'){
					    $field_value="''";
					}
					else{
					    $field_value='NULL';
					}
					if ($j < $fsd) {
					    $line .= $field_value . ",";
				    } else {
					    $line .= $field_value . ");\r\n";
				    }
				}
				else{
				    $field_value=RpLine(addslashes($field_value));
					if ($j < $fsd) {
					    $line .= "'" . $field_value . "',";
				    } else {
					    $line .= "'" . $field_value . "');\r\n";
				    }
				}
			}
			$m++;
			$bakStr .= $line;
		}
		mysql_free_result($query_table);
		//如果数据比卷设置值小
		if ($bakStr != '') {
			$fp = fopen($bakfilename, "w");
			fwrite($fp, $phpstart.$bakStr);
			fclose($fp);
		}
		for ($i = 0; $i < count($tables); $i++) {
			if ($tables[$i] == $nowtable) {
				if (isset ($tables[$i +1])) {
					$nowtable = $tables[$i +1];
					$startpos = 0;
					break;
				} else {
					PutInfo("完成所有数据备份！");
					exit ();
				}
			}
		}
		$tmsg = "<font color='red'>完成到{$m}条记录的备份，继续备份{$nowtable}...</font>";
		$doneForm = "<form name='gonext' method='post' action='index.php?mod=data&act=list&dopost=bak'>
		          <input type='hidden' name='isstruct' value='$isstruct' />
		          <input type='hidden' name='fsize' value='$fsize' />
		          <input type='hidden' name='tablearr' value='$tablearr' />
		          <input type='hidden' name='nowtable' value='$nowtable' />
				  <input type='hidden' name='date' value='$date' />
		          <input type='hidden' name='startpos' value='$startpos'>\r\n</form>\r\n{$dojs}\r\n";
		PutInfo($tmsg.$doneForm);
		exit ();
	}
	//分页备份代码结束
}

//获取系统存在的表信息
$otherTables = Array ();
$dedeSysTables = Array ();

$sql = "Show Tables";
$query = $duoduo->query($sql);
$a=0;
$all_show=(int)$_GET['all_show'];
while ($row = $duoduo->fetch_array($query,MYSQL_NUM)) {
	if (preg_match('/^'.BIAOTOU.'/', $row[0])) {
		$a=1;
		$duoduoSysTables[] = $row[0];
	} else {
		if($a==1 && $all_show==0){break;}
		$otherTables[] = $row[0];
	}
}
$mysql_version=$duoduo->get_version();
$options=sel_date(DDBACKUPDATA);

