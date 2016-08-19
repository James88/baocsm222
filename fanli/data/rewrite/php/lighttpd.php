<?php //伪静态
include('../../../comm/dd.config.php');
include(DDROOT.'/comm/rewrite.class.php');
ob_start();
?>
url.rewrite-once=(
<?php
$rewrite = new rewrite();
echo $rewrite->run('lighttpd');
?>
)
<?php
$c=ob_get_contents();
dd_file_put(DDROOT.'/data/rewrite/lighttpd.txt',$c);
ob_clean();
?>