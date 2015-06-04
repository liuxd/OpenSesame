<?php
/**
 * System command.
 */

namespace core;

class Command
{
    public static function __callStatic($method, $params)
    {
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
}

# end of this file.
