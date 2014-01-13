<?php
/**
 * 作为CGI时的处理逻辑。
 */

class CGI {

    public static function run(stdClass $o) {
        switch ($o->op_type) {
            case Router::OP_PAGE: //渲染页面。
                self::page_handler($o);
                break;

            case Router::OP_FORM: //表单处理。
                self::form_handler($o);
                break;

            case Router::OP_AJAX: //ajax请求。
                self::ajax_handler($o);
                break;

            default:break;
        }

        fastcgi_finish_request();
    }

    //页面请求处理
    private static function page_handler(stdClass $o) {
        extract($o->ret);

        $o->tpls = [
            'header' => 'header.tpl',
            'body' => $o->op . '.tpl',
            'footer' =>  'footer.tpl',
        ];

        if (isset($header)){
            $o->tpls['header'] = $header;
        }

        if (isset($footer)){
            $o->tpls['footer'] = $footer;
        }

        ob_start('ob_gzhandler');

        foreach ($o->tpls as $key => $tpl_file) {
            $real_file = $o->tpl_path . DS . $tpl_file;

            if (file_exists($real_file)){
                require $real_file;
            }
        }
    }

    //表单请求处理
    private static function form_handler(stdClass $o) {
        $op = $o->ret['op'];
        $params = (isset($o->ret['params'])) ? $o->ret['params'] : [];
        $url = Router::gen_url($op, Router::OP_PAGE, $params);
        Router::redirect($url);
    }

    //ajax请求
    private static function ajax_handler($o) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($o->ret);
    }
}

# end of this file
