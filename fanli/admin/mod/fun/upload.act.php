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

if($_GET['sid']) session_id($_GET['sid']);
if(isset($_GET['do'])) $do=$_GET['do'];
if(isset($_GET['type'])){
	$type=$_GET['type'];
}
else{
	$type='img';
}
$uploadtext = $_GET['uploadtext'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" type="text/javascript" src="../js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="../js/fun.js"></script>
<?php

$uploadtext = $_GET['uploadtext'];

if(isset($_FILES[$uploadtext]['error'])){
	switch($_FILES[$uploadtext]['error']) {   

    case 1:    
        exit('文件大小超出了服务器的空间大小');    
	break;    

	case 2:    
        exit('要上传的文件大小超出浏览器限制');  
   
    case 3:    
        exit('文件仅部分被上传');  
   
    case 4:    
        exit('没有找到要上传的文件');   
   
    case 5:    
        exit('服务器临时文件夹丢失');
   
    case 6: 
        exit('文件写入到临时文件夹出错');  
	}
}

if (is_uploaded_file($_FILES[$uploadtext]['tmp_name'])) {
	if($_FILES[$uploadtext]['error']>0){
		switch($_FILES[$uploadtext]['error']){
			case 1:
				dd_exit('上传文件太大');
			break;
			case 2:
				dd_exit('上传文件太大');
			break;
			case 3:
				dd_exit('文件只有部分上传成功');
			break;
			case 4:
				dd_exit('文件没有被上传');
			break;
			case 6:
				dd_exit('找不到临时上传目录');
			break;
			case 7:
				dd_exit('写入失败');
			break;
		}
	}
	
	$saved_upload_name='';
	if($_GET['name']!=''){
		$img_im=explode('.',$_FILES[$uploadtext]['name']);//取后缀
		$saved_upload_name=DDROOT.'/upload/'.$_GET['name'].'.'.$img_im['1'];
	}
	$file_name=upload($uploadtext,$saved_upload_name);
	
	if(is_numeric($file_name)){
		echo $errorData[$file_name];
		exit;
	}
	else{
		if($do=='httpurl' && FUJIAN_FTP==0){
			$file_name=SITEURL.'/'.$file_name;
		}
		?>
		<script language="javascript" type="text/javascript">
		$(window.opener.document).find("#<?=$uploadtext?>").val('<?=$file_name?>');
		if(window.opener.uploadCall){
			window.opener.uploadCall("<?=$uploadtext?>","<?=$file_name?>");
		}
		window.close();
        </script>
		<?
	}
}
?>
<script type="text/javascript">
<!--
function doCheck() 
{
	if(upload.<?=$uploadtext?>.value == '') {
		alert('请选择文件!');
		return false;
	}
	return true;
}

function setpicWH(ImgD,w,h)
{
	var image=new Image();
	image.src=ImgD.src;
	if(image.width>0 && image.height>0)
	{
		flag=true;
		if(image.width/image.height>= w/h)
		{
			if(image.width>w)
			{
				ImgD.width=w;
				ImgD.height=(image.height*w)/image.width;
				ImgD.style.display="block";
			}else{
				ImgD.width=image.width;
				ImgD.height=image.height;
				ImgD.style.display="block";
			}
		}else{
			if(image.height>h)
			{
				ImgD.height=h;
				ImgD.width=(image.width*h)/image.height;
				ImgD.style.display="block";
			}else{
				ImgD.width=image.width;
				ImgD.height=image.height;
				ImgD.style.display="block";
			}
		}
	}
}
//-->
</script>
<style type="text/css">
<!--
body { margin:0px; padding:0px; text-align:center; width:100%}
img { border:#FF9900 1px solid}
-->
</style>
</head>
<body>
<div style=" width:430px; height:auto; background:#CCCCCC; border:#999999 4px solid; margin:auto; margin-top:30px; padding-top:10px">

<form name="upload" method="post" action="" enctype="multipart/form-data" onSubmit="return doCheck();">
<div style="text-align:center">文件上传</div>
<table cellpadding="2" cellspacing="1" class="table_form" style="width:300px; margin:auto; text-align:center">
    
  <tr>
     <td>
             <input name="<?=$uploadtext?>" type="file" size="15">
             <input type="submit" name="dosubmit" value=" 上传 ">
			 </td>
   </tr>
  <tr>
     <td>
	 </td>
   </tr>
   <?php if($type=='img'){?>
  <tr>
     <td align="center" style=" padding-top:20px;">
<img id="previewpic" onload="setpicWH(this,300,300)">
<script type="text/javascript">
<!--
if($("#<?=$uploadtext?>",window.opener.document).val())
{
    $("#previewpic").attr("src", http_pic($(window.opener.document).find("#<?=$uploadtext?>").val())); 
}
else
{
	$("#previewpic").attr("src","images/nopic.gif"); 
}
//-->
</script>
			 </td>
   </tr>
   <?php }?>
</table>
</form>
</div>
</body>
</html>