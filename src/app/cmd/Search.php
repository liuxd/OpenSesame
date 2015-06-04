<?php

namespace cmd;

use core as c;
use model as m;
use util as u;

class Search
{
    public function run()
    {
        $aConfig = c\Config::get('dsn');
        u\DB::connect($aConfig['data']);

        global $argv;
        $sKeyword = $argv[2];
        $aList = (new m\Search)->handle($sKeyword);

        foreach ($aList as $aAccount) {
            $sMsg = str_pad($aAccount['rowid'], 8) . $aAccount['name'];
            c\cecho($sMsg, 'notice');
        }
    }
}

# end of this file
