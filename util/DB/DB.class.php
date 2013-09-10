<?php

class DB {

    public static $db = null;

    public static function get_instance($dsn, $username, $password, $options = array()) {
        if (is_null(self::$db)){
            self::$db = new PDO($dsn, $username, $password, $options);
        }

        return self::$db;
    }

    public static function get_list($sql, $p = array()) {
        $dbh = self::$db->prepare($sql);
        $dbh->execute($p);
        $ret = $dbh->fetchall(PDO::FETCH_ASSOC);

        return $ret;
    }

    public static function add($info, $table) {
        $ret = self::parse_arr($info);
        $sql = "insert into $table (" . $ret['keys'] . ") values (" . $ret['marks'] . ")";
        $dbh = self::$db->prepare($sql);
        $dbh->execute($ret['values']);
        $id = self::$db->lastInsertId();

        return $id;
    }

    public static function get_one($sql, $p = array()) {
        $dbh = self::$db->prepare($sql);
        $dbh->execute($p);
        $ret = $dbh->fetch(PDO::FETCH_ASSOC);

        return $ret;
    }

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