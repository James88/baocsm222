<?php 
/**
 * ============================================================================
 * 版权所有 多多科技，保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('ADMIN')){
	exit('Access Denied');
}
if(isset($_GET['which_lt'])){
	$which_lt=(int)$_GET['which_lt'];
	if($which_lt==0){
		$ucenter_arr = $duoduo->webset_part('ucenter',array('open'=>'0'));
		foreach($ucenter_arr as $m=>$n){
					$duoduo->set_webset($m,$n);
		}
		$phpwind_arr = $duoduo->webset_part('phpwind',array('open'=>'0'));
		foreach($phpwind_arr as $m=>$n){
					$duoduo->set_webset($m,$n);
		}	
	}elseif($which_lt==1){
		$ucenter_arr = $duoduo->webset_part('ucenter',array('open'=>'1'));
		foreach($ucenter_arr as $m=>$n){
					$duoduo->set_webset($m,$n);
		}
		$phpwind_arr = $duoduo->webset_part('phpwind',array('open'=>'0'));
		foreach($phpwind_arr as $m=>$n){
					$duoduo->set_webset($m,$n);
		}	
	}elseif($which_lt==2){
		$ucenter_arr = $duoduo->webset_part('ucenter',array('open'=>'0'));
		foreach($ucenter_arr as $m=>$n){
					$duoduo->set_webset($m,$n);
		}
		$phpwind_arr = $duoduo->webset_part('phpwind',array('open'=>'1'));
		foreach($phpwind_arr as $m=>$n){
					$duoduo->set_webset($m,$n);
		}	
	}
	exit();	
}

include(ADMINTPL.'/header.tpl.php');
$status=array(0=>'关闭',1=>'开启');
$which_lt = $webset['ucenter']['open']==1?'1':($webset['phpwind']['open']==1?'2':'0');
if($_GET['ucmyset']==1){$webset['ucenter']['open']==1;}
?>
<script>
$(function(){
	 $('input[name="which_lt"]').click(function(){
        if($(this).val()==1){
		    $('#form1').show();
			$('#form2').hide();
		}
		else if($(this).val()==2){
		   $('#form2').show();
		   $('#form1').hide();
		}else if($(this).val()==0){
		   $('#form2').hide();
		   $('#form1').hide();
		}
	});
	
	 $('input[name="which_lt"]').click(function(){
		var which_lt=$(this).val();
		$.get('<?=u(MOD,ACT)?>',{'which_lt':which_lt},function(data){
			if(which_lt==1){
				alert('您已选择ucenter整合，请进行相关设置！');
			}else if(which_lt==2){
				alert('您已选择phpwind整合，请进行相关设置！');
			}else if(which_lt==0){
				alert('您已关闭论坛整合！');
			}
		});
	});
	
	if(parseInt($('input[name="which_lt"]:checked').val())==1){
		$('#form1').show();
		$('#form2').hide();
	}else if(parseInt($('input[name="which_lt"]:checked').val())==2){
		 $('#form2').show();
		 $('#form1').hide();
	}else if(parseInt($('input[name="which_lt"]:checked').val())==0){
		 $('#form2').hide();
		 $('#form1').hide();
	}
	
})
</script>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
<tr>
    <td width="115px" align="right">论坛选择：</td>
    <td>&nbsp;<?=html_radio(array('0'=>'关闭论坛整合','1'=>'UCenter整合','2'=>'phpwind整合'),$which_lt,'which_lt')?> <span class="zhushi" style="font-weight:bold; color:#F00">注：如果你不整合论坛请选择关闭论坛整合</span></td>
  </tr>
</table>
<form action="index.php?mod=ucenter&act=set" method="post" name="form1" id="form1" style="display:none">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
<?php if(isset($_GET['ucapiset']) || ((!isset($_GET['ucapiset']) && !isset($_GET['ucmyset'])) && $webset['ucenter']['open']==0)){?>
  <tr>
    <td width="150px" align="right">设置：</td>
    <td>&nbsp; <a href="<?=u(MOD,ACT,array('ucmyset'=>1))?>" class="zt_red">切换到人工设置</a> <span class="zhushi"><a href="http://bbs.duoduo123.com/read-1-1-198032.html" target="_blank">设置教程</a></span></td>
  </tr>
  <tr>
    <td width="115px" align="right">UCenter地址：</td>
    <td>&nbsp;<input name="url" type="text" id="url" value="" style="width:300px" /> <span class="zhushi">举例：http://www.taobao.com/uc_server</span></td>
  </tr>
  <tr>
    <td align="right">初始管理员密码：</td>
    <td>&nbsp;<input name="pwd" type="text" id="pwd" value="" /></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="step" value="1" /><input type="submit" class="sub" name="sub" value=" 设 置 " /></td>
  </tr>
<?php }elseif(isset($_GET['ucmyset']) || $webset['ucenter']['open']==1){?>
<div class="explain-col">提醒：如果UCenter是全新而网站有会员，需要将网站会员导入到UCenter中。<a style="color:#F00" href="<?=u(MOD,'import')?>">马上导入</a>
  </div>
  <tr>
    <td width="150px" align="right">设置：</td>
    <td>&nbsp;<a href="<?=u(MOD,ACT,array('ucapiset'=>1))?>"  class="zt_red">切换到自动设置</a> <span class="zhushi"> <a href="http://bbs.duoduo123.com/read-1-1-198032.html" target="_blank">设置教程</a></span></td>
  </tr>
  <tr>
    <td align="right">UCenter 应用 ID：</td>
    <td>&nbsp;<input name="ucenter[UC_APPID]" type="text" value="<?=$webset['ucenter']['UC_APPID']?>" /> </td>
  </tr>
  <tr>
    <td align="right">UCenter 通信密钥：</td>
    <td>&nbsp;<input name="ucenter[UC_KEY]" type="text" value="<?=$webset['ucenter']['UC_KEY']?>" style="width:300px" /><span class="zhushi"> 注意：要与UC内的设置一致</span></td>
  </tr>
  <tr>
    <td align="right">UCenter 访问地址：</td>
    <td>&nbsp;<input name="ucenter[UC_API]" type="text" value="<?=$webset['ucenter']['UC_API']?>"  style="width:300px"/> </td>
  </tr>
  <tr>
    <td align="right">数据库字符集：</td>
    <td>&nbsp;<input name="ucenter[UC_DBCHARSET]" type="text" value="<?=$webset['ucenter']['UC_DBCHARSET']?>" /> </td>
  </tr>
  <tr>
    <td align="right">UCenter 字符集：</td>
    <td>&nbsp;<input name="ucenter[UC_CHARSET]" type="text" value="<?=$webset['ucenter']['UC_CHARSET']?>" /> </td>
  </tr>
  <tr>
    <td align="right">UCenter 数据库服务器：</td>
    <td>&nbsp;<input name="ucenter[UC_DBHOST]" type="text" value="<?=$webset['ucenter']['UC_DBHOST']?>" /> </td>
  </tr>
  <tr>
    <td align="right">UCenter 数据库用户名：</td>
    <td>&nbsp;<input name="ucenter[UC_DBUSER]" type="text" value="<?=$webset['ucenter']['UC_DBUSER']?>" /> </td>
  </tr>
  <tr>
    <td align="right">UCenter 数据库密码：</td>
    <td>&nbsp;<input name="ucenter[UC_DBPW]" type="password" style="width:150px" value="<?=$webset['ucenter']['UC_DBPW']?>" /> </td>
  </tr>
  <tr>
    <td align="right">UCenter 数据库名：</td>
    <td>&nbsp;<input name="ucenter[UC_DBNAME]" type="text" value="<?=$webset['ucenter']['UC_DBNAME']?>" /> </td>
  </tr>
  <tr>
    <td align="right">UCenter 表前缀：</td>
    <td>&nbsp;<input name="ucenter[UC_DBTABLEPRE]" type="text" value="<?=$webset['ucenter']['UC_DBTABLEPRE']?>" /> </td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="step" value="2" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
<?php }?>
</table>
</form>
<form action="index.php?mod=phpwind&act=set" method="post" name="form2" id="form2" style="display:none">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
<?php include(ADMINTPL.'/ucenter/header.php');?>
<div class="explain-col">提醒：如果网站是全新而phpwind有会员，需要将phpwind会员导入到网站中。导入先请先将网站提供的phpwind整合文件上传到phpwind根目录下 <a style="color:#F00" href="<?=u(MOD,'import')?>">马上导入</a>
  </div>
  <tr>
    <td width="115px" align="right">注意：</td>
    <td>&nbsp;<b style="color:#F00">整合适用于phpwind8.7版本</b> <span class="zhushi"><a href="http://bbs.duoduo123.com/read-1-1-198036.html" target="_blank">设置教程</a></span></td>
  </tr>
  <tr>
    <td align="right">phpwind 通信密钥：</td>
    <td>&nbsp;<input name="phpwind[key]" type="text" value="<?=$webset['phpwind']['key']?>" style="width:200px" /> <span class="zhushi">注意：要与phpwind内的设置一致</span></td>
  </tr>
  <tr>
    <td align="right">phpwind 访问地址：</td>
    <td>&nbsp;<input name="phpwind[url]" type="text" value="<?=$webset['phpwind']['url']?>"  style="width:200px"/> </td>
  </tr>
  <tr>
    <td align="right">数据库字符集：</td>
    <td>&nbsp;<input name="phpwind[charset]" type="text" value="<?=$webset['phpwind']['charset']?>" /> <span class="zhushi">默认：utf-8</span></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="submit" class="sub" name="sub" value=" 保 存 " /> <?php if($webset['phpwind']['url']!=''){?><a href="<?=$webset['phpwind']['url']?>/admin.php" target="_blank">phpwind后台</a><?php }?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;整合说明：</td>
    <td><ul>
    <li>1、下载整合程序上传。<?php if(DLADMIN!=1){?><a href="http://bbs.duoduo123.com/read-1-1-109559.html" target="_blank">立刻下载</a><?php }?></li>
    <li>2、进入phpwind后台，"应用"->"插件中心"->"通行证"->"设置"，显示界面如下：<br/>
        <img src="images/phpwindport.jpg" /></li>
    <li>3、信息填写如下表：<br/><table border="1" cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <th scope="col">&nbsp;通行证</th>
    <th scope="col">&nbsp;密钥</th>
    <th scope="col">&nbsp;系统作为</th>
    <th scope="col">&nbsp;服务器地址</th>
    <th scope="col">&nbsp;登录地址</th>
    <th scope="col">&nbsp;退出地址</th>
    <th scope="col">&nbsp;注册地址</th>
  </tr>
  <tr>
    <td>&nbsp;开启</td>
    <td>&nbsp;与phpwin相同</td>
    <td>&nbsp;客户端</td>
    <td>&nbsp;<?=SITEURL?></td>
    <td>&nbsp;index.php?mod=user&act=login</td>
    <td>&nbsp;index.php?mod=user&act=exit</td>
    <td>&nbsp;index.php?mod=user&act=register</td>
  </tr>
</table>
</li>
    </ul></td>
  </tr>
</table>
</form>
<script>
alert('如果你不整合论坛请选择关闭论坛整合，否则会造成会员无法登陆');
</script>
<?php include(ADMINTPL.'/footer.tpl.php');?>