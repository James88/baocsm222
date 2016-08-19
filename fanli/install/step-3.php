<div class="container">
	<div class="header">
		<?php include('step_header.php');?>
		<div class="setup step3">
		<h2>安装数据库</h2>
		<p>正在执行创建数据表操作</p>
	</div>
	<div class="stepstat">
		<ul>
			<li class="">1</li>

			<li class="">2</li>
			<li class="current">3</li>
			<li class="unactivated last">4</li>
		</ul>
		<div class="stepstatbg stepstat3"></div>
	</div>
</div>
<div class="main">
<script type="text/javascript">
function goadmin() {
	window.location='over.php';
}
function errormessage(message) {
	$('#notice').value += message + "\r\n";
	$('#notice').css('background','#FFE8E8');
}
function showmessage(message) {
	$('#notice').val(message + "\r\n" + $('#notice').val());
}
</script>
	<div class="main">
		<div class="btnbox"><textarea name="notice" style="width: 80%;"  readonly="readonly" id="notice"></textarea></div>
		<div class="btnbox marginbot">
	<input type="button" name="submit" value="安装数据" style="height:35" id="laststep" onclick="initinput()">
    <script>
    $('#laststep').attr('disabled','true');
    </script>
	</div>
	<?php include('footer.php');?>

	</div>
</div>
</div>
<?php
flush();
ob_flush();

$next_ok=1;
$url = "http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF'];
$url=str_replace('/install/install.php','',$url); //网站网址
$url=str_replace('http://','',$url);

$_POST['db']=cleartrim($_POST['db']);
$_POST['admin']=cleartrim($_POST['admin']);

$dbserver = $_POST['db']['host'];
$dbuser =$_POST['db']['username'];
$dbpass = $_POST['db']['password'];
$dbname = $_POST['db']['dbname'];
$BIAOTOU = $_POST['db']['prefix'];
define('BIAOTOU',$BIAOTOU);

$duoduo = new duoduo;
$duoduo->dbserver=$dbserver;
$duoduo->dbuser=$dbuser;
$duoduo->dbpass=$dbpass;
$duoduo->dbname=$dbname;
$duoduo->BIAOTOU=$BIAOTOU;
$duoduo_link=$duoduo->connect();

if($_POST['admin']['miyue']==''){
	$randstr='!@#$%^&*()_+abcdefghigklmnopqrstuvwxyz1234567890';  //站点密钥，一旦生成，不能更改
	$ddkey='';
	for($i=0;$i<10;$i++){
		$ddkey.=$randstr{rand(0,47)};
	}
}
else{
	$ddkey=$_POST['admin']['miyue'];
}

$dbstr="<?php\n\$dbserver='".$dbserver."';\n\$dbuser='".$dbuser."';\n\$dbpass='".$dbpass."';\n\$dbname='".$dbname."';\n\$BIAOTOU='".$BIAOTOU."';\ndefine('BIAOTOU',\$BIAOTOU);\ndefine('DDKEY','".$ddkey."');\n?>";

file_put_contents('../data/conn.php',$dbstr); //写入数据库信息

$database=dd_get_cache('basedata','array');

foreach($database as $table=>$field){
    $query=$duoduo->delete_table($table); //先删除表
	$q=$duoduo->creat_table($table,$field); //再创建表
	if($q!=''){
	    echo script('showmessage("创建数据表 '.$table.'")');
		flush();
		ob_flush();
	}
	else{
		exit($duoduo->lastsql.mysql_error());
	    $next_ok=0;
	}
}

$data_arr=glob('data/*.php');
foreach($data_arr as $v){
    $sql=include(DDROOT.'/install/'.$v);
	$q=$duoduo->query($sql);
	if($q==''){
		exit($duoduo->lastsql.mysql_error());
	}
	$table=str_replace('data/','',$v);
	$table=str_replace('.php','',$table);
	echo script('showmessage("添加默认数据到表 '.$table.'")');
	flush();
	ob_flush();
}

$data=array('adminname'=>$_POST['admin']['adminuser'],'adminpass'=>deep_jm($_POST['admin']['adminpassword'],$ddkey),'addtime'=>time(),'role'=>1);
$duoduo->insert('duoduo2010',$data);

$domain_url=get_domain();
if($domain_url!='localhost'){
	$authcode=dd_get('http://auth.duoduo123.com/new_install.php?url='.urlencode("http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF']).'&key='.urlencode($ddkey)); //授权码
	if($authcode=='' || $authcode=='error'){
		echo script('showmessage("授权码获取失败")');
		exit;
	}
	elseif($next_ok==1){
		echo script("$('#notice').css('background','#deeff9');");
		echo script('showmessage("数据库安装完毕")');
		echo script("setTimeout('goadmin()',1000);");
	}
	$data=array('val'=>$authcode);
	$duoduo->update('webset',$data,'var="authorize"');
}
else{
	if($next_ok==1){
		echo script("$('#notice').css('background','#deeff9');");
		echo script('showmessage("数据库安装完毕")');
		echo script("setTimeout('goadmin()',1000);");
	}
}
?>