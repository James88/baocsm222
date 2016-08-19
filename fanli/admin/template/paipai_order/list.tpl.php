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
      <td width="300px" class="bigtext">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'report')?>" class="link3">[获取订单]</a>&nbsp;<?php if($reycle==1){?><a href="<?=u(MOD,ACT)?>" class="link3">[返回列表]</a><?php }else{?><a href="<?=u(MOD,ACT,array('reycle'=>1))?>" class="link3">[回收站]</a><?php }?></td>
      <td width="" align="right">&nbsp;<input type="text" name="q" value="<?=$q?>" />&nbsp;<?=select($select_arr,$se,'se')?>&nbsp;<?=select($checked_arr,$checked,'checked')?>&nbsp;<input type="submit" value="搜索" /></td>
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
                      <th width="115px">订单号</th>
					  <th width="330px">商品名称</th>
                      <th width="5%">交易额</th>
                      <th width="4%">数量</th>
                      <th width="4%">佣金</th>
                      <th width="4%">返利</th>
                      <th width="4%">积分</th>
                      <th width="11%">确认时间</th>
                      <th width="6%">状态</th>
                      <th width="7%">会员</th>
                      <th width="">操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>"><?=$r["dealId"]?></a></td>
						<td><a href="<?='http://auction1.paipai.com/'.$r['commId']?>" class="ddnowrap" style="width:250px; " title="<?=$r["title"]?>" target="_blank"><?=$r["commName"]?></a></td>
                        <td><?=$r["careAmount"]?></td>
                        <td><?=$r["commNum"]?></td>
						<td><?=$r["commission"]?></td>
                        <td><?=$r["fxje"]?></td>
                        <td><?=$r["jifen"]?></td>
                        <td><?=date('Y-m-d H:i:s',$r["chargeTime"])?></td>
                        <td><?=$checked_status[$r["checked"]]?></td>
                        <td><?=$r["uname"]?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" class=link4>
                        <?php if($r["checked"]==2){?>
                        查看
                        <?php }elseif($r["checked"]==1){?>
                        审核
                        <?php }elseif($r["checked"]==0){?>
                        返现
                        <?php }elseif($r["checked"]==-1){?>
                        查看
                        <?php }?>
                        </a></td>
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