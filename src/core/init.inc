<?php
/**
 * 框架初始化。
 */

date_default_timezone_set('Asia/Shanghai');
error_reporting(-1);
mb_internal_encoding("UTF-8");

# 路径常量定义
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', __DIR__ . DS . '..' . DS);
define('UTIL_PATH', ROOT_PATH . 'util' . DS);
define('APP_PATH', ROOT_PATH . 'app' . DS);
define('WWW_PATH', ROOT_PATH . 'www' . DS);
define('INI_PATH', ROOT_PATH . 'ini' . DS);

define('DEFAULT_APP', 'web');

# 错误提示常量定义
$msgs = parse_ini_file(__DIR__ . DS . 'error_msg.ini.core', true);

# 框架核心文件
$core_files = [
    'error_handler.php',
    'Config.class.php',
    'CGI.class.php',
    'Router.class.php',
    'ClassLoader.class.php',
    'FrontEnd.class.php'
];

foreach ($core_files as $core_file) {
    require __DIR__ . DS . $core_file;
}

# end of this file
