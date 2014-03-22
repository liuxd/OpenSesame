<?php
/**
 * 框架初始化。
 */
namespace core;

date_default_timezone_set('Asia/Shanghai');
error_reporting(-1);
mb_internal_encoding("UTF-8");

$aCoreFiles = [
    'Const.php',
    'Config.php',
    'Error.php',
    'Front.php',
    'Function.php',
    'Interface.php',
    'Loader.php',
    'Output.php',
    'Router.php',
];

foreach ($aCoreFiles as $sCoreFile) {
    require __DIR__ . DIRECTORY_SEPARATOR . $sCoreFile;
}

new Loader;
set_error_handler('err');

# end of this file
