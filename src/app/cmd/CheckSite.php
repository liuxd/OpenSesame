<?php

namespace cmd;

use core as c;
use util as u;
use model as m;

class CheckSite
{
    public function run()
    {
        $aConfig = c\Config::get('dsn');
        u\DB::connect($aConfig['data']);

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

    public static function check($url, $timeout = 3, $conn_timeout = 2)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $conn_timeout);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $file_contents = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        return $info['http_code'];
    }
}

# end of this file
