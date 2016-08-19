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
              <td class="bigtext">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'list')?>" class="link3">[本地规则]</a>  <a href="http://bbs.duoduo123.com/" target="_blank" class="link3">[付费定制采集]</a></td>
              <td align="right" class="bigtext">共有 <b><?php echo $total;?></b> 条云采集规则&nbsp;&nbsp;</td>
            </tr>
      </table>

      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      <input type="hidden" name="code" value="<?=$code?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px;">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
        <tr>
        <th width="60px">标识码</th>
          <th width="60px">简介</th>
          <th width="150px">预览数据</th>
          <th width="150px">价格</th>
          <th width="120px">操作</th>
          <th width="200px">发布/更新时间</th>
          <th width="200px">商品下架时间</th>
          <th width="120px">错误反馈</th>
        </tr>
	    <tr>
        <td>etjk</td>
          <td><span class="ddnowrap" style="width:300px;">多多卖淘宝店铺的高佣金商品</span></td>
          <td><a href="http://www.fanlicheng.cn" target="_blank">预览数据</a></td>
          <td>官方基础服务</td>
          <td><a href="<?=u(MOD,'addedi',array('id'=>$vo['id']))?>" style="color:#F00; font-weight:bolder">采集</a> </td>
		  <td>2015-04-02/2015-04-03</td>
          <td>不限</td>
		  <td><a href="http://bbs.duoduo123.com/thread-page-1-69.html" target="_blank">错误反馈</a></td>
        </tr>
         <tr>
          <td>tyuh</td>
           <td><span class="ddnowrap" style="width:300px;">多多官方9元购商品</span></td>
          <td><a href="http://www.fanlicheng.cn" target="_blank">预览数据</a></td>
          <td>官方基础服务</td>
          <td><a href="<?=u(MOD,'addedi',array('id'=>$vo['id']))?>" style="color:#F00; font-weight:bolder">采集</a> </td>
		  <td>2015-04-02/2015-04-03</td>
          <td>不限</td>
		  <td><a href="http://bbs.duoduo123.com/thread-page-1-69.html" target="_blank">错误反馈</a></td>
        </tr>
        <tr>
         <td>tyu2</td>
          <td><span class="ddnowrap" style="width:300px;">多多官方19元购商品</span></td>
          <td><a href="http://www.fanlicheng.cn" target="_blank">预览数据</a></td>
          <td>官方基础服务</td>
          <td><a href="<?=u(MOD,'addedi',array('id'=>$vo['id']))?>" style="color:#F00; font-weight:bolder">采集</a> </td>
		  <td>2015-04-02/2015-04-03</td>
          <td>不限</td>
		  <td><a href="http://bbs.duoduo123.com/thread-page-1-69.html" target="_blank">错误反馈</a></td>
        </tr>
        <tr>
         <td>ty34</td>
          <td><span class="ddnowrap" style="width:300px;">多多官方30%超高佣金</span></td>
          <td><a href="http://www.fanlicheng.cn" target="_blank">预览数据</a></td>
          <td>1元特惠</td>
          <td><a href="<?=u(MOD,'addedi',array('id'=>$vo['id']))?>" style="color:#F00; font-weight:bolder">采集</a> </td>
		  <td>2015-04-02/2015-04-03</td>
          <td>限时活动2015-4-31结束</td>
		  <td><a href="http://bbs.duoduo123.com/thread-page-1-69.html" target="_blank">错误反馈</a></td>
        </tr>
        <tr>
         <td>ty3h</td>
          <td><span class="ddnowrap" style="width:300px;">多多官方90%超高佣金</span></td>
          <td><a href="http://www.fanlicheng.cn" target="_blank">预览数据</a></td>
          <td>100元特惠</td>
          <td><a href="<?=u(MOD,'addedi',array('id'=>$vo['id']))?>" style="color:#F00; font-weight:bolder">采集</a> </td>
		  <td>2015-04-02/2015-04-03</td>
          <td>活动已结束，7天后删除</td>
		  <td><a href="http://bbs.duoduo123.com/thread-page-1-69.html" target="_blank">错误反馈</a></td>
        </tr>
        </table>
        <div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,ACT,$page_arr));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>