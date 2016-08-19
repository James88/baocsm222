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
$top_nav_name=array(array('url'=>u(MOD,'list'),'name'=>'数据库管理'),array('url'=>u(MOD,'backup'),'name'=>'还原数据库'),array('url'=>u(MOD,'check'),'name'=>'数据库检测'));
include(ADMINTPL.'/header.tpl.php');
?>
<div style="padding-left:10px; margin-top:10px">
<table width="700" border="0">
<tr>
<td style="padding-left:10px; font-size:20px; color:#990000; font-weight:bold">专用数据库检测修复工具</td>
</tr>
<tr><td height="10"></td></tr>
<tr>
<td style="padding-left:20px; line-height:20px">
<?php
$need_repaire=0;
if ($repaire == 0) {
	echo '<span style="font-weight:bold; color:#ff6600; font-size:12px;">开始检测表结构</span><br/>';
	if (!empty ($miss_table_msg)) {
		foreach ($miss_table_msg as $v) {
			echo '缺少表：' . $v . '<br/>';
			$need_repaire = 1;
		}
	}
	if (!empty ($miss_field_msg)) {
		foreach ($miss_field_msg as $v) {
			echo '缺少字段：' . $v . '<br/>';
			$need_repaire = 1;
		}
	}
	if (!empty ($error_msg)) {
		foreach ($error_msg as $v) {
			echo '数据错误：' . $v . '<br/>';
			$need_repaire = 1;
		}
	}
	if(empty ($miss_table_msg) && empty ($miss_field_msg) && empty ($error_msg)){
	    echo '数据检测无问题！';
	}
}
else{
    if (!empty ($creat_table_msg)) {
		foreach ($creat_table_msg as $v) {
			echo '修复表：' . $v . '<br/>';
		}
	}
	if (!empty ($creat_field_msg)) {
		foreach ($creat_field_msg as $v) {
			echo '修复字段：' . $v . '<br/>';
		}
	}
	if (!empty ($repair_msg)) {
		foreach ($repair_msg as $v) {
			echo '修复数据：' . $v . '<br/>';
		}
	}
}
?>
</td>
</tr>
<tr><td style="padding-left:20px">
<?php if($need_repaire==1){?>
<form action="">
<input type="hidden" name="mod" value="data" />
<input type="hidden" name="act" value="check" />
<input type="hidden" name="repaire" value="1" />
<input type="submit" name="sub" value="一键修复" />
</form>
<?php }?>
</td></tr>
<tr>
<td style="padding-left:10px; color:#999999; line-height:25px;"><br>
<?php if (!empty ($error_msg)) {?>
<b style="color:red">数据错误指的是数据库字段需要添加唯一索引（如会员帐号，不可能存在两个同样的），但是由于数据库中已经存在两条或者多条重复数据，添加索引会失败，所以需要先修复数据。<br/>
修复数据的规则是，在重复的数据后加“_”，修复数据后站长需及时通知会员。</b><br/><br/>
如果您的数据库缺少字段，可能是你的数据库被破坏或没有运行升级文件。<br>
<?php }?>
1、如果你是升级后出现：说明你没有运行升级文件。<br>
2、如果是平时出现：可能数据库被破坏。<br>
3、如果是恢复数据后出现，可能你的数据库被还原到老版本了。<br>
4、如果无法确定提交论坛寻求帮助。
</td>
</tr>
</table>
</div>
<?php include(ADMINTPL.'/footer.tpl.php');?>