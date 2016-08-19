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
<form name="form1" action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td>&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'jiangli',array('form_table_id'=>'share'))?>" class="link3">[设置]</a></td>
              <td align="right"><?=select(array('0'=>'分享人','1'=>'购买人'),$se,'se')?><input type="text" name="q" value="<?=$q?>" />&nbsp;<input type="submit" value="搜索" />&nbsp;共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
                  <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="100">分享人</th>
                      <th width="100">购买人</th>
					  <th width="410">标题</th>
                      <th width="80">状态</th>
                      <th width="80">奖励</th>
                      <th width="120">添加时间</th>
                      <th width="">确认时间</th>
                    </tr>
					<?php foreach ($tuiguang as $r){?>
					  <tr>
						<td><?=$r["fenxiangren"]?></td>
                        <td><?=$r["username"]?></td>
                        <td><a class="ddnowrap" style="width:400px; " href="<?=$r['url']?>" target="_blank" title="<?=$r['title']?>">【<?=$r['type']?>】<?=$r["title"]?></a></td>
                        <td><?=$r['status']==1?'已确认':'未确认'?></td>
                        <td><?=$r["money"]?>元</td>
						<td><?=date('Y-m-d',strtotime($r["date"]))?></td>
                        <td><?=$r['status']==1?$r["pay_time"]:'——'?></td>
					  </tr>
					<?php }?>
                  </table>
				<div style="position:relative; padding-bottom:10px">
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',array('q'=>$q)));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>