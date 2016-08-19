<?php 
/**
 * ============================================================================
 * 版权所有 2008-2012 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}

include(ADMINTPL.'/header.tpl.php');
?>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="3%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
                      <th width="">日期</th>
					  <th width="8%" style="color:#F00">淘宝总成交</th>
                      <th width="8%" style="color:#00F">淘宝总佣金</th>
                      <th width="8%" style="color:#90C">淘宝总利润</th>
                      <th width="8%" style="color:#F00">拍拍总成交</th>
                      <th width="8%" style="color:#00F">拍拍总佣金</th>
                      <th width="8%" style="color:#90C">拍拍总利润</th>
                      <th width="8%" style="color:#F00">联盟总成交</th>
                      <th width="8%" style="color:#00F">联盟总佣金</th>
                      <th width="8%" style="color:#90C">联盟总利润</th>
                      <th width="10%">操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                       <td><?=$r["date"]?></td>
						<td style="color:#F00"><?=$r["taocj"]?></td>
                        <td style="color:#00F"><?=$r["taoyj"]?></td>
                        <td style="color:#90C"><?=$r["taolr"]?></td>
                        <td style="color:#F00"><?=$r["paicj"]?></td>
						<td style="color:#00F"><?=$r["paiyj"]?></td>
                        <td style="color:#90C"><?=$r["pailr"]?></td>
                        <td style="color:#F00"><?=$r["mallcj"]?></td>
                        <td style="color:#00F"><?=$r["mallyj"]?></td>
                        <td style="color:#90C"><?=$r["malllr"]?></td>
						<td>
                        <a href="<?=u('tradelist','list',array('stime'=>$r['stime'],'dtime'=>$r['dtime']))?>" class=link4>淘宝</a>
                        <a href="<?=u('paipai_order','list',array('stime'=>$r['stime'],'dtime'=>$r['dtime']))?>" class=link4>拍拍</a>
                        <a href="<?=u('mall_order','list',array('stime'=>$r['stime'],'dtime'=>$r['dtime']))?>" class=link4>商城</a></td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="更新" onclick='return confirm("确定要更新?")'/></div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',array('q'=>$q,'se'=>$se,'checked'=>$checked)));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>