<?php
/**
 * Framework entrance.
 */

// Just for CLI mode.
if (php_sapi_name() === 'cli') {
    echo 'Open Sesame 4.2.1', PHP_EOL;
    echo 'Powered by liuxd', PHP_EOL;
    echo 'Fork me on github: https://github.com/liuxd', PHP_EOL;
    die;
}

// Initialize the web framework.
require 'core/Bootstrap.php';

// Response the front end requests.
\core\Router::responseFrontEndFiles('static');

// Router work, get the target controller object.
$oController = \core\Router::route($_SERVER['REQUEST_URI'], APP_PATH);

// Run previous hook.
$oController->before();

// The result data.
$aData = $oController->handle();

// The request type.Such as, html, json and pjax.
$sOutputType = $oController->getOutputType();

// Output the result data.
\core\Output::handle($aData, $sOutputType);

// Run after hook.
$oController->after();

# end of this file
