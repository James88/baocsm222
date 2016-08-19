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
              <td width="500px"class="bigtext">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<?php if($reycle==1){?><a href="<?=u(MOD,ACT)?>" class="link3">[返回列表]</a><?php }else{?><a href="<?=u(MOD,ACT,array('reycle'=>1))?>" class="link3">[回收站]</a><?php }?></td>
              <td width=""></td>
              <td width="700" align="right">会员名：<input type="text" name="q" value="<?=$q?>" />&nbsp;<input type="submit" value="搜索" /> 共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="3%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
                      <th width="">用户名</th>
                      <th width="6%">兑换商品</th>
                      <th width="8%">姓名</th>
                      <th width="150px">支付宝</th>
                      <th width="85px">电话</th>
                      <th width="85px">qq</th>
                      <th width="4%">数量</th>
                      <th width="6%">花费</th>
                      <th width="6%">模式</th>
                      <th width="8%">状态</th>
                      <th width="140px">兑换时间</th>
                      <th width="8%">操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><?=$r["ddusername"]?></td>
						<td><a href="<?=u('huan_goods','addedi',array('id'=>$r["huan_goods_id"]))?>">查看</a></td>
                        <td><?=$r["realname"]?></td>
                        <td><?=$r["alipay"]?></td>
						<td><?=$r["mobile"]?></td>
                        <td><?=$r["qq"]?></td>
                        <td><?=$r["num"]?></td>
                        <td><?=(float)$r["spend"]?></td>
                        <td><?=$r['mode']==1?TBMONEY:'积分'?></td>
                        <td <?php if($r["status"]==2){?>title="<?=$r["why"]?>"<?php }?>><?=$status_arr[$r["status"]]?></td>
                        <td><?=date('Y-m-d H:i:s',$r["addtime"])?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id'],'do'=>'yes'))?>">确认</a>&nbsp;<a href="<?=u(MOD,'addedi',array('id'=>$r['id'],'do'=>'no'))?>">退回</a></td>
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