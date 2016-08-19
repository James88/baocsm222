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
$top_nav_name=array(array('url'=>u('baobiao','rank'),'name'=>'集分宝返利排名'),array('url'=>u('baobiao','rank_jine'),'name'=>'金额返利排名'),array('url'=>u('baobiao','tuiguang'),'name'=>'推广排名'),array('url'=>u('baobiao','share'),'name'=>'集分宝分享排名'),array('url'=>u('baobiao','share_jifen'),'name'=>'积分分享排名'));
include(ADMINTPL.'/header.tpl.php');
?>
      <form name="form2" method="get" action="index.php?mod=<?=MOD?>&act=<?=ACT?>" style="margin:0px; padding:0px">
      <table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB;">
        <tr>
              <td width="300px">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;&nbsp;</td>
              <td width="50%" align="right"></td>
              <td width="150px" align="right">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr> 
                      <th width="20%">排名</th>
					  <th width="25%">会员名</th>
                      <th width="">总分享奖励（<?=TBMONEY?>）</th>
                    </tr>
					<?php foreach ($row_2 as $k=>$r){?>
					  <tr>
                      	<td>第<?=($page-1)*$pagesize+($k+1)?>名</td>
                        <td><a href="<?=u('baobei','list',array('se'=>'ddusername','q'=>$r['ddusername']))?>"><?=$r["ddusername"]?></a></td>
                        <td><span style="color:#F00;font-weight:bold"><?=(float)$r['sum']?></span>（<?=TBMONEY?>）</td>
					  </tr>
					<?php }?>
      </table>
       <div class="megas512" style=" margin-top:15px;">
      <?=pageft($total,$pagesize,u(MOD,ACT,array('q'=>$q)));?>
    </div>
       </form>
       <?php include(ADMINTPL.'/footer.tpl.php')?>