<?php
/**
 * 密码管理器。
 * @author liuxd
 */
class Base {

    protected $msg_map = '';

    public function init() {
        Config::$app = Router::$app;
        $msg = Config::get('msg_default');

        if (!$msg['result']) {
            echo $msg['msg'];
            exit;
        }

        $this->msg_map = $msg['data'];
        $op = $this->get('op', 'index');
        $this->anti_robot();
        $this->auth($op);

        $data = array();
        $db_con = $this->connect_master();

        if (!$db_con['result']) {
            $data['error'] = $this->msg_map[$db_con['msg']];
        }

        if (Router::op_type() !== Router::OP_PAGE) {
            return array();
        }

        $site_name = $this->get('site_name', '');
        $data['op'] = $op;
        $data['index_url'] = Router::gen_url('index');
        $data['app'] = Router::$app;
        $data['pop_title'] = $this->msg_map['pop_title'];

        $msg_js = Config::get('msg_js_default');
        $data['msg_js'] = $msg_js['data'];

        $cdn_host = Config::get('cdn_host');

        if ($cdn_host['result']) {
            $data['css_host'] = $cdn_host['data']['css'];
            $data['js_host'] = $cdn_host['data']['js'];
            $data['img_host'] = $cdn_host['data']['img'];
        }

        $data['title_url'] = '';

        if (!empty($site_name)) {
            $tmp = ConfDB::get(Const_PAC::SITE_LIST, $site_name);

            if ($tmp['stat']) {
                $data['title_url'] = 'http://' . $tmp['response'];
            }
        }

        return $data;
    }

    /**
     * 获得URL中的参数。
     * @param string $name 参数名。默认为空。
     * @param unknown $default 指定参数名时，该参数的默认值。
     * @return array or mix
     */
    public function get($name = '', $default = '') {
        return Router::get($name, $default);
    }

    /**
     * 身份验证。
     * @param string $op
     */
    private function auth($op) {
        //放过身份验证
        if ($op == 'login_auth') {
            return TRUE;
        }

        $ip_check = Config::get('ip_check');

        //检查cookie是否OK。
        $check_cookie = function() {
            $cookie_name = md5(date('Y-m-d'));
            return isset($_COOKIE[$cookie_name]);
        };

        //身份验证后的跳转处理。
        $redirect = function($auth)use($op) {
            //检验cookie
            if (!$auth and $op != 'welcome') {
                Router::redirect(Router::gen_url('welcome'));
            } else if ($auth and $op == 'deny') {
                Router::redirect(Router::gen_url('index'));
            } else {
                return TRUE;
            }
        };

        $auth = $check_cookie();

        //IP检查
        if ($ip_check['data'] == 'on') {
            if ($op == 'deny') {
                return TRUE;
            } else {
                $allow_ip = Config::get('allow_ip');
                $is_auth = in_array(ip(), $allow_ip['data']);

                if (!$is_auth) {
                    Router::redirect(Router::gen_url('deny'));
                } else {
                    return $redirect($auth);
                }
            }
        } else {
            return $redirect($auth);
        }
    }

    /**
     * 链接主数据库。
     */
    protected function connect_master() {
        $db = Config::get('db');
        $this->db_file = $db['data']['master'];
        $r = ConfDB::connect($this->db_file);
        return $r;
    }

    /**
     * 反爬虫
     */
    private function anti_robot() {
        //反爬虫
        $ua = $_SERVER['HTTP_USER_AGENT'];

        if (empty($ua) or strpos($ua, 'bot') !== FALSE or strpos($ua, 'curl') !== FALSE) {
            header("HTTP/1.1 404 Not Found");
            header("Status: 404 Not Found");
            exit;
        }
    }

}

# end of this file
