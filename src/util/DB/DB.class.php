<?php
/**
 * 封装RDBMS的访问操作。
 */

class DB {

    public static $db = null;

    /**
     * 连接数据库
     * @param type $dsn
     * @param type $username
     * @param type $password
     * @param type $options
     * @return PDO
     */
    public static function get_instance($dsn, $username, $password, $options = array()) {
        if (is_null(self::$db)){
            self::$db = new PDO($dsn, $username, $password, $options);
            self::$db->query('set names utf8');
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$db;
    }

    /**
     * 查询一个列表的数据。
     * @param type $sql
     * @param type $p
     * @return type
     */
    public static function get_list($sql, $p = array()) {
        $dbh = self::$db->prepare($sql);
        $dbh->execute($p);
        $ret = $dbh->fetchall(PDO::FETCH_ASSOC);

        return $ret;
    }

    /**
     * 插入数据。
     * @param type $info
     * @param type $table
     * @return type
     */
    public static function add($info, $table) {
        $ret = self::parse_arr($info);
        $sql = "insert into $table (" . $ret['keys'] . ") values (" . $ret['marks'] . ")";
        $dbh = self::$db->prepare($sql);
        $dbh->execute($ret['values']);
        $id = self::$db->lastInsertId();

        return $id;
    }

    /**
     * 获得单条数据。
     * @param type $sql
     * @param type $p
     * @return type
     */
    public static function get_one($sql, $p = array()) {
        $dbh = self::$db->prepare($sql);
        $dbh->execute($p);
        $ret = $dbh->fetch(PDO::FETCH_ASSOC);

        return $ret;
    }

    /**
     * 更新数据。
     * @param type $table
     * @param type $where
     * @param type $info
     * @return type
     */
    public static function update($table, $where, $info) {
        $tmp = array();
        foreach ($info as $key => $value) {
            $tmp[] = "$key=$value";
        }

        $keys = implode(',', $tmp);
        $sql = "update $table set $keys $where";
        $ret = self::$db->exec($sql);

        return $ret;
    }

    /**
     * 解析插入数据时的数组。
     * @param type $info
     * @return type
     */
    private static function parse_arr($info) {
        //keys
        $keys_origin = array_map(function($v) {
                return "`$v`";
            }, array_keys($info));

        $keys = implode(',', $keys_origin);

        //marks
        $marks = implode(',', array_fill(0, count($keys_origin), '?'));

        //values
        $values = array_values($info);
        $ret = array(
            'keys' => $keys,
            'marks' => $marks,
            'values' => $values
        );

        return $ret;
    }

}

# end of this file