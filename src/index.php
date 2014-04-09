<?php
/**
 * 入口文件
 */

use core as c;

require 'core' . DIRECTORY_SEPARATOR . 'Bootstrap.php';
$oController = c\Router::route($_SERVER['REQUEST_URI'], APP_PATH);
$oController->before();
c\Output::handle($oController->handle(), $oController->outputType);
$oController->after();

# end of this file
