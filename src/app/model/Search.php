<?php
namespace model;

use util as u;

class Search
{
    /**
     * 关键字搜索。
     * @param string $sKeyword 搜索关键字。
     * @return array
     */
    public function handle($sKeyword)
    {
        $sSQL = 'SELECT *, rowid 
            FROM ' . Account::TABLE_NAME . ' 
            WHERE parent=0 
            AND valid=' . Account::STATUS_VALID . ' 
            AND (name like ? OR value like ?)';
        return u\DB::getList($sSQL, ['%' . $sKeyword . '%', '%' . $sKeyword . '%']);
    }
}

# end of this file
