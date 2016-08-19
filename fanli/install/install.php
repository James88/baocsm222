<?php
error_reporting(0);
header('Cache-control: none-Cache');
header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
define('DDROOT',dirname(dirname(__FILE__)));
include('../comm/comm.func.php');
include('../comm/json.php');
include('../comm/define.php');
include('../comm/dd.func.php');
include('../comm/dd.class.php');
include('../comm/collect.class.php');
include('../comm/mod.func.php');
if($_SERVER['PHP_SELF']==''){
	$_SERVER['PHP_SELF']=$_SERVER['SCRIPT_NAME'];
}
$step = 0;
if(!empty($_GET['step']))
{
	$step = intval($_GET['step']);
}


function checktaobao($taobao)
{
	$taobao = cleartrim($taobao);

	if(!$taobao['taokecode'])
	{
		return '授权码不能为空!';
	}

	return false;
}

function cleartrim($array)
{
	foreach($array as $key => $value)
	{
		$array[$key] = trim($value);
	}

	return $array;
}

if($_POST && $_POST['db'])
{
	$step = 3;
}

if(in_array($step,array(0,1,2,3)) && file_exists('install.php.lock'))
{
	echo "<script>window.locltion='index.php'</script>";
	exit;
}

$step = 'step-'.$step.'.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>多多返利建站系统 安装向导</title>
<link rel="stylesheet" href="images/style.css" type="text/css" media="all" />
<link href="../css/jumpbox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jumpbox.js"></script>
<script type="text/javascript" src="../js/fun.js"></script>
</head>
<body>
<?php
require $step;
mysql_close();
?>
</body>
</html>