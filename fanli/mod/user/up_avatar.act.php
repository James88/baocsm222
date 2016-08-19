<?php
/**
 * ============================================================================
 * 版权所有 多多科技，保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('INDEX')){
	exit('Access Denied');
}

//设置区
$config = array(
    'tmpdir' => 'data/cache/tempUpload',           //临时文件夹（相对于本文件的位置而言）。开头和结尾请不要加反斜杆
    'avatardir' => 'upload/avatar',        //存储头像的文件夹（相对于本文件的位置而言），开头和结尾请不要加反斜杆
    'authkey' => DDKEY,          //通讯密钥，必须填写，否则脚本无法运行！
    'debug' => true,    //开启debug记录？
    'uploadsize' => 1024,   //上传图片文件的最大值，单位是KB
    'imgtype' => array(1 => '.gif', 2 => '.jpg', 3 => '.png'),        //允许上传的类型，请勿修改此处设置，否则会引起安全隐患问题！
);

//脚本运行区
//定义运行开始
define('IN_INTER', true);
define('SYSTEM_PATH', DDROOT. '/api/Lib');

//错误调试区
if( true === $config['debug'] ){
    set_exception_handler(array('Inter_Error', 'exception_handler'));
    set_error_handler(array('Inter_Error', 'error_handler'), E_ALL);
    Inter_Error::$conf['debugMode'] = false;
    Inter_Error::$conf['logType'] = 'simple';
    Inter_Error::$conf['logDir'] = DDROOT. '/cache/Log';
    //Inter_Error::$conf['logDir'] = 'R:\TEMP';
}else{
    error_reporting(0);
}

//获取动作名称
if( !isset($_GET['a']) || empty($_GET['a']) || !is_string($_GET['a']) ){
    $action = 'showuploadAction';
}else{
    $action = $_GET['a']. 'Action';
}

//因为这个程序只有一个控制器，所以直接实例化了
$controller = new Controller_AvatarFlashUpload();
$controller->config->set($config);
//运行该脚本的网址（不含脚本名称），存储于config中
$controller->config->uc_api = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http' ). '://'. $_SERVER['HTTP_HOST']. substr( $_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/') );
                              
//运行控制器指定的动作

if(method_exists($controller, $action)){
    /*
    if(method_exists($controller, $action.'Before')){
        $controller->$action.'Before';
    }
    */
    $result = $controller->$action();
    /*
    if(method_exists($controller, $action.'After')){
        $controller->$action.'After';
    }
    */
    if(is_array($result)){
        $uc_avatarflash=$result;
		echo "'".implode("','", $uc_avatarflash)."'";
    }else{
        echo $result;
    }
}else{
    dd_exit('NO ACTION FOUND!');
}


/**
 * php 5.0新增的自动加载模式
 * 假如php版本高于5.0，并且在大于等于5.1.2的情况下没有开启spl_autoload_register，则使用此__autoload方法执行之。
 * 本函数依赖于：
 *   - 常量SYSTEM_PATH：框架组件目录
 * @param string $classname 遵循本框架命名规则的class名称
 */
function __autoload($classname){
    $path = SYSTEM_PATH. DIRECTORY_SEPARATOR. str_replace('_', DIRECTORY_SEPARATOR, $classname). '.php';
    require($path);
}
?>