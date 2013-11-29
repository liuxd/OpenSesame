<?php
/**
 * 各种格式的数据转换为数组。
 * @author liuxd
 */
class Sth2arr {
    /**
     * json字符串转换成数组。
     *
     * @param string $json
     * @return array
     */
    public static function json2arr ($json) {
        return json_decode($json, true);
    }

    /**
     * 文本文件转成数组。
     * 
     * @param string $filename 文件路径
     * @return array
     */
    public static function file2arr ($filename) {
        return file($filename);
    }

    /**
     * ini文件转成数组。 
     *
     * @param string $ini_file
     * @return array
     */
    public static function ini2arr ($ini_file){
        return parse_ini_file($ini_file, true);
    }

    /**
     * xml转成数组。
     *
     * @param string $xml
     * @return array
     */
    public static function xml2arr ($xml){
        return (array) simplexml_load_string($xml);
    }
}

# end of this file
