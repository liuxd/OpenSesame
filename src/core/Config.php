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
namespace core;

class Config
{
    public static $aConfig = [];

    /**
     * 获得配置项。
     * @param string $sKey
     * @return array
     */
    public static function get($sKey)
    {
        self::$aConfig = [
            'result' => false,
            'msg' => '',
            'data' => []
        ];

        $sConfigFile = realpath('./') . DS . 'config.ini';

        if (!is_readable($sConfigFile)) {
            $sConfigFile = realpath('./') . DS . 'config-dev.ini';
        }

        if (!is_readable($sConfigFile)) {
            self::$aConfig['msg'] = "配置文件不存在：" . $sConfigFile;
            return self::$aConfig;
        }

        $aConfigInfo = parse_ini_file($sConfigFile, true);

        if (!isset($aConfigInfo[$key])) {
            self::$aConfig['msg'] = "配置项不存在：" . $sKey;
            return self::$aConfig;
        }

        self::$aConfig = [
            'result' => true,
            'msg' => '',
            'data' => $aConfigInfo[$sKey]
        ];

        return self::$aConfig;
    }
}

# end of this file
