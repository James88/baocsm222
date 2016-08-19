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
if($webset['taobao_session']['auto']==1){
	$taobao_session_day=30;
}
else{
	$taobao_session_day=1;
}
$session_time_last=24*3600*$taobao_session_day;
?>
<div style="width:100%;">
  <div class="c_left">
	<!--安全监控-->
    <?php if($admin_name=='admin'){?><div class="box_a"><span>安全提示：请及时通过FTP更改后台路径目录"admin"为其他名称。</span></div><?php }?>
    <?php if($install==1){?><div class="box_a"><span>安全提示：请及时通过FTP删除install文件夹。</span></div><?php }?>
    <?php if($nopid==1){?><div class="box_a"><span>推广提示：您有子域名没有添加对应PID，请及时去阿里妈妈备案并添加（如果该域名下没有淘宝商品，请忽略）。  <a target="_blank" href="http://pub.alimama.com/myunion.htm?spm=a2320.7388781.a214tr8.d006.WOweLH#!/manage/site/site">去添加</a></span></div><?php }?>
    <?php if(DLADMIN!=1){?>
    <div class="box_l">
        <div class="c_biaoti" >&nbsp;站务快捷  <span style="font-size:12px; font-weight:normal"><a style="color:#FF6600; cursor:pointer" href="http://bbs.duoduo123.com/read-1-1-197798.html" target="_blank" >设置向导 </a></span></div>
        <ul class="kuaijie">
		  <li><a href="http://bbs.duoduo123.com" target="_blank">官方便捷：</a></li>
          <li><a href="http://bbs.duoduo123.com/thread-page-1-85.html" target="_blank">新手帮助</a></li>
		  <li><a href="http://bbs.duoduo123.com/forum.php?mod=post&action=newthread&fid=96" target="_blank">提交问题</a></li>
		  <li><a href="http://bbs.duoduo123.com/thread-page-1-69.html" target="_blank" style="color:#F30">风向标</a></li>
		  <li><a href="http://bbs.duoduo123.com/thread-page-1-64.html" target="_blank">多多黑板报</a></li>
		  <li><a href="http://bbs.duoduo123.com/thread-page-1-37.html" target="_blank">发展与建议</a></li>
          <li><a href="<?=DD_OPEN_JFB_REG_URL?><?=urlencode(URL)?>" style="color:#F30">集分宝平台</a></li>
          <li><a href="<?=u('plugin','bbx')?>" style="color:#F30">百宝箱平台</a></li>
		</ul>	
		<ul class="kuaijie">
		  <li><a href="<?=u('kuaijie','list')?>">站务便捷：</a></li>
          <?php foreach($kuaijie as $k=>$v){?>
          <li><a href="<?=$v['url']?>"><?=$v['title']?></a></li>
          <?php }?>
          <li><a style="color:#F00; cursor:pointer" href="<?=u('kuaijie','list')?>">添加快捷</a></li>
		</ul>
        <div style="clear:both"></div>
      </div>
      <?php }?>
      <div class="box_l">
        <div class="c_biaoti" >&nbsp;站务处理  </div>
        <ul  style="color:#009900">
          <?php if($checked_trade_num==0 && $wait_see_msg_num==0 && $wait_do_duihuan_num==0 && $wait_do_tixian_num==0 && $hezuo_num==0){?>
		  <li>站内暂时无事务处理！</li>
          <?php }else{?>
              <?php if($checked_trade_num>0){?>
			  <li>有<b class="bignum"><?=$checked_trade_num?></b>条订单未审核！<a href="<?=u('tradelist','list',array('checked'=>1))?>">处理</a></li>
              <?php }?>
              <?php if($wait_see_msg_num>0){?>
			  <li>有<b class="bignum"><?=$wait_see_msg_num?></b>条短信未回复！<a href="<?=u('msg','list')?>" >查看</a></li>
              <?php }?>
              <?php if($wait_do_duihuan_num>0){?>
			  <li>有<b class="bignum"><?=$wait_do_duihuan_num?></b>条兑换未处理！<a href="<?=u('duihuan','list')?>" >处理</a></li>
              <?php }?>
              <?php if($wait_do_tixian_num>0){?>
			  <li>有<b class="bignum"><?=$wait_do_tixian_num?></b>条提现未处理！<a href="<?=u('tixian','list',array('status'=>0))?>">处理</a></li>
              <?php }?>
              <?php if($hezuo_num>0){?>
			  <li>有<b class="bignum"><?=$hezuo_num?></b>条卖家报名未处理！<a href="<?=u('hezuo','list',array('status'=>0))?>">处理</a></li>
              <?php }?>
              <?php if($baobei_num>0){?>
			  <li>有<b class="bignum"><?=$baobei_num?></b>条晒单未审核！<a href="<?=u('baobei','list',array('status'=>2))?>">处理</a></li>
              <?php }?>
          <?php }?>
		</ul>		
        <div style="clear:both"></div>
      </div>
 <div  class="center_tj">
      <div  class="bg  <?php if($day!=1 && $day!=2 && $day!=3){?>bg_1<?php }?>"><a href="<?=u('webset','center')?>" >今日数据</a></div><div class="bg <?php if($day==1){?>bg_1<?php }?>"><a href="<?=u('webset','center',array('day'=>1))?>" >近7日数据</a></div><div class="bg <?php if($day==2){?>bg_1<?php }?>"><a href="<?=u('webset','center',array('day'=>2))?>" >近1月数据</a></div><div class="bg <?php if($day==3){?>bg_1<?php }?>"><a href="<?=u('webset','center',array('day'=>3))?>" >总数据</a></div>
      <div class="box_l">
        <div class="c_biaoti" >&nbsp;网站数据</div>
        <ul class="shuju">
		  <li title="网站所有项目的佣金收益">网站收益：<b style="color:#FF6600"><?=($web_zsy)?> 元</b></li>
		  <li title="总收益-已支出">预计净收益：<b style="color:#FF6600" ><?=round($web_zsy-$zhizhu_sum,2)?> 元</b></li>
		  <li title="已兑换+已提现">已支出：<b style="color:#009900"><?=$zhizhu_sum?> 元</b></li>
          <li title="阶段内会员增量">会员数：<b style="color:#009900"><?=$user_sum?> </b></li>
		</ul>	
        <div style="clear:both"></div>
      </div>
      
      <div class="box_l">
        <div class="c_biaoti" >&nbsp;淘宝联盟</div>
        <ul class="shuju">
		  <li>总交易额：<b style="color:#FF6600"><?=$tao_goods_sum?> 元</b></li>
		  <li>总收益：<b style="color:#FF6600"><?=$taobao_zsy?> 元</b></li>
		  <li>总交易量：<b style="color:#FF6600"><?=$taobao_tradenum?> 条</b></li>
		  <li>已确认订单：<b style="color:#FF6600"><?=$tradenum_ok?> 条</b></li>
		  <li>未认领订单：<b style="color:#FF6600"><?php echo $taobao_tradenum-$tradenum_ok;?> 条</b></li>
		</ul>	
        <div style="clear:both"></div>
      </div>
      <?php if($webset['paipai']['open']==1){?>
      <div class="box_l">
        <div class="c_biaoti" >&nbsp;拍拍联盟</div>
        <ul class="shuju">
		  <li>总交易额：<b style="color:#FF6600"><?=$pai_goods_sum?> 元</b></li>
		  <li>总收益：<b style="color:#FF6600"><?=$paipai_zsy?> 元</b></li>
		  <li>总交易量：<b style="color:#FF6600"><?=$paipai_tradenum?> 条</b></li>
		  <li>已确认订单：<b style="color:#FF6600"><?=$paipai_tradenum_ok?> 条</b></li>
		  <li>未认领订单：<b style="color:#FF6600"><?php echo $paipai_tradenum-$paipai_tradenum_ok;?> 条</b></li>
		</ul>	
        <div style="clear:both"></div>
      </div>
      <?php }?>
      <div class="box_l">
        <div class="c_biaoti" >&nbsp;其他联盟</div>
        <ul class="shuju">
		  <li>总交易额：<b style="color:#FF6600"><?=$mall_goods_sum?> 元</b></li>
		  <li>总收益：<b style="color:#FF6600"><?=$mall_zsy?> 元</b></li>
		  <li>总交易量：<b style="color:#FF6600"><?=$mall_tradenum?> 条</b></li>
		  <li>有效订单：<b style="color:#FF6600"><?=$mall_order_ok?> 条</b></li>
		  <li>未核对订单：<b style="color:#FF6600"><?=$mall_order_no?> 条</b></li>
          <li>未认领订单：<b style="color:#FF6600"><?=$mall_no_user?> 条</b></li>
		</ul>	
        <div style="clear:both"></div>
      </div>
      <?php if($task_status==1){?>
      <div class="box_l">
        <div class="c_biaoti" >&nbsp;任务返利</div>
        <ul class="shuju">
		  <li>总佣金：<b style="color:#FF6600"><?=$taskyj['commission']?> 元</b></li>
		  <li>会员收益：<b style="color:#FF6600"><?=$taskyj['point']?> 元</b></li>
          <li>网站收益：<b style="color:#FF6600"><?=$tasksy?> 元</b></li>
		  <li>总订单：<b style="color:#FF6600"><?=$tasknum?> 条</b></li>
		  <li>确认订单：<b style="color:#FF6600"><?=$tasknum_1?> 条</b></li>
		</ul>	
        <div style="clear:both"></div>
      </div>
      <?php }?>
      </div>
      <div class="box_l" style="margin-top:5px">
        <div class="c_biaoti" >&nbsp;最新操作日志 &nbsp; &nbsp;<a href="<?=u('adminlog','list')?>">更多</a></div>
        <table width="100%" border=1 cellpadding=0 cellspacing=0 style="border-collapse: collapse" bordercolor="#DCEAF7">                
          <tr>
            <td width="11%"  height="30" align="center" bgcolor="#F2F2F2" class="bigtext"><strong>管理员</strong></td>
			<td width="19%" align="center"  bgcolor="#F2F2F2" class="bigtext"><strong>操作IP</strong></td>
            <td width="20%" align="center"  bgcolor="#F2F2F2" class="bigtext"><strong>模块</strong></td>
            <td width="20%" align="center"  bgcolor="#F2F2F2" class="bigtext"><strong>操作</strong></td>
            <td width=""  align="center" bgcolor="#F2F2F2" class="bigtext"><strong>执行时间</strong></td>
          </tr>
          <?php foreach($admin_log as $row){?>
          <tr>
            <td height="30" align="center"><?=$row['admin_name']?></td>
            <td align="center"><?=$row['ip']?></td>
            <td align="center"><?=$row['mod']?></td>
            <td align="center"><?=$row['do']?></td>
            <td align="center"><?=date('Y-m-d H:i:s',$row['addtime'])?></td>
          </tr>
          <?php }?>
        </table>
        <div style="clear:both"></div>
      </div>
  </div>
  <?php if(DLADMIN!=1){?>
  <div class="c_right">
    <div class="box_l">
	 	  <table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7;">
            <tr>
              <td width="811" height="25" bgcolor="E9F2FB" class="bigtext c_biaoti" >&nbsp;版本信息</td>
            </tr>
            <tr>
              <td colspan="2" valign="top"><span class="left_txt" style="color:#F00; font-weight:bold">&nbsp;<img src="images/ts.gif" width="12" height="12" /> 版本：<span class="banben">V8.3</span>_UTF-8 更新日期：</span> <span class="S3" style="color:#F00; font-weight:bold"><?=BANBEN?></span> <a style="text-decoration:underline" href="<?=u('upgrade','index')?>"></a>
			    <div style=" margin:5px 10px; clear:both; height:80px; line-height:20px; vertical-align:middle">
			      <iframe frameborder="0" marginheight="0" marginwidth="0" border="0" scrolling="No" height="80" width="100%" src="http://soft.duoduo123.com/soft_info/update_v8.1.html" ></iframe>
	          </div></td>
            </tr>
          </table>
	 	</div>
        
        <div class="box_l">
	 	  <table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7;">
            <tr>
              <td width="811" height="25" bgcolor="E9F2FB" class="bigtext c_biaoti" ><div style="float:left">&nbsp;风向标信息</div><div style="float:right"><a href="http://bbs.duoduo123.com/thread-htm-fid-69.html" target="_blank" style="font-family:宋体">更多></a>></div></td>
            </tr>
            <tr>
              <td colspan="2" valign="top">
			    <div style=" margin:5px 10px; clear:both; height:80px; line-height:20px; vertical-align:middle">
			      <iframe frameborder="0" marginheight="0" marginwidth="0" border="0" scrolling="No" height="80" width="100%" src="http://soft.duoduo123.com/soft_info/fxb_v8.1.html" ></iframe>
	          </div></td>
            </tr>
          </table>
	 	</div>
        
        <div class="box_l">
	 	  <table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7;">
            <tr>
              <td width="811" height="25" bgcolor="E9F2FB" class="bigtext c_biaoti" >&nbsp;商业授权查询&nbsp;&nbsp;<span style="font-size:12px; font-weight:normal">查询授权唯一域名:duoduo123.com</span> 
             </td>
            </tr>
            <tr>
              <td colspan="2" valign="top" style="padding:3px 10px;"><div align="left" style="line-height:25px;">
              授权网址： <span style="color:#FF0000"><?=$auth_arr['url']?$auth_arr['url']:'本地测试'?></span>&nbsp;&nbsp;<a href="http://auth.duoduo123.com/ckurl.php?url=<?=iconv('utf-8','gbk//IGNORE',urlencode(get_domain()))?>" target="_blank"><img src="images/biz.gif" width="52" height="23" border="0" align="absmiddle" /></a><br/>
              开始时间：<?=date('Y-m-d',$auth_arr['stime'])?>&nbsp;&nbsp;到期时间：<?=$auth_arr['etime']>=2143123200?'终生授权':date('Y-m-d',$auth_arr['etime'])?> <a href="<?=u(MOD,ACT,array('duoduoauthget'=>'1'))?>"><img src="images/to.gif"  alt="重新获取" border="0" align="absmiddle" /></a><br/>
              <?php if($auth_arr['type']==2){?>
              <span style="line-height:25px;">客服经理：<?=$auth_arr['kefu_name']?></span> <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?=$auth_arr['kefu']?>&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:<?=$auth_arr['kefu']?>:46" title="<?=$auth_arr['kefu_name']?>"></a>
              <?php }elseif($auth_arr['type']==1){?>
              购买授权，<a href="http://auth.duoduo123.com" target="_blank" style="text-decoration:underline; color:#F00">购买地址</a>
              <?php }elseif((int)$auth_arr['type']==0){?>
              购买授权，<a href="http://auth.duoduo123.com" target="_blank" style="text-decoration:underline; color:#F00">购买地址</a>
              <?php }?>
              </div></td>
            </tr>
          </table>
	 	</div>
        <div class="box_l">
	 	  <table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7;">
            <tr>
              <td width="811" height="25" bgcolor="E9F2FB" class="bigtext c_biaoti" >&nbsp;官方公告</td>
            </tr>
            <tr>
              <td colspan="2" valign="top" style="padding:3px 10px;">
	 <iframe frameborder="0" marginheight="0" marginwidth="0" border="0" scrolling="No" height="166" width="100%" src="http://soft.duoduo123.com/soft_info/gonggao.html" ></iframe>	  
			  </td>
            </tr>
          </table>
		</div>
      <div class="box_l">
	 	  <table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7;">
            <tr>
              <td width="811" height="25" bgcolor="E9F2FB" class="bigtext c_biaoti" >&nbsp;站长推荐</td>
            </tr>
            <tr>
              <td colspan="2" valign="top" style="padding:3px 10px;">
<iframe frameborder="0" marginheight="0" marginwidth="0" border="0" scrolling="No" height="166" width="100%" src="http://soft.duoduo123.com/soft_info/ad.html" ></iframe>			  
			  </td>
            </tr>
          </table>
		</div>
  </div>
  <?php }?>
</div>  
<script src="<?=DD_U_URL?>/?g=Home&m=DdApi&a=tixing&url=<?=urlencode(URL)?>&key=<?=urlencode(md5(DDYUNKEY))?>&banben=<?php echo include(DDROOT.'/data/banben.php');?>"></script>
<?php include(ADMINTPL.'/footer.tpl.php')?>