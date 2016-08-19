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
              <td class="bigtext">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'huodong')?>" class="link3">[活动列表]</a>&nbsp;<a href="<?=u(MOD,'my_huodong')?>" class="link3">[我的活动]</a> 当前网址:<span class="zt_red">http://www.fanlicheng.com;</span> 状态：<span class="zt_green">正常</span> </td>
              <td width="" align="right"></td>
              <td width="500" align="right"><input type="text" name="q" value="搜索活动名称" />&nbsp;<input type="submit" value="搜索" /></td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
                  <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="">活动名称</th>
					  <th width="80">状态</th>
                      <th width="80">平均佣金</th>
                      <th width="80">商品数量</th>
                      <th width="150">开始时间</th>
                      <th width="150">结束时间</th>
                      <th width="250">操作</th>
                    </tr>
                    <tr>
                      <td style="line-height:20px;"><a href="#">多多返利站长超返推广专享</a> <span style="color:red">[new]</span></td>
                      <td><span class="zt_red">已发布</span></td>
                      <td>24%</td>
                      <td>600</td>
                      <td>2015-06-18</td>
                      <td>2015-07-18</td>
                      <td><a href="<?=u(MOD,'addedi')?>">立刻推广</a></td>
                    </tr>
                    <tr>
                      <td style="line-height:20px;"><a href="#">多多返利站长超返推广专享</a> </td>
                      <td><span class="zt_green">推广中</span></td>
                      <td>24%</td>
                      <td>600</td>
                      <td>2015-06-18</td>
                      <td>2015-07-18</td>
                      <td><a href="#">立刻推广</a></td>
                    </tr>
                    <tr>
                      <td style="line-height:20px;"><a href="#">多多返利站长超返推广专享</a> </td>
                      <td><span class="zt_gray">已结束</span></td>
                      <td>24%</td>
                      <td>600</td>
                      <td>2015-06-18</td>
                      <td>2015-07-18</td>
                      <td><span class="zt_gray">已结束</span></td>
                    </tr>
					<?php foreach ($tuiguang as $r){?>
					  <tr>
						<td><?=$r["fenxiangren"]?></td>
                        <td><?=$r["username"]?></td>
                        <td><a class="ddnowrap" style="width:400px; " href="<?=$r['url']?>" target="_blank" title="<?=$r['title']?>">【<?=$r['type']?>】<?=$r["title"]?></a></td>
                        <td><?=$r['status']==1?'已确认':'未确认'?></td>
                        <td><?=$r["money"]?>元</td>
						<td><?=date('Y-m-d',strtotime($r["date"]))?></td>
                        <td><?=$r['status']==1?$r["pay_time"]:'——'?></td>
					  </tr>
					<?php }?>
                  </table>
流程文字说明：<br/>
<ol>
<li>官方在返利城添加精选活动，并采集商品编辑后发布活动</li>
<li>列表显示官方发布的精选活动，显示的方法有两种，api或者iframe，个人倾向api，代码制作简单。iframe可以随时调整内容（但是这个内容觉得没什么可调整的）</li>
<li>点击推广到推广页面。</li>
</ol>
				<div style="position:relative; padding-bottom:10px">
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',array('q'=>$q)));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>