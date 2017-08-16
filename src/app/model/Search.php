<?php
namespace model;

use util as u;

class Search
{
    /**
     * Search by keyword.
     * @param string $sKeyword The keyword to search.
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
