<?php

namespace controller;

use core as c;
use util as u;
use model as m;

class Base extends c\Controller
{
    public $bAuth = true;

    public function handle()
    {
        $aIPPower = c\Config::get('ip_check')['data'];

        if ($aIPPower === 'on' && $this->bAuth && !(new m\Secure())->checkIp()) {
            c\Router::redirect(c\Router::genURL('Deny'));
        }

        $aConfig = c\Config::get('dsn');
        u\DB::getInstance($aConfig['data']);
        $aData = parent::handle();

        return $aData;
    }
}

# end of this file
