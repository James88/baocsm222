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
<script>
$(function(){
	$('#removecidform').submit(function(){
		if($('#cidselect').val()==0){
			alert('没有选择栏目');
			return false;
		}
		var ids='';
		$('.idss').each(function(){
			if($(this).attr('checked')=='checked'){
				ids=ids+$(this).attr('id')+',';
			}
		});
		if(ids==''){
			alert('没有选择文章');
			return false;
		}
		$('#ids').val(ids);
	});
})
</script>
<form name="form1" action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB;">
        <tr>
              <td width="20%">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'addedi')?>" class="link3">[新增文章]</a> &nbsp;<?php if($reycle==1){?><a href="<?=u(MOD,ACT)?>" class="link3">[返回列表]</a><?php }else{?><a href="<?=u(MOD,ACT,array('reycle'=>1))?>" class="link3">[回收站]</a><?php }?></td>
              <td width="" align="right">标题：<input type="text" name="q" value="<?=$q?>" />&nbsp;<select name="cid" style="font-size:12px"><option value="0">--顶层栏目--</option><?php getCategorySelect($cid);?></select>&nbsp;<input type="submit" value="搜索" /></td>
              <td width="150px" align="right">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
                  <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="3%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
					  <th width="">标题</th>
                      <th width="115px">栏目</th>
                      <th width="10%">来源</th>
                      <th width="5%">点击</th>
                      <th width="5%">排序</th>
                      <th width="8%">操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' class="idss" value='<?=$r["id"]?>' id='<?=$r["id"]?>' /></td>
                        <td style="text-align:left; padding-left:5px"><a href="../<?=u(MOD,'view',array('id'=>$r['id']))?>" target="_blank"><?=$r["title"]?></a></td>
						<td><?=$this_type[$r["cid"]]?></td>
                        <td><?=$r["source"]?></td>
                        <td><?=$r["hits"]?></td>
						<td class="input" field='sort' w='50' tableid="<?=$r["id"]?>" status='a' title="双击编辑"><?=$r["sort"]==DEFAULT_SORT?'——':$r["sort"]?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>">修改</a></td>
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
       <div style="padding-left:10px"><form id="removecidform" action="index.php?mod=<?=MOD?>&act=removecid" method="post">批量移动：<select id="cidselect" name="cid" style="font-size:12px"><option value="0">--顶层栏目--</option><?php getCategorySelect($cid);?></select> <input type="hidden" name="ids" id="ids" value="" /><input name="sub" type="submit" value="提交" /></form></div>
<?php include(ADMINTPL.'/footer.tpl.php');?>