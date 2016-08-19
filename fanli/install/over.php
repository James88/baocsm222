<?php
include('../comm/dd.config.php');
$duoduo->webset();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>多多淘宝客 安装向导</title>
<link rel="stylesheet" href="images/style.css" type="text/css" media="all" />
<meta content="Comsenz Inc." name="Copyright" />
</head>
<body>
<div class="container">
	<div class="header">
		<?php include('step_header.php');?>
		<div class="setup step4">
		<h2>安装完成</h2>
		<p>程序已安装成功</p>
	</div>
	<div class="stepstat">
		<ul>
			<li class="">1</li>

			<li class="">2</li>
			<li class="unactivated">3</li>
			<li class=" last current">4</li>
		</ul>
		<div class="stepstatbg stepstat4"></div>
	</div>
</div>

<div class="main">

<table class="tb2">
<tr><th class="tbopt">
<img src="images/Trust.png"  border="0"/></th>
<td valign="top" align="left">
<p>&nbsp;
  <input type="button" value="前台首页" onclick="window.location='../';" />
  &nbsp;&nbsp;
  <input type="button" value="后台管理" onclick="window.location='../admin/';" /></p>
<br/>
<span class="red">强烈建议安装按完成删除install目录。</span>
</td>
<td>&nbsp;</td>
</tr>
</table>
	<?php include('footer.php');?>
	</div>
</div>
</body>
</html>
<?php 
$suffix='php|inc|html|txt|ico|css';
function scan($dir, &$record_arr,$i=0) {
	global $suffix,$duoduo;
	if (is_dir($dir)) {
		if (1) {
			$dh = opendir($dir);
			while ($file = readdir($dh)) {
				if ($file != "." && $file != "..") {
					$fullpath = $dir . "/" . $file;
					if (!is_dir($fullpath)) {
						if (preg_match('/(.' . $suffix . ')$/', $fullpath)) {
							$a['size']=filesize($fullpath);
							$a['time']=filemtime($fullpath);
							$a['md5']=md5_file($fullpath);
							$a['path']=str_replace(DDROOT,'',$fullpath);

							$duoduo->insert('file',$a);
						}
					} 
					else {
						scan($fullpath, $record_arr,$i);
					}
				}
			}
			closedir($dh);
		}
	} 
	else {
		$a['size']=filesize($dir);
		$a['time']=filemtime($dir);
		$a['md5']=md5_file($dir);
		$a['path']=str_replace(DDROOT,'',$dir);
		
		$duoduo->insert('file',$a);
	}
}

$file_arr=array (
  0 => '/comm',
  1 => '/css',
  2 => '/fanxianbao',
  3 => '/images',
  4 => '/js',
  5 => '/kindeditor',
  6 => '/mod',
  7 => '/page',
  8 => '/template',
  9 => '/uc_client',
  10 => '/admin',
  11 => '/api',
  12 => '/index.php',
  13 => '/robots.txt',
  14 => '/favicon.ico',
);

$sql="TRUNCATE TABLE `".BIAOTOU."file` ";
$duoduo->query($sql);
foreach($file_arr as $v){
	scan(DDROOT.$v,$record_arr);
}

if(file_exists('install.php')){
	rename('install.php','install.php.lock'); 
}
?>