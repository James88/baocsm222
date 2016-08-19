<?php 
/**
 * ============================================================================
 * 版权所有 多多科技，保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}
include(ADMINTPL.'/header.tpl.php');
?>
<!--<a href="<?=DD_OPEN_JFB_REG_URL?><?=urlencode(URL)?>" style="color:#F30">集分宝平台</a>
<?php 
//echo file_get_contents(DD_OPEN_JFB_REG_URL.urlencode(URL));
?>-->
<iframe src="<?=DD_OPEN_JFB_REG_URL?><?=urlencode(URL)?>" frameborder="0" style="width:100%; height:560px"></iframe>