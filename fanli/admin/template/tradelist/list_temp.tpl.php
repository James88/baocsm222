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
$top_nav_name=array(array('url'=>u('tradelist','import'),'name'=>'导入订单'),array('url'=>u('tradelist','list_temp'),'name'=>'未处理订单'));
include(ADMINTPL.'/header.tpl.php');
?>

<form action="" method="get">
  <table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
    <tr>
      <td width="300px" class="bigtext">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u('tradelist','list_temp',array('do'=>'daoru'))?>" class="link3">[处理订单]</a></td>
      <td width="" align="right"><?=select($select_arr,$se,'se')?> <input type="text" name="q" value="<?=$q?>" />
        <?=select($checked_arr,$checked,'checked')?>
	<?php if(TAOTYPE==1){?>
        <?=select($_status_arr,$status,'status')?>
	<?php }else{?>
        <?=select($select2_arr,$se2,'se2')?>
    <?php }?>
        <input type="submit" value="搜索" /></td>
      <td width="125px" align="right" class="bigtext">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="mod" value="<?=MOD?>" />
  <input type="hidden" name="act" value="<?=ACT?>" />
</form>
<form name="form2" method="get" action="" style="margin:0px; padding:0px">
  <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
    <tr>
      <th width="3%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
      <th width="115px">交易号</th>
      <?php if(TAOTYPE==2){?>
      <th width="38px">来源</th>
      <?php }?>
      <th width="210px">商品名称</th>
      <th width="4%">单价</th>
      <th width="4%">数量</th>
      <th width="5%">成交额</th>
      <th width="5%">比例</th>
      <th width="4%">佣金</th>
      <th width="5%"><?=TBMONEY?></th>
      <th width="4%">积分</th>
      <th width="120px"><a href="<?=u(MOD,ACT,array('pay_time'=>$listorder))?>">结算时间</a></th>
      <th width="6%">认领</th>
      <?php if(TAOTYPE==1){?>
      <th width="65px">状态</th>
      <th width="70px"><a href="<?=u(MOD,ACT,array('create_time'=>$listorder))?>">下单时间</a></th>
      <?php }?>
    </tr>
    <?php foreach ($row as $r){?>
    <tr>
      <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
      <td><?=preg_replace('/_\d+/','',$r["trade_id"])?></td>
      <?php if(TAOTYPE==2){?>
      <td title="订单来源"><?=$select2_arr[$r['platform']]?></td>
      <?php }?>
      <td style="padding:0px 3px 0px 3px; text-align:left"><a href="<?='http://item.taobao.com/item.html?id='.$r['num_iid']?>" target="_blank" class="ddnowrap" style="width:200px; " title="<?=$r["title"]?>"><?=$r["item_title"]?></a></td>
      <td><?=$r["pay_price"]?></td>
      <td><?=$r["item_num"]?></td>
      <td><?=$r["real_pay_fee"]>0?$r["real_pay_fee"]:'--'?></td>
      <td <?php if($r["commission_rate"] >= 0.25){ echo 'style="color:red;"';}?>><?=$r["commission_rate"]*100?>%</td>
      <td><?=$r["commission"]>0?$r["commission"]:'--'?></td>
      <td><?=jfb_data_type($r["jifenbao"])>0?jfb_data_type($r["jifenbao"]):'--'?></td>
      <td><?=$r["jifen"]>0?$r["jifen"]:'--'?></td>
      <td><?=(TAOTYPE==1)?$r["pay_time"]?$r["pay_time"]:'--':$r["pay_time"]?></td>
      <td><?=$checked_arr[$r["checked"]]?></td>
      <?php if(TAOTYPE==1){?>
      <td><?=$status_arr[$r["status"]]?></td>
      <td><?=$r["create_time"]?date('Y-m-d',strtotime($r["create_time"])):'--'?></td>
      <?php }?>
    </tr>
    <?php }?>
  </table>
  <div style="position:relative; padding-bottom:10px">
    <div class="megas512" style=" margin-top:15px;">
      <?=pageft($total,$pagesize,u(MOD,'list_temp',$page_arr));?>
    </div>
  </div>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>