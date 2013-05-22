<?php
/**
 * 框架入口。
 * @author liuxd
 */

require __DIR__ . '/core/init.inc';

# 创建数据对象。保存响应请求过程中需要的各种参数。
$o = new stdClass;

# 解析URL。
$o->app = Router::app(DEFAULT_APP);
$o->app_path = APP_PATH . $o->app;
$o->op = Router::op('index');
$o->op_type = Router::op_type();
$o->op_class_name = Router::get_op_class_name($o->op_type);
$o->op_file = $o->app_path . DS . $o->op_class_name . '.class.php';
$o->tpl_path = $o->app_path . DS . 'tpl';

# 执行动作代码。
require $o->app_path . DS . 'Base.class.php';
require $o->op_file;

$o->op_obj = new $o->op_class_name;
$o->res_app = $o->op_obj->init();
$op_name = $o->op;
$o->res_op = $o->op_obj->$op_name();
$o->res = array_merge($o->res_app, $o->res_op);

# 根据请求类型进行不同的处理。
CGI::run($o);

# 销毁数据对象。释放资源。
unset($o);

# end of this file