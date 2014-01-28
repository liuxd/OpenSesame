<?php
/**
 * 路由操作。实现URL地址与解析与封装。
 */
namespace system;

class Router
{

    const OP_PAGE = 1;
    const OP_FORM = 2;
    const OP_AJAX = 3;

    public static $app = '';
    private static $is_default = false;

    /**
     * 获得进入的app
     * @param string $default_app 默认的app。
     * @return string
     */
    public static function app($default = 'index')
    {
        if (self::get('app')) {
            self::$app = self::get('app');
        } else {
            self::$app = $default;
            self::$is_default = true;
        }

        return self::$app;
    }

    /**
     * 获得动作文件的类型。可能的类型：1=页面请求，2=表单请求，3=ajax请求。
     * @return int
     */
    public static function opType()
    {
        $type = (int) self::get('type');
        $type_list = [
            self::OP_PAGE,
            self::OP_FORM,
            self::OP_AJAX,
        ];

        if (!in_array($type, $type_list) || empty($type)) {
            return self::OP_PAGE;
        } else {
            return $type;
        }
    }

    /**
     * 获得具体的动作。具体响应请求的代码目标，可能一个类，也可能是方法。
     * @param string $default_op 默认页面。
     * @return string
     */
    public static function op($default_op)
    {
        $info = parse_url($_SERVER['REQUEST_URI']);
        $r = ($info['path'] === '/') ? $default_op : trim($info['path'], '/');

        return $r;
    }

    /**
     * 获得URL中的参数。
     * @param string $name 参数名。默认为空。
     * @param unknown $default 指定参数名时，该参数的默认值。
     * @return array or mix
     */
    public static function get($name = '', $default = '')
    {
        if (isset($name[1])) {
            return (isset($_GET[$name])) ? $_GET[$name] : $default;
        }

        $r = [];
        $framework_url_param = ['app', 'type', 'op'];

        foreach ($_GET as $k => $v) {
            if (!in_array($k, $framework_url_param)) {
                $r[$k] = $v;
            }
        }

        return $r;
    }

    /**
     * 分装URL。
     * @param string $app 应用模块。
     * @param int $type 请求类型。
     * @param string $op 请求动作。
     * @param array $params 传递的参数。
     */
    public static function genURL($op, $type = false, $params = [])
    {
        if (!self::$is_default) {
            $params['app'] = self::$app;
        }

        if ($type && $type !== self::OP_PAGE) {
            $params['type'] = $type;
        }

        array_map(function ($v) {
            return urlencode($v);
        }, $params);

        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $op . '/?' . http_build_query($params);

        return $url;
    }

    /**
     * 获得操作类的类名。
     * @params int $op_type 控制器类型。
     * @return string
     */
    public static function getOpClassName($op_type)
    {
        $type_list = [
            self::OP_PAGE => 'Page',
            self::OP_FORM => 'Form',
            self::OP_AJAX => 'Ajax',
        ];

        $class_name = ($type_list[$op_type]) ? $type_list[$op_type] : 'Page';

        return $class_name;
    }

    /**
     * 页面跳转。
     * @param string $url
     * @param int status_code
     * @return
     */
    public static function redirect($url, $status_code = null)
    {
        if ($status_code) {
            header('Location:' . $url, true, $status_code);
        } else {
            header('Location:' . $url);
        }

        return;
    }

    /**
     * 解析URL
     * @return stdClass
     */
    public static function route()
    {
        $o = new stdClass;
        $o->app = self::app(DEFAULT_APP);
        $o->app_path = APP_PATH . $o->app;

        $o->op = self::op('index');
        $o->op_type = self::opType();
        $o->op_class_name = self::getOpClassName($o->op_type);
        $o->op_file = $o->app_path . DS . 'controller' . DS . $o->op_class_name . '.class.php';
        $o->tpl_path = $o->app_path . DS . 'view';

        require $o->app_path . DS . 'controller/Base.class.php';
        require $o->op_file;

        $o->op_obj = new $o->op_class_name;
        $o->ret_app = $o->op_obj->init();
        $op_name = $o->op;
        $o->ret_op = $o->op_obj->$op_name();
        $o->ret = (is_array($o->ret_app)) ? array_merge($o->ret_app, $o->ret_op) : $o->ret_op;

        return $o;
    }
}

# end of this file
