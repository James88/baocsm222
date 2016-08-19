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

$type_all=dd_get_cache('type');
$web_cid_arr=$type_all['goods'];

include(ADMINTPL.'/header.tpl.php');
if(isset($_POST['sub'])){
	jump(u(MOD,'my_huodong'),'保存一条数据并跳转到我的活动');

}
?>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>&code=<?=$code?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
	<tr>
    <td align="right">网站信息：</td>
    <td>&nbsp;当前网址:<span class="zt_red">http://www.fanlicheng.com;</span> 状态：<span class="zt_green">正常</span> ；</td>
   </tr>
   <tr>
    <td align="right">活动名称：</td>
    <td>&nbsp;多多返利站长超返推广专享</td>
   </tr>
   <tr>
    <td align="right">当前期数：</td>
    <td>&nbsp;第1期</td>
   </tr>
   <tr>
    <td align="right">推广时间：</td>
    <td>&nbsp;起：2015-06-18 止：2015-07-18</td>
   </tr>
  <tr>
    <td align="right">推广地址：</td>
    <td>&nbsp;<a href="">自动参加</a>&nbsp;&nbsp;&nbsp;<a href="">人工获取</a> <input name="URL" type="text" id="url" value="v83.duoduo123.com" size="40" class="btn3 input-text" style="width:400px"> <span class="zhushi"><a href="#">获取方法</a></span></td>
  </tr> 
   <tr>
    <td align="right">接收板块：</td>
    <td>&nbsp;<select name="bankuai_tpl" id="bankuai_tpl" class="bankuai_tpl"><option value="站长网站板块1" style="background:">站长网站板块2</option><option value="新建板块" style="background:">新建板块</option></select> <a target="_blank" href="<?=u('bankuai','addedi')?>">新建</a> <a href="">刷新</a>   新建板块是弹出新页面，所以需要点击刷新来显示新建的板块</td>
  </tr>
 <tr>
    <td align="right">包含分类：</td>
    <td>
      <table width="200" border="0" cellspacing="0" cellpadding="0" style=" text-align:center">
        <tr>
          <td>规则分类</td>
          <td>本站分类</td>
        </tr>
                <tr>
            <td><input type="hidden" name="yun_cid[1][yun]" value="10008">其他</td>
            <td id="yun_cid_1"><select name="yun_cid[1][bendi]">
            <option  value="10001">服饰</option><option  value="10002">鞋包</option><option  value="10003">美妆</option><option  value="10004">美食</option><option  value="10005">母婴</option><option  value="10006">居家</option><option  value="10007">数码</option><option selected value="10008">其他</option><option  value="0">不采集</option>            </select></td>
            </tr>
                    <tr>
            <td><input type="hidden" name="yun_cid[2][yun]" value="10007">数码</td>
            <td id="yun_cid_2"><select name="yun_cid[2][bendi]">
            <option  value="10001">服饰</option><option  value="10002">鞋包</option><option  value="10003">美妆</option><option  value="10004">美食</option><option  value="10005">母婴</option><option  value="10006">居家</option><option selected value="10007">数码</option><option  value="10008">其他</option><option  value="0">不采集</option>            </select></td>
            </tr>
                    <tr>
            <td><input type="hidden" name="yun_cid[3][yun]" value="10006">居家</td>
            <td id="yun_cid_3"><select name="yun_cid[3][bendi]">
            <option  value="10001">服饰</option><option  value="10002">鞋包</option><option  value="10003">美妆</option><option  value="10004">美食</option><option  value="10005">母婴</option><option selected value="10006">居家</option><option  value="10007">数码</option><option  value="10008">其他</option><option  value="0">不采集</option>            </select></td>
            </tr>
                    <tr>
            <td><input type="hidden" name="yun_cid[4][yun]" value="10005">母婴</td>
            <td id="yun_cid_4"><select name="yun_cid[4][bendi]">
            <option  value="10001">服饰</option><option  value="10002">鞋包</option><option  value="10003">美妆</option><option  value="10004">美食</option><option selected value="10005">母婴</option><option  value="10006">居家</option><option  value="10007">数码</option><option  value="10008">其他</option><option  value="0">不采集</option>            </select></td>
            </tr>
                    <tr>
            <td><input type="hidden" name="yun_cid[5][yun]" value="10004">美食</td>
            <td id="yun_cid_5"><select name="yun_cid[5][bendi]">
            <option  value="10001">服饰</option><option  value="10002">鞋包</option><option  value="10003">美妆</option><option selected value="10004">美食</option><option  value="10005">母婴</option><option  value="10006">居家</option><option  value="10007">数码</option><option  value="10008">其他</option><option  value="0">不采集</option>            </select></td>
            </tr>
                    <tr>
            <td><input type="hidden" name="yun_cid[6][yun]" value="10003">美妆</td>
            <td id="yun_cid_6"><select name="yun_cid[6][bendi]">
            <option  value="10001">服饰</option><option  value="10002">鞋包</option><option selected value="10003">美妆</option><option  value="10004">美食</option><option  value="10005">母婴</option><option  value="10006">居家</option><option  value="10007">数码</option><option  value="10008">其他</option><option  value="0">不采集</option>            </select></td>
            </tr>
                    <tr>
            <td><input type="hidden" name="yun_cid[7][yun]" value="10002">鞋包</td>
            <td id="yun_cid_7"><select name="yun_cid[7][bendi]">
            <option  value="10001">服饰</option><option selected value="10002">鞋包</option><option  value="10003">美妆</option><option  value="10004">美食</option><option  value="10005">母婴</option><option  value="10006">居家</option><option  value="10007">数码</option><option  value="10008">其他</option><option  value="0">不采集</option>            </select></td>
            </tr>
                    <tr>
            <td><input type="hidden" name="yun_cid[8][yun]" value="10001">服饰</td>
            <td id="yun_cid_8"><select name="yun_cid[8][bendi]">
            <option selected value="10001">服饰</option><option  value="10002">鞋包</option><option  value="10003">美妆</option><option  value="10004">美食</option><option  value="10005">母婴</option><option  value="10006">居家</option><option  value="10007">数码</option><option  value="10008">其他</option><option  value="0">不采集</option>            </select></td>
            </tr>
                    </table>
      </td>
  </tr>

  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
流程文字说明：<br/>
<ol>
<li>板块可以选择，分类随着板块联动</li>
<li>点击自动残疾后开始模拟登陆（如果没设置淘宝账号先跳转去设置），如果点击人工获取出现input框自己写完整pid（有pid就能获取到商品）</li>
<li>点击保存将pid和网址提交到U平台（推广表，记录网站，pid，活动id。这样平台就能看到有多少网站推广了这个活动，也为下一步做准备），然后跳转到我的活动。</li>
</ol>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>