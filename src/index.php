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

if (substr($_SERVER['REQUEST_URI'], 0, 8) === '/static/') {
    c\FrontEnd::handle(WWW_PATH, 8);
} else {
    $oController = c\Router::route($_SERVER['REQUEST_URI'], APP_PATH);
    $oController->before();
    $aData = $oController->handle();
    $sType = $oController->getType();
    $oController->after();

    c\Output::handle($aData, $sType);
}

# end of this file
