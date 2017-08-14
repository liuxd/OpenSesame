<?php

namespace cmd;

use core as c;
use model as m;
use util as u;

class Base
{
    public function __construct()
    {
        $aConfig = c\Config::get('dsn');

        if ($aConfig['result']) {
            u\DB::connect($aConfig['data']);
        } else {
            $tmp = str_replace('phar://', 'sqlite:', __DIR__);
            $dsn = str_replace('opensesame.phar/app/cmd', '084', $tmp);
            u\DB::connect($dsn);
        }

        $aConfigKey = c\Config::get('secret_key');
        m\Account::$sSecretKey = $aConfigKey['data'];
    }
}

# end of this file
