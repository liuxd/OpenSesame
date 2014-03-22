<?php
/**
 * 入口文件
 */

use core as c;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', __DIR__ . DS);
define('CORE_PATH', ROOT_PATH . 'core' . DS);
define('UTIL_PATH', ROOT_PATH . 'util' . DS);
define('APP_PATH', ROOT_PATH . 'app' . DS);
define('WWW_PATH', ROOT_PATH . 'www' . DS);

require CORE_PATH . 'Bootstrap.php';

$sURI = $_SERVER['REQUEST_URI'];

if (c\Router::isStatic($sURI)) {
    c\FrontEnd::handle(WWW_PATH, 8);
} else {
    $oController = c\Router::route($sURI, APP_PATH);
    $oController->before();
    c\Output::handle($oController->handle(), $oController->outputType);
    $oController->after();
}

# end of this file
