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

if(!defined('INDEX')){
	exit('Access Denied');
}

if(!isset($_POST['sub'])){
	$a=authcode('uid='.$dduser['id'].'&agent='.md5('')."&time=".TIME, 'ENCODE', DDKEY);
	$a=urlencode($a);
}
else{
	function make_avatar_path($uid, $dir = '.') {
        $uid = sprintf("%010d", $uid);
        $dir1 = substr($uid, 0, 4);
        $dir2 = substr($uid, 4, 4);
        //$dir3 = substr($uid, 5, 2);
        !is_dir($dir.'/'.$dir1) && mkdir($dir.'/'.$dir1, 0777);
        !is_dir($dir.'/'.$dir1.'/'.$dir2) && mkdir($dir.'/'.$dir1.'/'.$dir2, 0777);
		return $dir.'/'.$dir1.'/'.$dir2.'/';
    }
	include(DDROOT.'/comm/thumb.class.php');
	
	$picname=upload('up_pic',DDROOT.'/upload/avatar/a'.$dduser['id'].'.jpg',2);

	$picname=change_img($picname,'jpg');
	$save_pic_dir=make_avatar_path($dduser['id'],DDROOT.'/upload/avatar');
	
	$uid = sprintf("%02d", $dduser['id']);
	$avatar_id=substr($uid, -2);
	
	$t = new ThumbHandler();
	$t->setSrcImg($picname);
	$t->setCutType(1);
	$t->setDstImg($save_pic_dir.$avatar_id."_avatar_small.jpg");
	$t->createImg(48,48);
	
	$t->setSrcImg($picname);
	$t->setCutType(1);
	$t->setDstImg($save_pic_dir.$avatar_id."_avatar_middle.jpg");
	$t->createImg(120,120);

	$t->setSrcImg($picname);
	$t->setCutType(1);
	$t->setDstImg($save_pic_dir.$avatar_id."_avatar_big.jpg");
	$t->createImg(200,200);
	
	if(FUJIAN_FTP==1){
		$config=array('hostname' => FTP_IP,'username' => FTP_USER,'password' => FTP_PWD,'port' => FTP_PORT,'pasv' => FTP_PASV,'timeout' => FTP_TIMEOUT,'mulu' => FTP_MULU,'url' => FTP_URL);
		$ftp=fs('ftp',$config);
		$ftp->make_dir_file($save_pic_dir.$avatar_id."_avatar_small.jpg",0);
		$ftp->make_dir_file($save_pic_dir.$avatar_id."_avatar_middle.jpg",0);
		$ftp->make_dir_file($save_pic_dir.$avatar_id."_avatar_big.jpg",0);
	}
	
	unlink($picname);
	
	jump(u('user','avatar'),'上传完成');
}
?>