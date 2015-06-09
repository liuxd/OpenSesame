<?php
/**
 * Dispatcher.
 */

namespace core;

class Dispatcher
{
    /**
     * Dispater for CLI mode.
     * @param array $argv The params of command line.
     * @return bool
     */
    public static function handleCLI($argv)
    {
        $cmd = isset($argv[1]) ? $argv[1] : 'help';
        require CORE_PATH . 'Command.php';

        // Check framework commands.
        if (Command::$cmd() !== false) {
            return true;
        }

        $sCmdClass = ucfirst($cmd);
        $sCmdFile = APP_PATH . 'cmd' . DS . $sCmdClass . '.php';

        if (!file_exists($sCmdFile)) {
            cecho('Invalid Command : ' . $cmd, 'error');
        } else {
            require $sCmdFile;
            $classname = "\cmd\\" . $sCmdClass;
            $oCmd = new $classname;
            $oCmd->run();
        }
    }

    /**
     * Dispatcher for CGI mode.
     */
    public static function handleCGI()
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
}

# end of this file.
