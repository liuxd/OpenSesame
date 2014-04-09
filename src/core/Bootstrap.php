<?php
/**
 * 框架初始化。
 */
namespace core;

date_default_timezone_set('Asia/Shanghai');
error_reporting(-1);

$aCoreFiles = [
    'Const.php',
    'Config.php',
    'Error.php',
    'Function.php',
    'Interface.php',
    'Loader.php',
    'Output.php',
    'Router.php',
    'Controller.php',
];

foreach ($aCoreFiles as $sCoreFile) {
    require __DIR__ . DIRECTORY_SEPARATOR . $sCoreFile;
}

require APP_PATH . 'controller/Base.php';
new Loader;
set_error_handler('err');

# end of this file
