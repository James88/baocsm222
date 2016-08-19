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
$top_nav_name=array(array('url'=>u('mobile','wap_set'),'name'=>'wap设置'),array('url'=>u('mobile','weixin'),'name'=>'微信设置'));
include(ADMINTPL.'/header.tpl.php');
?>
<iframe src="<?=DD_YUN_URL?>/?m=weixin&siteurl=<?=URL?>&ver=2" frameborder="0" style="width:100%; height:560px"></iframe>
<?php include(ADMINTPL.'/footer.tpl.php');?>