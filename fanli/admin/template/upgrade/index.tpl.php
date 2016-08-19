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
?>
<link href="css/upgrade.css" rel="stylesheet" type="text/css" />
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="container" id="cpcontainer">
  <div class="itemtitle">
    <h3>在线升级</h3>
    <ul class="tab1" style="margin-right:10px">
    </ul>
    <ul class="stepstat">
      <li <?php if($step==1){?>class="current"<?php }?> id="step1">1.版本选择</li>
      <li <?php if($step==2){?>class="current"<?php }?> id="step2">2.获取待更新文件列表</li>
      <li <?php if($step==3){?>class="current"<?php }?> id="step3">3.下载更新</li>
      <li <?php if($step==4){?>class="current"<?php }?> id="step4">4.本地文件比对</li>
      <li <?php if($step==5){?>class="current"<?php }?> id="step5">5.正在覆盖更新</li>
      <li <?php if($step==6){?>class="current"<?php }?> id="step6">6.覆盖后文件校对</li>
      <li <?php if($step==7){?>class="current"<?php }?> id="step7">7.数据库更新</li>
      <li <?php if($step==8){?>class="current"<?php }?> id="step8">8.升级完成</li>
    </ul>
    <ul class="tab1">
    </ul>
  </div>
  <?php include(ADMINROOT.'/template/upgrade/step/step_'.$step.'.tpl.php');?>
</div>
<?php include(ADMINTPL.'/footer.tpl.php');?>