<?php
/**
 * 路由操作。实现URL地址与解析与封装。
 */
namespace core;

use controller;

class Router
{
    /**
     * 拼装URL。
     * @param string $sAction 请求动作。
     * @param array $aParams 传递的参数。
     */
    public static function genURL($sAction, $aParams = [])
    {
        array_map(function ($v) {
            return urlencode($v);
        }, $aParams);

        $sURL = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $sAction . '/?' . http_build_query($aParams);

        return $sURL;
    }

    /**
     * 页面跳转。
     * @param string $sURL
     * @param int $iStatusCode
     */
    public static function redirect($sURL, $iStatusCode = 0)
    {
        if ($iStatusCode) {
            header('Location:' . $sURL, true, $iStatusCode);
        } else {
            header('Location:' . $sURL);
        }
    }

    /**
     * 解析URL。
     * @param string $sURI 请求的URI。
     * @param string $sAppPath 应用程序路径。
     */
    public static function route($sURI, $sAppPath)
    {
        $aTmp = explode('/', $sURI);
        $sAction = ($aTmp[1]) ? : 'Home';
        $sControllerName = 'controller\\' . $sAction;
        $sControllerFile = $sAppPath . str_replace('\\', '/', $sControllerName) . '.php';
        $aData = [];

        require APP_PATH . 'controller/Base.php';
        require $sControllerFile;

        return new $sControllerName;
    }
}

# end of this file
