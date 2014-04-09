<?php
/**
 * 入口文件
 */

use core as c;

require 'core' . DIRECTORY_SEPARATOR . 'Bootstrap.php';

$sURI = $_SERVER['REQUEST_URI'];
$oController = c\Router::route($sURI, APP_PATH);
$oController->before();
c\Output::handle($oController->handle(), $oController->outputType);
$oController->after();

# end of this file
