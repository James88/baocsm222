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
              <td class="bigtext">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'addedi')?>" class="link3">[添加]</a> &nbsp;<?php if($_GET['reycle']==1){?><a href="<?=u(MOD,ACT)?>" class="link3">[返回列表]</a><?php }else{?><a href="<?=u(MOD,ACT,array('reycle'=>1))?>" class="link3">[回收站]</a><?php }?></td>
              <td align="right" class="bigtext">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>

      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      <input type="hidden" name="code" value="<?=$code?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px;">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
        <tr>
          <th width="40px" ><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
          <th width="60px">排序</th>
          <th width="120px">名称</th>
          <th width="70px">标识码</th>
          <th width="70px">列表形式</th>
          <th width="70px">商家报名</th>
          <th width="70px">首页推荐</th>
          <th width="100px">分类</th>
		  <th width="150px">添加时间</th>
          <th width="120px">状态</th>
          <th width="150px">操作</th>
          <th></th>
        </tr>
        <?php foreach($data as $vo){?>
	    <tr>
          <td><input type='checkbox' name='ids[]' value='<?=$vo["id"]?>' id='content_<?=$vo["id"]?>' <?php if($vo['sys']==1){?> title="默认数据，不能删除" disabled<?php }?> /></td>
          <td class="input" field='sort' url='<?=u(MOD,ACT,array('update'=>'sort'))?>' w='40' tableid="<?=$vo["id"]?>" status='a' title="双击编辑"><?=is_kong($vo['sort'])?></td>
          <td><?=$vo['title']?></td>
          <td><?=$vo['code']?></td>
          <td><?=$vo['bankuai_tpl']?></td>
		  <td><?php if($vo['baoming']==1){?>是<?php }else{?>否<?php }?></td>
          <td><?php if($vo['tuijian']==1){?>推荐<?php }else{?>不推荐<?php }?></td>
          <td><?=$fenlei_arr[$vo['fenlei']]?></td>
          <td><?=$vo['addtime']?date('Y-m-d H:i:s',$vo['addtime']):''?></td>
          <td><?php if($vo['status']==1){?><span class="zt_green">开启</span><?php }else{?><span class="zt_red">关闭</span><?php }?></td>
          <td><a href="<?=u(MOD,'addedi',array('id'=>$vo['id']))?>">修改</a> <?php if($vo['laiyuan']==2){?> <?php }?> <a href="<?=u('goods','addedi',array('code'=>$vo['code']))?>">添加数据</a>
          <a onclick="return confirm('确定要清空该板块的商品数据吗？');" href="<?=u('goods','del',array('code'=>$vo['code'],'qingkong'=>1))?>">清空数据</a></td>
		  <td></td>
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
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,ACT,$page_arr));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>