<?php
/**
 * Dispatcher.
 */

namespace core;

/**
 * Dispater for CLI mode.
 */
function dispatch_cli()
{
    cecho('Open Sesame 4.3.2');
    cecho('Powered by liuxd');
    cecho('Fork me on github: https://github.com/liuxd');
}

/**
 * Dispatcher for CGI mode.
 */
function dispatch_cgi()
{
    require APP_PATH . 'controller/Base.php';
    Router::responseFrontEndFiles('static');
    $oController = Router::route($_SERVER['REQUEST_URI'], APP_PATH);
    $oController->before();
    $aData = $oController->handle();
    $sOutputType = $oController->getOutputType();
    Output::handle($aData, $sOutputType);
    $oController->after();
}

# end of this file.
