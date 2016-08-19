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
<style>
.FUJIAN_FTP_guanlian{ display:none}
</style>
<script>
$(function(){
	<?=radio_guanlian('FUJIAN_FTP')?>;
})

function testFtp(){
	$('#test').attr('disabled',true);
	var ip=$('#FTP_IP').val();
	if(ip==''){
		alert('IP不能为空');
	}
	var port=$('#FTP_PORT').val();
	if(ip==''){
		alert('端口不能为空');
	}
	var user=$('#FTP_USER').val();
	if(ip==''){
		alert('账号不能为空');
	}
	var pwd=$('#FTP_PWD').val();
	if(ip==''){
		alert('密码不能为空');
	}
	if(pwd=='<?=DEFAULTPWD?>'){
		pwd='<?=FTP_PWD?>';
	}
	var pasv=$('input[name="FTP_PASV"]:checked').val();
	var mulu=$('#FTP_MULU').val();
	var url=$('#FTP_URL').val();
	var timeout=$('#FTP_TIMEOUT').val();
	var data={'ip':ip,'duankou':port,'user':user,'pwd':pwd,'pasv':pasv,'mulu':mulu,'url':url,'timeout':timeout};
	$.get('<?=u(MOD,ACT)?>&test=1',data,function(data){
		$('#test').attr('disabled',false);
		if(data.indexOf(url)==0){
			alert('上传成功，查看图片');
			openpic(data,'pic','500','500');
		}
		else{
			alert(data);
		}
	})
}
</script>

<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" style="font-size:12px" method="post" name="form1">
<table id="addeditable" align="center" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="110"  align="right">附件储存：</td>
   	<td>&nbsp; <?=html_radio(array('0'=>'本地','1'=>'远程'),FUJIAN_FTP,'FUJIAN_FTP')?></td>
  </tr>
  <tr>
    <td align="right">储存路径：</td>
    <td>&nbsp;/upload 目录下
  </td>
  </tr>
  <!--选远程显示开始-->
  <tbody class="FUJIAN_FTP_guanlian">
  <tr>
    <td align="right">教程：</td>
    <td>&nbsp;<span class="zhushi"><a href="http://bbs.duoduo123.com/read-1-1-198039.html" target="_blank">设置教程</a></span>
    </td>
  </tr>
  <tr>
    <td align="right">FTP服务器地址：</td>
    <td>&nbsp;<input name="FTP_IP" type="text" id="FTP_IP" value="<?=defined('FTP_IP')?FTP_IP:''?>" class="btn3" /> <span class="zhushi">如：192.168.1.1 </span>
    </td>
  </tr>
  <tr>
    <td align="right">FTP服务器端口：</td>
    <td>&nbsp;<input name="FTP_PORT" type="text" id="FTP_PORT" value="<?=defined('FTP_PORT')?FTP_PORT:'21'?>" class="btn3" /> <span class="zhushi">一般默认为21 </span>
    </td>
  </tr>
  <tr>
    <td align="right">FTP账号：</td>
    <td>&nbsp;<input name="FTP_USER" type="text" id="FTP_USER" value="<?=defined('FTP_USER')?FTP_USER:''?>" class="btn3" /> <span class="zhushi">该帐号必需具有以下权限：读取文件、写入文件、删除文件、创建目录、子目录继承</span>
    </td>
  </tr>
  <tr>
    <td align="right">FTP密码：</td>
    <td>&nbsp;<?=limit_input('FTP_PWD')?> <span class="zhushi">点击激活修改，FTP服务器登录密码</span>
    </td>
  </tr>
  <tr>
    <td width="110"  align="right">被动模式连接：</td>
   	<td>&nbsp; <?=html_radio(array('0'=>'否','1'=>'是'),defined('FTP_PASV')?FTP_PASV:1,'FTP_PASV')?> <span class="zhushi">FTP连接形式，默认为是。</span></td>
  </tr>
  <tr>
    <td align="right">远程图片目录：</td>
    <td>&nbsp;<input name="FTP_MULU" type="text" id="FTP_MULU" value="<?=defined('FTP_MULU')?FTP_MULU:''?>" class="btn3" /> <span class="zhushi">远程附件目录的绝对路径或相对于 FTP 主目录的相对路径，以“/”开头，结尾不要加斜杠“/”，空表示 FTP 主目录</span>
    </td>
  </tr>
  <tr>
    <td align="right">远程访问 URL：</td>
    <td>&nbsp;<input name="FTP_URL" type="text" id="FTP_URL" value="<?=defined('FTP_URL')?FTP_URL:''?>" class="btn3" /></td>
  </tr>
  <tr>
    <td align="right">传输超时时间：</td>
    <td>&nbsp;<input name="FTP_TIMEOUT" type="text" id="FTP_TIMEOUT" value="<?=defined('FTP_TIMEOUT')?FTP_TIMEOUT:'10'?>" class="btn3"/> <span class="zhushi">单位：秒</span>
    </td>
  </tr>
 <tr>
    <td align="right">连接测试：</td>
	<td>&nbsp;<input type="button" class="sub" id="test" value=" 点击测试连接 " onclick="testFtp()" /> <span class="zhushi">无需保存设置即可测试，请在测试通过后再保存</span></td>
  </tr>
  <!--选远程结束-->
  </tbody>
    <tr>
    <td align="right">&nbsp;</td>
	<td>&nbsp;<input type="submit" class="myself" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  <tr>
    <td align="right">说明：</td>
	<td><br />
	&nbsp;1、图片按日期格式保存。<br />
	&nbsp;2、会员上传的头像保存目录为avatar。<br />
	</td>
  </tr>
    <tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>