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
<form name="form1" action="index.php?mod=<?=MOD?>&amp;act=<?=ACT?>" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
    <tr>
      <td>&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'report')?>" class="link3">[获取订单]</a>&nbsp;<?php if($reycle==1){?><a href="<?=u(MOD,ACT)?>" class="link3">[返回列表]</a><?php }else{?><a href="<?=u(MOD,ACT,array('reycle'=>1))?>" class="link3">[回收站]</a><?php }?>&nbsp;</td>
      <td align="right"><?=select($select_arr,$se,'se')?>：<input type="text" name="q" value="<?=$_GET['q']?>" />&nbsp;<input type="submit" name="sub" value="搜索" />&nbsp;共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
    </tr>
  </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="index.php?mod=<?=MOD?>&amp;act=<?=ACT?>" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="30"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
                      <th width="250">任务名</th>
                      <th width="120">会员</th>
                      <th width="70">奖励金额</th>
                      <th width="70">会员佣金</th>
                      <th width="70">网站佣金</th>
                      <th width="230">流水号</th>
                      <th width="60">订单状态</th>
                      <th width="60">模块</th>
                      <th width="130">订单时间</th>  
                      <th></th>        
                    </tr>
					<?php foreach ($plugin_data as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td style="padding:0px 3px 0px 3px; text-align:left"><span class="ddnowrap" style="width:250px; " title="<?=$r["programname"]?>"><?=$r["programname"]?></span></td>
						<td><a href="<?=u('mingxi','list',array('uname'=>$r["ddusername"]))?>"><?=$r["ddusername"]?></a></td>
                         <td ><?=(float)$r["commission"]?>元</td>
                        <td ><?=(float)$r["point"]?>元</td>
                        <td ><?=(float)($r["commission"]-$r["point"])?>元</td>
						<td><?=$r["eventid"]?></td>
                        <td <?php if($r["immediate"]==1){?>style="color:#00C"<?php }?>><?=$type[$r["immediate"]]?></td>
                        <td><?=$task_type_arr[$r["type"]]?></td>
                        <td><?=$r["addtime"]?></td>
                        <td></td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" />
            <input type="hidden" name="act" value="del" />
            <?php if($reycle==1){?>
            <input type="hidden" id="do_input" name="do" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/> &nbsp;<input type="submit" value="还原" class="myself" onclick='$("#do_input").val("reset");return confirm("确定要还原?")'/></div>
            <?php }else{?>
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确认要删除转移到回收站?")'/></div>
            <?php }?>
            <div class="megas512" style=" margin-top:5px;"><?=pageft($total,$pagesize,u(MOD,ACT,$page_arr))?></div>
            </div>
       </form>
       <?php include(ADMINTPL.'/footer.tpl.php')?>