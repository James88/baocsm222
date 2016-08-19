<?php
include('../../../comm/dd.config.php');
include(DDROOT.'/comm/rewrite.class.php');
ob_start();
?>
[ISAPI_Rewrite]

# 3600 = 1 hour

RepeatLimit 32

# Protect httpd.ini and httpd.parse.errors files
# from accessing through HTTP

# duoduo Rewrite规则
<?php
$rewrite = new rewrite();
echo $rewrite->run('httpd');

$c=ob_get_contents();
dd_file_put(DDROOT.'/data/rewrite/httpd.ini',$c);
ob_clean();
?>