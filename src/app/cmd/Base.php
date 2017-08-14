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
        u\DB::connect($aConfig['data']);

        $aConfigKey = c\Config::get('secret_key');
        m\Account::$sSecretKey = $aConfigKey['data'];
    }
}

# end of this file
