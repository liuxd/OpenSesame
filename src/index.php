<?php
/**
 * Framework entrance.
 */

require 'core/Bootstrap.php';

$oController = \core\Router::route($_SERVER['REQUEST_URI'], APP_PATH, 'static');

if ($oController !== false) {
    $oController->before();
    \core\Output::handle($oController->handle(), $oController->outputType);
    $oController->after();
}

# end of this file
