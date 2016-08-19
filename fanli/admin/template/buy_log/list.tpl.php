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
              <td width="300px">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp; [系统会自动删除30天前的购物记录]</td>
              <td width="50%" align="right">会员：<input type="text" name="uname" value="<?=$uname?>" />&nbsp;<input type="submit" value="搜索" /></td>
              <td width="150px" align="right">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
                  <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <!--<th width="3%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>-->
					  <th width="25%">会员名</th>
                      <th width="">搜索记录</th>
                      <th width="25%">时间</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <!--<td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>-->
                        <td><?=$r["ddusername"]?></td>
                        <td><?php if($r["iid"]){?><a href="http://item.taobao.com/item.html?id=<?=$r["iid"]?>" target="_blank">http://item.taobao.com/item.html?id=<?=$r["iid"]?></a><?php }else{?><a href="<?=SITEURL.'/'.u('tao','view',array('q'=>$r['keyword'])); ?>" target="_blank"><?=$r['keyword']?></a><?php }?></td>
						<td><?=$r["day"]?></td>
					  </tr>
					<?php }?>
                  </table>
				<div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',$page_arr));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>