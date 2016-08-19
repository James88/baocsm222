<?php
error_reporting(0);

$today=(int)$_GET['set_today'];
file_put_contents('../data/backstage.txt',$today);