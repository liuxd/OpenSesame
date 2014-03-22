<?php
/**
 * 框架初始化。
 */
namespace core;

date_default_timezone_set('Asia/Shanghai');
error_reporting(-1);
mb_internal_encoding("UTF-8");

$aCoreFiles = [
    'Config.php',
    'Error.php',
    'Front.php',
    'Function.php',
    'Interface.php',
    'Loader.php',
    'Output.php',
    'Router.php',
];

foreach ($aCoreFiles as $sCoreFile){
    require CORE_PATH . $sCoreFile;
}

new Loader;
set_error_handler('err');

# end of this file
