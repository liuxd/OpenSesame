<?php
/**
 * Framework entrance.
 */

namespace core;

require 'core/Bootstrap.php';

if (PHP_SAPI === 'cli') {
    cecho('Open Sesame 4.3.0');
    cecho('Powered by liuxd');
    cecho('Fork me on github: https://github.com/liuxd');
} else {
    require APP_PATH . 'controller/Base.php';
    Router::responseFrontEndFiles('static');
    $oController = Router::route($_SERVER['REQUEST_URI'], APP_PATH);
    $oController->before();
    $aData = $oController->handle();
    $sOutputType = $oController->getOutputType();
    Output::handle($aData, $sOutputType);
    $oController->after();
}

# end of this file
