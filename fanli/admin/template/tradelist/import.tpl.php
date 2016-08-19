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
$cun=(int)$duoduo->select('tradelist_temp','id','1');
$top_nav_name=array(array('url'=>u('tradelist','import'),'name'=>'导入订单'),array('url'=>u('tradelist','list_temp'),'name'=>'未处理订单'));
include(ADMINTPL.'/header.tpl.php');
?>

<div class="explain-col"> 提示：导入的淘宝订单没有购买会员的信息，站长仔细看清后操作！<a href="http://u.alimama.com/union/newreport/taobaokeDetail.htm" target="_blank">点击获取最新的淘宝客推广明细</a> </div>
<form method="post" action="index.php?mod=<?=MOD?>&act=<?=ACT?>" enctype="multipart/form-data" name="form1">
  <table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
    <?php if($cun==0){?>
    <tr>
      <td width="115px" align="right">导入文件：</td>
      <td>&nbsp;
        <input name="upfile" type="file" size="17" /></td>
    </tr>
    <tr>
      <td width="115px" align="right">处理条数：</td>
      <td>&nbsp;
        <input name="pagesize" type="text" value="300" style="width:60px"/> <span class="zhushi">导入数据后，每次处理订单的数量，站长可根据自己的服务器性能调节</span></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;
        <input type="submit" class="myself" name="sub" value=" 文 件 导 入 " /></td>
    </tr>
    <?php }else{?>
    <tr>
      <td style="padding-left:20px">&nbsp;提示：亲，你淘宝订单临时表里有未导入的订单，<a style="color:#F00; font-weight:bold" href="<?=u('tradelist','list_temp',array('do'=>'daoru'))?>">点击导入</a>！</td>
    </tr>
    
    <?php }?>
  </table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>
