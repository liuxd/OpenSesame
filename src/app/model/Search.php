<?php
namespace model;

class Search
{
    /**
     * 关键字搜索。
     * @param string $sKeyword 搜索关键字。
     * @return array
     */
    public function search($sKeyword)
    {
        $sSQL = 'SELECT * FROM ' . Account::TABLE_NAME . ' WHERE name like "%?%" OR value like "%?%"';
        return u\DB::getInstance($sSQL, [$sKeyword, $sKeyword]);
    }
}

# end of this file
