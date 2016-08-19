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
$top_nav_name=array(array('url'=>u(MOD,'list'),'name'=>'数据库管理'),array('url'=>u(MOD,'backup'),'name'=>'还原数据库'),array('url'=>u(MOD,'check'),'name'=>'数据库检测'));
include(ADMINTPL.'/header.tpl.php');
?>
<style>
td { line-height:2; }
.dlg {
	border: 2px solid #749F4D;
	background-color: #F0FAEB;
	padding: 2px;
	width: 360px;
	line-height:160%;
}

.x a{ color:#666; text-decoration:none; line-height:25px;}
.w{font-size:12px; text-align:left;}/*模拟灰色阴影背景层*/
.x{ width:180px; position:relative; background:#ff9;  border:1px solid #F96; padding:0 10px; left:-4px; top:-4px;}/*内容div*/
.y , .z{position:absolute; left:30px;}
.y{ color:#ff9;  bottom:-9px;}/*模拟小三角*/
.z{ color:#f96;  bottom:-10px;}/*模拟小三角*/
</style>
<script language="javascript">
var myajax;
var newobj;
var posLeft = 300;
var posTop = 80;
function LoadUrl(surl){
  $.get("<?=u('data','list')?>&"+surl,function(data){
	var scrollTop=parseInt(getScrollTop());
    $('#_mydatainfo').css('top',scrollTop+100).html(data).show();
  })
}
function HideObj(objname){
	$('#_mydatainfo').hide();
    //var obj = document.getElementById(objname);
    //obj.style.display = "none";
}

//获得选中文件的数据表

function getCheckboxItem(){
	 var myform = document.form2;
	 var allSel="";
	 if(myform.tables.value) return myform.tables.value;
	 for(i=0;i<myform.tables.length;i++)
	 {
		 if(myform.tables[i].checked){
			 if(allSel=="")
				 allSel=myform.tables[i].value;
			 else
				 allSel=allSel+","+myform.tables[i].value;
		 }
	 }
	 return allSel;
}

//反选
function ReSel(){
	var myform = document.form2;
	for(i=0;i<myform.tables.length;i++){
		if(myform.tables[i].checked) myform.tables[i].checked = false;
		else myform.tables[i].checked = true;
	}
}

//全选
function SelAll(){
	var myform = document.form2;
	for(i=0;i<myform.tables.length;i++){
		myform.tables[i].checked = true;
	}
}

//取消
function NoneSel(){
	var myform = document.form2;
	for(i=0;i<myform.tables.length;i++){
		myform.tables[i].checked = false;
	}
}

function checkSubmit()
{
	var myform = document.form2;
	myform.tablearr.value = getCheckboxItem();
	return true;
}

function getScrollTop()
{
  var scrollTop=0;
  if(document.documentElement&&document.documentElement.scrollTop)
  {
  scrollTop=document.documentElement.scrollTop;
  }
  else if(document.body)
  {
  scrollTop=document.body.scrollTop;
  }
  return scrollTop;
}

</script>
<div id="waiwei" style="position:relative"><div class="dlg" id="_mydatainfo" style="position:absolute;top:100px; left:300px; display:none"></div></div>
<table width="99%" border="0" cellpadding="3" cellspacing="1" bgcolor="#D1DDAA">
  <tr>
    <td height="19" colspan="10" background="img/tbg.gif" bgcolor="#E7E7E7">
    	<table width="96%" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td width="24%"><strong>数据库管理</strong></td>
          <td width="76%" align="right">
          <form action="" method="get">
          <input type="hidden" name="mod" value="<?=MOD?>"  />
          <input type="hidden" name="act" value="backup"  />
          	<b>数据还原</b>
            <select name="date"><?=$options?></select>
            <input type="submit" value="提交" class="coolbg np" />
            </form>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <form name="form2" onSubmit="checkSubmit()" action="index.php?mod=data&act=list&dopost=bak&token=<?=$_SESSION['token']?>" method="post" target="stafrm">
  <input type='hidden' name='tablearr' value='' />
  <tr bgcolor="#F7F8ED">
    <td height="24" colspan="10"><strong>duoduo默认系统表：</strong></td>
  </tr>
  <tr bgcolor="#F2FFB5" align="center">
    <td height="24" width="5%">选择</td>
    <td width="15%">表名</td>
    <td width="8%">记录数</td>
    <td width="5%" style="position:relative; line-height:1.5">多余<div style="position:absolute; top:-68px; left:0px;"><div class="w">
<div class="x"><p><a>对于有多余碎片的表，可点击“优化”进行优化，刷新查看结果</a></p>
     <div class="z">◆</div>
        <div class="y">◆</div>
</div>
</div></div></td>
    <td width="17%">操作</td>
    <td width="5%">选择</td>
    <td width="15%">表名</td>
    <td width="8%">记录数</td>
    <td width="5%">多余</td>
    <td width="17%">操作</td>
  </tr>
  <?php
  for($i=0; isset($duoduoSysTables[$i]); $i++)
  {
    $t = $duoduoSysTables[$i];
	$tablename=preg_replace('/^'.BIAOTOU.'/','',$t);
    echo "<tr align='center'  bgcolor='#FFFFFF' height='24'>\r\n";
  ?>
    <td>
    	<input type="checkbox" name="tables" value="<?php echo $t; ?>" class="np" checked />
    </td>
    <td>
      <?php echo $t; ?>
    </td>
    <td>
      <?=$duoduo->count($tablename)?>
    </td>
    <td>
    <?php
	$a=$duoduo->show_states($tablename);if($a['Engine']='InnoDB'){$a['Data_free']=0;}echo round($a['Data_free']/1024,2).'kb';
	?>
    </td>
    <td>
    <a href="javascript:" onClick="LoadUrl('dopost=opimize&tablename=<?php echo $t; ?>');">优化</a> |
    <a href="javascript:" onClick="LoadUrl('dopost=repair&tablename=<?php echo $t; ?>');">修复</a> |
    <a href="javascript:" onClick="LoadUrl('dopost=viewinfo&tablename=<?php echo $t; ?>');">结构</a>
    </td>
  <?php
   $i++;
   if(isset($duoduoSysTables[$i])) {
   	$t = $duoduoSysTables[$i];
	$tablename=preg_replace('/^'.BIAOTOU.'/','',$t);
  ?>
    <td>
    	<input type="checkbox" name="tables" value="<?php echo $t; ?>" class="np" checked />
    </td>
    <td>
      <?php echo $t; ?>
    </td>
    <td>
      <?=$duoduo->count($tablename)?>
    </td>
    <td>
    <?php
	$a=$duoduo->show_states($tablename);if($a['Engine']='InnoDB'){$a['Data_free']=0;}echo round($a['Data_free']/1024).'kb';
	?>
    </td>
    <td>
    <a href="javascript:" onClick="LoadUrl('dopost=opimize&tablename=<?php echo $t; ?>');">优化</a> |
    <a href="javascript:" onClick="LoadUrl('dopost=repair&tablename=<?php echo $t; ?>');">修复</a> |
    <a href="javascript:" onClick="LoadUrl('dopost=viewinfo&tablename=<?php echo $t; ?>');">结构</a>
  </td>
  <?php
   }
   else
   {
   	  echo "<td></td><td></td><td></td><td></td><td></td>\r\n";
   }
   echo "</tr>\r\n";
  }
  ?>
  <tr bgcolor="#F7F8ED">
    <td height="24" colspan="10"><strong>其它数据表：</strong></td>
  </tr>
  <?php if($all_show==1){?>
  <tr bgcolor="#F9FEE2" align="center">
    <td height="24" width="5%">选择</td>
    <td width="15%">表名</td>
    <td width="8%">记录数</td>
    <td width="5%">多余</td>
    <td width="17%">操作</td>
    <td width="5%">选择</td>
    <td width="15%">表名</td>
    <td width="8%">记录数</td>
    <td width="5%">多余</td>
    <td width="17%">操作</td>
  </tr>
 <?php
  for($i=0; isset($otherTables[$i]); $i++)
  {
    $t = $otherTables[$i];
	$tablename=preg_replace('/^'.BIAOTOU.'/','',$t);
    echo "<tr align='center'  bgcolor='#FFFFFF' height='24'>\r\n";
  ?>
    <td>
    	<input type="checkbox" name="tables" value="<?php echo $t; ?>" class="np" />
    </td>
    <td>
      <?php echo $t; ?>
    </td>
    <td>
      <?=$duoduo->count_orther($tablename)?>
    </td>
    <td>
    <?php
	$a=$duoduo->show_states($tablename);if($a['Engine']='InnoDB'){$a['Data_free']=0;}echo round($a['Data_free']/1024).'kb';
	?>
    </td>
    <td>
    <a href="javascript:" onClick="LoadUrl('dopost=opimize&tablename=<?php echo $t; ?>');">优化</a> |
    <a href="javascript:" onClick="LoadUrl('dopost=repair&tablename=<?php echo $t; ?>');">修复</a> |
    <a href="javascript:" onClick="LoadUrl('dopost=viewinfo&tablename=<?php echo $t; ?>');">结构</a>
    </td>
  <?php
   $i++;
   if(isset($otherTables[$i])) {
   	$t = $otherTables[$i];
	$tablename=preg_replace('/^'.BIAOTOU.'/','',$t);
  ?>
   <td>
    	<input type="checkbox" name="tables" value="<?php echo $t; ?>" class="np" />
    </td>
    <td>
      <?php echo $t; ?>
    </td>
    <td>
      <?=$duoduo->count_orther($tablename)?>
    </td>
    <td>
    <?php
	$a=$duoduo->show_states($tablename);if($a['Engine']='InnoDB'){$a['Data_free']=0;}echo round($a['Data_free']/1024).'kb';
	?>
    </td>
    <td>
    <a href="javascript:" onClick="LoadUrl('dopost=opimize&tablename=<?php echo $t; ?>');">优化</a> |
    <a href="javascript:" onClick="LoadUrl('dopost=repair&tablename=<?php echo $t; ?>');">修复</a> |
    <a href="javascript:" onClick="LoadUrl('dopost=viewinfo&tablename=<?php echo $t; ?>');">结构</a>
  </td>
  <?php
   }else{
   	  echo "<td></td><td></td><td></td><td></td><td></td>\r\n";
   }
   echo "</tr>\r\n";
  }
  ?>
  <?php }?>
    <tr bgcolor="#FDFDEA">
      <td height="24" colspan="10">
      	&nbsp;
        <input name="b1" type="button" id="b1" class="coolbg np" onClick="SelAll()" value="全选" />
        &nbsp;
        <input name="b2" type="button" id="b2" class="coolbg np" onClick="ReSel()" value="反选" />
        &nbsp;
        <input name="b3" type="button" id="b3" class="coolbg np" onClick="NoneSel()" value="取消" />
        &nbsp;
        (<?php if($_GET['all_show']==1){?><a href="<?=u(MOD,ACT)?>">显示本站</a><?php }else{?><a href="<?=u(MOD,ACT,array('all_show'=>1))?>">显示全部</a><?php }?>)
      </td>
  </tr>
  <tr bgcolor="#F7F8ED">
    <td height="24" colspan="10"><strong>数据备份选项：</strong></td>
  </tr>
  <tr align="center" bgcolor="#FFFFFF">
    <td height="50" colspan="10">
    	  <table width="90%" border="0" cellspacing="0" cellpadding="0">
          <tr align="left">
            <td height="30">当前数据库版本： <?php echo $mysql_version?></td>
          </tr>
          <tr align="left">
            <td height="30">
            	指定备份数据格式：
              <input name="datatype" type="radio" class="np" value="4.0"<?php if($mysql_version<4.1) echo " checked='1'";?> />
              MySQL3.x/4.0.x 版本
              <input type="radio" name="datatype" value="4.1" class="np"<?php if($mysql_version>=4.1) echo " checked='1'";?> />
              MySQL4.1.x/5.x 版本
              </td>
          </tr>
          <tr align="left">
            <td height="30">
            	分卷大小：
              <input name="fsize" type="text" id="fsize" value="1024" size="6" />
              K&nbsp;，
              <input name="isstruct" type="checkbox" class="np" id="isstruct" value="1" checked='1' />
              备份表结构信息
              <?php  if(@function_exists('gzcompress') && false) {  ?>
              <input name="iszip" type="checkbox" class="np" id="iszip" value="1" checked='1' />
              完成后压缩成ZIP
              <?php } ?>
              <input type="hidden" name="date" value="<?=date('Ymd')?>" />
              <input type="submit" name="sub" value="提交" class="coolbg np myself" />
             </td>
          </tr>
        </table>
      </td>
   </tr>
   </form>
  <tr bgcolor="#F7F8ED">
    <td height="24" colspan="10"><strong>进行状态：</strong></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="180" colspan="10">
	<iframe name="stafrm" frameborder="0" id="stafrm" width="100%" height="100%"></iframe>
	</td>
  </tr>
</table>
<?php include(ADMINTPL.'/footer.tpl.php');?>