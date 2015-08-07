<?php
/**
 * DB controller.
 */

namespace util;

use PDO;

class DB
{

    private static $oCurrentDB = null;
    private static $aPool = [];

    /**
     * Connect to database.
     * @param string $sDSN
     * @param string $sUserName
     * @param string $sPassword
     * @param array $aOptions
     * @param string $sName
     * @return PDO
     */
    public static function connect($sDSN = '', $sUserName = '', $sPassword = '', $aOptions = [], $sName = 'default')
    {
        $connetDB = function () use ($sDSN, $sUserName, $sPassword, $aOptions) {
            $oDB = new PDO($sDSN, $sUserName, $sPassword, $aOptions);
            $oDB->query('set names utf8');
            $oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (!empty($aOptions)) {
                foreach ($aOptions as $sKey => $sValue) {
                    $oDB->setAttribute($sKey, $sValue);
                }
            }

            return $oDB;
        };

        if (!isset(self::$aPool[$sName])) {
            $oDB = $connetDB();
            self::$aPool[$sName] = $oDB;
        }

        self::$oCurrentDB = self::$aPool[$sName];
        return self::$oCurrentDB;
    }

    /**
     * Switch to another DB.
     * @param string $sName The connection name you set.
     * @return PDO or false
     */
    public static function switchDB($sName)
    {
        if (!isset(self::$aPool[$sName])) {
            return false;
        } else {
            self::$oCurrentDB = self::$aPool[$sName];
            return self::$oCurrentDB;
        }
    }

    /**
     * Get list.
     * @param string $sSQL
     * @param array $aParams
     * @return array
     */
    public static function getList($sSQL, $aParams = [])
    {
        $o = self::$oCurrentDB->prepare($sSQL);
        $o->execute($aParams);
        return $o->fetchall(PDO::FETCH_ASSOC);
    }

    /**
     * Insert a record.
     * @param array $aData
     * @param string $sTable
     * @return int
     */
    public static function add($aData, $sTable)
    {
        $aParsedData = self::parseArray($aData);
        $sSQL = "insert into $sTable (" . $aParsedData['keys'] . ") values (" . $aParsedData['marks'] . ")";
        $o = self::$oCurrentDB->prepare($sSQL);
        $o->execute($aParsedData['values']);
        return self::$oCurrentDB->lastInsertId();
    }

    /**
     * Get one record.
     * @param string $sSQL
     * @param array $aParams
     * @return array
     */
    public static function getOne($sSQL, $aParams = [])
    {
        try {
            $o = self::$oCurrentDB->prepare($sSQL);
        } catch (\Exception $e) {
            return false;
        }

        $o->execute($aParams);
        return $o->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update data.
     * @param string $sTable
     * @param string $sWhere
     * @param array $aData
     * @return bool
     */
    public static function update($sTable, $sWhere, $aData)
    {
        $aTmp = [];

        foreach ($aData as $key => $value) {
            $aTmp[] = "$key=?";
        }

        $sKeys = implode(',', $aTmp);
        $sSQL = "update $sTable set $sKeys $sWhere";
        $aParsedData = self::parseArray($aData);
        $o = self::$oCurrentDB->prepare($sSQL);
        return $o->execute($aParsedData['values']);
    }

    /**
     * Import sql file.
     * @param string $sFile
     * @return bool
     */
    public static function import($sFile)
    {
        return self::$oCurrentDB->exec(file_get_contents($sFile));
    }

    /**
     * Excute a sql.
     * @param string sSQL
     * @return bool
     */
    public static function query($sSQL)
    {
        return self::$oCurrentDB->query($sSQL);
    }

    /**
     * Parse data inserted.
     * @param array $aData
     * @return type
     */
    private static function parseArray($aData)
    {
        $sKeysOrigin = array_map(function ($v) {
                return "`$v`";
        }, array_keys($aData));

        $sKeys = implode(',', $sKeysOrigin);
        $sMarks = implode(',', array_fill(0, count($sKeysOrigin), '?'));
        $aValues = array_values($aData);

        return [
            'keys' => $sKeys,
            'marks' => $sMarks,
            'values' => $aValues
        ];
    }
}

# end of this file
