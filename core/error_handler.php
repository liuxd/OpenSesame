<?php
/**
 * 自定义错误处理函数。
 * @param int $errno 错误代码
 * @param string $errstr 错误提示
 * @param string $errfile 发生错误文件
 * @param int $errline 发生错误的行号
 * @return null
 */
defined('ROOT_PATH') or die('Visit unavailable!');

function err($errno, $errstr, $errfile, $errline) {
    $msg = 'errno       : ' . $errno . PHP_EOL;
    $msg .= 'errstr      : ' . strip_tags($errstr) . PHP_EOL;
    $msg .= 'errfile     : ' . $errfile . PHP_EOL;
    $msg .= 'errline     : ' . $errline . PHP_EOL;
    $msg .= 'time        : ' . date('Y-m-d H:i:s') . PHP_EOL;

    if (isset($_SERVER['REQUEST_URI'])) {
        $msg .= 'request_url : ' . $_SERVER['REQUEST_URI'] . PHP_EOL;
    }

    see(explode(PHP_EOL, substr($msg, 0, -1)));
    error_log($msg . PHP_EOL, 3, '/tmp/bh-account.err');
    exit;
}

# 设置自定义错误处理函数
set_error_handler('err');

# end of this file
