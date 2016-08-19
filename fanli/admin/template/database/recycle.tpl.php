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
				<table id="addeditable"  border=1  cellpadding=0 cellspacing=0 bordercolor="#dddddd" style="margin-top:10px; width:1020px; text-align:center">
				   <?php for($i=0;$i<$n;$i++){?>
                    <tr >
                      <?php for($z=0;$z<6;$z++){?>
                      <th width="170px"><a href="<?=$recyle[$i*6+$z]['url']?>"><?=$recyle[$i*6+$z]['title']?><?php if($recyle[$i*6+$z]['url']){?>(<?=$recyle[$i*6+$z]['num']?>)<?php }?></a> <?php if(isset($recyle[$i*6+$z])){?>[<a href="<?=u(MOD,ACT,array('qingkong'=>1,'table'=>$recyle[$i*6+$z]['table']))?>">清空</a>]<?php }?></th>
                      <?php }?>
                    </tr>
                    <?php }?>
                  </table>
<?php include(ADMINTPL.'/footer.tpl.php');?>