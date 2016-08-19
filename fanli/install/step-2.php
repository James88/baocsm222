<?php
$state = true;
?>
<script language="javascript" type="text/javascript">
goNext=3;
$(document).ready(function(){
	
	$('#ddkeysm').jumpBox({  
		height:230,
		width:380,
		contain:$('#ddkeydiv').html()
    });
	
    $('#datapwd').blur(function(){
	    var dataname=$('#dataname').val();
		var datauser=$('#datauser').val();
	    var datapwd=$('#datapwd').val();
	    var host=$('#host').val();
	    $.get("jiance.php", { "dataname": dataname,"datauser": datauser,"datapwd": datapwd,"host":host},function(data){
	        if(data==0){
		        $('#jieguo').html("&nbsp;数据库连接失败");
		        $('#jieguo').css("color","#F00");
		        $('.btn').attr("disabled",true);
	        }
	        else{
		        $('#jieguo').html("&nbsp;数据库连接成功");
				goNext--;
				if(goNext<=0){
					$('.btn').attr("disabled",false);
				}
	        }
        });
    });
	
	$('#datapre').blur(function(){
	    var dataname=$('#dataname').val();
		var datauser=$('#datauser').val();
	    var datapwd=$('#datapwd').val();
	    var host=$('#host').val();
		var datapre=$('#datapre').val();
	    $.get("jiance.php", { "dataname": dataname,"datauser": datauser,"datapwd": datapwd,"host":host,"datapre":datapre},function(data){
	        if(data==1){
		        alert('注意：'+datapre+'您好，您已安装过我们多多返利，是否覆盖，如果覆盖数据将被清空，如果不想被覆盖请修改数据表前缀或更换数据库名称。');
	        }
			else if(data==0){
				alert('数据库连接失败');
			}
        });
    });
	
    $('#check_admin_pwd').blur(function(){
	    var l =$(this).val().length;
		if(l>5 && l<11){
			goNext--;
			if(goNext<=0){
				$('.btn').attr("disabled",false);
			}
		}
		else{
			if(l>0){
				alert('管理员密码要在6-10位之间');
			}
	   }
	});
	$('#check_admin_pwd2').blur(function(){
	    var pwd2 =$(this).val();
		var pwd =$('#check_admin_pwd').val();
		if(pwd2!=pwd){
			alert('管理员密码输入不相同！');
		}
		else{
			goNext--;
			if(goNext<=0){
				$('.btn').attr("disabled",false);
			}
		}
	});
});
</script>
<div class="container">
	<div class="header">
		<?php include('step_header.php');?>
		<div class="setup step2">
		<h2>安装数据库</h2>
		<p>正在执行数据库安装</p>
	</div>
	<div class="stepstat">
		<ul>
			<li class="">1</li>

			<li class="current">2</li>
			<li class="unactivated">3</li>
			<li class="unactivated last">4</li>
		</ul>
		<div class="stepstatbg stepstat2"></div>
	</div>
</div>

<div class="main">
<form method="post" action="install.php">
<table class="tb2">
<input type="hidden" name="step" value="2" />
<div class="desc"><b>填写数据库信息</b></div>
<tr>
<th width="128" class="tbopt">&nbsp;数据库IP(地址):</th>
<td width="208"><input type="text" name="db[host]" value="localhost" size="35" class="txt" id="host"></td>
<td width="243">&nbsp;一般为localhost或IP:XX.XX.XX.XX</td>
</tr>

<tr><th class="tbopt">&nbsp;数据库名称:</th>
<td><input type="text" name="db[dbname]" value="" size="35" class="txt" id="dataname"></td>
<td>请到空间数据库管理内查找</td>
</tr>

<tr><th class="tbopt">&nbsp;数据库用户:</th>
<td><input type="text" name="db[username]" value="" size="35" class="txt" id="datauser"></td>
<td>请到空间数据库管理内查找</td>
</tr>

<tr><th class="tbopt">&nbsp;数据库密码:</th>
<td><input type="password" name="db[password]" value="" size="35" class="txt" id="datapwd"></td>
<td id="jieguo" style="color:#F00"></td>
</tr>

<tr><th class="tbopt">&nbsp;数据表前缀:</th>
<td><input type="text" name="db[prefix]" value="duoduo_" size="35" class="txt" id="datapre"></td>
<td></td>
</tr>
</table>
<table class="tb2">
<div class="desc">
<b>填写管理员信息</b>
<br>请牢记 管理员名称和密码，只有该密码才能登陆后台进行数据管理工作。</div>
<tr><th class="tbopt">&nbsp;管理员名称:</th>
<td><input type="text" name="admin[adminuser]" value="admin" size="35" class="txt"></td>
<td></td>
</tr>

<tr><th class="tbopt">&nbsp;管理员密码:</th>
<td><input type="password" name="admin[adminpassword]" value="" id="check_admin_pwd" size="35" class="txt"></td>
<td>最少6位</td>
</tr>
<tr><th class="tbopt">&nbsp;确认密码:</th>
<td><input type="password" name="admin[adminpassword]" value="" id="check_admin_pwd2" size="35" class="txt"></td>
<td>最少6位</td>
</tr>
</table>

<table width="508" class="tb2">
  <tr>
    <th align="center" valign="middle" class="tbopt">&nbsp;</th>
    <td align="center" valign="middle"><input type="submit" value="下一步" class="btn" id="xiayibu" disabled="disabled" /></td>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<div class="desc"></div>
</form>
<input type="text" id="aa"  onclick="window.location.href='install.php?step=2';" style="display:none" />

<?php include('footer.php');?>
</div>
</div>

<div id="ddkeydiv" style="display:none; ">
<div  style="font-size:14px; color:#666666; font-family:'宋体'; text-align:left; line-height:24px">
<p>1、如果你是初次安装多多程序，此项无需填写。</p>
<p style="margin-top:5px">2、如果你之前安装过多多程序，本次安装无需还原以前的数据，此项无需填写</p>
<p style="margin-top:5px">3、如果你之前安装过多多程序，并且需要还原之前的数据，此项需主动填写内容。记录内容的文件在你之前备份的数据中，文件名为ddkey.php</p>
<p style="margin-top:5px">4、还有问题联系多多技术客服</p>
</div>
</div>