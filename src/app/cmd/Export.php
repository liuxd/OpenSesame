<?php

namespace cmd;

use core as c;
use util as u;
use model as m;

class Export extends Base
{
    public function run()
    {
        $sSQL = 'SELECT rowid,name,value
            FROM ' . m\Account::TABLE_NAME . '
            WHERE parent=0
            AND valid=' . m\Account::STATUS_VALID . ' ORDER BY name';

        $aList = u\DB::getList($sSQL);

        $oAccount = new m\Account;

        foreach ($aList as $aInfo) {
            $sMessge = implode(' | ', $aInfo);
            echo '- ', $sMessge, "\n";

            $aFields = $oAccount->getAccountFields($aInfo['rowid']);

            foreach ($aFields as $aField) {
                echo '    - ' . $aField['name'] . ' : ' . $aField['value'], "\n";
            }
        }
    }
}

# end of this file
