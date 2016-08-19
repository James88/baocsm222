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

include(ADMINTPL.'/header.tpl.php');

$sys_tool_arr = array (
	array (
		'name' => '查杀木马',
		'mod' => 'scan',
		'act' => 'check'
	),
	array (
		'name' => '返现宝',
		'mod' => 'fxb',
		'act' => 'set'
	),
	array (
		'name' => 'bshare分享',
		'mod' => 'bshare',
		'act' => 'set'
	),
	array (
		'name' => '文件校对',
		'mod' => 'scan',
		'act' => 'file'
	),
	array (
		'name' => '生成关键词链接',
		'mod' => 'plugin',
		'act' => 'keyword'
	),
);

?>
<style>
ul li{ float:left; margin-right:30px}
</style>
<div style="margin-top:10px;"><ul>
<?php foreach($sys_tool_arr as $row){?>
<li><a href="<?=u($row['mod'],$row['act'])?>" style="font-size:16px"><?=$row['name']?></a></li>
<?php }?>
</ul></div>
<?php include(ADMINTPL.'/footer.tpl.php');?>