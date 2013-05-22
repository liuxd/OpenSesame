<?php
/**
 * 框架初始化。
 */

# 常量定义
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', __DIR__ . DS . '..' . DS);
define('UTIL_PATH', ROOT_PATH . 'util' . DS);
define('APP_PATH', ROOT_PATH . 'app' . DS);
define('WWW_PATH', ROOT_PATH . 'www' . DS);
define('RES_PATH', ROOT_PATH . 'res' . DS);
define('DB_PATH', RES_PATH . 'db' . DS);
define('INI_PATH', RES_PATH . 'ini' . DS);
define('DEFAULT_APP', 'web');

error_reporting(-1);

# 设置时区
date_default_timezone_set('Asia/Shanghai');

# 设定编码
mb_internal_encoding("UTF-8");

# 框架核心文件
$core_files = glob(__DIR__ . DS . '*.php');

foreach ($core_files as $key => $file) {
    require $file;
}

require ROOT_PATH . DS . 'dev' . DS . 'debug.function.php';

# end of this file