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
<form action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td>&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u('mall_order','addedi')?>" class="link3">[添加订单]</a>&nbsp;<?php if($reycle==1){?><a href="<?=u(MOD,ACT)?>" class="link3">[返回列表]</a><?php }else{?><a href="<?=u(MOD,ACT,array('reycle'=>1))?>" class="link3">[回收站]</a><?php }?> <a href="<?=u(MOD,'get')?>" class="link3">[获取订单]</a></td>
              <td align="right"><input type="text" name="q" value="<?=$q?>" />&nbsp;<?=select($malls,$mall_id,'mall_id')?>&nbsp;<?=select($select_arr,$se,'se')?>&nbsp;<?=select($status_arr,$status,'status')?>&nbsp;<?=select($select2_arr,$se2,'se2')?>&nbsp;<input type="submit" value="提交" /> 共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="40"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
                      <th width="130">下单时间</th>
                      <th width="80">商城</th>
                       <th width="50">来源</th>
					  <th width="150">订单号</th>
                      <?php if($need_zhlm==1){?>
                      <th width="70">联盟</th>
                      <th width="50">活动id</th>
                      <?php }?>
                      <th width="50">总价</th>
                      <th width="50">单价</th>
                      <th width="50">数量</th>
                      <th width="50">佣金</th>
                      <th width="50">返利</th>
                      <th width="50">积分</th>
                      <th width="60">状态</th>
                      <th width="80">会员</th>
                      <th width="50">操作</th>
                      <th></th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><?=date('Y-m-d H:i:s',$r["order_time"])?></td>
                        <td><?=$r["mall_name"]?></td>
                        <td title="订单来源"><?=$r['platform']==2?'手机':'电脑'?></td>
						<td><?=$r["order_code"]?></td>
                        <?php if($need_zhlm==1){?>
                        <td><?=$lianmeng_arr[$r['lm']]?$lianmeng_arr[$r['lm']]:$lianmeng_arr[8]?></td>
                        <td><?=$r["adid"]?></td>
                        <?php }?>
                        <td><?=$r["sales"]?></td>
                        <td><?=$r["item_price"]?></td>
                        <td><?=$r["item_count"]?></td>
						<td><?=$r["commission"]?></td>
                        <td><?=$r["fxje"]?></td>
                        <td><?=$r["jifen"]?></td>
                        <td><?=$status_arr[$r["status"]]?></td>
                        <td><?=$r["uname"]?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>">
                        <?php if($r["status"]==1){?>
                        查看
                        <?php }elseif($r["status"]==-1){?>
                        查看
                        <?php }elseif($r["status"]==0){?>
                        返现
                        <?php }?>
                        </a></td>
                        <td></td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
           <?php if($reycle==1){?>
            <input type="hidden" id="do_input" name="do" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/> &nbsp;<input type="submit" value="还原" class="myself" onclick='$("#do_input").val("reset");return confirm("确定要还原?")'/></div>
            <?php }else{?>
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确认要删除转移到回收站?")'/></div>
            <?php }?>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',$page_arr));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>