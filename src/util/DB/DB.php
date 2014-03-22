<?php
/**
 * 一个简单的PDO封装。
 * @author liuxd
 */

namespace util;

use PDO;

class DB
{

    public static $oDB = null;

    /**
     * 连接数据库
     * @param string $sDSN
     * @param string $sUserName
     * @param string $sPassword
     * @param array $aOptions
     * @return PDO
     */
    public static function getInstance($sDSN, $sUserName= '', $sPassword= '', $aOptions = [])
    {
        if (is_null(self::$db)) {
            self::$oDB = new PDO($sDSN, $sUserName, $sPassword, $aOptions);
            self::$oDB->query('set names utf8');
            self::$oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$oDB;
    }

    /**
     * 查询一个列表的数据。
     * @param string $sSQL
     * @param array $aParams
     * @return array 
     */
    public static function getList($sSQL, $aParams = [])
    {
        $o = self::$oDB->prepare($sSQL);
        $o->execute($aParams);
        return $o->fetchall(PDO::FETCH_ASSOC);
    }

    /**
     * 插入数据。
     * @param array $aData
     * @param string $sTable
     * @return int
     */
    public static function add($aData, $sTable)
    {
        $aParsedData = self::parseArray($aData);
        $sSQL = "insert into $sTable (" . $aParsedData['keys'] . ") values (" . $aParsedData['marks'] . ")";
        $o = self::$oDB->prepare($sSQL);
        $o->execute($aParsedData['values']);
        return self::$oDB->lastInsertId();
    }

    /**
     * 获得单条数据。
     * @param string $sSQL
     * @param array $aParams
     * @return array 
     */
    public static function getOne($sSQL, $aParams = [])
    {
        $o = self::$oDB->prepare($sSQL);
        $o->execute($aParams);
        return $o->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * 更新数据。
     * @param string $sTable
     * @param string $sWhere
     * @param array $aData
     * @return bool
     */
    public static function update($sTable, $sWhere, $aData)
    {
        $aTmp = [];

        foreach ($aData as $key => $value) {
            $aTmp[] = "$key=$value";
        }

        $skeys = implode(',', $aTmp);
        $sSQL = "update $sTable set $sKeys $sWhere";
        return self::$oDB->exec($sSQL);
    }

    /**
     * 导入指定sql文件。
     * @param string $sFile
     * @return bool
     */
    public static function import($sFile)
    {
        return self::$oDB->exec(file_get_contents($sFile));
    }

    /**
     * 执行SQL语句。
     * @param string sSQL
     * @return bool
     */
    public static function query($sSQL)
    {
        return self::$oDB->query($sSQL);
    }

    /**
     * 解析插入数据时的数组。
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
