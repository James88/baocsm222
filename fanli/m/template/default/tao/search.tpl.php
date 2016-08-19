<?php
if (!defined('INDEX')) {
	exit ('Access Denied');
}

$parameter=act_wap_search();
extract($parameter);
wap_jump($jump_arr['url'],$jump_arr['word']);