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
$admin_name=str_replace(DDROOT,'',ADMINROOT);
$admin_name=str_replace('/','',$admin_name);
$top_nav_name=array(array('url'=>u('user_temp','qunfa_tag'),'name'=>'群发方案'),array('url'=>u('user_temp','list'),'name'=>'待发列表'),array('url'=>u('user_temp','qunfa_jilu'),'name'=>'已发记录'));
include(ADMINTPL.'/header.tpl.php');
?>
<?php 
$domain_url=get_domain();
$url=DD_OPEN_URL.'/index.php?m=sms_qunfa_sign&a=index&name='.$domain_url;
?>
<br />
<iframe src="<?=$url?>" id="main" name="main" style="overflow: visible;display:" frameborder="0" height="950px" scrolling="yes" width="100%"></iframe>
</div>
<?php include(ADMINTPL.'/footer.tpl.php');?>