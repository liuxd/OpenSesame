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
foreach (glob(__DIR__ . DS . '*.php') as $key => $file) {
    require $file;
}

require ROOT_PATH . DS . 'dev' . DS . 'debug.function.php';

# end of this file
