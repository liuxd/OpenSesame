<?php
/**
 * 处理页面请求。
 * 所有页面请求方法的返回值都是数组。
 * @author liuxd
 */
class Page extends Base {
    private $history_table = 'view'; //记录浏览历史的表名。

    /**
     * 首页
     */
    public function index() {
        $site_list = ConfDB::get(Const_PAC::SITE_LIST);
        $total = count($site_list['response']);
        $user_config = Config::get('user');
        $email = $user_config['data']['email'];

        $data = array(
            'page_title' => $this->msg_map['title_index'],
            'form_action_add' => Router::gen_url('add_app', Router::OP_FORM),
            'site_total' => $total,
            'gravatar' => Gravatar::get_gravatar_url($email, 30),
        );

        $msg_list = array(
            'input_site',
            'input_url',
            'input_search',
            'bt_commit',
            'bt_logout',
            'bt_search',
            'title_search',
            'msg_recomm',
        );

        foreach ($msg_list as $v) {
            $data[$v] = $this->msg_map[$v];
        }

        //随机推荐帐号
        if ($total > Const_PAC::RECOMMAND_ACCOUNT_NUM){
            $rand_keys = array_rand($site_list['response'], Const_PAC::RECOMMAND_ACCOUNT_NUM);

            foreach ($rand_keys as $key){
                $tmp['name'] = $key;
                $tmp['url'] = Router::gen_url('app_info', Router::OP_PAGE, array('site_name' => $key));
                $random_account_keys[] = $tmp;
            }

            $data['random'] = $random_account_keys;
        }

        //按点击量推荐帐号
        $this->connect_history_db();
        $history_query = ConfDB::get($this->history_table);

        if ($history_query['stat']) {
            if ($history_query['response']) {
                uasort($history_query['response'], function($a, $b) {
                            if ($a == $b) {
                                return 0;
                            }

                            return ($a < $b) ? 1 : -1;
                        });

                $keys = array_keys($history_query['response']);
                $count = 0;
                $recomm = array();
                $tmp = array(
                    'name' => '',
                    'url' => ''
                );

                while ($count < Const_PAC::RECOMMAND_ACCOUNT_NUM and $keys) {
                    $tmp['name'] = array_shift($keys);
                    $tmp['url'] = Router::gen_url('app_info', Router::OP_PAGE, array('site_name' => $tmp['name']));
                    $recomm[] = $tmp;
                    $count++;
                }

                $data['recomm'] = $recomm;
            }
        }

        $error = $this->get('error');

        if ($error and isset($this->msg_map[$error])){
            $data['error'] = $this->msg_map[$error];
        }

        return $data;
    }

    /**
     * 搜索列表页。
     */
    public function app_list() {
        $key = trim($this->get('key'));

        if ($key === ''){
            Router::redirect(Router::gen_url('index'));
        }

        $site_list = ConfDB::get(Const_PAC::SITE_LIST);
        $result = array();

        if ($site_list['stat']) {
            foreach ($site_list['response'] as $k => $v) {
                if (empty($key) || strpos($k, $key) !== FALSE || strpos($v, $key) !== FALSE) {
                    $tmp['info_url'] = Router::gen_url('app_info', Router::OP_PAGE, array('site_name' => $k));
                    $tmp['goto_url'] = 'http://' . $v;
                    $result[$k] = $tmp;
                }
            }
        }

        $site_total = count($result);
        $error = ($site_total == 0) ? $this->msg_map['msg_no_result'] . '<b>' . $key . '</b>' : '';

        $data = array(
            'keyword' => $key,
            'page_title' => $this->msg_map['title_list'] . $site_total,
            'total' => $site_total,
            'msg_total' => $this->msg_map['msg_total'],
            'bt_del' => $this->msg_map['bt_del'],
            'bt_info' => $this->msg_map['bt_info'],
            'input_site' => $this->msg_map['input_site'],
            'input_url' => $this->msg_map['input_url'],
            'input_op' => $this->msg_map['input_op'],
            'error' => $error,
            'site_list' => $result,
            'table' => Const_PAC::SITE_LIST,
            'form_action_add' => Router::gen_url('add_site', Router::OP_FORM),
            'form_action_del' => Router::gen_url('del', Router::OP_FORM),
        );

        return $data;
    }

    /**
     * 某个网站帐号信息。
     */
    public function app_info() {
        $site_name = $this->get('site_name');
        $site_info = ConfDB::get($site_name);
        $site_list = ConfDB::get(Const_PAC::SITE_LIST);

        if ($site_list['stat']) {
            if (!isset($site_list['response'][$site_name])){
                $this->connect_history_db();
                ConfDB::del($this->history_table, $site_name);
                Router::redirect(Router::gen_url('index', Router::OP_PAGE, array('error' => 'error_not_found')));
            } else {
                $app_url = 'http://' . $site_list['response'][$site_name];
            }
        }

        if ($site_info['stat']) {
            foreach ($site_info['response'] as $k => $v) {
                $v = base64_decode($v);
                $tmp = array(
                    'display' => Str::part_cover($v, 2, 1),
                    'real' => $v,
                );

                $site_info['response'][$k] = $tmp;
            }

            //记录浏览记录
            $this->connect_history_db();
            $count_query = ConfDB::get('view', $site_name);
            $count = ($count_query['stat']) ? $count_query['response'] : 0;
            ConfDB::up('view', $site_name, $count + 1);
        }

        $data = array(
            'page_title' => $site_name,
            'site_name' => $site_name,
            'error' => isset($this->msg_map[$site_info['error']]) ? $this->msg_map[$site_info['error']] : '',
            'site_info' => $site_info,
            'form_action_add' => Router::gen_url('add_site_info', Router::OP_FORM),
            'form_action_del' => Router::gen_url('del', Router::OP_FORM),
            'app_url' => $app_url,
        );

        $msg_list = array(
            'input_key',
            'input_value',
            'bt_commit',
            'bt_pwd',
            'th_name',
            'th_value',
            'th_op',
            'bt_del',
            'bt_modify',
            'bt_copy',
        );

        foreach ($msg_list as $v) {
            $data[$v] = $this->msg_map[$v];
        }

        return $data;
    }

    /**
     * 无访问权限。
     */
    public function deny() {
        return array(
            'page_title' => $this->msg_map['title_deny'],
            'msg_deny' => $this->msg_map['msg_deny']
        );
    }

    /**
     * 登录页。
     */
    public function welcome() {
        $data = array(
            'page_title' => $this->msg_map['title_welcome'],
            'msg_welcome_1' => $this->msg_map['msg_welcome_1'],
            'msg_welcome_2' => $this->msg_map['msg_welcome_2'],
            'auth_url' => Router::gen_url('login_auth', Router::OP_AJAX)
        );

        return $data;
    }

    /**
     * 连接浏览历史数据库。
     */
    private function connect_history_db() {
        $history_db = Config::get('db');
        ConfDB::connect($history_db['data']['history']);
    }

}

# end of this file
