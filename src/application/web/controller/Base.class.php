<?php
/**
 * 密码管理器。
 */
namespace controller;

use system as s;
use utility as u;

class Base
{

    public function init()
    {
        $is_robot = $this->antiRobot();

        if ($is_robot) {
            return array();
        }

        s\Config::$app = s\Router::$app;
        $msg = s\Config::get('msg_default');

        if (!$msg['result']) {
            echo $msg['msg'];
            return array();
        }

        $this->msg_map = $msg['data'];
        $op = s\Router::op('index');
        $this->auth($op);

        $data = array();
        $db_con = $this->connectMaster();

        if (!$db_con['result']) {
            $data['error'] = $this->msg_map[$db_con['msg']];
        }

        if (s\Router::opType() !== s\Router::OP_PAGE) {
            return array();
        }

        $site_name = $this->get('site_name', '');
        $data['op'] = $op;
        $data['index_url'] = s\Router::genURL('index');
        $data['app'] = s\Router::$app;
        $data['title_url'] = '';
        $data['host'] = 'http://' . $_SERVER['HTTP_HOST'] . '/';

        if (!empty($site_name)) {
            $tmp = u\ConfDB::get(ConstCommon::SITE_LIST, $site_name);

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
        return s\Router::get($name, $default);
    }

    /**
     * 身份验证。
     * @param string $op
     */
    private function auth($op)
    {
        //放过身份验证
        if ($op == 'loginAuth') {
            return true;
        }

        $ip_check = s\Config::get('ip_check');

        //检查cookie是否OK。
        $check_cookie = function () {
            $cookie_name = md5(date('Y-m-d'));
            return isset($_COOKIE[$cookie_name]);
        };

        //身份验证后的跳转处理。
        $redirect = function ($auth) use ($op) {
            //检验cookie
            if (!$auth && $op != 'welcome') {
                s\Router::redirect(Router::genURL('welcome'));
            } elseif ($auth && $op == 'deny') {
                s\Router::redirect(Router::genURL('index'));
            } else {
                return true;
            }
        };

        $auth = $check_cookie();

        //IP检查
        if ($ip_check['data'] == 'on') {
            if ($op == 'deny') {
                return true;
            } else {
                $allow_ip = s\Config::get('allow_ip');
                $is_auth = in_array(ip(), $allow_ip['data']);

                if (!$is_auth) {
                    s\Router::redirect(s\Router::genURL('deny'));
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
        $db = s\Config::get('db');
        $this->db_file = $db['data']['master'];
        $r = u\ConfDB::connect($this->db_file);
        return $r;
    }

    /**
     * 反爬虫
     */
    private function antiRobot()
    {
        //反爬虫
        $ua = $_SERVER['HTTP_USER_AGENT'];

        if (empty($ua) || strpos($ua, 'bot') !== false || strpos($ua, 'curl') !== false) {
            header("HTTP/1.1 404 Not Found");
            header("Status: 404 Not Found");
            return true;
        }

        return false;
    }
}

# end of this file
