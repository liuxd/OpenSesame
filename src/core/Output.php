<?php
/**
 * 数据输出处理。
 */
namespace core;

class Output
{
    const TYPE_HTML = 'html';
    const TYPE_JSON = 'json';

    /**
     * 处理输出的主方法。
     * @param array $data 输出的原始数据。
     * @param string $type 输出的格式。
     */
    public static function handle($aData, $sType = 'html')
    {
        $sHandlerName = $sType . 'Handler';

        if (method_exists(__CLASS__, $sHandlerName)) {
            self::$sHandlerName($aData);
        } else {
            trigger_error('非法输出格式：' . $sType);
        }

        if (php_sapi_name() === 'cgi-fcgi') {
            fastcgi_finish_request();
        }
    }

    /**
     * 页面请求处理
     * @param array $aData
     */
    private static function htmlHandler($aData)
    {
        extract($aData['data']);

        foreach ($aData[self::TYPE_HTML] as $sHtml) {
            $sHtmlPath = APP_PATH . 'view' . DS . $sHtml . '.html';

            if (file_exists($sHtmlPath)) {
                require $sHtmlPath;
            }

        }
    }

    /**
     * 输出json。
     * @param array $aData  待输出数据。
     */
    private static function jsonHandler($aData)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($aData['data']);
    }
}

# end of this file
