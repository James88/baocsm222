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
              <td width="40%">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" /> <a href="<?=u('plugin','list')?>" class="link3">[返回应用列表]</a> </td>
              <td width="" align="right">应用标识码：<input type="text" name="code" value="<?=$code?>" />&nbsp;<input type="submit" value="搜索" /></td>
              <td width="150px" align="right">共有 <b><?=$total?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <td width="3%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></td>
                      <td width="" >插件标识码</td>
                      <td width="" >文件路径</td>
                      <td width="" >文件说明</td>
                    </tr>
					<?php foreach ($files as $r){?>
					  <tr>
                        <td><input <?php if($r['install']==1){?> title="卸载后才能删除" disabled="disabled"<?php }?> type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><?=$r["code"]?></td>
                        <td><?=$r["file"]?></td>
                        <td><?=$r["update_tag"]==1?'<b style=" color:red">更改了系统文件</b>':'<b style=" color:green">新增文件</b>'?></td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px">
          <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <div class="megas512" style=" margin-top:5px;"><?=pageft($total,$pagesize,u(MOD,ACT,array('code'=>$code)));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>