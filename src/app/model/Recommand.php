<?php
namespace model;

use util as u;
use core as c;

class Recommand
{
    /**
     * Recommedations.
     * @param int $iSize
     * @return array
     */
    public function get($iSize)
    {
        $sSQL = 'SELECT rowid, name, value
            FROM ' . Account::TABLE_NAME . '
            WHERE valid=1
            AND parent=0
            ORDER BY RANDOM()
            LIMIT ' . $iSize;

        $ret = u\DB::getList($sSQL);

        foreach ($ret as $k => $v) {
            $ret[$k]['url'] = c\Router::genURL('Detail', ['id' => $v['rowid']]);
        }

        return $ret;
    }
}

# end of this file
