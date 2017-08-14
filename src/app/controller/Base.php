<?php

namespace controller;

use core as c;
use util as u;
use model as m;

class Base extends c\Controller
{
    public function handle()
    {
        $aConfig = c\Config::get('dsn');

        if ($aConfig['result']) {
            u\DB::connect($aConfig['data']);
        } else {
            $tmp = str_replace('phar://', 'sqlite:', __DIR__);
            $dsn = str_replace('opensesame.phar/app/controller', '084', $tmp);
            u\DB::connect($dsn);
        }

        $aConfigKey = c\Config::get('secret_key');
        m\Account::$sSecretKey = $aConfigKey['data'];

        $aData = parent::handle();
        $aData['data']['host'] = "http://{$_SERVER['HTTP_HOST']}/?static=";


        return $aData;
    }
}

# end of this file
