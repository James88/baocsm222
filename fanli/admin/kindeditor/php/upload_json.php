<?php
/**
 * KindEditor PHP
 * 
 * 本PHP程序是演示程序，建议不要直接在实际项目中使用。
 * 如果您确定直接使用本程序，使用之前请仔细确认相关安全设置。
 * 
 */
include('../../../comm/dd.config.php');

if(is_uploaded_file($_FILES['imgFile']['tmp_name']) && authcode($_POST['admin'],'DECODE')==1) {
	$file_name=upload('imgFile');
	if(is_numeric($file_name)){
		$data=array('error' => 1, 'message' => $errorData[$file_name]);
	}
	else{
		if(strpos($file_name,FTP_URL)===false){
			$file_name='../'.$file_name;
		}
		$data=array('error' => 0, 'url' => $file_name);
	}
}
echo json_encode($data);
dd_exit();
?>