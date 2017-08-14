<?php

namespace cmd;

use core as c;
use util as u;
use model as m;

class CheckSite extends Base
{
    public function run()
    {
        $sSQL = 'SELECT rowid,name,value
            FROM ' . m\Account::TABLE_NAME . '
            WHERE parent=0
            AND valid=' . m\Account::STATUS_VALID;

        $aList = u\DB::getList($sSQL);

        foreach ($aList as $aInfo) {
            $aInfo['http_code'] = $this->check('http://' . $aInfo['value']);
            $sMessge = implode(' - ', $aInfo);
            $sTheme = ($aInfo['http_code'] == 200) ? 'notice' : 'error';
            c\cecho($sMessge, $sTheme);
        }
    }

    public function check($sURL, $iTimeout = 3, $iConnTimeout = 2)
    {
        $rResource = curl_init();
        curl_setopt($rResource, CURLOPT_URL, $sURL);
        curl_setopt($rResource, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($rResource, CURLOPT_TIMEOUT, $iTimeout);
        curl_setopt($rResource, CURLOPT_CONNECTTIMEOUT, $iConnTimeout);
        curl_setopt($rResource, CURLOPT_FOLLOWLOCATION, 1);
        curl_exec($rResource);
        $aReturnStatus = curl_getinfo($rResource);
        curl_close($rResource);

        return $aReturnStatus['http_code'];
    }
}

# end of this file
