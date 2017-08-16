<?php

namespace cmd;

use core as c;
use model as m;
use util as u;

class Show extends Base
{
    public function run()
    {
        global $argv;

        if (!isset($argv[2])) {
            c\cecho('What is the Account ID?', 'error');
            return false;
        }

        $iAccountID = $argv[2];
        $oAccount = new m\Account;

        $aDetail = $oAccount->getAccountDetail($iAccountID);

        if (empty($aDetail)) {
            c\cecho('Invalid ID', 'error');
            return false;
        }

        $aFields = $oAccount->getAccountFields($iAccountID);

        c\cecho($aDetail['name'], 'error');

        foreach ($aFields as $aField) {
            $sMsg = $aField['name'] . ' ---- ' . $aField['value'];
            c\cecho($sMsg, 'notice');
        }
    }
}

# end of this file
