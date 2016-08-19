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
dd_exit('文件已删除');
if($_GET['del']==1 && $_SESSION['ddadmin']['id']==1){ //只有默认管理员才有删除文件的权限
    unlink($_GET['filename']);
	jump(u('scan','file'),'删除成功！');
}
elseif($_GET['see']==1){
    $php=file_get_contents($_GET['filename']);
	echo '<textarea name="str" style="width:100%;height:450px;background:#cccccc;">'.$php.'</textarea><br/><br/><button onclick="history.go(-1)">返回</button>';
}