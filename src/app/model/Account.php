<?php
namespace model;

use util as u;
use core as c;

class Account
{
    const TABLE_NAME = 'account';
    const STATUS_VALID = 1;
    const STATUS_UNVALID = 0;

    public function getAllAccount()
    {
        $sSQL = 'SELECT *, rowid FROM ' . self::TABLE_NAME . ' WHERE valid=' . self::STATUS_VALID . ' AND parent=0';
        return u\DB::getList($sSQL);
    }

    /**
     * 获得一个帐号的详细信息。
     * @param int $iAccountID 帐号ID。
     * @return array
     */
    public function getAccountDetail($iAccountID)
    {
        $sSQL = 'SELECT *, rowid 
            FROM ' . self::TABLE_NAME . ' 
            WHERE rowid = ?  
            AND valid=' . self::STATUS_VALID . '
            Limit 1';
        return u\DB::getOne($sSQL, [$iAccountID]);
    }

    /**
     * 获得一个帐号的所有记录。
     * @param int $iAccountID 帐号ID。
     * @return array
     */
    public function getAccountFields($iAccountID)
    {
        $sSQL = 'SELECT *, rowid FROM ' . self::TABLE_NAME . ' WHERE parent=?  AND valid=' . self::STATUS_VALID;
        $aResult = u\DB::getList($sSQL, [$iAccountID]);

        foreach ($aResult as $k => $v) {
            if (substr($v['value'], 0, 5) === 'link:') {
                $sSQLAccount = 'SELECT rowid 
                    FROM ' . self::TABLE_NAME . '
                    WHERE valid=' . self::STATUS_VALID . ' 
                    AND name=? 
                    LIMIT 1';
                $sLinkAccount = substr($v['value'], 5);
                $aAccountID = u\DB::getOne($sSQLAccount, [$sLinkAccount]);
                $aResult[$k]['link'] = c\Router::genURL('Detail', ['id' => $aAccountID['rowid']]);
                $aResult[$k]['linkname'] = $sLinkAccount;
            }
        }

        return $aResult;
    }

    /**
     * 删除帐号或者一个帐号属性。
     * @param int $iRowID 主键。
     * @return bool
     */
    public function del($iRowID)
    {
        return u\DB::update(self::TABLE_NAME, 'WHERE rowid = ' . $iRowID, ['valid' => self::STATUS_UNVALID]);
    }

    /**
     * 添加一个新的帐号。
     * @param string $sName 帐号名称。
     * @param string $sURL 帐号的URL。
     * @return int
     */
    public function addAccount($sName, $sURL)
    {
        $aData = [
            'name' => $sName,
            'value' => $sURL,
            'parent' => 0,
            'valid' => self::STATUS_VALID
        ];

        return u\DB::add($aData, self::TABLE_NAME);
    }

    /**
     * 给一个帐号添加一个记录。
     * @param string $sName 名称。
     * @param string $sValue 值。
     * @param int $iAccountID 帐号ID。
     * @return int 主键
     */
    public function addField($sName, $sValue, $iAccountID)
    {
        $aData = [
            'name' => $sName,
            'value' => $sValue,
            'parent' => $iAccountID,
            'valid' => self::STATUS_VALID
        ];

        return u\DB::add($aData, self::TABLE_NAME);
    }

    /**
     * 更新一条记录。
     * @param string $sName 名称。
     * @param string $sValue 值。
     * @param int $iFieldID 属性的主键。
     * @return bool
     */
    public function updateField($sName, $sValue, $iFieldID)
    {
        $aData = [
            'name' => $sName,
            'value' => $sValue
        ];
        return u\DB::update(self::TABLE_NAME, 'WHERE rowid = ' . $iFieldID, $aData);
    }

    /**
     * 获得总数。
     * @return int
     */
    public function getTotal()
    {
        $sSQL = 'SELECT count(*) as total FROM ' . self::TABLE_NAME . ' WHERE valid=' . self::STATUS_VALID . ' Limit 1';
        return u\DB::getOne($sSQL)['total'];
    }

    /**
     * 创建表结构。
     */
    public function createTable()
    {
        u\DB::getInstance()->query('create table account (name text, value text, parent interger, valid interger)');
    }
}

# end of this file
