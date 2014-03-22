<?php
/**
 * 响应前端文件请求。
 */
namespace core;

class Front
{

    /**
     * 处理前端文件请求。
     * @param string $sPath 前端文件所在路径。
     * @param int $iPrefixLength 前端文件在URL中前缀的长度。
     */
    public static function handle($sPath, $iPrefixLength)
    {
        $sURI = $_SERVER['REQUEST_URI'];
        $sURL = 'http://' . $_SERVER['HTTP_HOST'] . $sURI;
        $aURLDetail = parse_url($sURI);
        $sRealPath = $sPath . substr($aURLDetail['path'], $iPrefixLength);
        $aPathDetail = pathinfo($sRealPath);
        $sMimeType = self::getMimeTypes($aPathDetail['extension']);
        header('Content-Type: ' . $sMimeType);
        readfile($sRealPath);
    }

    /**
     * 取得文件的mime type
     * @param string $sExt 文件扩展名。不包含"."
     * @return string
     */
    private static function getMimeTypes($sExt)
    {
        $aMimeMap = [
            'js' => 'application/x-javascript',
            'css' => 'text/css',
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'swf' => 'application/x-shockwave-flash'
        ];

        if (isset($aMimeMap[$sExt])) {
            return $aMimeMap[$sExt];
        } else {
            return '';
        }
    }
}

# end of this file
