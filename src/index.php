<?php
/**
 * 框架入口。
 * @author liuxd
 */

require __DIR__ . '/core/init.inc';

$www = substr($_SERVER['REQUEST_URI'], 0, 8);

if ($www === '/static/') {
    FrontEnd::handle(WWW_PATH, 8);
    die;
}

# 创建数据对象。保存响应请求过程中需要的各种参数。
$o = new stdClass;

# 解析URL。
# app
$o->app = Router::app(DEFAULT_APP);
$o->app_path = APP_PATH . $o->app;
is_dir($o->app_path) or die($msgs['APP_NOT_VALID']);

# op
$o->op = Router::op('index');
$o->op_type = Router::op_type();
$o->op_class_name = Router::get_op_class_name($o->op_type);
$o->op_file = $o->app_path . DS . $o->op_class_name . '.class.php';
file_exists($o->op_file) or die($msgs['OP_NOT_VALID']);

# tpl
$o->tpl_path = $o->app_path . DS . 'tpl';
file_exists($o->tpl_path) or die($msgs['TPL_NOT_VALID']);

# 执行动作代码。
require $o->app_path . DS . 'Base.class.php';
require $o->op_file;

$o->op_obj = new $o->op_class_name;
$o->ret_app = $o->op_obj->init();
$op_name = $o->op;
$o->ret_op = $o->op_obj->$op_name();
$o->ret = (is_array($o->ret_app)) ? array_merge($o->ret_app, $o->ret_op) : $o->ret_op;

# 根据请求类型进行不同的处理。
CGI::run($o);

# 销毁数据对象。释放资源。
unset($o);

# end of this file
