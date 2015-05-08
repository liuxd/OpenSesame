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
        $aConfig = c\Config::get('dsn');
        u\DB::getInstance($aConfig['data']);
        $aData = parent::handle();
        $aData['data']['host'] = "http://{$_SERVER['HTTP_HOST']}/?static=";

        return $aData;
    }
}

# end of this file
