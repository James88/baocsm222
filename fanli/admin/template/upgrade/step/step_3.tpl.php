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
<h3>信息提示</h3>
<div class="infobox">
<?php if($state==2){ $redtime=0;?>
  <h4 class="infotitle1">正在从官方下载更新文件<?php echo $download_file?></h4>
  <img src="images/ajax_loader.gif" class="marginbot" />
<?php }elseif($state==1){$redtime=10000;?>
    <h4 class="infotitle1"><?php echo $download_file?>没有成功下载</h4>
<?php }else{$redtime=10000;?>
 	<h4 class="infotitle1" title="可能网络原因,可能服务器上文件没更新"><?php echo $download_file?>文件的MD5校验错误，文件可能被改了(截图保留)</h4>
<?php }?>
  <p class="marginbot"><a href="<?php echo $url?>" class="lightlink">如果您的浏览器没有自动跳转，请点击这里</a></p>
</div>
<script type="text/javascript">
	setTimeout("redirect('<?php echo $url?>')", <?php echo $redtime?>);
function redirect(url) {
	window.location.replace(url);
}
</script>
</table>