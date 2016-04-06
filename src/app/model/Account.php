<?php
namespace model;

use util as u;
use core as c;

class Account
{
    const TABLE_NAME = 'account';
    const STATUS_VALID = 1;
    const STATUS_UNVALID = 0;
    const COMPRESS_LEVEL = 9;

    public static $sSecretKey = '';

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
            AND parent = 0
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
     * AES算法加密。
     * @param string $sData
     * @return string
     */
    public function encrypt($sData)
    {
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, self::$sSecretKey, $iv);
        $encrypted = mcrypt_generic($td, $sData);
        mcrypt_generic_deinit($td);

        return $iv . $encrypted;
    }

    /**
     * AES算法解密。
     * @param string $sData
     * @return string
     */
    public function decrypt($sData)
    {
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
        $iv = mb_substr($sData, 0, 32, 'latin1');
        mcrypt_generic_init($td, self::$sSecretKey, $iv);
        $data = mb_substr($sData, 32, mb_strlen($sData, 'latin1'), 'latin1');
        $data = mdecrypt_generic($td, $data);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);

        return trim($data);
    }
}

# end of this file
