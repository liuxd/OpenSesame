<?php
/**
 * 处理页面请求。
 * 所有页面请求方法的返回值都是数组。
 * @author liuxd
 */
class Page extends Base
{
    private $history_table = 'view'; //记录浏览历史的表名。

    /**
     * 首页
     */
    public function index()
    {
        $site_list = ConfDB::get(ConstCommon::SITE_LIST);
        $total = count($site_list['response']);
        $user_config = Config::get('user');
        $email = $user_config['data']['email'];

        $data = [
            'page_title' => 'Open Sesame',
            'form_action_add' => Router::gen_url('addApp', Router::OP_FORM),
            'site_total' => $total,
            'gravatar' => Gravatar::getGravatarURL($email, 30),
        ];

        //随机推荐帐号
        if ($total > ConstCommon::RECOMMAND_ACCOUNT_NUM){
            $rand_keys = array_rand($site_list['response'], ConstCommon::RECOMMAND_ACCOUNT_NUM);

            foreach ($rand_keys as $key){
                $tmp['name'] = $key;
                $tmp['url'] = Router::gen_url('appInfo', Router::OP_PAGE, ['site_name' => $key]);
                $random_account_keys[] = $tmp;
            }

            $data['random'] = $random_account_keys;
        }

        //按点击量推荐帐号
        $this->connectHistoryDB();
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
                $recomm = [];
                $tmp = [
                    'name' => '',
                    'url' => ''
                ];

                while ($count < ConstCommon::RECOMMAND_ACCOUNT_NUM && $keys) {
                    $tmp['name'] = array_shift($keys);
                    $tmp['url'] = Router::gen_url('appInfo', Router::OP_PAGE, ['site_name' => $tmp['name']]);
                    $recomm[] = $tmp;
                    $count++;
                }

                $data['recomm'] = $recomm;
            }
        }

        $error = $this->get('error');

        if ($error && isset($this->msg_map[$error])){
            $data['error'] = $this->msg_map[$error];
        }

        return $data;
    }

    /**
     * 搜索列表页。
     */
    public function appList()
    {
        $key = trim($this->get('key'));

        if ($key === ''){
            Router::redirect(Router::gen_url('index'));
        }

        $site_list = ConfDB::get(ConstCommon::SITE_LIST);
        $result = Search::get($key);

        $site_total = count($result);
        $error = ($site_total == 0) ? '没有关于<b>' . $key . '</b>的结果' : '';

        $data = [
            'keyword' => $key,
            'page_title' => '记录总数：'. $site_total,
            'total' => $site_total,
            'error' => $error,
            'site_list' => $result,
            'table' => ConstCommon::SITE_LIST,
            'form_action_del' => Router::gen_url('del', Router::OP_FORM),
        ];

        return $data;
    }

    /**
     * 某个网站帐号信息。
     */
    public function appInfo()
    {
        $site_name = $this->get('site_name');
        $site_info = ConfDB::get($site_name);
        $site_list = ConfDB::get(ConstCommon::SITE_LIST);

        if ($site_list['stat']) {
            if (!isset($site_list['response'][$site_name])){
                $this->connectHistoryDB();
                ConfDB::del($this->history_table, $site_name);
                Router::redirect(Router::gen_url('index', Router::OP_PAGE, ['error' => 'error_not_found']));
            } else {
                $app_url = 'http://' . $site_list['response'][$site_name];
            }
        }

        if ($site_info['stat']) {
            foreach ($site_info['response'] as $k => $v) {
                $v = base64_decode($v);
                $tmp = [
                    'display' => Str::partCover($v, 2, 1),
                    'real' => $v,
                ];

                $site_info['response'][$k] = $tmp;
            }

            //记录浏览记录
            $this->connectHistoryDB();
            $count_query = ConfDB::get('view', $site_name);
            $count = ($count_query['stat']) ? $count_query['response'] : 0;
            ConfDB::up('view', $site_name, $count + 1);
        }

        $data = [
            'page_title' => $site_name,
            'site_name' => $site_name,
            'error' => isset($this->msg_map[$site_info['error']]) ? $this->msg_map[$site_info['error']] : '',
            'site_info' => $site_info,
            'form_action_add' => Router::gen_url('addSiteInfo', Router::OP_FORM),
            'form_action_del' => Router::gen_url('del', Router::OP_FORM),
            'app_url' => $app_url,
        ];

        return $data;
    }

    /**
     * 无访问权限。
     */
    public function deny()
    {
        return [
            'page_title' => '闭门羹',
        ];
    }

    /**
     * 登录页。
     */
    public function welcome()
    {
        $data = [
            'auth_url' => Router::gen_url('loginAuth', Router::OP_AJAX)
        ];

        return $data;
    }

    /**
     * 连接浏览历史数据库。
     */
    private function connectHistoryDB()
    {
        $history_db = Config::get('db');
        ConfDB::connect($history_db['data']['history']);
    }

}

# end of this file
