<?php
/**
 * Framework entrance.
 */


require 'core/Bootstrap.php';

\core\Router::responseFrontEndFiles('static');
$oController = \core\Router::route($_SERVER['REQUEST_URI'], APP_PATH);
$oController->before();
\core\Output::handle($oController->handle(), $oController->outputType);
$oController->after();

# end of this file
