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
<style>
table a { text-decoration:none}
</style>
<div class="explain-col">
本工具统计的是所有没有退款订单的数据可能会有些偏差，仅供参考！
</div>
      <form name="form2" method="get" action="index.php?mod=<?=MOD?>&act=<?=ACT?>" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
      <?php if(!empty($row)){?>
      				<tr>
                      	<td colspan="13">
                      <div style="text-align:center;">
						<?=renderChartHTML("../data/Column3D.swf","",$dataxml, "my", "100%", 300)?>
                        <br />
                        <br />
                        |&nbsp;<a href="<?=$gourl.'&t=taoyj&n=淘宝佣金'?>">淘宝佣金</a>&nbsp;|&nbsp;<a href="<?=$gourl.'&t=taolr&n=淘宝利润'?>">淘宝利润</a>&nbsp;|&nbsp;<a href="<?=$gourl.'&t=paiyj&n=拍拍佣金'?>">拍拍佣金</a>&nbsp;|&nbsp;<a href="<?=$gourl.'&t=pailr&n=拍拍利润'?>">拍拍利润</a>&nbsp;|&nbsp;<a href="<?=$gourl.'&t=mallyj&n=商城佣金'?>">商城佣金</a>&nbsp;|&nbsp;<a href="<?=$gourl.'&t=malllr&n=商城利润'?>">商城利润|&nbsp;<a href="<?=$gourl.'&t=gameyj&n=游戏佣金'?>">游戏佣金</a>|&nbsp;<a href="<?=$gourl.'&t=gamelr&n=游戏利润'?>">游戏利润</a>|&nbsp;<a href="<?=$gourl.'&t=taskyj&n=任务佣金'?>">任务佣金</a>|&nbsp;<a href="<?=$gourl.'&t=tasklr&n=任务利润'?>">任务利润</a>&nbsp;|
                        <br />
                        <br />
                        </div>
						</td>
                      </tr>
      <?php }?>
                    <tr>
                      <th width="3%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
                      <th width="">日期</th>
                      <th width="8%" style="color:#00F" title="淘宝订单佣金的总和">淘宝佣金</th>
                      <th width="8%" style="color:#90C" title="淘宝佣金-给会员的返利">淘宝利润</th>
                      <th width="8%" style="color:#00F" title="拍拍订单佣金的总和">拍拍佣金</th>
                      <th width="8%" style="color:#90C" title="拍拍佣金-给会员的返利">拍拍利润</th>
                      <th width="8%" style="color:#00F" title="商城订单佣金的总和">商城佣金</th>
                      <th width="8%" style="color:#90C" title="商城佣金-给会员的返利">商城利润</th>
                      <th width="8%" style="color:#00F" title="任务网赚佣金的总和">任务佣金</th>
                      <th width="8%" style="color:#90C" title="任务网赚佣金-给会员的佣金">任务利润</th>
                      <th width="10%">操作</th>
                    </tr>
                       <tr style="background-color:#E9F2FB">
                        <td></td>
                        <td >总数据</td>
						<td style="color:#F00"><?=$list['taoyj']?></td>
                        <td style="color:#00F"><?=$list['taolr']?></td>
                        <td style="color:#90C"><?=$list['paiyj']?></td>
                        <td style="color:#F00"><?=$list['pailr']?></td>
						<td style="color:#00F"><?=$list['mallyj']?></td>
                        <td style="color:#90C"><?=$list['malllr']?></td>
                        <td style="color:#90C"><?=$list['taskyj']?></td>
                        <td style="color:#90C"><?=$list['tasklr']?></td>
						<td></td>
					  </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                       <td><?=$r["date"]?></td>
                        <td style="color:#00F"><?=(float)$r["taoyj"]?></td>
                        <td style="color:#90C"><?=(float)$r["taolr"]?></td>
						<td style="color:#00F"><?=(float)$r["paiyj"]?></td>
                        <td style="color:#90C"><?=(float)$r["pailr"]?></td>
                        <td style="color:#00F"><?=(float)$r["mallyj"]?></td>
                        <td style="color:#90C"><?=(float)$r["malllr"]?></td>
                        <td style="color:#00F"><?=(float)$r["taskyj"]?></td>
                        <td style="color:#90C"><?=(float)$r["tasklr"]?></td>
						<td>
                        <a href="<?=u('tradelist','list',array('stime'=>$r['stime'],'dtime'=>$r['dtime']))?>" class=link4>淘宝</a>
                        <a href="<?=u('paipai_order','list',array('stime'=>$r['stime'],'dtime'=>$r['dtime']))?>" class=link4>拍拍</a>
                        <a href="<?=u('mall_order','list',array('stime'=>$r['stime'],'dtime'=>$r['dtime']))?>" class=link4>商城</a>
                        <a href="<?=u('task','list',array('stime'=>$r['stime'],'dtime'=>$r['dtime']))?>" class=link4>任务</a></td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px">
       <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="addedi" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="更新" onclick='return confirm("确定要更新?")'/><span style="color:#F00">&nbsp;&nbsp;注意：请根据实际选择更新数量。</span></div>
            <div class="megas512" style=" margin-top:15px;"><br /><?=pageft($total,$pagesize,u(MOD,'list',array('q'=>$q,'se'=>$se,'checked'=>$checked)));?></div>
            </div>
       </form>
       <?php include(ADMINTPL.'/footer.tpl.php')?>