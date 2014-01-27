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
class Config
{

    public static $app;
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

        if (!isset(self::$app)) {
            self::$ret['msg'] = 'App unconfigured!';
            return self::$ret;
        }

        $config_file = '/tmp/' . self::$app . '.ini';

        if (!is_readable($config_file)) {
            $config_file = INI_PATH . self::$app . '.ini';
        }

        if (!file_exists($config_file)) {
            self::$ret['msg'] = "Config file doesn't exist!";
            return self::$ret;
        }

        $config_info = parse_ini_file($config_file, true);

        if (!isset($config_info[$key])) {
            self::$ret['msg'] = "Config option doesn't exist!";
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
