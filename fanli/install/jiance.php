<?php
error_reporting(0);
$dataname = $_GET['dataname'];
$datauser = $_GET['datauser'];
$datapwd = $_GET['datapwd'];
$host = $_GET['host'];
$conn = mysql_connect($host,$datauser,$datapwd);

if($_GET['datapre']){
	if($conn){
		mysql_select_db($dataname);
		$sql="SHOW TABLES LIKE '".$_GET['datapre']."ad'";
		$query=mysql_query($sql);
		$row=mysql_fetch_array($query);
		if($row[0]!=''){
			echo 1;
		}
		else{
			echo 2;
		}
	}
	else{
		echo 0;
	}
}
else{
	if($conn==''){
		echo 0;
	}
	else{
		echo 1;
	}
}
