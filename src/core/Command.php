<?php
/**
 * System command.
 */

namespace core;

class Command
{
    public static function __callStatic($method, $params)
    {
        if (strpos($method, '-') !== false) {
            // Put create-cmd to createCmd.
            $aNamePiece = explode('-', $method);
            $first = array_shift($aNamePiece);

            $aNamePieceUpperFirst = array_map(function ($piece) {
                return ucfirst($piece);
            }, $aNamePiece);

            array_unshift($aNamePieceUpperFirst, $first);
            $realMethod = implode('', $aNamePieceUpperFirst);

            if (method_exists(__CLASS__, $realMethod)) {
                self::$realMethod($params);
                return true;
            }
        }

        return false;
    }

    /**
     * Show help information.
     */
    public static function help()
    {
        cecho('Open Sesame 4.4.0');
        cecho('Powered by liuxd');
        cecho('Fork me on github: https://github.com/liuxd');
    }

    /**
     * Create controller.
     */
    public static function createController()
    {
        global $argv;
        $sControllerName = $argv[2];

        $sTemplateFile = CORE_PATH . 'template' . DS . 'controller.template';
        $sTemplateOrigin = file_get_contents($sTemplateFile);
        $sTemplate = str_replace('{$controller}', $sControllerName, $sTemplateOrigin);
        $sControllerFile = APP_PATH . 'controller' . DS . $sControllerName . '.php';

        if (file_exists($sControllerFile)) {
            cecho('The controller has existed.', 'error');
            die;
        }

        $bResult = file_put_contents($sControllerFile, $sTemplate);

        if ($bResult) {
            $sMsg = 'Success!';
            $sMsgTheme = 'notice';
        } else {
            $sMsg = 'Failed!';
            $sMsgTheme = 'error';
        }

        cecho($sMsg, $sMsgTheme);
    }

    /**
     * Create cmd.
     */
    public static function createCmd()
    {
        global $argv;
        $sCmdName = $argv[2];

        $sTemplateFile = CORE_PATH . 'template' . DS . 'controller.template';
        $sTemplateOrigin = file_get_contents($sTemplateFile);
        $sTemplate = str_replace('{$cmd}', $sCmdName, $sTemplateOrigin);
        $sCmdFile = APP_PATH . 'cmd' . DS . $sCmdName . '.php';

        if (file_exists($sCmdFile)) {
            cecho('The cmd has existed.', 'error');
            die;
        }

        $sCmdPath = APP_PATH . 'cmd';

        if (!is_dir($sCmdFile)) {
            mkdir($sCmdPath);
        }

        $bResult = file_put_contents($sCmdFile, $sTemplate);

        if ($bResult) {
            $sMsg = 'Success!';
            $sMsgTheme = 'notice';
        } else {
            $sMsg = 'Failed!';
            $sMsgTheme = 'error';
        }

        cecho($sMsg, $sMsgTheme);
    }
}

# end of this file.
