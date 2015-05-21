<?php
/**
 * Initialize the framework.
 */
namespace core;

mb_internal_encoding("UTF-8");
date_default_timezone_set('Asia/Shanghai');
error_reporting(-1);

$aCoreFiles = [
    'Const',
    'Config',
    'Handlers',
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

new Loader;
set_error_handler('\core\Handlers::errorHandler');
set_exception_handler('\core\Handlers::exceptionHandler');

# end of this file
