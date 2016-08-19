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
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB;">
        <tr>
              <td width="150px">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'addedi')?>" class="link3">[新增后台菜单]</a> </td>
              <td width="" align="right">名称：<input type="text" name="q" value="<?=$q?>" />&nbsp;<?=select($node_arr,$parent_id,'parent_id')?>&nbsp;<input type="submit" value="搜索" /></td>
              <td width="150px" align="right">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
                  <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="80px"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
                      <th width="80px">id</th>
                      <th width="80px">排序</th>
                      <th width="200px">名称</th>
                      <th width="115px">父节点</th>
                      <th width="115px">模块</th>
					  <th width="115px">行为</th>
                      <th width="115px">状态</th>
                      <th width="200">操作</th>
                      <th ></th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input <?php if($r['sys']==1){?>title="系统数据，不准删除"  disabled="disabled"<?php }?> type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><?=$r["id"]?></td>
                        <td class="input" field='sort' w='50' tableid="<?=$r["id"]?>" status='a'><?=$r["sort"]?></td>
                        <td><?=$r["title"]?></td>
                        <td><?=$node_arr[$r["parent_id"]]?></td>
						<td><?=$r["mod"]?$r["mod"]:'菜单节点'?></td>
                        <td><?=$r["act"]?></td>
                        <td><?=$hide_arr[$r["hide"]]?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" class=link4>修改</a></td>
                        <td ></td>
					  </tr>
					<?php }?>
                  </table>
				<div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" onclick='return confirm("确定要删除?")'/></div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',array('q'=>$q,'parent_id'=>$parent_id)));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>