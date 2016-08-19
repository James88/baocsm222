<?php //nginx伪静态
include('../../../comm/dd.config.php');
include(DDROOT.'/comm/rewrite.class.php');
ob_start();
?>
location / {
<?php
$rewrite = new rewrite();
echo $rewrite->run('nginx');
?>
}
<?php
$c=ob_get_contents();
dd_file_put(DDROOT.'/data/rewrite/nginx.txt',$c);
ob_clean();
?>