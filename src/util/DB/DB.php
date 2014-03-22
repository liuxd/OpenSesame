<?php
/**
 * 一个简单的PDO封装。
 * @author liuxd
 */

namespace util;

use PDO;

class DB
{

    public static $db = null;

    /**
     * 连接数据库
     * @param string $dsn
     * @param string $username
     * @param string $password
     * @param array $options
     * @return PDO
     */
    public static function getInstance($dsn, $username = '', $password = '', $options = [])
    {
        if (is_null(self::$db)) {
            self::$db = new PDO($dsn, $username, $password, $options);
            self::$db->query('set names utf8');
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$db;
    }

    /**
     * 查询一个列表的数据。
     * @param string $sql
     * @param array $p
     * @return array 
     */
    public static function getList($sql, $p = [])
    {
        $dbh = self::$db->prepare($sql);
        $dbh->execute($p);
        $ret = $dbh->fetchall(PDO::FETCH_ASSOC);

        return $ret;
    }

    /**
     * 插入数据。
     * @param array $info
     * @param string $table
     * @return int
     */
    public static function add($info, $table)
    {
        $ret = self::parseArray($info);
        $sql = "insert into $table (" . $ret['keys'] . ") values (" . $ret['marks'] . ")";
        $dbh = self::$db->prepare($sql);
        $dbh->execute($ret['values']);
        $id = self::$db->lastInsertId();

        return $id;
    }

    /**
     * 获得单条数据。
     * @param string $sql
     * @param array $p
     * @return array 
     */
    public static function getOne($sql, $p = [])
    {
        $dbh = self::$db->prepare($sql);
        $dbh->execute($p);
        $ret = $dbh->fetch(PDO::FETCH_ASSOC);

        return $ret;
    }

    /**
     * 更新数据。
     * @param string $table
     * @param string $where
     * @param array $info
     * @return bool
     */
    public static function update($table, $where, $info)
    {
        $tmp = [];

        foreach ($info as $key => $value) {
            $tmp[] = "$key=$value";
        }

        $keys = implode(',', $tmp);
        $sql = "update $table set $keys $where";
        $ret = self::$db->exec($sql);

        return $ret;
    }

    /**
     * 导入指定sql文件。
     * @param string $file
     * @return bool
     */
    public static function import($file)
    {
        $sql = file_get_contents($file);
        return self::$db->exec($sql);
    }

    /**
     * 解析插入数据时的数组。
     * @param array $info
     * @return type
     */
    private static function parseArray($info)
    {
        //keys
        $keys_origin = array_map(function ($v) {
                return "`$v`";
        }, array_keys($info));

        $keys = implode(',', $keys_origin);

        //marks
        $marks = implode(',', array_fill(0, count($keys_origin), '?'));

        //values
        $values = array_values($info);
        $ret = [
            'keys' => $keys,
            'marks' => $marks,
            'values' => $values
        ];

        return $ret;
    }
}

# end of this file
