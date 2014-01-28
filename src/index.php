<?php
/**
 * 框架入口。
 */
use system as s;

require __DIR__ . '/system/init.inc';

$www = substr($_SERVER['REQUEST_URI'], 0, 8);

if ($www === '/static/') {
    s\FrontEnd::handle(WWW_PATH, 8);
} else {
    s\CGI::run(s\Router::route());
}

# end of this file
