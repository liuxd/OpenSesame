<?php
/**
 * Initialize the framework.
 */
namespace core;

if (php_sapi_name() === 'cli') {
    echo 'Open Sesame 4.2.1', PHP_EOL;
    echo 'Powered by liuxd', PHP_EOL;
    echo 'Fork me on github: https://github.com/liuxd', PHP_EOL;
    die;
}

date_default_timezone_set('Asia/Shanghai');
error_reporting(-1);

$aCoreFiles = [
    'Const',
    'Config',
    'Error',
    'Function',
    'Interface',
    'Loader',
    'Output',
    'Router',
    'Controller',
];

foreach ($aCoreFiles as $sCoreFile) {
    require __DIR__ . DIRECTORY_SEPARATOR . $sCoreFile . '.php';
}

require APP_PATH . 'controller/Base.php';
new Loader;
set_error_handler('err');
mb_internal_encoding("UTF-8");

# end of this file
