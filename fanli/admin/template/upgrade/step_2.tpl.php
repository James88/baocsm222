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
$ok=1;
?>
<div class="explain-col"> 如果提示您某文件夹需要权限，请更改其操作权限，升级完毕后可还原您的设置。
  </div>
<br />
<table class="tb tb2 ">
    <tr class="header">
      <td>版本<?php echo $release?>的待更新文件列表</td>
    </tr>
    <tr>
      <td><b>文件存放目录:</b><?php echo UPGRADEROOT.'/'.$updaterelease?></td>
    </tr>
    <tr>
      <td><input type="button" class="btn" onclick="window.location.href='<?=u('upgrade','index',array('release'=>$updaterelease,'step'=>3))?>'" value="下载更新"></td>
    </tr>
    <?php foreach($updatefilelist as $vo){?>
    <tr>
      <td><em class="files bold"><?php echo $vo?></em>
		<?php
		$arr=explode('/',$vo);
		unset($arr[count($arr)-1]);
		$dir=implode('/',$arr);
		if(is_dir(DDROOT.$dir)){
			if(iswriteable(DDROOT.$dir)==0){
				$ok=0;
				echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;此路径 <b style=" color:red">'.$dir.'/</b> 不可写，无法升级！';
			}
		}
		else{
			$a=create_dir(DDROOT.$dir);
			if($a!=''){
				echo $a;
				$ok=0;
			}
		}
	  ?>
      </td>
    </tr>
    <?php }?>
    <tr>
      <td><b>文件存放目录:</b><?php echo UPGRADEROOT.'/'.$updaterelease?></td>
    </tr>
    <tr>
      <td><input type="button" class="btn" onclick="window.location.href='<?=u('upgrade','index',array('release'=>$updaterelease,'step'=>3))?>'" value="下载更新"></td>
    </tr>
  </table>
<?php if($ok==0){?>
<script>
$(function(){
	$('.btn').attr('disabled','disabled');
})
</script>
<?php }?>