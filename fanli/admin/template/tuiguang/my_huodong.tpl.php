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
                      <th width="120">开始时间</th>
                      <th width="120">结束时间</th>
                      <th width="170">上次同步</th>
                      <th width="250">操作</th>
                    </tr>
                    <tr>
                      <td style="line-height:20px;"><a href="#">多多返利站长超返推广专享</a> <span style="color:red">[new]</span></td>
                      <td><span class="zt_red">已发布</span></td>
                      <td>24%</td>
                      <td>600</td>
                      <td>2015-06-18</td>
                      <td>2015-07-18</td>
                      <td>2015-07-18 15:11:11</td>
                      <td><a href="<?=u(MOD,'addedi')?>">同步到网站</a> <a href="<?=u(MOD,'addedi')?>">编辑</a></td>
                    </tr>
                    <tr>
                      <td style="line-height:20px;"><a href="#">多多返利站长超返推广专享</a> </td>
                      <td><span class="zt_green">推广中</span></td>
                      <td>24%</td>
                      <td>600</td>
                      <td>2015-06-18</td>
                      <td>2015-07-18</td>
                      <td>2015-07-18 15:11:11</td>
                      <td><a href="<?=u(MOD,'addedi')?>">同步到网站</a> <a href="<?=u(MOD,'addedi')?>">编辑</a></td>
                    </tr>
                    <tr>
                      <td style="line-height:20px;"><a href="#">多多返利站长超返推广专享</a> </td>
                      <td><span class="zt_gray">已结束</span></td>
                      <td>24%</td>
                      <td>600</td>
                      <td>2015-06-18</td>
                      <td>2015-07-18</td>
                      <td>2015-07-18 15:11:11</td>
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
<li>点击同步到网站，带参数（网址，key，活动id）抓取官方平台，官方采集特定推广地址，结合编辑过的数据，反馈给网站。这里之前说过用推送的模式，是为了保证域名都是授权用户。但是存在个别服务器有问题的情况，所以在上一步采用保存pid的形式。（上面的检测状态就应该是检测fanlicheng.com
的）</li>
<li>采集成功后，跳转到goods对应的列表。超级返利商品默认都开启cpc统计。</li>
<li>数据展示采用日期随机算法，方案如下
  <ol>
    <li>假设活动时间3天，一共8件商品</li>
    <li>前台打开板块，检测板块是否是超级返利，如果是，获取到相关信息</li>
    <li>8除3，得到三天商品平均数量 3 3 2</li> 
    <li>如果当天是活动第一天，什么都不改</li>
    <li>如果当天是活动第二天，首次打开，把第4,5,6产品的开始时间，设置为活动开始时间+1秒（这里的前提是一批活动所有商品的开始时间都相同，也应该这么设置），然后做记录（因为前台程序按照添加时间越大越靠前的算法，所以456产品会在显示在前面）</li>
    <li>如果当天是活动第二天，第二次打开，检测已经做过排序，就什么都不改</li>
    <li>如果当天是活动第三天，同理</li>
  </ol>
</li>
				<div style="position:relative; padding-bottom:10px">
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',array('q'=>$q)));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>