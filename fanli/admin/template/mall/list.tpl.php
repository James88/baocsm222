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

$top_nav_name=array(0=>array('url'=>u('mall','list'),'name'=>'知名商城'));
if($need_zhlm==1){
	$top_nav_name[1]=array('url'=>u('mall_type','list'),'name'=>'商城分类');
}
else{
	$top_nav_name[1]=array('url'=>u('mall_type','list'),'name'=>'重置商城分类');
}
ksort($top_nav_name);
include(ADMINTPL.'/header.tpl.php');
$mall_type=array(''=>'全部')+$this_type;
?>
<form name="form1" action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td width="400px">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" /><!--<a href="../<?=u('cron','run',array('jiaoben'=>'cron_mall'))?>" onclick='return confirm("如果商城信息存在，会更新除排序和内容外的所有信息，确定更新？")' class="link3">[更新商城数据]</a>-->&nbsp;<a href="<?=u(MOD,'addedi')?>" class="link3">[新增商城]</a>&nbsp;<?php if($reycle==1){?><a href="<?=u(MOD,ACT)?>" class="link3">[返回列表]</a><?php }else{?><a href="<?=u(MOD,ACT,array('reycle'=>1))?>" class="link3">[回收站]</a><?php }?></td>
              <td width="" align="right">商城名或网址：<input type="text" name="q" value="<?=$q?>" />&nbsp;<?=select($mall_type,$cid,'cid')?>&nbsp;<input type="submit" value="搜索" /></td>
              <td width="150px" align="right">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
                  <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="50px"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
                      <th width="50px"><a href="<?=u(MOD,'list',array('sort'=>$listsort))?>">排序</a></th>
					  <th width="150px">名称</th>
                      <th width="" style="">网址</th>
                      <?php if($need_zhlm==1){?>
                      <th width="100px">联盟</th>
                      <?php }?>
                      <th width="80px">最高返</th>
                      <th width="100px">类别</th>
                      <th width="80px">logo</th>
                      <th width="140px"><a href="<?=u(MOD,'list',array('edate'=>$listedate))?>">到期时间</a></th>
                      <th width="140px">添加时间</th>
                      <th width="70px">锁定</th>
                      <th width="100px">操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td class="input" field='sort' url='<?=u(MOD,ACT,array('update'=>'sort'))?>' w='50' tableid="<?=$r["id"]?>" status='a' title="双击编辑"><?=$r["sort"]?></td>
						<td><?=$r["title"]?></td>
                        <td><span style="overflow:hidden; display:inline-block; width:300px;"><?=$r["url"]?></span></td>
                        <?php if($need_zhlm==1){?>
                        <td><?=$lm[$r["lm"]]?></td>
                        <?php }?>
                        <td><?=$r["fan"]?></td>
                        <td><?=$this_type[$r["cid"]]?></td>
                        <td class="showpic" pic="<?=http_pic($r["img"])?>">查看</td>
                        <td><?=date('Y-m-d',$r["edate"])?></td>
						<td><?=date('Y-m-d H:i:s',$r["addtime"])?></td>
                        <td><?=$r['suoding']==0?'<span class="zt_green" title="解锁状态，可被自动或人工更新覆盖信息">否</span>':'<span class="zt_red" title="锁定状态，不能自动或人工更新，建议不要锁定">是</span>';?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" class=link4>修改</a></td>
					  </tr>
					<?php }?>
                  </table>
				<div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" id="act" value="del" /><input type="hidden" name="table" value="mall" /><input type="hidden" id="qingkong" name="qingkong" value="" />
           <?php if($reycle==1){?>
            <input type="hidden" id="do_input" name="do" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/> &nbsp;<input type="submit" value="还原" class="myself" onclick='$("#do_input").val("reset");return confirm("确定要还原?")'/></div>
            <?php }else{?>
            <div style="position:absolute; left:5px; top:10px"><input type="submit" value="删除" onclick='return confirm("确认要删除转移到回收站?")'/>&nbsp;<input type="submit" value="全部删除" class="myself" onclick='$("#act").val("del");$("#qingkong").val(1);return confirm("此操作会清空商城所有信息，确定删除？")'/></div>
            <?php }?>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',$page_arr));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>