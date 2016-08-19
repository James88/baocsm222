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
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB;">
<form name="form1" action="" method="get">
<input type="hidden" name="mod" value="<?=MOD?>">
<input type="hidden" name="act" value="<?=ACT?>">
        <tr>
              <td width="" align="left">&nbsp;名称：<input type="text" name="q" value="<?=$q?>"  style="width:300px;"/>&nbsp;<?=select($node_arr,$parent_id,'parent_id')?>&nbsp;<input type="submit" value="搜索" /></td>
              <td width="150px" align="right">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
</form>
      </table>
                  <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="80px">id</th>
                      <th width="200px">名称</th>
                      <th width="500px">路径</th>
                      <th width="200">操作</th>
                      <th ></th>
                    </tr>
					<?php foreach ($slist as $r){?>
					  <tr>
                        <td><?=$r["id"]?></td>
                        <td><?=$r["title"]?></td>
                        <td><?=$r["p_title"]?>--<?=$r["title"]?></td>
						<td><a href="<?=$r["url"]?>" class=link4>去查看</a></td>
                        <td ></td>
					  </tr>
					<?php }?>
                  </table>
 <div style="position:relative; padding-bottom:10px">
  <div class="megas512" style=" margin-top:5px;"><?=pageft($total,$pagesize,u(MOD,'list',$page_arr));?></div>
  </div>
<?php include(ADMINTPL.'/footer.tpl.php');?>