<?php
/**
 * 入口文件
 */

use system as s;

require __DIR__ . '/system/init.inc';

if (substr($_SERVER['REQUEST_URI'], 0, 8) === '/static/') {
    s\FrontEnd::handle(WWW_PATH, 8);
} else {
    s\CGI::run(s\Router::route());
}

# end of this file
