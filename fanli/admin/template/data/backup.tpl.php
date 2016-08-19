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
* {
	font-size: 12px;
	font-family: "宋体";
}

td { line-height: 1.5; }

body {
	font-size: 12px;
	line-height: 1.5;
	font-family: "宋体";
}
.dlg {
	border: 2px solid #749F4D;
	background-color: #F0FAEB;
	padding: 2px;
	width: 360px;
	line-height:160%;
}
</style>
<script language="javascript">
$(function(){
	$('.np').click(function(){
		var s=$(this).attr('checked');
		if(s==true){
			var c=$(this).attr('class');
			c=c.replace('np ','');
			$('.'+c).attr('checked',true);
		}
	});
});
//获得选中文件的数据表
function getCheckboxItem(){
	 var myform = document.form2;
	 var allSel="";
	 if(myform.bakfile.value) return myform.bakfile.value;
	 for(i=0;i<myform.bakfile.length;i++)
	 {
		 if(myform.bakfile[i].checked){
			 if(allSel=="")
				 allSel=myform.bakfile[i].value;
			 else
				 allSel=allSel+","+myform.bakfile[i].value;
		 }
	 }
	 return allSel;
}
//反选
function ReSel(){
	var myform = document.form2;
	for(i=0;i<myform.bakfile.length;i++){
		if(myform.bakfile[i].checked) myform.bakfile[i].checked = false;
		else myform.bakfile[i].checked = true;
	}
}
//全选
function SelAll(){
	var myform = document.form2;
	for(i=0;i<myform.bakfile.length;i++){
		myform.bakfile[i].checked = true;
	}
}
//取消
function NoneSel(){
	var myform = document.form2;
	for(i=0;i<myform.bakfile.length;i++){
		myform.bakfile[i].checked = false;
	}
}
//
function checkSubmit()
{
	var myform = document.form2;
	myform.bakfiles.value = getCheckboxItem();
	return true;
}
</script>
<table width="99%" border="0" cellpadding="3" cellspacing="1" bgcolor="#D1DDAA">
  <tr>
    <td height="19" colspan="4" background="img/tbg.gif" bgcolor="#E7E7E7">
    	<table width="96%" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td width="24%"><strong>数据还原</strong></td>
          <td width="76%" align="right">
          <form action="" method="get">
          <input type="hidden" name="mod" value="<?=MOD?>"  />
          <input type="hidden" name="act" value="<?=ACT?>"  />
          	<b><a href="<?=u('data','list')?>"><u>数据备份</u></a></b>
          	|
          	<b>数据还原</b>
            <select name="date"><?=$option?></select>
            <input type="submit" value="提交" class="coolbg np" />
            </form>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <form name="form2" onSubmit="checkSubmit()" action="index.php?mod=data&act=backup&token=<?=$_SESSION['token']?>" method="post" target="stafrm">
    <input type='hidden' name='dopost' value='redat' />
    <input type='hidden' name='bakfiles' value='' />
    <tr bgcolor="#F7F8ED">
      <td height="24" colspan="4" valign="top">
      	<strong>发现的备份文件 (日期：<?=date('Y-m-d',strtotime($date))?>)</strong>
        <?php if(count($filelists)==0) echo " 没找到任何备份文件... "; ?>
      </td>
    </tr>
    <?php
	$c=count($filelists);
    for($i=0;$i<$c;$i++)
    {
		preg_match('/\w+_(\w+)_\d+_\w+/',$filelists[$i],$a);
    	echo "<tr  bgcolor='#FFFFFF' align='center' height='24'>\r\n";
      $mtd = "<td width='10%'>
             <input name='bakfile' id='bakfile".$i."' type='checkbox' class='np ".$a[1]."' value='".$filelists[$i]."' checked='1' />
             </td>
             <td width='40%'><label for='bakfile".$i."'>{$filelists[$i]}</label></td>\r\n";
      echo $mtd;
      if(isset($filelists[$i+1]))
      {
      	$i++;
		preg_match('/\w+_(\w+)_\d+_\w+/',$filelists[$i],$a);
      	$mtd = "<td width='10%'>
              <input name='bakfile' id='bakfile".$i."' type='checkbox' class='np ".$a[1]."' value='".$filelists[$i]."' checked='1' />
              </td>
              <td width='40%'><label for='bakfile".$i."'>{$filelists[$i]}</label></td>\r\n";
        echo $mtd;
      }else{
      	echo "<td></td><td></td>\r\n";
      }
      echo "</tr>\r\n";
    }
    ?>
    <tr align="center" bgcolor="#FDFDEA">
      <td height="24" colspan="4">
      	&nbsp;
        <input name="b1" type="button" id="b1" onClick="SelAll()" value="全选" />
        &nbsp;
        <input name="b2" type="button" id="b2" onClick="ReSel()" value="反选" />
        &nbsp;
        <input name="b3" type="button" id="b3" onClick="NoneSel()" value="取消" />
     </td>
    </tr>
	  <tr bgcolor="#F7F8ED">
      <td height="24" colspan="4" valign="top">
      	<strong>附加参数：</strong>
      </td>
    </tr>
    <tr  bgcolor="#FFFFFF">
      <td height="24" colspan="4">
        <input name="delfile" type="checkbox" class="np" id="delfile" value="1" />
        还原后删除备份文件 
        <input name="keepdb" type="checkbox" class="np" id="keepdb" value="1" />
        保留现有表结构 
        </td>
    </tr>
    <tr bgcolor="#E3F4BB">
      <td height="33" colspan="4">
      	 &nbsp;<input type="hidden" name="date" value="<?=$date?>" />
      	 <input type="submit" name="sub" value="开始还原数据" class="coolbg np myself" />
      </td>
    </tr>
  </form>
  <tr bgcolor="#F7F8ED">
    <td height="24" colspan="4"><strong>进行状态： </strong></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="180" colspan="4">
    	<iframe name="stafrm" frameborder="0" id="stafrm" width="100%" height="100%"></iframe>
    </td>
  </tr>
</table>
<?php include(ADMINTPL.'/footer.tpl.php');?>