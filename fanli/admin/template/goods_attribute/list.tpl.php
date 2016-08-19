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
              <td width="20%">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'addedi')?>" class="link3">[新增属性]</a> </td>
              <td ></td>
              <td ></td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
                  <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="40px"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
					  <th width="70px;">名称</th>
                      <th width="70px;">颜色</th>
                      <th width="70px;">底色</th>
                      <th width="100px;">备注</th>
                      <th width="70px;">排序</th>
                      <th width="100">操作</th>
                      <th ></th>
                    </tr>
					<?php foreach($row as $r){?>
                    <tr>
                      <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' <?php if($r['sys']==1){?>title="系统数据，不准删除"  disabled="disabled"<?php }?> id='content_<?=$r["id"]?>' /></td>
					  <td><?=$r['title']?></td>
                      <td style="background:#FCF"><div style="background:<?=$r['font_color']?>; width:80%; margin:auto"">&nbsp;</div></td>
                      <td style="background:#FCF"><div style="background:<?=$r['bg_color']?>; width:80%; margin:auto">&nbsp;</div></td>
                      <td><?=is_kong($r['beizhu'])?></td>
                      <td><?=$r['sort']?></td>
                      <td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" >修改</a></td>
                      <td></td>
                    </tr>
                    <?php }?>
                  </table>
				<div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" onclick='return confirm("确定要删除?")'/></div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',array('q'=>$q)));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>