<?php

namespace cmd;

use core as c;
use model as m;
use util as u;

/**
 * 从v4到v5的数据迁移。
 */
class Migrante
{
    public function run()
    {
        $aConfig = c\Config::get('dsn');
        u\DB::connect($aConfig['data']);

        $aConfigKey = c\Config::get('key_path');
        $oAccount = new m\Account;

        $aConfigKey = c\Config::get('secret_key');
        m\Account::$sSecretKey = $aConfigKey['data'];

        $sSQL = 'SELECT *, rowid FROM account WHERE valid=1 AND parent = 0';
        $rows = u\DB::getList($sSQL);

        foreach ($rows as $k => $row) {
            $rows[$k]['fields'] = $oAccount->getAccountFields($row['rowid']);
        }

        // print_r($rows);

        $aConfig = c\Config::get('dsn_new');
        u\DB::connect($aConfig['data'], '', '', [], 'new_db');
        $oAccount->createTable();

        foreach ($rows as $row) {
            $iAccountID = $oAccount->addAccount($row['name'], $row['value']);

            foreach ($row['fields'] as $v) {
                $oAccount->addField($v['name'], $v['value'], $iAccountID);
            }
        }
    }
}

# end of this file
