<?php
/**
 * 配置信息管理。
 * 接口规范：所有对外接口统一格式：
 * [
 *     'result' => false, //接口执行是否成功。
 *     'msg' => '', //接口执行失败的原因。
 *     'data' => [], //接口返回数据。
 * ];
 */
namespace system;

class Config
{
    public static $ret = [];

    /**
     * 获得配置项。
     * @param string $key
     */
    public static function get($key)
    {
        self::$ret = [
            'result' => false,
            'msg' => '',
            'data' => []
        ];

        $config_file = realpath('./') . DS . 'config.ini';

        if (!is_readable($config_file)) {
            $config_file = realpath('./') . DS . 'config-dev.ini';
        }

        if (!is_readable($config_file)) {
            self::$ret['msg'] = "配置文件不存在：" . $config_file;
            return self::$ret;
        }

        $config_info = parse_ini_file($config_file, true);

        if (!isset($config_info[$key])) {
            self::$ret['msg'] = "配置项不存在：" . $key;
            return self::$ret;
        }

        self::$ret = [
            'result' => true,
            'msg' => '',
            'data' => $config_info[$key]
        ];

        return self::$ret;
    }
}

# end of this file
