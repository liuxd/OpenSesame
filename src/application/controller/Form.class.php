<?php
/**
 * 处理页面请求。
 * 所有页面请求方法的返回值都是数组。
 */
namespace controller;

use system as s;
use model as m;
use utility as u;

class Form extends Base
{

    /**
     * 添加一条网站信息。
     */
    public function addApp()
    {
        $name = $this->post('name');
        $url = $this->post('url');

        if (empty($name) || empty($url)) {
            return array('op' => 'index');
        }

        $url_info = parse_url($url);
        $url_value = (isset($url_info['scheme'])) ? $url_info['host'] : $url_info['path'];

        if (substr($url_value, -1) === '/') {
            $url_value = substr($url_value, 0, -1);
        }

        u\ConfDB::up(m\ConstCommon::SITE_LIST, $name, $url_value);

        return array('op' => 'appInfo', 'params' => array('site_name' => $name));
    }

    /**
     * 添加某网站的一个属性。
     */
    public function addSiteInfo()
    {
        $table = $this->post('table');
        $key = $this->post('key');
        $value = $this->post('value');

        if (empty($table) || empty($key) || empty($value)) {
            return array('op' => 'appInfo', 'params' => array('site_name' => $table));
        }

        $value = base64_encode($value);
        u\ConfDB::up($table, $key, $value);

        return array('op' => 'appInfo', 'params' => array('site_name' => $table));
    }

    /**
     * 删除操作。
     */
    public function del()
    {
        $table = $this->post('table');
        $key = $this->post('key');

        if (empty($table) || empty($key)) {
            return array('op' => $op, 'params' => array('site_name' => $table));
        }

        u\ConfDB::del($table, $key);

        $op = ($table == m\ConstCommon::SITE_LIST) ? 'index' : 'appInfo';

        return array('op' => $op, 'params' => array('site_name' => $table));
    }

    /**
     * 获得表单值。
     * @param string $name 表单名称。
     * @param unknown $default 默认值。
     * @return unknown
     */
    private function post($name, $default = '')
    {
        return isset($_POST[$name]) ? $_POST[$name] : $default;
    }
}

# end of this file
