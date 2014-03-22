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
    public static $aConfig = null;

    /**
     * 获得配置项。
     * @param string $sKey
     * @return array
     */
    public static function get($sKey)
    {
        $aResult = [
            'result' => false,
            'msg' => '',
            'data' => []
        ];

        $aConfigInfo = self::read();

        if (!isset($aConfigInfo[$sKey])) {
            $aResult['msg'] = "配置项不存在：" . $sKey;
            return $aResult;
        }

        $aResult = [
            'result' => true,
            'msg' => '',
            'data' => $aConfigInfo[$sKey]
        ];

        return $aResult;
    }

    private static function read()
    {
        if (!is_null(self::$aConfig)) {
            return self::$aConfig;
        }

        $sConfigFile = realpath('./') . DS . 'config.ini';

        if (!is_readable($sConfigFile)) {
            $sConfigFile = realpath('./') . DS . 'config-dev.ini';
        }

        if (!is_readable($sConfigFile)) {
            trigger_error("配置文件不存在：" . $sConfigFile);
        }

        self::$aConfig = parse_ini_file($sConfigFile, true);

        return self::$aConfig;
    }
}

# end of this file
