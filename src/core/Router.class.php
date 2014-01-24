<?php
/**
 * 路由操作。实现URL地址与解析与封装。
 */

class Router
{

    const OP_PAGE = 1;
    const OP_FORM = 2;
    const OP_AJAX = 3;

    public static $app = '';
    private static $is_default = FALSE;

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
            self::$is_default = TRUE;
        }

        return self::$app;
    }

    /**
     * 获得动作文件的类型。可能的类型：1=页面请求，2=表单请求，3=ajax请求。
     * @return int
     */
    public static function op_type()
    {
        $type = (int) self::get('type');
        $type_list = [
            self::OP_PAGE,
            self::OP_FORM,
            self::OP_AJAX,
        ];

        if (!in_array($type, $type_list) or empty($type)) {
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
        $op = self::get('op');
        $r = (empty($op)) ? $default_op : $op;

        return $r;
    }

    /**
     * 获得URL中的参数。
     * @param string $name 参数名。默认为空。为空的情况下返回全部URL参数，否则返回指定参数的值。
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
    public static function gen_url($op, $type = FALSE, $params = [])
    {
        if (!self::$is_default) {
            $params['app'] = self::$app;
        }

        if ($type and $type !== self::OP_PAGE) {
            $params['type'] = $type;
        }

        $params['op'] = $op;
        array_map(function($v) {
                    return urlencode($v);
                }, $params);
        $url = '?' . http_build_query($params);

        return $url;
    }

    /**
     * 获得操作类的类名。
     * @params int $op_type 控制器类型。
     * @return string
     */
    public static function get_op_class_name($op_type)
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
            header('Location:' . $url, TRUE, $status_code);
        } else {
            header('Location:' . $url);
        }

        return;
    }

}

# end of this file
