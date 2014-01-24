<?php

/**
 * 处理页面请求。
 * 所有页面请求方法的返回值都是数组。
 * @author liuxd
 */
class Form extends Base {

    /**
     * 添加一条网站信息。
     */
    public function add_app() {
        $name = $this->post('name');
        $url = $this->post('url');

        if (empty($name) or empty($url)) {
            return array('op' => 'index');
        }

        $url_info = parse_url($url);
        $url_value = (isset($url_info['scheme'])) ? $url_info['host'] : $url_info['path'];

        if (substr($url_value, -1) === '/') {
            $url_value = substr($url_value, 0, -1);
        }

        ConfDB::up(ConstCommon::SITE_LIST, $name, $url_value);

        return array('op' => 'app_info', 'params' => array('site_name' => $name));
    }

    /**
     * 添加某网站的一个属性。
     */
    public function add_site_info() {
        $table = $this->post('table');
        $key = $this->post('key');
        $value = $this->post('value');

        if (empty($table) or empty($key) or empty($value)) {
            return array('op' => 'app_info', 'params' => array('site_name' => $table));
        }

        $value = base64_encode($value);
        ConfDB::up($table, $key, $value);

        return array('op' => 'app_info', 'params' => array('site_name' => $table));
    }

    /**
     * 删除操作。
     */
    public function del() {
        $table = $this->post('table');
        $key = $this->post('key');

        if (empty($table) or empty($key)) {
            return array('op' => $op, 'params' => array('site_name' => $table));
        }

        ConfDB::del($table, $key);

        $op = ($table == ConstCommon::SITE_LIST) ? 'index' : 'app_info';

        return array('op' => $op, 'params' => array('site_name' => $table));
    }

    /**
     * 获得表单值。
     * @param string $name 表单名称。
     * @param unknown $default 默认值。
     * @return unknown
     */
    private function post($name, $default = '') {
        return isset($_POST[$name]) ? $_POST[$name] : $default;
    }

}

# end of this file
