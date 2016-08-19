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
<style>
ul{ list-style:none; padding:0px; margin:0px; margin-top:20px}
ul li{ margin-bottom:5px; font-size:14px}
</style>
<div style="width:100%; padding-left:20px">
<div style="width:420px; margin-top:20px; font-size:20px; font-weight:bold; color:#990000; ">违规词专用检测工具 V1.0</div>
<form action="" method="get" >
<input type="hidden" name="mod" value="<?=MOD?>" />
<input type="hidden" name="act" value="<?=ACT?>" />
<div>
<ul style="margin-top:20px;">
  <li><?=$word?></li>
  <li><br /></li>
  <?php if($over==1){?>
  
   <div style=" height:auto; padding:10px;">
   	  <p>说明：</p>
      <p>1、本功能为仅根据预定设置对文字类做检测提示，请根据提示结果做对应修改调整。</p>
      <p>2、图片类含有“淘宝”，“返现”，“现金”，“提现”等字样请，人工查看并替换。主要为首页 文章教程页内。</p>
      <p>3、如需完全了解推广规范，请参见：<a href="http://club.alimama.com/read-htm-tid-5923484.html" target="_blank">http://club.alimama.com/read-htm-tid-5923484.html</a></p>
   </div>
   <?php }else{?>
   	  <?php if($moban==1){ jianceglob($dir); }else{?>
		  <?php if(empty($show)){?><span style="color:#00F">暂未发现违规事项</span><?php }?>
          <?php foreach($show as $v){?>
          <li><?=$v?>&nbsp;&nbsp;</li>
          <?php }?>
      <?php }?>
      <li><br /><input type="hidden" name="step" value="<?=$step+1?>" /><input type="submit" value="下一步" /> <input type="button" onclick="javascript:location.reload();" value="刷新" /> </li>
   <?php }?>
</ul>
</div>
</form>
</div>
<?php include(ADMINTPL.'/footer.tpl.php');?>