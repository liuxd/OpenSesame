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
            'form_action_add' => Router::genURL('addApp', Router::OP_FORM),
            'site_total' => $total,
            'gravatar' => Gravatar::getGravatarURL($email, 30),
        ];

        //随机推荐帐号
        if ($total > ConstCommon::RECOMMAND_ACCOUNT_NUM) {
            $data['random'] = Recommand::getRandom($site_list['response']);
        }

        //按点击量推荐帐号
        $this->connectHistoryDB();
        $history_query = ConfDB::get($this->history_table);

        if ($history_query['stat']) {
            if ($history_query['response']) {
                $data['recomm'] = Recommand::getRecommand($history_query['response']);
            }
        }

        $error = $this->get('error');

        if ($error && isset($this->msg_map[$error])) {
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

        if ($key === '') {
            Router::redirect(Router::genURL('index'));
        }

        $result = Search::get($key);

        $site_total = count($result);
        $error = ($site_total == 0) ? '没有关于<b>' . $key . '</b>的结果' : '';

        $data = [
            'keyword' => $key,
            'page_title' => '记录总数：' . $site_total,
            'total' => $site_total,
            'error' => $error,
            'site_list' => $result,
            'table' => ConstCommon::SITE_LIST,
            'form_action_del' => Router::genURL('del', Router::OP_FORM),
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
            if (!isset($site_list['response'][$site_name])) {
                $this->connectHistoryDB();
                ConfDB::del($this->history_table, $site_name);
                Router::redirect(Router::genURL('index', Router::OP_PAGE, ['error' => 'error_not_found']));
            } else {
                $app_url = 'http://' . $site_list['response'][$site_name];
            }
        }

        if ($site_info['stat']) {
            $site_info['response'] = Site::parseInfo($site_info['response']);

            //记录浏览记录
            $this->connectHistoryDB();
            $count_query = ConfDB::get('view', $site_name);
            $count = ($count_query['stat']) ? $count_query['response'] : 0;
            ConfDB::up('view', $site_name, $count + 1);
        }

        $default_password_query = Config::get('default_password');
        $default_password = '';

        if ($default_password_query['result']) {
            $default_password = $default_password_query['data'];
        }

        $emails_query = Config::get('emails');
        $emails = [];

        if ($emails_query['result']) {
            $emails = $emails_query['data'];
        }

        $data = [
            'page_title' => $site_name,
            'site_name' => $site_name,
            'error' => isset($this->msg_map[$site_info['error']]) ? $this->msg_map[$site_info['error']] : '',
            'site_info' => $site_info,
            'form_action_add' => Router::genURL('addSiteInfo', Router::OP_FORM),
            'form_action_del' => Router::genURL('del', Router::OP_FORM),
            'app_url' => $app_url,
            'default_password' => $default_password,
            'emails' => $emails
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
            'page_title' => '你中毒了！',
            'auth_url' => Router::genURL('loginAuth', Router::OP_AJAX)
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
