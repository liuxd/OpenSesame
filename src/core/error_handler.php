<?php
/**
 * 自定义错误处理函数。
 * @param int $errno 错误代码
 * @param string $errstr 错误提示
 * @param string $errfile 发生错误文件
 * @param int $errline 发生错误的行号
 * @return null
 */

function err($errno, $errstr, $errfile, $errline) {
    $msg[] = '编号： ' . $errno . PHP_EOL;
    $msg[] = '提示：' . strip_tags($errstr) . PHP_EOL;
    $msg[] = '文件：' . $errfile . PHP_EOL;
    $msg[] = '行号：' . $errline . PHP_EOL;
    $msg[] = '时间：' . date('Y-m-d H:i:s') . PHP_EOL;

    if (isset($_SERVER['REQUEST_URI'])) {
        $msg[] = '请求：' . $_SERVER['REQUEST_URI'] . PHP_EOL;
    }

    header('Content-type: text/html; charset=utf-8'); 

    foreach ($msg as $m){
        echo '<div style="color: red"><b>', $m, '</b></div>';
    }

    error_log('|'.implode('|', $msg).PHP_EOL, 3, '/tmp/open-sesame.err.log');
}

# 设置自定义错误处理函数
set_error_handler('err');

# end of this file
