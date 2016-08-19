<?php //Êä³ögbk
header("Content-type: text/html; charset=gbk");
$type=$_POST['type'];
$content=iconv('utf-8','gbk//IGNORE',$_POST['content']);
if($type=='csv'){
	$name=$_POST['name'];
	header("Content-Type:application/csv");
	header("Content-Disposition:attachment;filename=".$name.".csv");
	echo $content;
}