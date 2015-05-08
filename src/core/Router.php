<?php
/**
 * Router.
 */
namespace core;

use controller;

class Router
{
    /**
     * Generate URL.
     * @param string $sAction The request's action
     * @param array $aParams URL params.
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
     * Page redirection.
     * @param string $sURL Target URL.
     * @param int $iStatusCode HTTP code.
     */
    public static function redirect($sURL, $iStatusCode = 0)
    {
        if ($iStatusCode) {
            header('Location:' . $sURL, true, $iStatusCode);
        } else {
            header('Location:' . $sURL);
        }

        exit;
    }

    /**
     * URL parser.
     * @param string $sURI The request uri.
     * @param string $sAppPath The application's path.
     * @param string $sStatic The front end file's url parameter name.
     */
    public static function route($sURI, $sAppPath, $sStaticName = 'static')
    {
        if (isset($_GET[$sStaticName])) {
            $sFile = WWW_PATH . $_GET[$sStaticName];
            $aFileInfo = pathinfo($sFile);
            self::sendMimeType($aFileInfo['extension']);
            readFile($sFile);
            return false;
        }

        $aTmp = explode('/', $sURI);
        $sAction = ($aTmp[1] && $aTmp[1]{0} !== '?') ? $aTmp[1] : 'Home';
        $sControllerName = 'controller\\' . $sAction;
        $sControllerFile = $sAppPath . str_replace('\\', '/', $sControllerName) . '.php';

        if (file_exists($sControllerFile)) {
            require $sControllerFile;
        } else {
            $sControllerFile = $sAppPath . 'controller/NotFound.php';
            require $sControllerFile;
            $sControllerName = 'controller\\NotFound';
        }

        return new $sControllerName;
    }

    /**
     * Send mime type according to the file extension name.
     * @param string $sFileExt The extension name of this static file.
     */
    public static function sendMimeType($sFileExt)
    {
        $aMimeTypeList = [
            'js' => 'text/javascript',
            'css' => 'text/css',
            'jpg' => 'image/jpeg',
            'png' => 'image/x-png',
            'swf' => 'application/x-shockwave-flash'
        ];

        $sMimeType = $aMimeTypeList[$sFileExt];
        header('Content-Type:' . $sMimeType);
    }
}

# end of this file
