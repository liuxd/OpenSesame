<?php
/**
 * 框架初始化。
 */

require __DIR__ . DIRECTORY_SEPARATOR . 'Const.php';

date_default_timezone_set('Asia/Shanghai');
error_reporting(-1);
mb_internal_encoding("UTF-8");

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
