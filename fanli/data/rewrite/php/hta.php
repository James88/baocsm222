<?php
include('../../../comm/dd.config.php');
include(DDROOT.'/comm/rewrite.class.php');
ob_start();
?>
# 将 RewriteEngine 模式打开
RewriteEngine On
RewriteBase /

# Rewrite 定义各重写规则
<?php
$rewrite = new rewrite();
echo $rewrite->run('htaccess');

$c=ob_get_contents();
dd_file_put(DDROOT.'/data/rewrite/.htaccess',$c);
ob_clean();
?>