<?php
/**
 * 密码管理器。
 */
class Base
{

    public function init()
    {
        $is_robot = $this->antiRobot();

        if ($is_robot) {
            return array();
        }

        Config::$app = Router::$app;
        $msg = Config::get('msg_default');

        if (!$msg['result']) {
            echo $msg['msg'];
            return array();
        }

        $this->msg_map = $msg['data'];
        $op = $this->get('op', 'index');
        $this->auth($op);

        $data = array();
        $db_con = $this->connectMaster();

        if (!$db_con['result']) {
            $data['error'] = $this->msg_map[$db_con['msg']];
        }

        if (Router::opType() !== Router::OP_PAGE) {
            return array();
        }

        $site_name = $this->get('site_name', '');
        $data['op'] = $op;
        $data['index_url'] = Router::genURL('index');
        $data['app'] = Router::$app;
        $data['title_url'] = '';
        $data['host'] = 'http://' . $_SERVER['HTTP_HOST'] . '/';

        if (!empty($site_name)) {
            $tmp = ConfDB::get(ConstCommon::SITE_LIST, $site_name);

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
    public function get($name = '', $default = '')
    {
        return Router::get($name, $default);
    }

    /**
     * 身份验证。
     * @param string $op
     */
    private function auth($op)
    {
        //放过身份验证
        if ($op == 'loginAuth') {
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
            if (!$auth && $op != 'welcome') {
                Router::redirect(Router::genURL('welcome'));
            } else if ($auth && $op == 'deny') {
                Router::redirect(Router::genURL('index'));
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
                    Router::redirect(Router::genURL('deny'));
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
    protected function connectMaster()
    {
        $db = Config::get('db');
        $this->db_file = $db['data']['master'];
        $r = ConfDB::connect($this->db_file);
        return $r;
    }

    /**
     * 反爬虫
     */
    private function antiRobot()
    {
        //反爬虫
        $ua = $_SERVER['HTTP_USER_AGENT'];

        if (empty($ua) || strpos($ua, 'bot') !== FALSE || strpos($ua, 'curl') !== FALSE) {
            header("HTTP/1.1 404 Not Found");
            header("Status: 404 Not Found");
            return true;
        }

        return false;
    }

}

# end of this file
