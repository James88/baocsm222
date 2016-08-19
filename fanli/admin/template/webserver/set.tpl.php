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

if($_GET['ck']==1){
	$today=$_GET['today'];
	$url=SITEURL.'/page/backstage.php?set_today='.$today;
	only_send($url);
	sleep(5);
	echo file_get_contents(DDROOT.'/data/backstage.txt');
	exit;
}

include(ADMINTPL.'/header.tpl.php');
$collect_sort_arr=array(1=>1,2,3);


$num_iid=16021599283;
$json_obj='{"num_iid":'.$num_iid.'}';
$json_arr=json_decode($json_obj,1);

if(DDJSON==0){
	if($json_arr['num_iid']!=$num_iid){
		$json_error_word='<b style="color:red">json解析异常，建议使用json函数</b><input onclick="location.href=\'index.php?mod='.MOD.'&act='.ACT.'&ddjson=1\'" type="button" value="确定" />';
	}
	else{
		$json_error_word='php(json)解析正常。';
	}
}

if(DDJSON==1){
	if($json_arr['num_iid']==$num_iid){
		$json_error_word='<b style="color:red">json解析正常，建议使用php内部json函数</b><input onclick="location.href=\'index.php?mod='.MOD.'&act='.ACT.'&ddjson=0\'" type="button" value="确定" />';
	}
	else{
		$json_arr=dd_json_decode($json_obj,1);
		if($json_arr['num_iid']!=$num_iid){
			$json_error_word='解析异常，联系官方';
		}
		else{
			$json_error_word='duoduo(json)解析正常';
		}
	}
}

?>
<script>
function checkBackStage(){
	$('#checkBackStage').html('检测中...');
	$.get('<?=u(MOD,ACT)?>&ck=1&today=<?=date('Ymd')?>',function(data){
		if(data=='<?=date('Ymd')?>'){
			alert('可用');
			$('input[name="BACKSTAGE"]:eq(1)').attr("checked",'checked');
		}
		else{
			alert('不可用');
			$('input[name="BACKSTAGE"]:eq(0)').attr("checked",'checked');
		}
		$('#checkBackStage').html('检测');
	});
}
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">

  <tr>
    <td width="115px" align="right">curl：</td>
    <td>&nbsp;<?=$curl_status?>，<?php if($curl_status=='存在'){?><a style="text-decoration:underline" href="<?=u('webserver','set',array('fun'=>'test_curl'))?>">测试是否可用</a><?php }?> 优先级：<?=select($collect_sort_arr,$webset['collect']['curl'],'collect[curl]')?> <?php if(isset($_GET['fun']) && $_GET['fun']=='test_curl'){echo '<b style="color:red">'.test_curl($url).'</b>';}?> <span class="zhushi">如果curl方式可用，优先使用此方法。<b>数字越大优先级越高！</b></span></td>
  </tr>
  <tr>
    <td width="115px" align="right">file_get_contents：</td>
    <td>&nbsp;<?=$file_get_contents_status?>，<?php if($file_get_contents_status=='存在'){?><a style="text-decoration:underline" href="<?=u('webserver','set',array('fun'=>'test_file_get_contents'))?>">测试是否可用</a><?php }?> 优先级：<?=select($collect_sort_arr,$webset['collect']['file_get_contents'],'collect[file_get_contents]')?> <?php if(isset($_GET['fun']) && $_GET['fun']=='test_file_get_contents'){echo '<b style="color:red">'.test_file_get_contents($url).'</b>';}?></td>
  </tr>
  <tr>
    <td width="115px" align="right">(p)fsockopen：</td>
    <td>&nbsp;<?=$fsockopen_status?>，<?php if($fsockopen_status=='存在'){?><a style="text-decoration:underline" href="<?=u('webserver','set',array('fun'=>'test_fsockopen'))?>">测试是否可用</a><?php }?> 优先级：<?=select($collect_sort_arr,$webset['collect']['fsockopen'],'collect[fsockopen]')?> <?php if(isset($_GET['fun']) && $_GET['fun']=='test_fsockopen'){echo '<b style="color:red">'.test_fsockopen($url).'</b>';}?></td>
  </tr>
  <tr>
    <td align="right">异步执行：</td>
    <td>&nbsp;<?=html_radio(array(0=>'不可用',1=>'可用'),BACKSTAGE,'BACKSTAGE')?> <span class="zhushi" style="cursor:pointer" id="checkBackStage" onclick="checkBackStage()">检测</span> <span class="zhushi"><a href="http://bbs.duoduo123.com/read-1-1-205257.html" target="_blank">教程</a></span></td>
  </tr>
  <tr>
    <td align="right">gbk转utf8：</td>
    <td>&nbsp;<?=html_radio(array(1=>'方式1',2=>'方式2'),GBK_UTF8_FUN,'GBK_UTF8_FUN')?> <span class="zhushi">中文gbk编码转utf8的方式，默认使用方式1，如果发现程序出现编码错误，使用方式2</span></td>
  </tr>
  <tr>
    <td align="right"></td>
    <td>&nbsp;<input type="submit" name="sub" class="sub" value="保存" /> <span class="zhushi">数字越大使用优先级越高</span></td>
  </tr>
  
  <tr>
    <td align="right">json：</td>
    <td>&nbsp;<?=$json_encode_status?> <span class="zhushi"><?=$json_error_word?></span></td>
  </tr>
  <tr>
    <td align="right">openssl：</td>
    <td>&nbsp;<?=$ssl_status?> <span class="zhushi">（应用于QQ登陆等需要https验证的行为。）</span></td>
  </tr>
  <tr>
    <td align="right">zlib：</td>
    <td>&nbsp;<?=extension_loaded("zlib")?'支持':'不支持'?> <span class="zhushi">（应用于网页gzip输出。）</span></td>
  </tr>
  <tr>
    <td align="right">realpath：</td>
    <td>&nbsp;<?php echo realpath('../');?></td>
  </tr>
  <tr>
    <td align="right">目录权限：</td>
    <td style="padding:5px; line-height:20px">
    <table width="200" border="0">
  
  <?php foreach($file as $v){?>
  <tr>
  <?php if(iswriteable(DDROOT.'/'.$v)==0){?>
	<td><?=$v?></td><td> <span style=" color:red">不可写！</span></div></td>
	<?php }else{?>
	<td><?=$v?></td><td><span style=" color:#090">可写！</span></div></td>
	<?php }?>
    </tr>
    <?php }?>
   
  <!--<?php if(iswriteable(sys_get_temp_dir())==0){?>
  <tr><td><?=sys_get_temp_dir()?></td><td><span style=" color:red">不可写！</span></div></td></tr>
  <?php }else{?>
  <td><?=sys_get_temp_dir()?></td><td><span style=" color:#090">可写！</span></div></td>
  <?php }?>-->
</table>
    </td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>