<?php
namespace model;

use util as u;
use core as c;

class Account
{
    const TABLE_NAME = 'account';
    const STATUS_VALID = 1;
    const STATUS_UNVALID = 0;
    const ENCRYPT_SALT_PREFIX_LENGTH = 3;
    const ENCRYPT_SALT_SUFFIX_LENGTH = 4;
    const COMPRESS_LEVEL = 9;

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
            $aResult[$k]['value'] = $sRealValue = $this->decrypt(gzinflate($v['value']));
            $aResult[$k]['name'] = base64_decode(gzinflate($v['name']));

            if (substr($sRealValue, 0, 5) === 'link:') {
                $sSQLAccount = 'SELECT rowid FROM ' . self::TABLE_NAME;
                $sSQLAccount .= ' WHERE valid=' . self::STATUS_VALID . ' AND name=?  LIMIT 1';
                $sLinkAccount = substr($sRealValue, 5);
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
        return u\DB::update(self::TABLE_NAME, ' WHERE rowid = ' . $iRowID, ['valid' => self::STATUS_UNVALID]);
    }

    /**
     * 添加一个新的帐号。
     * @param string $sName 帐号名称。
     * @param string $sURL 帐号的URL。
     * @return int
     */
    public function addAccount($sName, $sURL)
    {
        $sSQLCheck = 'SELECT rowid FROM ' . self::TABLE_NAME;
        $sSQLCheck .= ' WHERE name=? AND parent=0 AND valid=' . self::STATUS_UNVALID . ' LIMIT 1';
        $aResult = u\DB::getOne($sSQLCheck, [$sName]);

        if ($aResult) {
            $iRowID = $aResult['rowid'];
            $aData = [
                'valid' => self::STATUS_VALID,
            ];
            u\DB::update(self::TABLE_NAME, 'WHERE rowid = ' . $iRowID, $aData);
            return $iRowID;
        }

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
            'name' => gzdeflate(base64_encode($sName), self::COMPRESS_LEVEL),
            'value' => gzdeflate($this->encrypt($sValue), self::COMPRESS_LEVEL),
            'parent' => $iAccountID,
            'valid' => self::STATUS_VALID
        ];

        return u\DB::add($aData, self::TABLE_NAME);
    }

    /**
     * 可以是帐号。
     * @param string $sName 名称。
     * @param string $sValue 值。
     * @param int $iRowID 主键。
     * @return bool
     */
    public function updateAccount($sName, $sValue, $iRowID, $bEncrypt = true)
    {
        $aData = [
            'name' => $sName,
            'value' => $sValue
        ];
        return u\DB::update(self::TABLE_NAME, 'WHERE rowid = ' . $iRowID, $aData);
    }

    /**
     * 更新一个帐号的属性。
     * @param string $sName 名称。
     * @param string $sValue 值。
     * @param int $iRowID 主键。
     * @return bool
     */
    public function updateField($sName, $sValue, $iRowID, $bEncrypt = true)
    {
        $name= $bEncrypt ? base64_encode($sName) : $sName;
        $value = $bEncrypt ? $this->encrypt($sValue) : $sValue;
        $aData = [
            'name' => gzdeflate($name, self::COMPRESS_LEVEL),
            'value' => gzdeflate($value, self::COMPRESS_LEVEL)
        ];
        return u\DB::update(self::TABLE_NAME, 'WHERE rowid = ' . $iRowID, $aData);
    }

    /**
     * 获得账号总数。
     * @return int
     */
    public function getTotal()
    {
        $sSQL = 'SELECT count(*) as total FROM ' . self::TABLE_NAME;
        $sSQL .= ' WHERE valid=' . self::STATUS_VALID . ' AND parent=0 Limit 1';
        $aResult = u\DB::getOne($sSQL);
        $mResult = ($aResult === false) ? false : $aResult['total'];
        return $mResult;
    }

    /**
     * 创建表结构。
     */
    public function createTable()
    {
        $sSQL = 'create table account (name text, value text, parent interger, valid interger)';
        u\DB::query($sSQL);
    }

    /**
     * 加密。
     * @param string $p_sString 待加密的字符串。
     * @return string
     */
    public function encrypt($p_sString)
    {
        $sTmp1 = u\Str::utf8Strrev($p_sString);
        $sTmp2 = u\Str::strSplit($sTmp1);
        $sTmp3 = '';

        foreach ($sTmp2 as $sChar) {
            $sTmp3 .= $sChar;
            $sTmp3 .= u\Str::random(1);
        }

        $sPrefix = u\Str::random(self::ENCRYPT_SALT_PREFIX_LENGTH);
        $sSuffix = u\Str::random(self::ENCRYPT_SALT_SUFFIX_LENGTH);
        $sResult = base64_encode($sPrefix . $sTmp3 . $sSuffix);

        return $sResult;
    }

    /**
     * 解密。
     * @param string $p_sString 待解密的字符串。
     * @return string
     */
    public function decrypt($p_sString)
    {
        $sTmp1 = base64_decode($p_sString);
        $sTmp2 = substr($sTmp1, self::ENCRYPT_SALT_PREFIX_LENGTH, -self::ENCRYPT_SALT_SUFFIX_LENGTH);
        $aTmp3 = u\Str::strSplit($sTmp2);
        $iLen = count($aTmp3);
        $sTmp4 = '';

        for ($i = 0; $i <= $iLen; $i += 2) {
            if (isset($aTmp3[$i])) {
                $sTmp4 .= $aTmp3[$i];
            }
        }

        $sResult = u\Str::utf8Strrev($sTmp4);

        return $sResult;
    }
}

# end of this file
