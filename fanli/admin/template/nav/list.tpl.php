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
$fu = $_GET['fu']?$_GET['fu']:'0';
include(ADMINTPL.'/header.tpl.php');
?>
<script>
$(function(){
	$('#fu').click(function(){
		if(parseInt($(this).val())==1){
			$('input[name="fu"]').val(0);
		}
		else{
			$('input[name="fu"]').val(1);
		}
	});
})
</script>
<form name="form1" action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB;">
        <tr>
              <td width="20%">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'addedi')?>" class="link3">[新增导航]</a> </td>
              <td width="" align="right">&nbsp;只显示父导航<label><input name="fu" id="fu" type="checkbox" value="<?=$fu?>" <?php if($fu==1){?> checked="check"<?php }?>/> </label>&nbsp;名称：<input type="text" name="q" value="<?=$q?>" />&nbsp;<input type="submit" value="搜索" /></td>
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
					  <th width="130px">名称</th>
                      <th width="115px">模块</th>
                      <th width="8%">行为</th>
                      <th width="8%">导航标记</th>
                      <th width="8%">目标</th>
                      <th width="115px">是否隐藏</th>
                      <th width="8%">状态</th>
                      <th width="5%">排序</th>
                      <th width="150px">添加时间</th>
                      <th width="">操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input <?php if($r['sys']==1){?>title="系统数据，不准删除"  disabled="disabled"<?php }else{?> <?php if(!empty($r['zdh'])){?>title="有子导航，不能删除"  disabled="disabled"<?php }?> <?php }?> type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                         <?php if($r["pid"]==0){?>
                        <td style="text-align:left; <?php if($r["hide"]==1){?>color:#999;<?php }?>"><span style="margin-left:20px"><?=$r["title"]?></span></td>
                        <?php }else{?>
                         <td style="text-align:right; <?php if($r["hide"]==1){?>color:#999;<?php }?>"><span style="margin-right:20px"><?=$r["title"]?></span></td>
                         <?php }?>
						<td><?=$r["mod"]?></td>
                        <td><?=$r["act"]?></td>
                        <td><?=$r["tag"]?></td>
                        <td><?=$target[$r["target"]]?></td>
                        <td><?=$status[$r["hide"]]?></td>
                        <td><?=$type[$r["type"]]?></td>
                       <td class="input" field='sort' w='50' tableid="<?=$r["id"]?>" status='a' title="双击编辑"><?=$r["sort"]==DEFAULT_SORT?'——':$r["sort"]?></td>
						<td><?=date('Y-m-d H:i:s',$r["addtime"])?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" class=link4>修改</a></td>
					  </tr>
                      <?php if(!empty($r['zdh'])){?>
                      	<?php foreach ($r['zdh'] as $a){?>
					  <tr>
                        <td><input <?php if($a['sys']==1){?>title="系统数据，不准删除"  disabled="disabled"<?php }?> type='checkbox' name='ids[]' value='<?=$a["id"]?>' id='content_<?=$a["id"]?>' /></td>
                         
                         <td style="text-align:right; <?php if($a["hide"]==1){?>color:#999;<?php }?>"><span style="margin-right:20px"><?=$a["title"]?></span></td>
						<td><?=$a["mod"]?></td>
                        <td><?=$a["act"]?></td>
                        <td><?=$a["tag"]?></td>
                        <td><?=$target[$a["target"]]?></td>
                        <td><?=$status[$a["hide"]]?></td>
                        <td><?=$type[$a["type"]]?></td>
                       <td class="input" field='sort' w='50' tableid="<?=$a["id"]?>" status='a' title="双击编辑"><?=$a["sort"]==DEFAULT_SORT?'——':$a["sort"]?></td>
						<td><?=date('Y-m-d H:i:s',$a["addtime"])?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$a['id']))?>" class=link4>修改</a></td>
					  </tr>
                      <?php }?>
                      <?php }?>
					<?php }?>
                  </table>
				<div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" onclick='return confirm("确定要删除?")'/></div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($_GET['fu']?$total:$total_nav,$pagesize,u(MOD,'list',array('q'=>$q,'fu'=>$fu)));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>