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
<div style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB; padding:5px">
<div class="bigtext">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<input type="submit"  value=" 一键 检 测 " /><label><input name="auto_del" value="1" style="vertical-align:middle;" type="checkbox" /><span style="vertical-align:middle;">同时删除</span></label>（不支持返利的也显示为下架）<br/>&nbsp;共有 <b><?php echo $total;?></b> 条记录</div>
</div>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" /><input type="hidden" name="jiance" value="1" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
        <tr>
          <th width="40px" ><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
          <th width="360px">商品名</th>
		  <th width="100px">版块</th>
          <th width="50px">图片</th>
          <th width="50px">原价</th>
		  <th width="50px">促销价</th>
          <th width="50px">排序</th>
          <th width="100px">来源</th>
          <th width="100px">审核人</th>
          <th width="150px">添加时间</th>
          <th width="">状态</th>
        </tr>
		<?php foreach ($zhidemai_data as $r){?>
	    <tr>
          <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
          <td><a href="<?='../'.u('goods','view',array('id'=>$r['id']))?>" target="_blank" class="ddnowrap" style="width:350px; " title="<?=$r["title"]?>"><?=$r["title"]?></a></td>
		  <td><?=$bankuai[$r["code"]]?></td>
		  <td class="showpic" pic="<?=$r['img']?>_b.jpg">查看</td>
		  <td><?=$r["price"]?></td>
          <td><?=$r["discount_price"]?></td>
          <td><?=$r["sort"]?></td>
          <td><span class="ddnowrap" style="width:90px" title="<?=$r["laiyuan"]?>"><?=$r["laiyuan"]?></span></td>
          <td><?=$r["auditor"]?></td>
          <td><?=$r["starttime"]?></td>
		  <td><span style="color:red">已下架</span></td>
		</tr>
		<?php }?>
        </table>
        <div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="goods" /><input type="hidden" name="act" value="del" /><input type="hidden" name="do" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/></div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,ACT,$page_arr));?></div>
            </div>
       </form>

<?php include(ADMINTPL.'/footer.tpl.php');?>