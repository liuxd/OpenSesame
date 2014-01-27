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
define('UTIL_PATH', ROOT_PATH . 'utility' . DS);
define('APP_PATH', ROOT_PATH . 'application' . DS);
define('WWW_PATH', ROOT_PATH . 'public' . DS);
define('INI_PATH', ROOT_PATH . 'config' . DS);
define('DEFAULT_APP', 'web');

# 框架核心文件
$core_files = [
    'ErrorHandler.php',
    'Config.class.php',
    'CGI.class.php',
    'Function.php',
    'Router.class.php',
    'ClassLoader.class.php',
    'FrontEnd.class.php'
];

foreach ($core_files as $core_file) {
    require __DIR__ . DS . $core_file;
}

new ClassLoader;
set_error_handler('err');

# end of this file
