<?php
/**
 * 作为CGI时的处理逻辑。
 */
namespace system;

use stdClass;

class CGI
{

    public static function run(stdClass $o)
    {
        switch ($o->op_type) {
            case Router::OP_PAGE:self::pageHandler($o);
                break;

            case Router::OP_FORM:self::formHandler($o);
                break;

            case Router::OP_AJAX:self::ajaxHandler($o);
                break;
        }

        return fastcgi_finish_request();
    }

    //页面请求处理
    private static function pageHandler(stdClass $o)
    {
        extract($o->ret);

        $o->tpls = [
            'header' => 'header.tpl',
            'body' => $o->op . '.tpl',
            'footer' => 'footer.tpl',
        ];

        if (isset($header)) {
            $o->tpls['header'] = $header;
        }

        if (isset($footer)) {
            $o->tpls['footer'] = $footer;
        }

        ob_start('ob_gzhandler');

        foreach ($o->tpls as $key => $tpl_file) {
            $real_file = $o->tpl_path . DS . strtolower($tpl_file);

            if (is_file($real_file) && file_exists($real_file)) {
                require $real_file;
            }
        }
    }

    //表单请求处理
    private static function formHandler(stdClass $o)
    {
        $op = $o->ret['op'];
        $params = (isset($o->ret['params'])) ? $o->ret['params'] : [];
        $url = Router::genURL($op, Router::OP_PAGE, $params);
        Router::redirect($url);
    }

    //ajax请求
    private static function ajaxHandler(stdClass $o)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($o->ret);

        return array();
    }
}

# end of this file
