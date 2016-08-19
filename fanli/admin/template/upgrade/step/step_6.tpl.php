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
      <td colspan="3" class="red">版本<?php echo $updaterelease?>的文件升级完成,下面升级数据库</td>
    </tr>
    <tr>
      <td colspan="3"><input type="button" class="btn" onclick="window.location.href='<?=u(MOD,ACT,array('release'=>$updaterelease,'step'=>7))?>';" value="下一步"></td>
    </tr>
    <?php foreach($updatefilelist as $key=>$vo){
	$file=UPGRADEROOT .'/'.$updaterelease."/backup".$vo;
	if(preg_match('#^'.UPGRADEROOT.'/'.$updaterelease.'/backup/admin'.'#',$file)==1){
		$admin_name=str_replace(DDROOT,'',ADMINROOT);
		$admin_name=str_replace('/','',$admin_name);
		$file=preg_replace('#^'.UPGRADEROOT.'/'.$updaterelease.'/backup/admin'.'#',UPGRADEROOT .'/'.$updaterelease."/backup/".$admin_name,$file);
	}
	?>
    <tr>
     <?php if(file_exists($file)){?>
      <td width="60px;">备份且更新</td>
      <?php }else{?>
       <td width="50px;"><a title="多次尝试下载不了可以手动下载" href="<?=u(MOD,ACT,array('release'=>$updaterelease,'step'=>5,'fileseq'=>$key+1,'refurl'=>'true'))?>">重新更新</a></td>
       <?php }?>
       <?php if(file_exists($file)){?>
      <td width="39"><a title="不想更新本文件就删除" href="<?=u(MOD,ACT,array('release'=>$updaterelease,'step'=>6,'hai'=>$key+1))?>">还原</a></td>
      <?php }else{?>
      <td width="50" title="不想更新本文件、服务器上没本文件、网络、文件权限等原因下载不了">[未下载]</td>
       <?php }?>
      <td><em class="files bold"><?php echo $vo?></em></td>
    </tr>
    <?php }?>
    <tr>
      <td colspan="3"><b>文件存放目录:</b><?php echo UPGRADEROOT.'/'.$updaterelease."/"."backup"?></td>
    </tr>
    <tr>
      <td colspan="3"><input type="button" class="btn" onclick="window.location.href='<?=u(MOD,ACT,array('release'=>$updaterelease,'step'=>7))?>';" value="下一步"></td>
    </tr>
  </table>