<?php
error_reporting(0);
date_default_timezone_set('PRC');
define('DDROOT', str_replace(DIRECTORY_SEPARATOR,'/',dirname(dirname(__FILE__))));
include(DDROOT.'/comm/lib.php');
include(DDROOT.'/data/conn.php');
class pic {
	function yzm() {
		include('yzm.php');
		$rsi = new Utils_Caption();
        $rsi->TFontSize = array (16,18);
        $rsi->Width = 50;
        $rsi->Height = 25;
        $code = $rsi->RandRSI();
        dd_session_start();
        $_SESSION["captcha"] = $code;
        $rsi->Draw();
	}
	
	function easy_yzm(){
		$yzm = random(4); //随机生成的字符串
		$width = 50; //验证码图片的宽度
		$height = 25; //验证码图片的高度
		header("Content-Type:image/png");
		$im = imagecreate($width, $height);
		//背景色
		$back = imagecolorallocate($im, 0xFF, 0xFF, 0xFF);
		//模糊点颜色
		$pix = imagecolorallocate($im, 187, 230, 247);
		//字体色
		$font = imagecolorallocate($im, 41, 163, 238);
		//绘模糊作用的点
		mt_srand();
		for ($i = 0; $i < 1000; $i++) {
			imagesetpixel($im, mt_rand(0, $width), mt_rand(0, $height), $pix);
		}
		imagestring($im, 5, 7, 5, $yzm, $font);
		imagerectangle($im, 0, 0, $width -1, $height -1, $font);
		imagepng($im);
		imagedestroy($im);
		$str=$yzm.'|'.time();
		create_file(DDROOT.'/data/temp/session/'.date('Ymd').'/'.$yzm.'.yzm',$str);
		dd_session_start();
        $_SESSION["captcha"] = $yzm;
	}

	function show_pic($pic) {
		if(strpos($pic,'http')!==false){
			$image_ext = array( 'gif', 'jpeg', 'jpg', 'jpe', 'png' );
			preg_match('/(\.[a-zA-Z]{3,5})$/isU',$pic,$exts);
			$houzhui=str_replace('.','',strtolower($exts[1]));
			
			if(!in_array($houzhui,$image_ext)){
				return '';
			}
			header("Content-type: image/png");
		    echo dd_get($pic);
		}
		else{
			if($pic=='images/tbdp.gif' || $pic=='images/tbsc.gif'){
			    include('../'.$pic);
			}
		}
	}
}

$pic=new pic;
if(!isset($_GET['pic'])){
	if($_GET['easy']==1){
		$pic->easy_yzm();
	}
	else{
		$pic->yzm();
	}
}
else{
	$picname=ddStrCode($_GET['pic'],DDKEY,'DECODE');
	$pic->show_pic($picname);
}
?>