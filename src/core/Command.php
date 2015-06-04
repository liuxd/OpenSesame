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
        cecho('Open Sesame 4.3.2');
        cecho('Powered by liuxd');
        cecho('Fork me on github: https://github.com/liuxd');
    }

    /**
     * Create controller.
     */
    public static function createController()
    {
        global $argv;
        $controller_name = $argv[2];

        $template = <<<EOF
<?php
namespace controller;

use core as c;
use model as m;

class {$controller_name} extends Base
{
    public function run()
    {
    }
}

# end of this file

EOF;
        file_put_contents(APP_PATH . 'controller' . DS . $controller_name . '.php', $template);
    }

    /**
     * Create cmd.
     */
    public static function createCmd()
    {
        global $argv;
        $cmd = $argv[2];
        $cmd_folder = APP_PATH . 'cmd';

        if (!is_dir($cmd_folder)) {
            mkdir($cmd_folder);
        }

        $template = <<<EOF
<?php

namespace cmd;

use core as c;

class {$cmd}
{
    public function run()
    {
        // @todo do something you like.
    }
}

# end of this file

EOF;
        file_put_contents(APP_PATH . 'cmd' . DS . $cmd . '.php', $template);
    }
}

# end of this file.
