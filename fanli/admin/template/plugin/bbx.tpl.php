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
include(ADMINTPL.'/header.tpl.php');
?>
<?php 
$domain_url=get_domain();
$url=urlencode($domain_url);
?>
<script src="<?=DD_YUN_URL?>/alert.js"></script>
<div class="admin_table">
<div class="explain-col"><a href="<?=u('plugin','list')?>">点击进入我的订单。</a>
  </div>
<iframe src="<?=DD_YUN_URL?>/index.php?g=Home&m=Bbx&url=<?=urlencode(SITEURL.'/'.$admin_name)?>&domain=<?=urlencode(DOMAIN)?>&banben=<?=BANBEN?>" id="main" name="main" style="overflow: visible;display:" frameborder="0" height="950px" scrolling="yes" width="100%"></iframe>
</div>
<?php include(ADMINTPL.'/footer.tpl.php');?>