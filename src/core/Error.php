<?php
/**
 * 错误处理
 */

/**
 * 自定义错误处理函数。
 *
 * @param int $errno 错误代码
 * @param string $errstr 错误提示
 * @param string $errfile 发生错误文件
 * @param int $errline 发生错误的行号
 * @return null
 */
function err($iError, $sErrStr, $sErrFile, $sErrLine)
{
    $aMsg[] = '编号： ' . $iError. PHP_EOL;
    $aMsg[] = '提示：' . strip_tags($sErrStr) . PHP_EOL;
    $aMsg[] = '文件：' . $sErrFile. PHP_EOL;
    $aMsg[] = '行号：' . $sErrLine. PHP_EOL;
    $aMsg[] = '时间：' . date('Y-m-d H:i:s') . PHP_EOL;

    if (php_sapi_name() !== 'cli') {
        $aMsg[] = '请求：' . $_SERVER['REQUEST_URI'] . PHP_EOL;
        header('Content-type: text/html; charset=utf-8');

        foreach ($aMsg as $m) {
            echo '<div style="color: red"><b>', $m, '</b></div>';
        }
    } else {
        foreach ($aMsg as $m) {
            echo $m;
        }
    }

    die;
}

# end of this file
