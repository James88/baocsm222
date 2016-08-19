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
  <tr class="header">
    <td class="red">
    <?php
	include(DDROOT.'/update.php');
	unlink(DDROOT.'/update.php');
	?>
    <ol>
    <?php foreach($msg as $v){?>
      <li><?=$v?></li>
    <?php }?>
    </ol>
    </td>
  </tr> 
</table>
<?php
$url=u(MOD,ACT,array('release'=>$release,'step'=>8,'rela'=>1));
$redtime=5000;
?>
<script type="text/javascript">
setTimeout("redirect('<?php echo $url?>')", <?php echo $redtime?>);
function redirect(url) {
	window.location.replace(url);
}
</script>