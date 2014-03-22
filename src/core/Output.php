<?php
/**
 * 数据输出处理。
 */
namespace core;

class Output
{

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
        }

        fastcgi_finish_request();
    }

    /**
     * 页面请求处理
     * @param array $aData
     */
    private static function htmlHandler($aData)
    {
        extract($aData['data']);

        foreach ($aData['html'] as $sHtml) {
            if (!file_exists(APP_PATH . 'view' . DS . $sHtml)) {
                trigger_error('页面模板未找到：' . $sHtml);
            }

            require APP_PATH . 'view' . DS . $sHtml;
        }
    }

    /**
     * 输出json。
     * @param array $aData  待输出数据。
     */
    private static function ajaxHandler($aData)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($aData['data']);
    }
}

# end of this file
