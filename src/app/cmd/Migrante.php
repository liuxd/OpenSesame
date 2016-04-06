<?php

namespace cmd;

use core as c;
use model as m;
use util as u;

class Migrante
{
    public function run()
    {
        $aConfig = c\Config::get('dsn');
        u\DB::connect($aConfig['data']);

        $aConfigKey = c\Config::get('key_path');
        $oAccount = new m\Account;

        $oAccount->setSecretKey(file_get_contents($aConfigKey['data']));

        var_dump($oAccount->getSecretKey());
    }
}

# end of this file
