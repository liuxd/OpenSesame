<?php
/**
 * 框架入口。
 */
require __DIR__ . '/system/init.inc';

$www = substr($_SERVER['REQUEST_URI'], 0, 8);

if ($www === '/static/') {
    FrontEnd::handle(WWW_PATH, 8);
} else {
    CGI::run(Router::route());
}

# end of this file
