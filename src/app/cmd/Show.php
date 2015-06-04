<?php

namespace cmd;

use core as c;
use model as m;
use util as u;

class Show
{
    public function run()
    {
        $aConfig = c\Config::get('dsn');
        u\DB::connect($aConfig['data']);

        global $argv;
        $iAccountID = $argv[2];
        $oAccount = new m\Account;

        $aDetail = $oAccount->getAccountDetail($iAccountID);
        $aFields = $oAccount->getAccountFields($iAccountID);

        c\cecho($aDetail['name'], 'error');

        foreach ($aFields as $aField) {
            $sMsg = $aField['name'] . ' ---- ' . $aField['value'];
            c\cecho($sMsg, 'notice');
        }
    }
}

# end of this file
