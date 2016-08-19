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

if($qf_sign['content']=='' && $_GET['qf_content']!=''){
	$qf_sign['content']=$_GET['qf_content'];
}
if($qf_sign['title']=='' && $_GET['qf_title']!=''){
	$qf_sign['title']=$_GET['qf_title'];
}

$top_nav_name=array(array('url'=>u('user_temp','qunfa_tag'),'name'=>'群发方案'),array('url'=>u('user_temp','list'),'name'=>'待发列表'),array('url'=>u('user_temp','qunfa_jilu'),'name'=>'已发记录'));
include(ADMINTPL.'/header.tpl.php');
$shifou_arr=array('1'=>'是','0'=>'否','2'=>'全部');
?>
<style>
.numWidth{ width:60px}
</style>
<form action="index.php" method="get" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  
  
  <?php if($p==1){?>
  <tr>
    <td width="115px" align="right"></td>
    <td>&nbsp;创建群发方案</td>
  </tr>
   <tr>
    <td align="right">方案标记：</td>
    <td>&nbsp;<?=$sign?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="zhushi">用于区别群发</span></td>
  </tr>
  <?php if($qf_sign['id'] > 0){?>
  <tr>
    <td align="right">会员检索：</td>
    <td>&nbsp;<?=html_radio(array('新增','重置'),$qf_sign['reset'],'reset')?><span class="zhushi">新增:新增记录；重置：清空之前待发记录；</span></td>
  </tr>
  <?php }?>
  <tr>
    <td align="right">群发标题：</td>
    <td>&nbsp;<input type="text" name="title" id="title" value="<?=$qf_sign['title']?>" /><span class="zhushi">用于备忘</span></td>
  </tr>
  <tr>
    <td align="right">群发内容：</td>
    <td><table border="0">
  <tr>
    <td>&nbsp;<textarea class="required" onkeyup="$('#num').text($(this).val().length)" name="content" cols="60" rows="5"><?=$qf_sign['content']?></textarea></td>
    <td><span class="zhushi">当前字符：<b id="num">0</b><br/><br/>字数54个算一条短信，113个算两条短信，中文，英文，空格，标点符号都算1个字符</span></td>
  </tr>
</table></td>
  </tr>
  <?php }else{?>
   <tr>
    <td width="115px" align="right">方案标记：</td>
    <td>&nbsp;<?=$sign?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="zhushi">用于区别群发</span></td>
  </tr>
  <!--<tr>
    <td width="150px" align="right">群发类型：</td>
    <td>&nbsp;<?=html_radio($qunfa_arr,$do,'do')?> &nbsp;<!--<span class="zhushi"><a href="<?=u(MOD,'list',array('do'=>$do))?>">群发列表</a></span></td>
  </tr>-->
  <tr>
    <td align="right">用户名：</td>
    <td>&nbsp;<input type="text" name="ddusername" id="ddusername" value="<?=$_GET['ddusername']?>" /><span class="zhushi">（模糊查询用此格式【%关键字%】）</span></td>
  </tr>
  <tr>
    <td align="right">会员ID：</td>
    <td>&nbsp;<input type="text" name="sid" value="" class="numWidth" />- <input type="text" name="eid" value="" class="numWidth" /><span class="zhushi">（包含本身）</span></td>
  </tr>
  <tr>
    <td align="right">金额范围：</td>
    <td>&nbsp;<input type="text" name="smoney" value="" class="numWidth" />- <input type="text" name="emoney" value="" class="numWidth" />元 <span class="zhushi">（包含本身）</span></td>
  </tr>
  <tr>
    <td align="right"><?=TBMONEY?>范围：</td>
    <td>&nbsp;<input type="text" name="sjifenbao" value="" class="numWidth" />- <input type="text" name="ejifenbao"  value="" class="numWidth" />个<span class="zhushi">（包含本身）</span></td>
  </tr>
  <tr>
    <td align="right">已提现金额：</td>
    <td>&nbsp;<input type="text" name="syitixian" value="" class="numWidth" />- <input type="text" name="eyitixian" value="" class="numWidth" />元 <span class="zhushi">（包含本身）</span></td>
  </tr>
  <tr>
    <td align="right">已提现<?=TBMONEY?>：</td>
    <td>&nbsp;<input type="text" name="stbyitixian" value="" class="numWidth" />- <input type="text" name="etbyitixian"  value="" class="numWidth" />个<span class="zhushi">（包含本身）</span></td>
  </tr>
  <tr>
    <td align="right">等级范围：</td>
    <td>&nbsp;<input type="text" name="slevel" value="" class="numWidth"/>- <input type="text" name="elevel" value="" class="numWidth"/><span class="zhushi">（包含本身）</span></td>
  </tr>
  <tr>
    <td align="right">注册日期：</td>
    <td>&nbsp;<input name="sregtime" type="text" id="sdate" style="width:100px" value="" />- <input name="eregtime" type="text" id="edate" style="width:100px" value="" /></td>
  </tr>
  <tr>
    <td align="right">最后登陆时间：</td>
    <td>&nbsp;<input name="slastlogintime" type="text" id="sdatetime" style="width:100px" value="" />- <input name="elastlogintime" type="text" id="edatetime" style="width:100px" value="" /></td>
  </tr>
  <tr>
    <td align="right">每轮检索个数：</td>
    <td>&nbsp;<input type="text" name="pagesize" id="pagesize" value="100" class="numWidth" /><span class="zhushi">（默认100，根据服务器性能自行调整）</span></td>
  </tr>
  <tr>
    <td align="right">手机已验证：</td>
    <td>&nbsp;<?=html_radio($shifou_arr,'2','mobile_test')?></td>
  </tr>
  <tr>
    <td align="right"><?=TBMONEY?>提现中：</td>
    <td>&nbsp;<?=html_radio($shifou_arr,'2','tbtxstatus')?></td>
  </tr>
  <tr>
    <td align="right">金额提现中：</td>
    <td>&nbsp;<?=html_radio($shifou_arr,'2','txstatus')?></td>
  </tr>
  <tr>
    <td align="right">手机号不为空：</td>
    <td>&nbsp;<input type="radio" checked="checked" />是 <span class="zhushi">（短信群发必备条件）</span></td>
  </tr>
  <?php }?>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="hidden" name="sign" value="<?=$sign?>" /><input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="<?=ACT?>" /><input type="hidden" name="do" value="sms" /><input type="submit" id="sub" name="sub" value="<?=$p==1?' 创 建 方 案 ':' 检 索 会 员 '?>" /></td>
  </tr>
  
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>