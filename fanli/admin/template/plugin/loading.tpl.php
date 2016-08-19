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
if(empty($_SERVER["REQUEST_URI"])){
	$_SERVER["REQUEST_URI"]=$_SERVER['PHP_SELF']."?".$_SERVER["argv"][0];
}
$yun_url=DD_YUN_URL."/index.php?g=Home&m=Bbx&a=view&code=".$_GET['code'];
$url=str_replace("act=loading","act=down",$_SERVER["REQUEST_URI"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>插件下载更新操作</title>
<script type="text/javascript" src="../js/jquery.js"></script>
</head>
<body style="text-align:center">
<div style="margin:15px auto;width:400px;" id="loading">
<div style="width:400px; padding-top:4px;height:24;border-left:1px solid #cccccc;border-top:1px solid #cccccc;border-right:1px solid #cccccc;background-color:#DBEEBD; text-align:center">系统提示</div>
<div style="width:400px;height:100px;border:1px solid #cccccc;background-color:#F4FAEB; text-align:center"> 
<br/>下载中......倒计时：<span id="djs">30</span>秒<br/><br/>
<img src="../images/wait2.gif" />
</div>
</div>
<script>
var timeout=0;
var waitSecond=30;
var refreshFun = function(){
		timeout++;
		var shengyu=waitSecond - timeout;
		if(shengyu<=0){
			alert("可能插件包太大，无法完成自动下载，请手动安装！");
			window.location.href="<?php echo $yun_url;?>";
		}else{
			$('#djs').html(shengyu);
			setTimeout(refreshFun,1000);
		}
};
setTimeout(refreshFun,1000);
$.ajax({
	url: '<?php echo $_SERVER["REQUEST_URI"]?>',
	type: "GET",
	data:{down:1},
	dataType: "html",
	success:function(data){
		if(data=="1"){
			window.location.href="<?php echo $url;?>";
		}else{
			alert(data);
			window.location.href="<?php echo $yun_url;?>";
		}
	},
	error:function(error){
		alert(error);
		window.location.href="<?php echo $yun_url;?>";
	}
});
</script>
</body>
</html>