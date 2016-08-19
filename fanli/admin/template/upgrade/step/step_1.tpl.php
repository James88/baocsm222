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
?>
<table class="tb tb2 ">
    <?php if ($thisrelease ==$latestrelease) {?>
    <tr class="header hover">
      <td colspan="4">已经最新版本<?php echo $latestrelease?>，无需升级。</td>
      <td width="68" colspan="2"></td>
      <?php }?>
      <?php if ($thisrelease !=$latestrelease) {?>
    <tr class="header hover">
      <td colspan="4">&nbsp;当前版本<span class="red"><?php echo $thisrelease;?></span><?php if($updaterelease!=''){?>,检测到有新的版本<span class="red"><?php echo $updaterelease;?></span>可供升级,点击自动更新进行升级操作。<input type="button" class="btn" onclick="confirm('自动升级前请您先备份程序及数据库，确定开始升级吗？') ? window.location.href='<?=u('upgrade','index',array('release'=>$updaterelease,'step'=>2))?>' : '';" value="自动升级"><?php }else{?>，已经是最新版本！<?php }?></td>
      <td width="68" colspan="2"></td>
      <?php }?>
      <td width="64"></td>
    </tr>
    <tr class="header hover">
      <td colspan="7">官方版本列表（你可以按需升级，建议使用自动升级）</td>
    </tr>
    <tr class="header hover">
      <td width="85">更新日期</td>
      <td width="75">自动升级</td>
      <td width="150">文件名</td>
      <td width="80">更新说明</td>
      <td width="68">下载状态</td>
      <td width="110">直接升级数据库</td>
      <td>手动下载</td>
    </tr>
    <?php $i=-1; foreach($upgradelist as $vo){$i++;
	$dir=$vo['dir'];//路径
	$thisdir= UPGRADEROOT.'/'.$vo['release']."/uploads";
	if(is_array($vo['zip'])){
		$zip=reset($vo['zip']);//文件名
	}
	if(is_array($vo['desc'])){
		$desc=reset($vo['desc']);//更新说明
	}
	$updatefile=$vo['update']['file'];
?>
    <tr class="hover">
      <td ><?php echo $vo['release']?></td>
      <td><input type="button" class="btn <?php if($i!=0){?>dis<?php }?>" onclick="confirm('你确定要选择这个版本升级吗？确定开始升级吗？') ? window.location.href='<?=u('upgrade','index',array('release'=>$vo['release'],'step'=>2))?>' : '';" value="选它升级"></td>
      <td ><?php echo $zip['name']?></td>
      <td ><a href="<?php echo $upgradeurl.$dir.$desc['name']?>" target="_blank">更新说明</a></td>
      <?php if(file_exists($thisdir)){?>
      <td ><input type="button" class="btn <?php if($i!=0){?>dis<?php }?>" onclick="confirm('你确认删除本地<?php echo $vo['release']?>更新包吗，特别注意你备份文件也会删除最好手动删除，确定删除吗？') ? window.location.href='<?=u('upgrade','index',array('release'=>$vo['release'],'step'=>1,'del'=>$vo['release']))?>' : '';" value="删除"></td>
      <?php }else{?>
      <td width="110">还未下载</td>
      <?php }?>
      <?php if(!empty($updatefile)){?>
      <td ><input type="button" class="btn <?php if($i!=0){?>dis<?php }?>" onclick="confirm('确定不升级文件直接进行数据库升级吗，确定开始升级吗？') ? window.location.href='<?=u('upgrade','index',array('release'=>$vo['release'],'step'=>7))?>' : '';" value="直接升级数据库" /></td>
      <?php }else{?>
      <td >无需升级</td>
      <?php }?>
      <td><a href="<?php echo $upgradeurl.$dir.$zip['name']?>" target="_blank">手动下载</a></td>
    </tr>
    <?php }?>
  </table>
<script>
$(function(){
	$('.dis').attr('disabled',true).css('color','#999').css('cursor','default');
})
</script>