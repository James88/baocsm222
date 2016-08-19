<?php
$state = true;

function php_get_mysql_version(){
	return 5;
}

function get_php_version(){
	if(strpos(PHP_VERSION,'5.')!==false){
		return 5;
	}
	elseif((int)PHP_VERSION==6){
		return 6;
	}
}

$hostinfo[] = array('name'=>'操作系统','old'=>'不限制','new'=>PHP_OS,'state'=>true);
$hostinfo[] = array('name'=>'PHP 版本','old'=>'5.0','new'=>PHP_VERSION,'state'=>(bool)get_php_version()>=5);

$uploadsize = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'unknow';
$hostinfo[] = array('name'=>'附件上传','old'=>' 2M','new'=>$uploadsize,'state'=>(bool)(intval($uploadsize) >= 2));

$tmp = function_exists('gd_info') ? gd_info() : array();

if(empty($tmp)){
	$gd=false;
}
else{
	$gd=true;
}

$hostinfo[] = array('name'=>'GD 库版本','old'=>'2.0','new'=>'2.0','state'=>$gd);

$space = function_exists('disk_free_space') ?  '> 50M' : 'unknow';
$hostinfo[] = array('name'=>'磁盘空间','old'=>'50M','new'=>$space,'state'=>true);

$hostinfo[] = array('name'=>'MySQL','old'=>'5.0','new'=>php_get_mysql_version(),'state'=>(bool)(intval(php_get_mysql_version()) >= 5));

$pdo = class_exists('PDO') ? 'PDO' : 'unknow';
$hostinfo[] = array('name'=>'PDO','old'=>'PDO','new'=>$pdo,'state'=>true);
$pdo_mysql = class_exists('PDO') ? PDO::getAvailableDrivers() : array('unknow');
$hostinfo[] = array('name'=>'PDO Mysql','old'=>'PDO Mysql','new'=>'PDO('.implode(',',$pdo_mysql).')','state'=>true);

$dirrole[] = array('name'=>'/data','old'=>'可写');
$dirrole[] = array('name'=>'/data/bdata','old'=>'可写');
$dirrole[] = array('name'=>'/data/temp','old'=>'可写');
$dirrole[] = array('name'=>'/data/city','old'=>'可写');
$dirrole[] = array('name'=>'/data/spider','old'=>'可写');
$dirrole[] = array('name'=>'/data/title','old'=>'可写');
$dirrole[] = array('name'=>'/data/cache','old'=>'可写');
$dirrole[] = array('name'=>'/data/cache/tempUpload','old'=>'可写');
$dirrole[] = array('name'=>'/data/cache/Log','old'=>'可写');
$dirrole[] = array('name'=>'/data/json','old'=>'可写');
$dirrole[] = array('name'=>'/data/json/webset.php','old'=>'可写');
$dirrole[] = array('name'=>'/data/js','old'=>'可写');
$dirrole[] = array('name'=>'/data/css','old'=>'可写');
$dirrole[] = array('name'=>'/data/ad','old'=>'可写');
$dirrole[] = array('name'=>'/data/array','old'=>'可写');
$dirrole[] = array('name'=>'/data/rewrite','old'=>'可写');
$dirrole[] = array('name'=>'/data/upgrade','old'=>'可写');
$dirrole[] = array('name'=>'/data/banben.php','old'=>'可写');
$dirrole[] = array('name'=>'/upload','old'=>'可写');
$dirrole[] = array('name'=>'/upload/avatar','old'=>'可写');
$dirrole[] = array('name'=>'/upload/ddjt','old'=>'可写');
$dirrole[] = array('name'=>'/install','old'=>'可写');
$dirrole[] = array('name'=>'/plugin','old'=>'可写');

foreach($dirrole as $key => $value)
{
	$value['state'] = iswriteable(DDROOT.$value['name']);
	$value['new'] = $value['state'] ? '可写' : '不可写';
	$dirrole[$key] = $value;
}

$function = function_check();

function function_check() 
{
	$func_items = array('mysql_connect','iconv');
	foreach($func_items as $item) {
		$function[] = array($item.'()',function_exists($item),'http://help.phpdiy.com/php/php/html/res/function.'.str_replace('_','-',$item).'.html');
	}
	return $function;
}
function zhengshu(){
	if(!file_exists('code.pfx')){
		echo "<tr><td>code.pfx</td><td class=\"padleft\">已上传</td><td clas=\"w pdleft1\">是</td></tr>";
		}else{
			echo "<tr><td>code.pfx</td><td class=\"padleft\"><button>未上传</button></td><td clas=\"w pdleft1\">否</td></tr>";
			}
	}
?>
<script language="javascript" type="text/javascript"> 
function openwinx(url,name,w,h)
{
    window.open(url,name,"top=100,left=400,width=" + w + ",height=" + h + ",toolbar=no,menubar=no,scrollbars=yes,resizable=no,location=no,status=no");
}
</script>

<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
-->
</style>
<div class="container">
	<div class="header">
		<?php include('step_header.php');?>	
		
		<div class="setup step1">
		<h2>开始安装</h2>
		<p>环境以及文件目录权限检查</p>
	</div>
	<div class="stepstat">
		<ul>
			<li class="current">1</li>
			<li class="unactivated">2</li>
			<li class="unactivated">3</li>
			<li class="unactivated last">4</li>
		</ul>
		<div class="stepstatbg stepstat1"></div>
	</div>
