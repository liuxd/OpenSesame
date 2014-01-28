<?php
/**
 * 处理ajax请求。
 * 所有页面请求方法的返回值都是json。
 * @author liuxd
 */
namespace controller;

class Ajax extends Base
{

    const AUTH_FILE = '/tmp/pac.auth'; //身份验证的缓存文件路径。
    const AUTH_FAILED = 0;             //验证失败标识。
    const AUTH_SUCCESS = 1;            //验证成功标识。
    const AUTH_FILE_EXPIRE = 20;       //身份验证缓存文件重置周期。
    const AUTH_ENTER_TIME = 3;         //身份确定点击的时间间隔。
    const AUTH_SAFE_BOOM = 2592000;    //自毁时限。

    /**
     * 身份验证。
     */
    public function loginAuth()
    {
        $data = array(
            'result' => self::AUTH_FAILED,
            'msg' => '',
        );

        $cookie_name = md5(date('Y-m-d'));
        $key = false;
        $now = $_SERVER['REQUEST_TIME'];

        if (is_readable(self::AUTH_FILE)) {
            $history = file(self::AUTH_FILE);
            $last_click = end($history);
            $t = $now - $last_click;

            if ($t > self::AUTH_SAFE_BOOM) {
                $this->bomb();
            } elseif ($t > self::AUTH_FILE_EXPIRE) {
                unlink(self::AUTH_FILE);
                error_log($now . PHP_EOL, 3, self::AUTH_FILE);
            } elseif ($t > self::AUTH_ENTER_TIME) {
                $key = count(file(self::AUTH_FILE));
            } else {
                error_log($now . PHP_EOL, 3, self::AUTH_FILE);
            }
        } else {
            error_log($now . PHP_EOL, 3, self::AUTH_FILE);
        }


        if ($key) {
            //本周剩余天数作为key。
            $date_info = getdate();
            $today_key = 7 - $date_info['wday'];

            if ($key == $today_key) {
                $data['result'] = self::AUTH_SUCCESS;
                setcookie($cookie_name, 'liuxd', $this->getLoginExpire(), '/');
            }
        }

        return $data;
    }

    /**
     * 退出。
     */
    public function logout()
    {
        $cookie_name = md5(date('Y-m-d'));
        setcookie($cookie_name, '', $_SERVER['REQUEST_TIME'] - 3600, '/');
        unlink(self::AUTH_FILE);

        return array();
    }

    /**
     * 销毁重要数据。
     */
    private function bomb()
    {
        $cmd_rmdir = 'rm -rf ';
        $fileinfo = pathinfo($this->db_file);
        $cmd_rmdir_db = $cmd_rmdir . $fileinfo['dirname'];
        $cmd_rmdir_git = $cmd_rmdir . ROOT_PATH . '.git';
        `$cmd_rmdir_db`;
        `$cmd_rmdir_git`;
    }

    /**
     * 获得登录状态有效时间。
     * @return int
     */
    private function getLoginExpire()
    {
        $today = getdate();
        $tomorrow = mktime(0, 0, 0, $today['mon'], $today['mday'] + 1, $today['year']);

        return $tomorrow;
    }
}

# end of this file
