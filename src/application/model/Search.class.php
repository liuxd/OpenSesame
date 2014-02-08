<?php
/**
 * 帐号搜索逻辑。
 */
namespace model;

use system as s;
use utility as u;

class Search
{

    public static function get($key)
    {
        $site_list = u\ConfDB::get(ConstCommon::SITE_LIST);
        $result = [];

        if ($site_list['stat']) {
            foreach ($site_list['response'] as $k => $v) {
                if (empty($key) || strpos($k, $key) !== false || strpos($v, $key) !== false) {
                    $tmp['info_url'] = s\Router::genURL('appInfo', s\Router::OP_PAGE, ['site_name' => $k]);
                    $tmp['goto_url'] = 'http://' . $v;
                    $result[$k] = $tmp;
                }
            }
        }

        return $result;
    }
}

# end of this file
