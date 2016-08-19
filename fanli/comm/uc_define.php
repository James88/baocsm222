<?php //UC常量定义
if(!isset($webset)){
	$webset['ucenter']=$this->webset['ucenter'];
}
define('UC_CONNECT', 'mysql');
define('UC_DBHOST', $webset['ucenter']['UC_DBHOST']);
define('UC_DBUSER', $webset['ucenter']['UC_DBUSER']);
define('UC_DBPW', $webset['ucenter']['UC_DBPW']);
define('UC_DBNAME', $webset['ucenter']['UC_DBNAME']);
define('UC_DBCHARSET', $webset['ucenter']['UC_DBCHARSET']);
define('UC_DBTABLEPRE', '`' . $webset['ucenter']['UC_DBNAME'] . '`.' . $webset['ucenter']['UC_DBTABLEPRE']);
define('UC_DBCONNECT', '0');
define('UC_KEY', $webset['ucenter']['UC_KEY']);
define('UC_API', $webset['ucenter']['UC_API']);
define('UC_CHARSET', $webset['ucenter']['UC_CHARSET']);
define('UC_IP', '');
define('UC_APPID', $webset['ucenter']['UC_APPID']);
define('UC_PPP', '20');
?>