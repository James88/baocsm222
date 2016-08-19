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
        <tr>
        <form name="form1" action="" method="get">
              <td width="300px">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" /></td>
              <input type="hidden" name="mod" value="<?=MOD?>" />
              <input type="hidden" name="act" value="del" />
              </form>
              <form name="form1" action="" method="get">
              <td width="" align="right">日期：<input style="width:70px" type="text" id="sday" name="sday" /> - <input style="width:70px" type="text" id="eday" name="eday" />&nbsp;<?=select($se_arr,$se,'se')?>：<input type="text" name="q" value="<?=$q?>" />&nbsp;<input type="submit" value="搜索" /></td>
              <td width="150px" align="right" class="bigtext">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
               <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
            </tr>
      </table>

                  <table id="listtable" border=1 cellpadding=0 cellspacing=0  bordercolor="#dddddd">
                    <tr>
                      <th width="5%">id</th>
					  <th width="">管理员</th>
                      <th width="20%">操作IP</th>
                      <th width="20%">模块</th>
                      <th width="115px">操作</th>
                      <th width="20%">执行时间</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><?=$r["id"]?></td>
                        <td><?=$r["admin_name"]?></td>
						<td><?=$r["ip"]?></td>
                        <td><?=$r["mod"]?></td>
                        <td><?=$r["do"]?></td>
						<td><?=date('Y-m-d H:i:s',$r["addtime"])?></td>
					  </tr>
					<?php }?>
                  </table>
                  <div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" id="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"></div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',$page_arr));?></div>
            </div>

<?php include(ADMINTPL.'/footer.tpl.php');?>