</div>
<div class="main">
<h2 class="title">环境检查</h2>
<table class="tb" style="margin:20px 0 20px 55px;">
<tr>
	<th width="150px">环境项目</th>
	<th class="padleft" width="150px">最低配置</th>
	<th class="padleft" width="280px">当前服务器</th>
</tr>
<?php foreach($hostinfo as $value):?>
<tr>
<td><?php echo $value['name'];?></td>
<td class="padleft"><?php echo $value['old'];?></td>
<td class="<?php echo $value['state'] ? 'w' : 'nw';?> pdleft1"><?php echo $value['new'];?></td>
</tr>
<?php if(!$value['state']){$state = false;}?>
<?php endforeach;?>
</table>
<h2 class="title">目录、文件权限检查&nbsp;&nbsp; <span class="STYLE1">如何更改权限？</span> <a href="http://zhidao.baidu.com/link?url=9waLGcqAHMj1kjxPivsmM0ioTf2xYRzc6fbPpS-a_kiZDmzrcbMoTUwhnZy6pumAqbnY4wRVyiWMmSt34-mp7rBM81gyt2q_HoQcL4QazTe" target="_blank">查看</a></h2>
<table class="tb" style="margin:20px 0 20px 55px;">
	<tr>
	<th width="150px" >目录文件</th>
	<th width="150px" class="padleft"><div align="left">所需状态</div></th>
	<th width="280px" class="padleft">当前状态</th>
</tr>

<?php foreach($dirrole as $value):?>
<tr>
<td><?php echo $value['name'];?></td>
<td class="padleft"><?php echo $value['old'];?></td>
<td class="<?php echo $value['state'] ? 'w' : 'nw';?> pdleft1"><?php echo $value['new'];?></td>
</tr>
<?php if(!$value['state']){$state = false;}?>
<?php endforeach;?>
</table>
<h2 class="title">函数依赖性检查 （如果没开启，请让空间服务商开启即可）</h2>
<table class="tb" style="margin:20px 0 20px 55px;">
<tr>
	<th width="175" >函数名称</th>
	<th  width="128" class="padleft">&nbsp;</th>
	<th width="284" class="padleft">检查结果</th>
</tr>
<?php foreach($function as $value):?>
<tr>
<td><?php echo $value['0'];?></td>
<td class="padleft">&nbsp;</td>
<td class="<?php echo $value['1'] ? 'w' : 'nw';?> pdleft1"><?php echo $value['1'] ? '支持' : '不支持';?></td>
</tr>
<?php if(!$value['1']){$state = false;}?>
<?php endforeach;?>
<tr>
<?php 
$allow_url_fopen=ini_get('allow_url_fopen');
if($allow_url_fopen){
	$html=file_get_contents('http://www.baidu.com');
	if($html!=''){
		$allow_url_fopen=true;
	}
	else{
		$allow_url_fopen=false;
	}
}
?>
<td>file_get_contents()</td>
<td class="padleft">&nbsp;</td>
<td class="<?php echo $allow_url_fopen ? 'w' : 'nw';?> pdleft1"><?php echo $allow_url_fopen ? '支持' : '不支持';?></td>
<?php if(!$allow_url_fopen){$state = false;}?>
</tr>
<tr>
<?php $short_open_tag=ini_get('short_open_tag');?>
<td>short_open_tag(短标签)</td>
<td class="padleft">&nbsp;</td>
<td class="<?php echo $short_open_tag ? 'w' : 'nw';?> pdleft1"><?php echo $short_open_tag ? '支持' : '不支持';?></td>
<?php if(!$short_open_tag){$state = false;}?>
</tr>

<tr>
<?php if(function_exists('gzuncompress')){$zlib=1;}else{$zlib=0;}?>
<td>zlib库</td>
<td class="padleft">&nbsp;</td>
<td class="<?php echo $zlib ? 'w' : 'nw';?> pdleft1"><?php echo $zlib ? '支持' : '不支持';?></td>
<?php if(!$zlib){$state = false;}?>
</tr>

<tr>
<?php if(function_exists('imagettfbbox')){$imagettfbbox=1;}else{$imagettfbbox=0;}?>
<td>imagettfbbox</td>
<td class="padleft">&nbsp;</td>
<td class="<?php echo $imagettfbbox ? 'w' : 'nw';?> pdleft1"><?php echo $imagettfbbox ? '支持' : '不支持';?></td>
<?php if(!$imagettfbbox){$state = false;}?>
</tr>

</table>

<h2 class="title">&nbsp;</h2>
<form action="install.php" method="get">
<input type="hidden" name="step" value="2" /><div class="btnbox marginbot"><input type="button" onclick="history.back();" value="上一步">
<?php if($state==true){?>
<input type="submit" value="下一步">
<?php }else{?>
<input type="submit" value="下一步" disabled="disabled" id="next">
<?php }?>
</div>
</form>
	
    <?php include('footer.php');?>
  </div>
</div>